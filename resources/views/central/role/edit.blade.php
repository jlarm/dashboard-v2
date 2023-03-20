<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit the {{ $role->name }} Role
            </h2>
            <div class="flex space-x-5">

            </div>
        </div>
    </x-slot>

    <div class="py-12 px-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border p-10">
                <livewire:central.role.edit :role="$role"/>
            </div>
        </div>
    </div>
</x-app-layout>
