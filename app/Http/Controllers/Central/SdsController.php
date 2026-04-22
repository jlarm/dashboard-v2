<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\Sds\Actions\CreateSds;
use App\Domain\Central\Sds\Actions\DeleteSds;
use App\Domain\Central\Sds\Actions\UpdateSds;
use App\Domain\Central\Sds\Data\SdsData;
use App\Domain\Central\Sds\Queries\SearchSds;
use App\Domain\Central\Sds\Support\SdsStorage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Central\Sds\StoreSdsRequest;
use App\Http\Requests\Central\Sds\UpdateSdsRequest;
use App\Http\Resources\Central\SdsResource;
use App\Models\Sds;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SdsController extends Controller
{
    public function index(Request $request, SearchSds $query): Response
    {
        $this->authorize('viewAny', Sds::class);

        /** @var User $user */
        $user = $request->user();

        $search = $request->string('search')->toString() ?: null;

        return Inertia::render('central/sds/Index', [
            'sheets' => SdsResource::collection($query->handle($search)),
            'filters' => $request->only(['search']),
            'can' => [
                'create' => $user->can('create', Sds::class),
                'update' => $user->hasRole('super-admin'),
                'delete' => $user->hasRole('super-admin'),
            ],
        ]);
    }

    public function store(StoreSdsRequest $request, CreateSds $action): RedirectResponse
    {
        $this->authorize('create', Sds::class);

        $action->handle($this->sdsData($request->validated(), $request->file('file')));

        return to_route('sds.index')->with('flash.success', 'SDS sheet added successfully.');
    }

    public function update(UpdateSdsRequest $request, Sds $sds, UpdateSds $action): RedirectResponse
    {
        $this->authorize('update', $sds);

        $action->handle($sds, $this->sdsData($request->validated(), $request->file('file')));

        return back()->with('flash.success', 'SDS sheet updated successfully.');
    }

    public function destroy(Sds $sds, DeleteSds $action): RedirectResponse
    {
        $this->authorize('delete', $sds);

        $action->handle($sds);

        return to_route('sds.index')->with('flash.success', 'SDS sheet deleted.');
    }

    public function download(Sds $sds, SdsStorage $storage): StreamedResponse
    {
        $this->authorize('view', $sds);

        abort_unless(is_string($sds->file_name) && $sds->file_name !== '', 404);

        return $storage->download($sds->file_name, $sds->name.'.pdf');
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    private function sdsData(array $validated, mixed $file): SdsData
    {
        return new SdsData(
            name: $validated['name'],
            manufacturer: $validated['manufacturer'] ?? '',
            keywords: array_values(array_filter($validated['keywords'] ?? [], fn ($keyword): bool => is_string($keyword) && $keyword !== '')),
            file: $file ?: null,
        );
    }
}
