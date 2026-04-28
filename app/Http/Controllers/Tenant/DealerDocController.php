<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\Document\StoreDealerDocRequest;
use App\Http\Resources\Tenant\DealerDocListItemResource;
use App\Models\Dealer\Store;
use App\Models\DealerDoc;
use App\Models\SharedDocument;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class DealerDocController extends Controller
{
    private const int PER_PAGE = 15;

    public function index(Request $request): InertiaResponse
    {
        /** @var User $user */
        $user = $request->user();

        $search = mb_trim((string) $request->string('search'));
        $page = max(1, (int) $request->integer('page', 1));

        $merged = $this->mergedDocs($search === '' ? null : $search);

        $paginator = new LengthAwarePaginator(
            items: $merged->forPage($page, self::PER_PAGE)->values(),
            total: $merged->count(),
            perPage: self::PER_PAGE,
            currentPage: $page,
            options: [
                'path' => $request->url(),
                'query' => $request->query(),
            ],
        );

        return Inertia::render('tenant/document/Index', [
            'docs' => DealerDocListItemResource::collection($paginator),
            'filters' => [
                'search' => $search === '' ? null : $search,
            ],
            'can' => [
                'create' => $user->can('create', DealerDoc::class),
            ],
        ]);
    }

    public function store(StoreDealerDocRequest $request): RedirectResponse
    {
        $store = Store::query()->firstOrFail();

        $file = $request->file('file');
        $filePath = '';
        $fileName = '';

        if ($file !== null) {
            $stored = $file->store(tenant()->id, 'dealer-docs');

            throw_unless($stored, RuntimeException::class, 'Unable to store the uploaded file.');

            $filePath = $stored;
            $fileName = $file->getClientOriginalName();
        }

        DealerDoc::query()->create([
            'store_id' => $store->id,
            'title' => $request->validated('title'),
            'url' => $request->validated('url') ?: null,
            'file_name' => $fileName,
            'file_path' => $filePath,
        ]);

        return back()->with('flash.success', 'Document added successfully.');
    }

    public function destroy(DealerDoc $dealerDoc): RedirectResponse
    {
        $this->authorize('delete', $dealerDoc);

        if ($dealerDoc->file_path !== null && $dealerDoc->file_path !== '') {
            Storage::disk('dealer-docs')->delete($dealerDoc->file_path);
        }

        $dealerDoc->delete();

        return back()->with('flash.success', 'Document deleted successfully.');
    }

    /**
     * @throws Throwable
     */
    public function download(DealerDoc $dealerDoc): StreamedResponse
    {
        abort_unless(is_string($dealerDoc->file_path) && $dealerDoc->file_path !== '', 404);

        return Storage::disk('dealer-docs')->response(
            $dealerDoc->file_path,
            $dealerDoc->file_name !== '' ? $dealerDoc->file_name : null,
        );
    }

    public function downloadShared(int $sharedDocument): StreamedResponse
    {
        return tenancy()->central(function () use ($sharedDocument): StreamedResponse {
            $doc = SharedDocument::query()->findOrFail($sharedDocument);

            abort_unless(is_string($doc->file_name) && $doc->file_name !== '', 404);

            return Storage::disk('central-docs')->response($doc->file_name);
        });
    }

    /**
     * @return Collection<int, array<string, mixed>>
     */
    private function mergedDocs(?string $search): Collection
    {
        $dealerDocs = DealerDoc::query()
            ->when($search, fn ($query, $value) => $query->where('title', 'like', "%{$value}%"))
            ->orderBy('title')
            ->get()
            ->map(fn (DealerDoc $doc): array => [
                'key' => "dealer-{$doc->id}",
                'id' => $doc->id,
                'title' => $doc->title,
                'url' => $doc->url,
                'download_url' => $doc->file_path !== '' && $doc->file_path !== null
                    ? route('dealer.doc.download', $doc)
                    : null,
                'is_shared' => false,
            ]);

        $sharedDocs = tenancy()->central(fn (): Collection => SharedDocument::query()
            ->when($search, fn ($query, $value) => $query->where('title', 'like', "%{$value}%"))
            ->orderBy('title')
            ->get()
            ->map(fn (SharedDocument $doc): array => [
                'key' => "shared-{$doc->id}",
                'id' => $doc->id,
                'title' => $doc->title,
                'url' => $doc->url,
                'download_url' => $doc->file_name !== null && $doc->file_name !== ''
                    ? route('dealer.doc.shared.download', ['sharedDocument' => $doc->id])
                    : null,
                'is_shared' => true,
            ]));

        return $dealerDocs->concat($sharedDocs)->sortBy('title')->values();
    }
}
