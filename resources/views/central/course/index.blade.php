<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Courses') }}
            </h2>
            <div class="flex space-x-5">
            </div>
        </div>
    </x-slot>

    <div class="py-12 px-5 lg:px-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:central.course.index/>
        </div>
    </div>
</x-app-layout>
