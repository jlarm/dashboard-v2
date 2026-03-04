<x-dealer-app>
    @php
        $settingsSections = [
            [
                'label' => 'General',
                'route' => route('dealer.dealer.settings'),
                'key' => 'general',
            ],
            [
                'label' => 'Managers',
                'route' => route('dealer.dealer.settings.managers'),
                'key' => 'managers',
            ],
            [
                'label' => 'Compliance',
                'route' => route('dealer.dealer.settings.compliance'),
                'key' => 'compliance',
            ],
        ];

        if (auth()->user()?->can('create-dealerships')) {
            $settingsSections[] = [
                'label' => 'Reset Courses',
                'route' => route('dealer.dealer.settings.reset-courses'),
                'key' => 'reset-courses',
            ];
            $settingsSections[] = [
                'label' => 'Ridgeback',
                'route' => route('dealer.dealer.settings.ridgeback'),
                'key' => 'ridgeback',
            ];
        }
    @endphp

    @if($store)
    <div>
        <x-slot name="header">
            <x-slot name="pageTitle">Settings</x-slot>
        </x-slot>
        <div class="flex justify-center">
            <div class="inline-flex h-10 rounded-lg bg-gray-800/5 p-1">
                @foreach($settingsSections as $settingsSection)
                    <a
                        href="{{ $settingsSection['route'] }}"
                        class="{{ $section === $settingsSection['key'] ? 'shadow-sm bg-white text-gray-600' : 'border-transparent text-gray-600 hover:text-gray-800' }} flex whitespace-nowrap flex-1 items-center justify-center rounded-md px-4 text-sm"
                        @if($section === $settingsSection['key']) aria-current="page" @endif
                    >
                        {{ $settingsSection['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
        <div class="mt-5">
            @if($section === 'general')
                <section class="p-2">
                <livewire:dealer.store.single-store-details :store="$store"/>
                </section>
            @elseif($section === 'managers')
                <section class="p-2">
                    <livewire:dealer.settings.employee-list :store="$store"/>
                </section>
            @elseif($section === 'compliance')
                <section class="p-2">
                    <livewire:dealer.store.single-onboarding-details :store="$store"/>
                </section>
            @elseif($section === 'reset-courses')
                <section class="p-2">
                    <div class="max-w-6xl mx-auto">
                        <livewire:dealer.settings.course-reset-manager :store="$store" />
                    </div>
                </section>
            @elseif($section === 'ridgeback')
                <section class="p-2">
                    <livewire:dealer.settings.ridgeback-settings-form :store="$store" />
                </section>
            @endif
        </div>
    </div>
    @else
    <x-slot name="header">
        <x-slot name="pageTitle">Settings Overview</x-slot>
    </x-slot>

    <div class="space-y-4">
        <div class="flex justify-center">
            <div class="inline-flex h-10 rounded-lg bg-gray-800/5 p-1">
                @foreach($settingsSections as $settingsSection)
                    <a
                        href="{{ $settingsSection['route'] }}"
                        class="{{ $section === $settingsSection['key'] ? 'shadow-sm bg-white text-gray-600' : 'border-transparent text-gray-600 hover:text-gray-800' }} flex whitespace-nowrap flex-1 items-center justify-center rounded-md px-4 text-sm"
                        @if($section === $settingsSection['key']) aria-current="page" @endif
                    >
                        {{ $settingsSection['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-4 text-sm text-gray-700">
            Overview mode is active. Select a store from the store switcher to edit detailed settings.
        </div>

        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Store</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Location</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Users</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @foreach($stores as $overviewStore)
                    <tr>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $overviewStore->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ trim(($overviewStore->city ?? '').', '.($overviewStore->state ?? ''), ', ') ?: '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $overviewStore->users_count }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</x-dealer-app>
