<div class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl">
    <div class="space-y-1">
        <div class="flex justify-between">
            <h4 class="mb-2.5 font-medium text-sm text-gray-800">
                {{ $this->quarter() }}
            </h4>
            <div
                x-data="{
                            open: false,
                            toggle() {
                                if (this.open) {
                                    return this.close()
                                }
                                this.$refs.button.focus()
                                this.open = true
                            },
                            close(focusAfter) {
                                if (! this.open) return
                                this.open = false
                                focusAfter && focusAfter.focus()
                            }
                        }"
                x-on:keydown.escape.prevent.stop="close($refs.button)"
                x-on:focusin.window="!$refs.panel || !$refs.panel.contains($event.target) && close()"
                x-id="['dropdown-button']"
                class="relative flex-none"
            >
                <button
                    x-ref="button"
                    x-on:click="toggle()"
                    :aria-expanded="open"
                    :aria-controls="$id('dropdown-button')"
                    type="button"
                    class="-m-2.5 block p-2.5 pr-1 text-gray-500 hover:text-gray-900"
                    id="options-menu-0-button"
                    aria-expanded="false"
                    aria-haspopup="true"
                >
                    <span class="sr-only">Open options</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                    </svg>
                </button>
                <div
                    x-ref="panel"
                    x-show="open"
                    x-transition.origin.top.left
                    x-on:click.outside="close($refs.button)"
                    :id="$id('dropdown-button')"
                    style="display: none;"
                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                    role="menu"
                    aria-orientation="vertical"
                    aria-labelledby="options-menu-0-button"
                    tabindex="-1"
                >
                    @can('create-audits')
                        <a href="{{ tenant('locations') ? route('dealer.stores.audits.body-shop.edit', [$store, $bodyShopAudit->uuid]) : route('dealer.audit.body-shop.edit', $bodyShopAudit->uuid) }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#4a4a4a" fill="none">
                                <path d="M15.5 5.5L18 3L21 6L18.5 8.5M15.5 5.5L9 12L8 16L12 15L18.5 8.5M15.5 5.5L18.5 8.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                <path d="M11 5H3V21H19V13" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                            </svg>
                            Edit
                        </a>
                    @endcan
                    @if($remediations && $bodyShopAudit->pdf_path)
                        @can('view-audits')
                            <a href="{{ tenant('locations') ? route('dealer.stores.audits.body-shop.remediation', [$store, $bodyShopAudit->uuid]) : route('dealer.audit.body-shop.remediation', $bodyShopAudit->uuid) }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#4a4a4a" fill="none">
                                    <path d="M6.50256 17.4971L6.49622 17.5034" stroke="currentColor" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round" />
                                    <path d="M6.53145 21.4957C6.52756 21.4996 6.52126 21.4997 6.51734 21.4958L2.49907 17.5292C2.49513 17.5253 2.4951 17.5189 2.49901 17.515L9.74034 10.2469C8.77141 6.85634 10.7044 3.93772 13.2977 2.9258C14.8604 2.31602 16.6643 2.3761 17.9917 3.01986C17.5364 3.48022 16.8871 4.09505 16.3054 4.68145C15.6913 5.3006 15.0716 5.89067 14.7531 6.29192C13.3917 8.48441 15.9136 10.434 17.6375 9.27594C17.9219 9.08493 18.3556 8.57712 18.8641 8.09065C19.5963 7.39024 20.2333 6.7218 20.9465 6.01509C21.6586 7.67186 21.6489 9.33041 21.0551 10.7508C20.4803 12.126 19.3536 13.2789 18.0591 13.9344C16.7378 14.3924 15.4276 14.7886 13.753 14.259L6.53145 21.4957Z" stroke="currentColor" stroke-width="1.5" />
                                </svg>
                                Remediate
                            </a>
                        @endcan
                    @endif
                    <a href="{{ tenant('locations') && auth()->user()->can('create-stores') ? route('dealer.stores.audits.body-shop.view', [$store, $bodyShopAudit->uuid]) : route('dealer.audit.body-shop.show', $bodyShopAudit->uuid) }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" color="#4a4a4a" fill="none">
                            <path d="M15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12Z" stroke="currentColor" stroke-width="1.5" />
                            <path d="M12 5C17.5228 5 22 12 22 12C22 12 17.5228 19 12 19C6.47715 19 2 12 2 12C2 12 6.47715 5 12 5Z" stroke="currentColor" stroke-width="1.5" />
                        </svg>
                        View
                    </a>
                    @if($bodyShopAudit->pdf_path)
                        <span class="flex px-4 py-2 text-sm font-medium bg-gray-50">Violations</span>
                    @endif
                    @can('create-audits')
                        @if(!$bodyShopAudit->pdf_path)
                            <span class="flex px-4 py-2 text-sm font-medium bg-gray-50">Violations</span>
                        @endif
                        @if($this->bodyShopAudit->violations->count() > 0)
                            <livewire:dealer.audit.body-shop.generate-button :bodyShopViolationAudit="$bodyShopAudit" />
                        @endif
                    @endcan
                    @if($bodyShopAudit->pdf_path)
                        <button wire:click="download" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none">
                                <path d="M21 3H3V21H21V3Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                <path d="M8 17.0039H16M11.9961 7.00391V13.7212M9.49435 11.8211L11.9961 13.987L14.4978 11.8211" stroke="currentColor" stroke-width="1.5" />
                            </svg>
                            Download PDF
                            <svg
                                wire:loading
                                wire:target="download"
                                class="animate-spin -ml-1 mr-1 h-3 w-3 text-gray-700"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24"
                            >
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    @endif
                    @if($remediations && $bodyShopAudit->remediation_pdf_path)
                        <span class="flex px-4 py-2 text-sm font-medium bg-gray-50">Remediations</span>
                        <livewire:dealer.audit.body-shop.generate-remediation-button :bodyShopViolationAudit="$bodyShopAudit" />
                    @endif
                    @can('delete-audits')
                        <div class="border-0 bg-gray-800/15 h-px w-full"></div>
                        <button wire:click="$emit('modal.open', 'dealer.audit.body-shop.delete',  @js(['bodyShopAudit' => $bodyShopAudit->id]))" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-gray-100 hover:text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none">
                                <path d="M19.5 5.5L18.5 22H5.5L4.5 5.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                <path d="M2 5.5H8M22 5.5H16M16 5.5L14.5 2H9.5L8 5.5M16 5.5H8" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                <path d="M9.5 16.5L9.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                                <path d="M14.5 16.5L14.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                            </svg>
                            Delete
                        </button>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Item -->
        <div class="flex justify-between items-center gap-x-2">
        <span class="text-xs text-gray-600">
          Grade:
        </span>
            <span class="text-sm font-medium text-gray-800">
           {{ $bodyShopAudit->grade ?? 'N/A' }}
        </span>
        </div>
        <!-- End Item -->

        <!-- Item -->
        <div class="flex justify-between items-center gap-x-2">
        <span class="text-xs text-gray-600">
          Total Violations:
        </span>
        <span class="text-sm font-medium text-gray-800">
           {{ $bodyShopAudit->violation_count }}
        </span>
        </div>
        <!-- End Item -->

        <!-- Item -->
        <div class="flex justify-between items-center gap-x-2">
        <span class="text-xs text-gray-600">
          Total Remediations:
        </span>
            <span class="text-sm font-medium text-gray-800">
           {{ $bodyShopAudit->grade ? $bodyShopAudit->remediation_count : '-' }}
        </span>
        </div>
        <!-- End Item -->

        <!-- Item -->
        <div class="flex justify-between items-center gap-x-2">
        <span class="text-xs text-gray-600">
          Status:
        </span>
            <span @class([
                'inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium',
                'bg-teal-100 text-teal-800' => $bodyShopAudit->grade != null,
                'bg-sky-100 text-sky-800' => $bodyShopAudit->grade === null
            ])
              >
            {{ $bodyShopAudit->grade ? 'Complete' : 'In Progress' }}
        </span>
        </div>
        <!-- End Item -->
    </div>
</div>
