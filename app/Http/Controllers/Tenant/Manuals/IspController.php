<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Manuals;

use App\Domain\Tenant\Manuals\Isp\Actions\CreateIspManual;
use App\Domain\Tenant\Manuals\Isp\Actions\DeleteIspManual;
use App\Domain\Tenant\Manuals\Isp\Data\IspManualListItemData;
use App\Domain\Tenant\Manuals\Isp\Queries\BuildIspFormDefaults;
use App\Domain\Tenant\Manuals\Isp\Queries\ListIspManuals;
use App\Domain\Tenant\Manuals\Queries\ResolveManualStores;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tenant\Manuals\Concerns\ResolvesManualStore;
use App\Http\Requests\Tenant\Manuals\Isp\StoreIspManualRequest;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use RuntimeException;

class IspController extends Controller
{
    use ResolvesManualStore;

    public function index(
        Request $request,
        ResolveManualStores $resolveManualStores,
        ListIspManuals $listIspManuals,
    ): InertiaResponse {
        $storeIds = $resolveManualStores->handle($request->user());

        $store = $this->resolveCurrentStore();

        return Inertia::render('tenant/manuals/isp/Index', [
            'store' => $store instanceof Store
                ? ['id' => $store->id, 'name' => $store->name]
                : null,
            'manuals' => $listIspManuals->handle($storeIds)
                ->map(static fn (IspManualListItemData $item): array => $item->toArray())
                ->all(),
        ]);
    }

    public function create(BuildIspFormDefaults $buildIspFormDefaults): InertiaResponse
    {
        $store = $this->resolveCurrentStoreOrFail();

        return Inertia::render('tenant/manuals/isp/Create', [
            'defaults' => $buildIspFormDefaults->handle($store)->toArray(),
        ]);
    }

    public function store(
        StoreIspManualRequest $request,
        CreateIspManual $createIspManual,
    ): RedirectResponse {
        $store = $this->resolveCurrentStoreOrFail();
        $user = $request->user();

        throw_unless($user instanceof User, RuntimeException::class, 'Authenticated user required.');

        $createIspManual->handle($store, $user, $request->toData());

        return to_route('dealer.manual.isp.index')
            ->with('success', 'ISP manual signed. Your PDF is being generated.');
    }

    public function destroy(
        Request $request,
        Isp $manual,
        DeleteIspManual $deleteIspManual,
    ): RedirectResponse {
        $this->authorizeManualScope($request, $manual);

        $deleteIspManual->handle($manual);

        return back()->with('success', 'ISP manual deleted.');
    }
}
