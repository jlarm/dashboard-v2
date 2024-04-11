<x-dealer-app>
    <div
        class="px-6 py-5 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate capitalize">{{ mb_convert_case($user->name, MB_CASE_TITLE, "UTF-8") }}</h1>
            <p class="text-gray-400">{{ $user->department->name ?? '' }} - {{ $user->roles->first()->name ?? '' }}</p>
        </div>
        <div class="mt-4 flex space-x-5 sm:mt-0 sm:ml-4">
            @can('create-stores')
                @if(auth()->user()->id != $user->id)
                    <button
                        class="text-red-500 text-sm"
                        onclick="Livewire.emit('modal.open', 'dealer.employee.delete', @js(['user' => $user->id]))"
                    >
                        Delete
                    </button>
                @endif
            @endcan
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 xl:grid xl:grid-cols-3">
            <div class="xl:col-span-2 xl:border-r xl:border-gray-200 xl:pr-8">
                @if($user->department)
                    <livewire:dealer.employee.course-results :user="$user"/>
                @endif
            </div>
            <div class="xl:block xl:pl-8">
                <livewire:dealer.employee.details :user="$user"/>
                <livewire:dealer.employee.dot-cert :user="$user" />
                <livewire:dealer.employee.cert-index :user="$user"/>
            </div>
        </div>
    </div>
</x-dealer-app>
