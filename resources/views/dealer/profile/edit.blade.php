<x-dealer-app>
    <x-slot name="header">
        <x-slot name="pageTitle">
            {{ __('Profile') }}
        </x-slot>
    </x-slot>

    <div class="space-y-10">
        <div class="max-w-xl">
            @include('dealer.profile.partials.update-profile-information-form')
        </div>
        <div class="max-w-xl">
            @include('dealer.profile.partials.update-password-form')
        </div>
        <livewire:dealer.profile.cert-index />
    </div>
</x-dealer-app>
