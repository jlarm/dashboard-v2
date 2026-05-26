<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Manuals;

use App\Domain\Tenant\Manuals\Osha\Actions\CreateOshaManual;
use App\Domain\Tenant\Manuals\Osha\Actions\DeleteOshaManual;
use App\Domain\Tenant\Manuals\Osha\Data\OshaFormDefaultsData;
use App\Domain\Tenant\Manuals\Osha\Data\OshaManualListItemData;
use App\Domain\Tenant\Manuals\Osha\Queries\BuildOshaFormDefaults;
use App\Domain\Tenant\Manuals\Osha\Queries\ListOshaManuals;
use App\Domain\Tenant\Manuals\Queries\ResolveManualStores;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tenant\Manuals\Concerns\ResolvesManualStore;
use App\Http\Requests\Tenant\Manuals\Osha\StoreOshaManualRequest;
use App\Models\Dealer\Manual\Osha;
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

class OshaController extends Controller
{
    use ResolvesManualStore;

    public function index(
        Request $request,
        ResolveManualStores $resolveManualStores,
        ListOshaManuals $listOshaManuals,
    ): InertiaResponse {
        $storeIds = $resolveManualStores->handle($request->user());

        $store = $this->resolveCurrentStore();

        return Inertia::render('tenant/manuals/osha/Index', [
            'store' => $store instanceof Store
                ? ['id' => $store->id, 'name' => $store->name]
                : null,
            'manuals' => $listOshaManuals->handle($storeIds)
                ->map(static fn (OshaManualListItemData $item): array => $item->toArray())
                ->all(),
        ]);
    }

    public function create(BuildOshaFormDefaults $buildOshaFormDefaults): InertiaResponse
    {
        $store = $this->resolveCurrentStoreOrFail();

        $defaults = $buildOshaFormDefaults->handle($store);

        return Inertia::render('tenant/manuals/osha/Create', [
            'defaults' => $defaults->toArray(),
            'policyHtml' => $this->renderPolicyHtml($store, $defaults),
        ]);
    }

    public function store(
        StoreOshaManualRequest $request,
        CreateOshaManual $createOshaManual,
    ): RedirectResponse {
        $store = $this->resolveCurrentStoreOrFail();
        $user = $request->user();

        throw_unless($user instanceof User, RuntimeException::class, 'Authenticated user required.');

        $createOshaManual->handle($store, $user, $request->toData());

        return to_route('dealer.manual.osha.index')
            ->with('success', 'OSHA manual signed. Your PDF is being generated.');
    }

    public function destroy(
        Request $request,
        Osha $manual,
        DeleteOshaManual $deleteOshaManual,
    ): RedirectResponse {
        $this->authorizeManualScope($request, $manual);

        $deleteOshaManual->handle($manual);

        return back()->with('success', 'OSHA manual deleted.');
    }

    public function download(Request $request, Osha $manual): StreamedResponse
    {
        $this->authorizeManualScope($request, $manual);

        abort_unless(is_string($manual->pdf_path) && $manual->pdf_path !== '', 404);

        $path = tenant('id').'/osha/'.$manual->pdf_path;
        $disk = Storage::disk('do-manuals');

        abort_unless($disk->exists($path), 404);

        $filename = 'osha-manual-'.optional($manual->created_at)->format('Y-m-d').'.pdf';

        return $disk->download($path, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    private function renderPolicyHtml(Store $store, OshaFormDefaultsData $defaults): string
    {
        return View::make('manuals.osha-content', [
            'store' => $store,
            'qi' => $defaults->qualifiedIndividualName,
            'sm' => $defaults->serviceManagerName,
            'smp' => $defaults->serviceManagerPhone,
            'pm' => $defaults->partsManagerName,
            'pmp' => $defaults->partsManagerPhone,
            'bsm' => $defaults->bodyShopManagerName,
            'bsmp' => $defaults->bodyShopManagerPhone,
            'gm' => $defaults->generalManagerName,
            'gmp' => $defaults->generalManagerPhone,
            'owner' => $defaults->ownerName,
            'ownerp' => $defaults->ownerPhone,
        ])->render();
    }
}
