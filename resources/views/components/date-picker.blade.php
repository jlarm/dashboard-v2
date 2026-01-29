@props([
      'label' => null,
      'value' => null,
      'placeholder' => 'Select date',
      'format' => 'Y-m-d',
      'minDate' => null,
      'maxDate' => null,
      'disabled' => false,
      'size' => 'base',
      'required' => false,
  ])

@php
    $sizeClasses = [
        'sm' => 'px-2.5 py-1.5 text-sm',
        'base' => 'px-3 py-2 text-sm',
        'lg' => 'px-4 py-2.5 text-base',
    ];

    $inputId = $attributes->get('id') ?? 'datepicker-' . Str::random(8);
    $calendarId = 'calendar-' . $inputId;
@endphp

<div wire:ignore data-datepicker="{{ $inputId }}" data-format="{{ $format }}" data-min-date="{{ $minDate }}" data-max-date="{{ $maxDate }}" data-value="{{ $value }}">
    @if ($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input
            type="text"
            id="{{ $inputId }}"
            readonly
            placeholder="{{ $placeholder }}"
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge(['class' => implode(' ', [
                'block w-full rounded-md shadow-sm border border-gray-300',
                'bg-white dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300',
                'focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:border-arm-blue-500',
                'disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50',
                'cursor-pointer transition ease-in-out duration-150',
                $sizeClasses[$size],
            ])]) }}
        />

        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>

        <div
            id="{{ $calendarId }}"
            class="hidden absolute z-50 mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-4"
            style="min-width: 280px;"
        >
            <div class="flex items-center justify-between mb-4">
                <button
                    type="button"
                    data-action="prev-month"
                    class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                >
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <div class="flex gap-2">
                    <select
                        data-select="month"
                        class="text-sm font-medium text-gray-900 dark:text-gray-100 bg-transparent border-0 focus:ring-0 cursor-pointer"
                    >
                        <option value="0">January</option>
                        <option value="1">February</option>
                        <option value="2">March</option>
                        <option value="3">April</option>
                        <option value="4">May</option>
                        <option value="5">June</option>
                        <option value="6">July</option>
                        <option value="7">August</option>
                        <option value="8">September</option>
                        <option value="9">October</option>
                        <option value="10">November</option>
                        <option value="11">December</option>
                    </select>

                    <select
                        data-select="year"
                        class="text-sm font-medium text-gray-900 dark:text-gray-100 bg-transparent border-0 focus:ring-0 cursor-pointer"
                    ></select>
                </div>

                <button
                    type="button"
                    data-action="next-month"
                    class="p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                >
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-7 gap-0.5 mb-2">
                <div class="text-xs font-medium text-center text-gray-500 dark:text-gray-400 py-2">Su</div>
                <div class="text-xs font-medium text-center text-gray-500 dark:text-gray-400 py-2">Mo</div>
                <div class="text-xs font-medium text-center text-gray-500 dark:text-gray-400 py-2">Tu</div>
                <div class="text-xs font-medium text-center text-gray-500 dark:text-gray-400 py-2">We</div>
                <div class="text-xs font-medium text-center text-gray-500 dark:text-gray-400 py-2">Th</div>
                <div class="text-xs font-medium text-center text-gray-500 dark:text-gray-400 py-2">Fr</div>
                <div class="text-xs font-medium text-center text-gray-500 dark:text-gray-400 py-2">Sa</div>
            </div>

            <div data-calendar-grid class="grid grid-cols-7 gap-0.5"></div>

            <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <button
                    type="button"
                    data-action="today"
                    class="text-sm text-arm-blue-600 dark:text-arm-blue-400 hover:text-arm-blue-700 dark:hover:text-arm-blue-300 font-medium"
                >
                    Today
                </button>

                <button
                    type="button"
                    data-action="clear"
                    class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                >
                    Clear
                </button>
            </div>
        </div>
    </div>
</div>
