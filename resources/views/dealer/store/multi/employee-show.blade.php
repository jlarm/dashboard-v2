<x-store-app :title="$store->name">
    <div class="border-b border-gray-200 py-4 sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">{{ $user->name }}</h1>
        </div>
        <div class="mt-4 flex space-x-5 sm:mt-0 sm:ml-4">
            {{--            <button--}}
            {{--                onclick="Livewire.emit('slide-over.open', 'dealer.employee.edit', @js(['user' => $user->id]))"--}}
            {{--                class="sm:order-0 order-1 ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:ml-0"--}}
            {{--            >--}}
            {{--                Edit--}}
            {{--            </button>--}}
        </div>
    </div>
    <div class="py-12">
        <livewire:dealer.employee.course-results :user="$user"/>
    </div>
</x-store-app>
