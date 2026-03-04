<x-dealer-app>
    @php($hasStores = app()->bound('storesExist') ? app('storesExist') : \App\Models\Dealer\Store::query()->exists())
    @if(! $hasStores)
        <div class="mx-auto max-w-3xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900">Create your first store</h2>
            <p class="mt-2 text-sm text-gray-600">
                You must create at least one store before using the rest of the dashboard.
            </p>

            @if(auth()->user()?->hasAnyRole(['super-admin', 'Consultant']))
                <form method="POST" action="{{ route('dealer.store.first') }}" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="first_store_name" :value="__('Name')"/>
                        <x-text-input
                            id="first_store_name"
                            name="name"
                            type="text"
                            class="mt-1 block w-full"
                            :value="old('name')"
                            required
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <div>
                        <x-input-label for="first_store_address" :value="__('Address')"/>
                        <x-text-input
                            id="first_store_address"
                            name="address"
                            type="text"
                            class="mt-1 block w-full"
                            :value="old('address')"
                            required
                        />
                        <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <x-input-label for="first_store_city" :value="__('City')"/>
                            <x-text-input
                                id="first_store_city"
                                name="city"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('city')"
                                required
                            />
                            <x-input-error :messages="$errors->get('city')" class="mt-2"/>
                        </div>
                        <div>
                            <x-input-label for="first_store_state" :value="__('State')"/>
                            <x-text-input
                                id="first_store_state"
                                name="state"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('state')"
                                required
                            />
                            <x-input-error :messages="$errors->get('state')" class="mt-2"/>
                        </div>
                        <div>
                            <x-input-label for="first_store_postal_code" :value="__('Postal Code')"/>
                            <x-text-input
                                id="first_store_postal_code"
                                name="postal_code"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('postal_code')"
                                required
                            />
                            <x-input-error :messages="$errors->get('postal_code')" class="mt-2"/>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <x-input-label for="first_store_phone" :value="__('Phone')"/>
                            <x-text-input
                                id="first_store_phone"
                                name="phone"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('phone')"
                                required
                            />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                        </div>
                        <div>
                            <x-input-label for="first_store_website" :value="__('Website')"/>
                            <x-text-input
                                id="first_store_website"
                                name="website"
                                type="url"
                                class="mt-1 block w-full"
                                :value="old('website')"
                                required
                            />
                            <x-input-error :messages="$errors->get('website')" class="mt-2"/>
                        </div>
                    </div>
                    <x-armp.button type="submit" variant="primary">Create Store</x-armp.button>
                </form>
            @else
                <p class="mt-4 text-sm text-gray-600">
                    A super-admin or consultant must create the first store to continue.
                </p>
            @endif
        </div>
    @else
        @php($hasSelectedStore = filled(auth()->user()?->current_store_id))
        @php($accessibleStoreCount = app()->bound('accessibleStoreIds') ? app('accessibleStoreIds')->count() : 0)
        @php($showSingleStoreWidgets = ($hasSelectedStore || $accessibleStoreCount === 1))
        <div class="space-y-5">
            {{-- Single Location Dealer View --}}
            @if($showSingleStoreWidgets)
                @can('create-stores')
                    {{-- Audit Stats --}}
                    <x-dealer.dashboard.audit-stats/>

                    {{-- Course Stats and Consultant Notes --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-5">
                        <x-dealer.dashboard.department-completion/>

                        @can('create-dealerships')
                            <x-dealer.dashboard.consultant-notes/>
                        @endcan

                        @role('Qualified Individual')
                        <div class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
                            <div class="p-5 pb-4">
                                <livewire:dealer.home.manuals/>
                            </div>
                        </div>
                        @endrole
                    </div>
                @endcan
            @endif

            {{-- Multiple Locations Dealer Group View --}}
            @if(! $showSingleStoreWidgets)
                @can('edit-stores')
                    <livewire:dealer.home.group-rating/>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-5">
                        <x-dealer.dashboard.department-completion
                            subtitle="*Based on all stores in your group and the total number of employees who completed required training."/>

                        <x-dealer.dashboard.stores-list/>
                    </div>
                @endcan
            @endif

            @can('create-users')
                <livewire:dealer.home.training-compliance/>
            @endcan

            {{-- Employee Course View --}}
            @cannot('create-stores')
                <x-dealer.dashboard.course-list/>
            @endcannot
        </div>
    @endif
</x-dealer-app>
