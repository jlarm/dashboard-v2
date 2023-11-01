<x-app-layout>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
        <aside class="lg:col-span-1">
            <div class="bg-white p-6 rounded-md">
                <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900 mb-5">{{ $user->name }}</h1>
                <div class="flex flex-col space-y-3">
                    <div class="flex flex-col space-y-1 text-arm-blue-500 text-sm">
                        <span><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></span>
                        <span>{{ $user->phoneNumber }}</span>
                        <span>{{ $user->roles()->first()->name }}</span>
                    </div>
                    <span class="text-gray-500 text-sm">Since: {{ $user->created_at->format('F d, Y') }}</span>
                </div>
            </div>
        </aside>
        <section class="col-span-3 bg-white p-4 rounded-md">
            <livewire:central.employee.dealership-list :user="$user"/>
        </section>
    </div>
</x-app-layout>
