@props([
      'name',
      'show' => false,
      'maxWidth' => 'md',
  ])

@php
    $maxWidthClass = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth];
@endphp

<div
    x-data="{
          show: @js($show),
          focusables() {
              let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
              return [...$el.querySelectorAll(selector)]
                  .filter(el => ! el.hasAttribute('disabled'))
          },
          firstFocusable() { return this.focusables()[0] },
          lastFocusable() { return this.focusables().slice(-1)[0] },
          nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
          prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
          nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
          prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
      }"
    x-init="$watch('show', value => {
          if (value) {
              document.body.classList.add('overflow-hidden');
              {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }}
          } else {
              document.body.classList.remove('overflow-hidden');
          }
      })"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-0"
    style="display: none;"
>
    <div class="fixed inset-0" x-on:click="show = false">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div class="relative bg-white rounded-lg overflow-hidden shadow-xl sm:w-full {{ $maxWidthClass }}">
        {{ $slot }}
    </div>
</div>
