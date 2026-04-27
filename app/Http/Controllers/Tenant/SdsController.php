<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Sds\RequestSdsSheetRequest;
use App\Http\Resources\Tenant\SdsRecordResource;
use App\Mail\Tenant\SdsRequestMail;
use App\Models\Sds;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class SdsController extends Controller
{
    private const array ALLOWED_SORT_FIELDS = ['name', 'manufacturer'];

    private const int PER_PAGE = 25;

    public function index(Request $request): InertiaResponse
    {
        $search = mb_trim((string) $request->string('search'));
        $sort = in_array($request->string('sort')->toString(), self::ALLOWED_SORT_FIELDS, true)
            ? $request->string('sort')->toString()
            : 'name';
        $direction = $request->string('direction')->toString() === 'desc' ? 'desc' : 'asc';

        $records = $search === ''
            ? null
            : SdsRecordResource::collection($this->searchSds($search, $sort, $direction));

        return Inertia::render('tenant/sds/Index', [
            'records' => $records,
            'filters' => [
                'search' => $search === '' ? null : $search,
                'sort' => $sort,
                'direction' => $direction,
            ],
        ]);
    }

    public function view(string $uuid): Response
    {
        return tenancy()->central(function () use ($uuid): Response {
            $sds = Sds::query()->where('uuid', $uuid)->firstOrFail();

            $fileContents = Storage::disk('sds-sheets')->get($sds->file_name);

            return response($fileContents, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$sds->name.'.pdf"',
                'Cache-Control' => 'public, max-age=31536000',
                'Expires' => now()->addYear()->format('D, d M Y H:i:s \G\M\T'),
            ]);
        });
    }

    public function storeRequest(RequestSdsSheetRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $superAdminEmails = User::query()->role('super-admin')->pluck('email')->all();

        if ($superAdminEmails !== []) {
            Mail::to($superAdminEmails)->queue(new SdsRequestMail(
                chemicalName: (string) $request->string('name'),
                manufacturer: ($manufacturer = mb_trim((string) $request->string('manufacturer'))) === '' ? null : $manufacturer,
                requesterName: $user->name,
                requesterEmail: $user->email,
                tenantName: (string) tenant('name'),
            ));
        }

        return back()->with('flash.success', 'Request successfully sent.');
    }

    private function searchSds(string $search, string $sort, string $direction): LengthAwarePaginator
    {
        return tenancy()->central(fn (): LengthAwarePaginator => Sds::query()
            ->where(function ($query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('manufacturer', 'like', "%{$search}%")
                    ->orWhere('file_name', 'like', "%{$search}%")
                    ->orWhereJsonContains('keywords', $search);
            })
            ->orderBy($sort, $direction)
            ->when($sort !== 'name', fn ($query) => $query->orderBy('name'))
            ->paginate(self::PER_PAGE)
            ->withQueryString());
    }
}
