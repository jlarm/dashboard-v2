<div>
    <x-slot name="header">
        <x-slot name="pageTitle">Documents</x-slot>
    </x-slot>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="border rounded-md p-5">
            <ul role="list" class="divide-y divide-gray-100">
                @forelse($docs as $doc)
                    <li class="flex justify-between gap-x-6 py-2">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-gray-900">{{ $doc->title }}</p>
                            </div>
                        </div>
                        <div class="space-x-5 flex flex-col md:flex-row justify-end">
                            @if($doc->url)
                                <a target="_blank"
                                   href="{{ $doc->url }}"
                                   class="text-sm leading-6 text-gray-900">
                                    Link
                                </a>
                            @endif
                            @if(!$doc->shared)
                                @if($doc->file_name)
                                    <a target="_blank"
                                       href="https://armp-dealer-docs.nyc3.cdn.digitaloceanspaces.com//{{ $doc->file_path }}"
                                       download
                                       class="text-sm leading-6 text-gray-900">
                                        Download
                                    </a>
                                @endif
                            @else
                                <button class="text-sm leading-6 text-gray-900" wire:click="download({{ $doc }})">Download</button>
                            @endif
                            @can('create-dealerships')
                                @if(!$doc->shared)
                                <button
                                    class="text-red-500 text-sm"
                                    wire:click="$emit('modal.open', 'dealer.docs.delete',  @js(['doc' => $doc->id]))"
                                >
                                    Delete
                                </button>
                                @endif
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
            @can('create-dealerships')
                <livewire:dealer.docs.create/>
            @endcan
        </div>
    </div>
</div>
