<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Manuals;

use App\Domain\Tenant\Manuals\Queries\ResolveManualStores;
use App\Domain\Tenant\Manuals\RedFlag\Actions\CreateRedFlagManual;
use App\Domain\Tenant\Manuals\RedFlag\Actions\DeleteRedFlagManual;
use App\Domain\Tenant\Manuals\RedFlag\Data\RedFlagFormDefaultsData;
use App\Domain\Tenant\Manuals\RedFlag\Data\RedFlagManualListItemData;
use App\Domain\Tenant\Manuals\RedFlag\Queries\BuildRedFlagFormDefaults;
use App\Domain\Tenant\Manuals\RedFlag\Queries\ListRedFlagManuals;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tenant\Manuals\Concerns\ResolvesManualStore;
use App\Http\Requests\Tenant\Manuals\RedFlag\StoreRedFlagManualRequest;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RedFlagController extends Controller
{
    use ResolvesManualStore;

    public function index(
        Request $request,
        ResolveManualStores $resolveManualStores,
        ListRedFlagManuals $listRedFlagManuals,
    ): InertiaResponse {
        $storeIds = $resolveManualStores->handle($request->user());

        $store = $this->resolveCurrentStore();

        return Inertia::render('tenant/manuals/red-flag/Index', [
            'store' => $store instanceof Store
                ? ['id' => $store->id, 'name' => $store->name]
                : null,
            'manuals' => $listRedFlagManuals->handle($storeIds)
                ->map(static fn (RedFlagManualListItemData $item): array => $item->toArray())
                ->all(),
        ]);
    }

    public function create(BuildRedFlagFormDefaults $buildRedFlagFormDefaults): InertiaResponse
    {
        $store = $this->resolveCurrentStoreOrFail();

        $defaults = $buildRedFlagFormDefaults->handle($store);

        return Inertia::render('tenant/manuals/red-flag/Create', [
            'defaults' => $defaults->toArray(),
            'policyHtml' => $this->renderPolicyHtml($store, $defaults),
        ]);
    }

    public function store(
        StoreRedFlagManualRequest $request,
        CreateRedFlagManual $createRedFlagManual,
    ): RedirectResponse {
        $store = $this->resolveCurrentStoreOrFail();
        $user = $request->user();

        throw_unless($user instanceof User, RuntimeException::class, 'Authenticated user required.');

        $createRedFlagManual->handle($store, $user, $request->toData());

        return to_route('dealer.manual.red-flag.index')
            ->with('success', 'Red Flag manual signed. Your PDF is being generated.');
    }

    public function destroy(
        Request $request,
        RedFlag $manual,
        DeleteRedFlagManual $deleteRedFlagManual,
    ): RedirectResponse {
        $this->authorizeManualScope($request, $manual);

        $deleteRedFlagManual->handle($manual);

        return back()->with('success', 'Red Flag manual deleted.');
    }

    public function download(Request $request, RedFlag $manual): StreamedResponse
    {
        $this->authorizeManualScope($request, $manual);

        abort_unless(is_string($manual->pdf_path) && $manual->pdf_path !== '', 404);

        $path = tenant('id').'/red-flags/'.$manual->pdf_path;
        $disk = Storage::disk('do-manuals');

        abort_unless($disk->exists($path), 404);

        $filename = 'red-flag-manual-'.optional($manual->created_at)->format('Y-m-d').'.pdf';

        return $disk->download($path, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    private function renderPolicyHtml(Store $store, RedFlagFormDefaultsData $defaults): string
    {
        return View::make('manuals.red-flag-content', [
            'store' => $store,
            'qi' => $defaults->qualifiedIndividualName,
            'owner' => $defaults->ownerName,
        ])->render();
    }
}
