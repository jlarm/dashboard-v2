<div class="bg-white rounded-md p-6">
    <div
        class="sm:flex sm:items-center sm:justify-between">
        <div class="min-w-0 flex-1">
            <h1 class="text-xl font-bold leading-none tracking-tight text-neutral-900">Documents</h1>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
        <div class="border rounded-md p-5 bg-white">
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
                               href="https://central-docs.nyc3.cdn.digitaloceanspaces.com/{{ $doc->file_name }}"
                               download
                               class="text-sm leading-6 text-gray-900">
                                Download
                            </a>
                            @can('delete-dealerships')
                                <button
                                    class="text-red-500 text-sm"
                                    wire:click="$emit('modal.open', 'central.docs.delete',  @js(['doc' => $doc->id]))"
                                >
                                    Delete
                                </button>
                            @endcan
                        </div>
                    </li>
                @empty
                    <li class="flex justify-between gap-x-6 py-5">
                        <p class="text-sm font-semibold leading-6 text-gray-900">No documents have been uploaded</p>
                    </li>
                @endforelse
            </ul>
        </div>
        <div class="border rounded-md p-5">
            @can('delete-dealerships')
                <livewire:central.docs.create/>
            @endcan
        </div>
    </div>
</div>
