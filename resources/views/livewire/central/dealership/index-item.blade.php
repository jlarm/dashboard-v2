<x-table.row>
    <x-table.cell>
        {{ $dealership->name }}
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
            <span class="relative text-xs font-light font-mono text-gray-400 hover:cursor-pointer" x-on:click="copy">
                {{ $dealership->id }}
                <svg x-cloak x-show="copied" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400 absolute -right-5 top-0">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                </svg>
            </span>
        </div>
        @endrole
        <dl class="font-normal lg:hidden">
            @role('super-admin')
            <dd class="mt-1 truncate text-gray-500 sm:hidden">
                @foreach($dealership->users as $user)
                    <p class="text-xs">{{ $user->name }}</p>
                @endforeach
            </dd>
            @endrole
            <dd class="mt-1 truncate text-gray-700">
                <a class="flex items-center space-y-3 text-arm-blue-500 group" target="_blank"
                   href="https://{{ $dealership->domain }}/dashboard">
                    {{ $dealership->domain }}
                    <svg class="w-3 h-3 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none">
                        <path d="M12 3H3V21H21V12" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                        <path d="M10.9883 13.0016L20.5838 3.41584M20.9998 8.99185L21.0001 3H15.0108" stroke="currentColor" stroke-width="1.5" />
                    </svg>
                </a>
            </dd>
        </dl>
    </x-table.cell>
    <x-table.cell>
        @role('super-admin')
        <div class="flex items-center -space-x-2">
            @foreach($dealership->users as $user)
                <div class="relative group" x-data="{ showTooltip: false }">
            <span
                class="inline-flex items-center justify-center size-8 rounded-full bg-gray-500 ring-2 ring-white text-xs font-semibold text-white"
                @mouseenter="showTooltip = true"
                @mouseleave="showTooltip = false"
            >
                {{ $user->initials }}
            </span>
                    <div
                        x-show="showTooltip"
                        x-cloak
                        class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 whitespace-nowrap bg-gray-800 text-white text-xs px-2 py-1 rounded shadow-lg"
                    >
                        {{ $user->name }}
                    </div>
                </div>
            @endforeach
        </div>
        @endrole
    </x-table.cell>
    <x-table.cell>
        <a class="flex items-center space-y-3" target="_blank"
           href="https://{{ $dealership->domain }}/dashboard">
            {{ $dealership->domain }}
            <svg class="w-3 h-3 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" color="#9b9b9b" fill="none">
                <path d="M12 3H3V21H21V12" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                <path d="M10.9883 13.0016L20.5838 3.41584M20.9998 8.99185L21.0001 3H15.0108" stroke="currentColor" stroke-width="1.5" />
            </svg>
        </a>
    </x-table.cell>
    <x-table.cell>
        @if(auth()->user()->id === 1)
            <div class="flex gap-x-2 justify-end">
                <button
                    wire:click="$emit('slide-over.open', 'central.dealership.edit', @js(['dealership' => $dealership->id]))"
                    class="text-arm-blue-600 hover:text-arm-blue-900">Edit
                </button>
                @if(config('app.env') === 'local')
                <livewire:central.dealership.delete :dealership="$dealership" />
                @endif
            </div>
        @endif
    </x-table.cell>
</x-table.row>
