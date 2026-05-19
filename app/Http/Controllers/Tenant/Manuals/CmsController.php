<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Manuals;

use App\Domain\Tenant\Manuals\Cms\Actions\CreateCmsManual;
use App\Domain\Tenant\Manuals\Cms\Actions\DeleteCmsManual;
use App\Domain\Tenant\Manuals\Cms\Data\CmsFormDefaultsData;
use App\Domain\Tenant\Manuals\Cms\Data\CmsManualListItemData;
use App\Domain\Tenant\Manuals\Cms\Queries\BuildCmsFormDefaults;
use App\Domain\Tenant\Manuals\Cms\Queries\ListCmsManuals;
use App\Domain\Tenant\Manuals\Queries\ResolveManualStores;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tenant\Manuals\Concerns\ResolvesManualStore;
use App\Http\Requests\Tenant\Manuals\Cms\StoreCmsManualRequest;
use App\Models\CmsManual;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use RuntimeException;

class CmsController extends Controller
{
    use ResolvesManualStore;

    public function index(
        Request $request,
        ResolveManualStores $resolveManualStores,
        ListCmsManuals $listCmsManuals,
    ): InertiaResponse {
        $storeIds = $resolveManualStores->handle($request->user());

        $store = $this->resolveCurrentStore();

        return Inertia::render('tenant/manuals/cms/Index', [
            'store' => $store instanceof Store
                ? ['id' => $store->id, 'name' => $store->name]
                : null,
            'manuals' => $listCmsManuals->handle($storeIds)
                ->map(static fn (CmsManualListItemData $item): array => $item->toArray())
                ->all(),
        ]);
    }

    public function create(BuildCmsFormDefaults $buildCmsFormDefaults): InertiaResponse
    {
        $store = $this->resolveCurrentStoreOrFail();
        $defaults = $buildCmsFormDefaults->handle($store);

        return Inertia::render('tenant/manuals/cms/Create', [
            'defaults' => $defaults->toArray(),
            'introHtml' => $this->renderPartial('manuals.cms-content-intro', $defaults),
            'dppHtml' => $this->renderPartial('manuals.cms-content-dpp', $defaults),
            'formExampleHtml' => $this->renderPartial('manuals.cms-content-form-example', $defaults),
        ]);
    }

    public function store(
        StoreCmsManualRequest $request,
        CreateCmsManual $createCmsManual,
    ): RedirectResponse {
        $store = $this->resolveCurrentStoreOrFail();
        $user = $request->user();

        throw_unless($user instanceof User, RuntimeException::class, 'Authenticated user required.');

        $createCmsManual->handle($store, $user, $request->toData());

        return to_route('dealer.manual.cms.index')
            ->with('success', 'CMS manual signed. Your PDF is being generated.');
    }

    public function destroy(
        Request $request,
        CmsManual $manual,
        DeleteCmsManual $deleteCmsManual,
    ): RedirectResponse {
        $this->authorizeManualScope($request, $manual);

        $deleteCmsManual->handle($manual);

        return back()->with('success', 'CMS manual deleted.');
    }

    private function renderPartial(string $view, CmsFormDefaultsData $defaults): string
    {
        return View::make($view, [
            'qualifiedIndividualName' => $defaults->qualifiedIndividualName,
            'standardDppRate' => $defaults->standardDppRate,
            'tenantName' => $defaults->tenantName,
            'today' => $defaults->today,
            'todayDay' => $defaults->todayDay,
            'todayMonth' => $defaults->todayMonth,
            'todayYear' => $defaults->todayYear,
        ])->render();
    }
}
