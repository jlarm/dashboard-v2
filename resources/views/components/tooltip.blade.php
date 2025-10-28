@props([
    'placement' => 'top',   // top, bottom, left, right
    'content'   => '',
    'delayHide' => 120,     // ms delay before hiding
])

<span
    x-data="{
        open: false,
        hideTimeout: null,
        show() {
            this.clear();
            this.open = true;
        },
        scheduleHide() {
            this.clear();
            this.hideTimeout = setTimeout(() => {
                if (!this.$el.matches(':hover') && !this.$refs.tip.matches(':hover')) {
                    this.open = false;
                }
            }, {{ $delayHide }});
        },
        clear() {
            if (this.hideTimeout) {
                clearTimeout(this.hideTimeout);
                this.hideTimeout = null;
            }
        }
    }"
    @mouseenter="show()"
    @mouseleave="scheduleHide()"
    class="relative inline-block"
>
    <!-- Trigger Slot -->
    {{ $slot }}

    <!-- Tooltip -->
    <div
        x-ref="tip"
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak
        @mouseenter="show()"
        @mouseleave="scheduleHide()"
        class="
            absolute z-50 text-sm px-2 py-1 rounded bg-gray-900 text-white whitespace-nowrap pointer-events-auto
            {{ $placement === 'top'    ? 'bottom-full left-1/2 mb-2' : '' }}
            {{ $placement === 'bottom' ? 'top-full left-1/2 mt-2' : '' }}
            {{ $placement === 'left'   ? 'right-full top-1/2 mr-2' : '' }}
            {{ $placement === 'right'  ? 'left-full top-1/2 ml-2' : '' }}
        "
    >
        {{ $content }}
    </div>
</span>
