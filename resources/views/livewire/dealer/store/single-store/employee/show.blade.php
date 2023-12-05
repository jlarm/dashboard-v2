<div>
    <div>
        <div class="px-6">
            <div class="py-5 sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-4xl font-bold text-arm-blue-900 sm:truncate leading-normal">{{ $user->name }}</h1>
                </div>
                <div class="sm:ml-16 sm:mt-0 sm:flex-none">
                    @can('create-stores')
                        <button
                            class="text-red-500 text-sm"
                            onclick="Livewire.emit('modal.open', 'dealer.store.single-store.employee.delete', @js(['user' => $user->id, 'store' => $store->id]))"
                        >
                            Delete
                        </button>
                    @endcan
                </div>
            </div>
            <div class="flow-root">
                <div class="mx-auto xl:grid xl:grid-cols-3">
                    <div class="xl:col-span-2 xl:border-r xl:border-gray-200 xl:pr-8">
                        <livewire:dealer.employee.course-results :user="$user"/>
                    </div>
                    <div class="hidden xl:block xl:pl-8">
                        <livewire:dealer.employee.details :user="$user"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
