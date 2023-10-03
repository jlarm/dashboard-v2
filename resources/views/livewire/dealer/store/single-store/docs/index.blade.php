<div>
    <div>
        <livewire:dealer.store.single-store-sub-nav :store="$store"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="border p-5 rounded-lg">
                        <ul role="list" class="divide-y divide-gray-100">
                            @forelse($docs as $doc)
                                <li class="flex justify-between gap-x-6 py-5">
                                    <div class="flex min-w-0 gap-x-4">
                                        <div class="min-w-0 flex-auto">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">{{ $doc->title }}</p>
                                        </div>
                                    </div>
                                    <div class="space-x-5 flex flex-col md:flex-row justify-end">
                                        <a target="_blank"
                                           href="https://armp-dealer-docs.nyc3.cdn.digitaloceanspaces.com//{{ $doc->file_path }}"
                                           download
                                           class="text-sm leading-6 text-gray-900">
                                            Download
                                        </a>
                                        @can('create-dealerships')
                                            <button
                                                class="text-red-500 text-sm"
                                                wire:click="$emit('modal.open', 'dealer.docs.delete',  @js(['doc' => $doc->id]))"
                                            >
                                                Delete
                                            </button>
                                        @endcan
                                    </div>
                                </li>
                            @empty
                                <li class="flex justify-between gap-x-6 py-5">
                                    <p class="text-sm font-semibold leading-6 text-gray-900">No documents have been
                                        uploaded</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="border p-5 rounded-lg">
                        @can('create-dealerships')
                            <livewire:dealer.store.single-store.docs.create :store="$store"/>
                        @endcan
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
