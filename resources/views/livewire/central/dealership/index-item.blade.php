<div class="group relative overflow-hidden flex flex-col justify-between rounded-lg border border-gray-200 bg-white shadow-sm transition-all hover:shadow-md">
    <div class="p-6">
        <div>
            <h3 class="text-lg font-medium text-gray-900">{{ $dealership->name }}</h3>
            @role('super-admin')
                <div
                    x-data="{
                        link: '{{ $dealership->id }}',
                        copied: false,
                        timeout: null,
                        copy () {
                            $clipboard(this.link)
                            this.copied = true
                            clearTimeout(this.timeout)
                            this.timeout = setTimeout(() => {
                                this.copied = false
                            }, 3000)
                        }
                    }"
                >
                    <span class="relative inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-mono text-gray-500 ring-1 ring-inset ring-gray-200 hover:cursor-pointer hover:bg-gray-100" x-on:click="copy">
                        {{ $dealership->id }}
                        <svg x-cloak x-show="!copied" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-1 h-3.5 w-3.5 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25" />
                        </svg>
                        <svg x-cloak x-show="copied" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-1 h-3.5 w-3.5 text-green-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                        </svg>
                    </span>
                </div>
            @endrole
        </div>
        
        <div class="mt-4">
            <div class="flex items-center -space-x-2">
                @foreach($dealership->users as $user)
                    <div class="relative" x-data="{ showTooltip: false }" >
                        <span
                            class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 text-xs font-medium text-gray-800 ring-2 ring-white transition-all hover:bg-gray-200"
                            @mouseenter="showTooltip = true"
                            @mouseleave="showTooltip = false"
                        >
                            {{ $user->initials }}
                        </span>
                        <div
                            x-show="showTooltip"
                            x-cloak
                            class="absolute bottom-full left-1/2 mb-2 -translate-x-1/2 whitespace-nowrap rounded-md bg-gray-800 px-2 py-1 text-xs font-medium text-white shadow-sm"
                        >
                            {{ $user->name }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="border-t border-gray-100 bg-gray-50 p-4">
        <div class="flex gap-x-2">
            <button wire:click="$emit('slide-over.open', 'central.dealership.edit', @js(['dealership' => $dealership->id]))" class="inline-flex w-full items-center justify-center rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Edit</button>
            <a href="https://{{ $dealership->domain }}/dashboard" target="_blank" class="inline-flex w-full items-center justify-center rounded-md bg-arm-blue-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-arm-blue-700">View</a>
        </div>
    </div>
</div>