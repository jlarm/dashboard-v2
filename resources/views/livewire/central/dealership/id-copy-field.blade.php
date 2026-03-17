<div
    x-data="{
        dealershipId: '{{ $dealership->id }}',
        copied: false,
        timeout: null,
        copyToClipboard() {
            $clipboard(this.dealershipId);
            this.copied = true;
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                this.copied = false;
            }, 2000);
        }
    }"
>
    <button
        type="button"
        @click="copyToClipboard"
        class="group/button relative inline-flex items-center gap-1.5 rounded-md bg-gray-50 px-2.5 py-1.5 text-xs font-mono text-gray-600 ring-1 ring-inset ring-gray-200 transition-all hover:bg-gray-100 hover:ring-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1"
        :class="{ 'bg-green-50 ring-green-200 text-green-700': copied }"
    >
        <span>{{ $dealership->id }}</span>

        <svg
            x-show="!copied"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-3.5 w-3.5 text-gray-400 transition-colors group-hover/button:text-gray-600"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
        </svg>

        <svg
            x-show="copied"
            x-cloak
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            class="h-3.5 w-3.5 text-green-600"
        >
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
        </svg>
    </button>
</div>
