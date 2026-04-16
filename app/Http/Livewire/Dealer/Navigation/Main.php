<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Navigation;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class Main extends Component
{
    public ?Store $currentStore = null;
    public bool $phishingIsEnabled = false;
    public bool $hasStores = false;
    public bool $hasCurrentStore = false;
    public bool $multipleScopedStores = false;
    public array $primaryItems = [];
    public array $secondaryItems = [];

    public function mount(): void
    {
        $currentStore = app()->bound('currentStoreModel') ? app('currentStoreModel') : null;
        $this->currentStore = $currentStore instanceof Store ? $currentStore : null;
        $this->phishingIsEnabled = (bool) ((app()->bound('globalSetting') ? app('globalSetting') : null)?->phishing_active ?? false);
        $this->hasStores = app()->bound('storesExist') ? (bool) app('storesExist') : Store::query()->exists();
        $this->hasCurrentStore = auth()->user()?->current_store_id !== null;
        $this->multipleScopedStores = app()->bound('scopedStoreIds') && collect(app('scopedStoreIds'))->count() > 1;

        $this->primaryItems = $this->resolveItems($this->primaryItemDefinitions());
        $this->secondaryItems = $this->resolveItems($this->secondaryItemDefinitions());
    }

    public function render(): View
    {
        return view('livewire.dealer.navigation.main');
    }

    private function primaryItemDefinitions(): array
    {
        return [
            [
                'label' => 'Home',
                'icon' => 'home',
                'route' => 'dealer.dashboard',
                'active_routes' => ['dealer.dashboard'],
            ],
            [
                'label' => 'Courses',
                'icon' => 'courses',
                'route' => 'dealer.courses.index',
                'active_routes' => [
                    'dealer.courses.index',
                    'dealer.courses.show',
                    'dealer.courses.edit',
                    'dealer.courses.quiz',
                    'dealer.courses.results.store',
                ],
                'permissions_any' => ['create-users'],
                'not_roles' => ['super-admin', 'Consultant'],
            ],
            [
                'label' => 'Employees',
                'icon' => 'employees',
                'route' => 'dealer.employees.index',
                'active_routes' => ['dealer.employees.*'],
                'permissions_any' => ['create-users'],
            ],
            [
                'label' => 'IT Scans',
                'icon' => 'scans',
                'route' => 'dealer.scan.index',
                'active_routes' => ['dealer.scan.*'],
                'permissions_any' => ['create-users'],
                'requires_current_store' => true,
            ],
            [
                'label' => 'Manuals',
                'icon' => 'manuals',
                'type' => 'group',
                'permissions_any' => ['create-stores'],
                'requires_current_store' => true,
                'children' => [
                    [
                        'label' => 'ISP',
                        'route' => 'dealer.manual.isp.index',
                        'active_routes' => ['dealer.manual.isp.*'],
                    ],
                    [
                        'label' => 'Osha',
                        'route' => 'dealer.manual.osha.index',
                        'active_routes' => ['dealer.manual.osha.*'],
                    ],
                    [
                        'label' => 'Red Flag',
                        'route' => 'dealer.manual.red-flag.index',
                        'active_routes' => ['dealer.manual.red-flag.*'],
                    ],
                    [
                        'label' => 'CMS',
                        'route' => 'dealer.manual.cms.index',
                        'active_routes' => ['dealer.manual.cms.*'],
                    ],
                ],
            ],
            [
                'label' => 'Audits',
                'icon' => 'audits',
                'type' => 'group',
                'permissions_any' => ['view-audits'],
                'requires_current_store' => true,
                'children' => [
                    [
                        'label' => 'OSHA',
                        'route' => 'dealer.audit.osha.index',
                        'active_routes' => ['dealer.audit.osha.*'],
                    ],
                    [
                        'label' => 'Body Shop',
                        'route' => 'dealer.audit.body-shop.index',
                        'active_routes' => ['dealer.audit.body-shop.*'],
                    ],
                    [
                        'label' => 'GLBA Walkthrough',
                        'route' => 'dealer.audit.finance.index',
                        'active_routes' => ['dealer.audit.finance.*'],
                    ],
                    [
                        'label' => 'Deal Jackets',
                        'route' => 'dealer.audit.deal-jackets.index',
                        'active_routes' => [
                            'dealer.audit.deal-jackets.*',
                            'dealer.audit.individual.*',
                        ],
                    ],
                    [
                        'label' => 'Fit Tests',
                        'route' => 'dealer.fit-tests.index',
                        'active_routes' => ['dealer.fit-tests.*'],
                    ],
                ],
            ],
            [
                'label' => 'Vendors',
                'icon' => 'vendors',
                'route' => 'dealer.vendor.index',
                'active_routes' => ['dealer.vendor.*'],
                'permissions_any' => ['view-vendors'],
            ],
            [
                'label' => 'Ridgeback',
                'icon' => 'ridgeback',
                'route' => 'dealer.ridgeback.index',
                'active_routes' => ['dealer.ridgeback.*'],
                'permissions_any' => ['create-dealerships'],
                'requires_current_store' => true,
            ],
            [
                'label' => 'Phishing',
                'icon' => 'phishing',
                'route' => 'dealer.phishing.index',
                'active_routes' => ['dealer.phishing.*'],
                'permissions_any' => ['create-manuals'],
                'requires_phishing' => true,
            ],
            [
                'label' => 'Documents',
                'icon' => 'documents',
                'route' => 'dealer.doc.index',
                'active_routes' => ['dealer.doc.*'],
                'permissions_any' => ['create-users'],
            ],
            [
                'label' => 'OSHA 300 Form',
                'icon' => 'osha-300',
                'url' => global_asset('docs/osha-300.pdf'),
                'target' => '_blank',
                'permissions_any' => ['create-users'],
            ],
            [
                'label' => 'SDS Sheets',
                'icon' => 'sds',
                'route' => 'dealer.sds.index',
                'active_routes' => ['dealer.sds.*'],
            ],
            [
                'label' => 'Courses',
                'icon' => 'courses',
                'route' => 'dealer.courses.all',
                'active_routes' => ['dealer.courses.all'],
                'tenant_ids' => ['e44653a5-c049-4be0-92e3-b8aacea4bf20'],
            ],
        ];
    }

    private function secondaryItemDefinitions(): array
    {
        return [
            [
                'label' => 'Settings',
                'icon' => 'settings',
                'route' => 'dealer.dealer.settings',
                'active_routes' => ['dealer.dealer.settings*'],
                'permissions_any' => ['create-stores'],
                'requires_current_store_selection' => true,
            ],
            [
                'label' => 'Global Settings',
                'icon' => 'settings',
                'route' => 'dealer.settings.global',
                'active_routes' => ['dealer.settings.global*'],
                'roles_any' => ['super-admin'],
                'requires_multiple_scoped_stores' => true,
                'requires_no_current_store' => true,
            ],
            [
                'label' => 'Automated Reports',
                'icon' => 'settings',
                'route' => 'dealer.settings.automated-reports',
                'active_routes' => ['dealer.settings.automated-reports*'],
                'roles_any' => ['super-admin', 'Consultant', 'Owner', 'GM', 'CFO', 'GSM', 'Qualified Individual'],
            ],
            [
                'label' => 'Locations',
                'icon' => 'locations',
                'route' => 'dealer.locations.index',
                'active_routes' => ['dealer.locations.*'],
                'roles_any' => ['super-admin', 'Consultant'],
            ],
            [
                'label' => 'Logs',
                'icon' => 'logs',
                'route' => 'dealer.logs.index',
                'active_routes' => ['dealer.logs.*'],
                'roles_any' => ['super-admin', 'Consultant'],
            ],
        ];
    }

    private function resolveItems(array $definitions): array
    {
        $user = auth()->user();
        $items = [];

        foreach ($definitions as $definition) {
            if (! $this->shouldDisplayItem($definition, $user)) {
                continue;
            }

            $children = isset($definition['children'])
                ? $this->resolveItems($definition['children'])
                : [];

            if (isset($definition['children']) && $children === []) {
                continue;
            }

            $isActive = $this->itemIsActive($definition)
                || collect($children)->contains(fn (array $child): bool => (bool) ($child['active'] ?? false));

            $items[] = [
                ...$definition,
                'href' => $this->resolveHref($definition),
                'active' => $isActive,
                'open' => $isActive,
                'children' => $children,
            ];
        }

        return $items;
    }

    private function shouldDisplayItem(array $definition, ?User $user): bool
    {
        if (! $user instanceof User) {
            return false;
        }

        if (($definition['requires_current_store'] ?? false) && ! $this->currentStore instanceof Store) {
            return false;
        }

        if (($definition['requires_current_store_selection'] ?? false) && ! $this->hasCurrentStore) {
            return false;
        }

        if (($definition['requires_no_current_store'] ?? false) && $this->hasCurrentStore) {
            return false;
        }

        if (($definition['requires_multiple_scoped_stores'] ?? false) && ! $this->multipleScopedStores) {
            return false;
        }

        if (($definition['requires_phishing'] ?? false) && ! $this->phishingIsEnabled) {
            return false;
        }

        if (isset($definition['tenant_ids']) && ! in_array((string) tenant('id'), $definition['tenant_ids'], true)) {
            return false;
        }

        if (isset($definition['permissions_any'])) {
            $hasVisiblePermission = collect($definition['permissions_any'])
                ->contains(fn (string $permission): bool => $user->can($permission));

            if (! $hasVisiblePermission) {
                return false;
            }
        }

        if (isset($definition['roles_any']) && ! $user->hasAnyRole($definition['roles_any'])) {
            return false;
        }

        return ! (isset($definition['not_roles']) && $user->hasAnyRole($definition['not_roles']));
    }

    private function itemIsActive(array $definition): bool
    {
        foreach ($definition['active_routes'] ?? [] as $pattern) {
            if (request()->routeIs($pattern)) {
                return true;
            }
        }

        return false;
    }

    private function resolveHref(array $definition): string
    {
        if (isset($definition['route'])) {
            return route($definition['route']);
        }

        return (string) ($definition['url'] ?? '#');
    }
}
