<x-dealer-app>
    <x-slot:header>
        <x-slot:pageTitle>Deal Jacket Audits</x-slot:pageTitle>
    </x-slot:header>
    <x-slot:actions>
        <x-button
            :href="request()->route('store') ? route('dealer.stores.audits.individual.index', request()->route('store')) : route('dealer.audit.individual.index')"
            variant="outline"
        >
            View Past Audits
        </x-button>
        @hasanyrole('super-admin|Consultant')
        <livewire:tenant.audit.deal-jacket.create-new-group-button />
        @endhasanyrole
    </x-slot:actions>
    <div>
        @if (session()->has('message'))
            <x-modal-form name="audit-exists" :show="true">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Deal Jacket Audits</h3>
                    <p class="text-sm text-gray-600">{{ session('message') }}</p>
                    <div class="flex gap-2 mt-6">
                        <x-button class="w-full" @click="show = false">Cancel</x-button>
                        <x-button href="{{
                            session()->has('storeSlug')
                            ? route('dealer.stores.audits.deal-jackets.show', [session('storeSlug'), session('dealJacketGroupUuid')])
                            : route('dealer.audit.deal-jackets.show', session('dealJacketGroupUuid'))
                        }}" class="w-full" variant="primary">View</x-button>
                    </div>
                </div>
            </x-modal-form>
        @endif

        <x-modal-form name="welcome-modal" :show="true" max-width="2xl">
            <div class="p-6">
                <div class="flex items-start gap-4 mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Welcome to the New Deal Jacket Audits!</h3>
                        <div class="text-sm text-gray-600 space-y-3">
                            <p>We've redesigned Deal Jacket Audits to make them easier to use and more efficient.</p>
                            <p class="font-medium text-gray-700">What's new:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Quarterly grouping for better organization</li>
                                <li>Improved analytics and reporting</li>
                                <li>Enhanced navigation and user experience</li>
                            </ul>
                            <p class="text-gray-500 text-xs mt-4">Your previous audits are still accessible via the "View Past Audits" button above.</p>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <x-button
                        variant="primary"
                        @click="
                            localStorage.setItem('deal-jackets-welcome-seen', 'true');
                            show = false;
                        "
                    >
                        Got it, thanks!
                    </x-button>
                </div>
            </div>
        </x-modal-form>

        <script>
            document.addEventListener('alpine:init', () => {
                if (!localStorage.getItem('deal-jackets-welcome-seen')) {
                    setTimeout(() => {
                        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'welcome-modal' }));
                    }, 500);
                }
            });
        </script>
    </div>

    <div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <livewire:tenant.audit.deal-jacket.components.pass-rate-trend-chart />
            <livewire:tenant.audit.deal-jacket.components.common-issues-chart />
        </div>

        <livewire:tenant.audit.deal-jacket.group-index />
    </div>
</x-dealer-app>
