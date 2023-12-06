<x-dealer-app>
    <div class="px-6 py-4 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">{{ __('Courses') }}</h1>
        </div>
{{--        <livewire:dealer.course.dot-cert />--}}
    </div>
    <div class="px-6">
        <div class="border rounded-md">
            <div class="p-6">
                <livewire:dealer.course.index/>
            </div>
        </div>
    </div>
</x-dealer-app>
