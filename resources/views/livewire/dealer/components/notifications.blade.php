<div
    x-data="{
        open: false,
            toggle() {
                if (this.open) {
                    return this.close()
                }

                this.$refs.button.focus()

                this.open = true
            },
            close(focusAfter) {
                if (! this.open) return

                this.open = false

                focusAfter && focusAfter.focus()
            }
    }"
    x-on:keydown.escape.prevent.stop="close($refs.button)"
    x-on:focusin.window="$refs.panel && !$refs.panel.contains($event.target) && close()"
    x-id="['dropdown-button']"
    class="relative"
>
    <button
        @if(auth()->user()->unreadNotifications->count() == 0) disabled @endif
        x-ref="button"
        x-on:click="toggle()"
        type="button"
        class="relative rounded-full bg-white p-1 text-gray-400"
    >
        <span class="absolute -inset-1.5"></span>
        <span class="sr-only">View notifications</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"></path>
        </svg>
        @if(auth()->user()->unreadNotifications->count() > 0)
        <span class="absolute -right-1 -top-1 h-5 w-5 flex justify-center items-center rounded-full bg-red-500 ring-2 ring-white text-white text-xs">
            {{ auth()->user()->unreadNotifications->count() }}
        </span>
        @endif
    </button>
    @if(auth()->user()->unreadNotifications->count() > 0)
    <div
        x-ref="panel"
        x-show="open"
        x-transition.origin.top.left
        x-on:click.outside="close($refs.button)"
        :id="$id('dropdown-button')"
        style="display: none;"
        class="absolute right-0 mt-2 w-72 rounded-md bg-white shadow-md border"
    >
        <ul class="divide-y divide-gray-200">
            @foreach(auth()->user()->unreadNotifications as $notification)
                <li class="px-2 py-3 flex justify-between items-center hover:bg-gray-50 group">
                    <p class="text-xs w-5/6">
                        {{ $notification->data['message'] }}<br />
                        <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                    </p>
                    <div>
                        <button wire:click="markAsRead({{ $notification }})" class="w-1/6 hidden group-hover:block hover:bg-white rounded-full p-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </li>
            @endforeach
            <li class="p-1">
               <button x-on:click="toggle()" wire:click="markAllAsRead" class="w-full px-2 py-3 text-sm text-arm-blue-500 hover:text-arm-blue-600 hover:bg-gray-50 rounded-b-md">Mark all as Read</button>
            </li>
        </ul>
    </div>
    @endif
</div>
