<div x-data="{
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
     x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
     x-id="['dropdown-button']"
     class="relative ml-3">
    <div>
        <button
            x-ref="button"
            x-on:click="toggle()"
            :aria-expanded="open"
            :aria-controls="$id('dropdown-button')"
            type="button"
            class="flex max-w-xs items-center bg-gray-50 hover:text-arm-blue-500 text-sm focus:outline-none"
            id="user-menu-button" aria-expanded="false" aria-haspopup="true"
        >
            <span class="sr-only">Open user menu</span>
            {{ auth()->user()->name }}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-3 h-3 ml-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
            </svg>
        </button>
    </div>
    <div
        x-ref="panel"
        x-show="open"
        x-transition.origin.top.left
        x-on:click.outside="close($refs.button)"
        :id="$id('dropdown-bottom')"
        style="display:none;"
        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
    >
        <!-- Active: "bg-gray-100", Not Active: "" -->
        <a href="{{ route('dealer.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
           tabindex="-1" id="user-menu-item-0">Your Profile</a>
        <form method="POST" action="{{ route('dealer.logout') }}">
            @csrf
            <a
                href="#"
                onclick="event.preventDefault(); this.closest('form').submit();"
                class="block px-4 py-2 text-sm text-gray-700"
                role="menuitem"
                tabindex="-1"
            >
                {{ __('Sign Out') }}
            </a>
        </form>
    </div>
</div>
