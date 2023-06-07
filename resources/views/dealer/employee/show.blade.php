<x-dealer-app>
    <div
        class="bg-gray-50 border-b border-gray-200 px-4 py-20 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate">{{ $user->name }}</h1>
            <p class="text-gray-400">{{ $user->department->name ?? '-' }} - {{ $user->roles->first()->name }}</p>
        </div>
        <div class="mt-4 flex space-x-5 sm:mt-0 sm:ml-4">
            {{--            <button--}}
            {{--                onclick="Livewire.emit('slide-over.open', 'dealer.employee.edit', @js(['user' => $user->id]))"--}}
            {{--                class="sm:order-0 order-1 ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:ml-0">--}}

            {{--                Edit--}}
            {{--            </button>--}}
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 xl:grid xl:grid-cols-3">
            <div class="xl:col-span-2 xl:border-r xl:border-gray-200 xl:pr-8">
                @if($user->department)
                    <livewire:dealer.employee.course-results :user="$user"/>
                @endif
            </div>
            <div class="hidden xl:block xl:pl-8">
                <livewire:dealer.employee.details :user="$user"/>
            </div>
        </div>
    </div>
</x-dealer-app>
