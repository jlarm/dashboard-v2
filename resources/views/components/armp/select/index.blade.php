@props([
    'variant' => 'native',
    'placeholder' => null,
    'value' => null,
    'size' => 'base',
    'disabled' => false,
    'invalid' => false,
    'multiple' => false,
    'searchable' => false,
    'clearable' => false,
    'label' => null,
    'description' => null,
])

@php
    $id = $attributes->get('id') ?? 'armp-select-' . Str::random(8);
    $name = $attributes->get('name');

    $wireModel = null;
    foreach ($attributes->getAttributes() as $key => $val) {
        if (str_starts_with($key, 'wire:model')) {
            $wireModel = $val;
            break;
        }
    }

    $hasError = $invalid || ($wireModel && $errors->has($wireModel));
    $errorMessage = $wireModel ? $errors->first($wireModel) : null;

    $sizes = [
        'xs'   => ['trigger' => 'h-7 text-xs px-2',   'icon' => 'size-3.5', 'option' => 'px-2 py-1 text-xs'],
        'sm'   => ['trigger' => 'h-8 text-sm px-2.5',  'icon' => 'size-4',   'option' => 'px-2.5 py-1 text-sm'],
        'base' => ['trigger' => 'h-10 text-sm px-3',   'icon' => 'size-5',   'option' => 'px-3 py-1.5 text-sm'],
    ];
    $sz = $sizes[$size] ?? $sizes['base'];

    $borderClasses = $hasError
        ? 'border-red-500 focus-within:border-red-500 focus-within:ring-red-500/25 dark:border-red-400'
        : 'border-zinc-200 focus-within:ring-zinc-950/10 dark:border-white/10 dark:focus-within:ring-white/10';

    $nativeClasses = implode(' ', [
        'block w-full appearance-none rounded-lg border shadow-sm bg-white',
        'text-zinc-800 dark:text-white dark:bg-white/10',
        'focus:outline-none focus:ring-2 focus:ring-offset-0',
        'disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-zinc-50 dark:disabled:bg-white/[0.03]',
        'transition duration-100',
        $hasError
            ? 'border-red-500 focus:border-red-500 focus:ring-red-500/25 dark:border-red-400'
            : 'border-zinc-200 focus:ring-zinc-950/10 dark:border-white/10 dark:focus:ring-white/10',
        $sz['trigger'],
        'pr-10',
    ]);

    $isCombobox = $variant === 'combobox';

    $config = [
        'multiple'     => (bool) $multiple,
        'searchable'   => (bool) ($searchable || $isCombobox),
        'clearable'    => (bool) $clearable,
        'disabled'     => (bool) $disabled,
        'placeholder'  => $placeholder ?? '',
        'isCombobox'   => $isCombobox,
        'initialValue' => $value,
    ];
@endphp

<div class="w-full">
    @if ($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-zinc-800 dark:text-white mb-1.5">
            {{ $label }}
        </label>
    @endif

    @if ($variant === 'native')
        {{-- Native <select> --}}
        <div class="relative">
            <select
                id="{{ $id }}"
                @disabled($disabled)
                {{ $attributes->except(['id', 'disabled', 'class'])->merge(['class' => $nativeClasses]) }}
            >
                @if ($placeholder)
                    <option value="" disabled selected>{{ $placeholder }}</option>
                @endif
                {{ $slot }}
            </select>

            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <svg class="{{ $sz['icon'] }} text-zinc-400 dark:text-zinc-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    @else
        {{-- Listbox / Combobox --}}
        <div
            class="relative"
            data-armp-select
            data-select-config='@json($config)'
        >
            {{-- Hidden input for form / wire:model --}}
            <input
                type="hidden"
                data-select-input
                {{ $attributes->whereStartsWith('wire:model') }}
                @if ($name) name="{{ $name }}" @endif
                @if ($value) value="{{ is_array($value) ? json_encode($value) : $value }}" @endif
            >

            @if ($isCombobox)
                {{-- Combobox trigger: input --}}
                <div @class([
                    'relative flex items-center rounded-lg border shadow-sm transition duration-100',
                    'bg-white dark:bg-white/10',
                    $borderClasses,
                    'opacity-50 cursor-not-allowed' => $disabled,
                ])>
                    <input
                        type="text"
                        data-select-trigger
                        data-select-combobox-input
                        id="{{ $id }}"
                        placeholder="{{ $placeholder }}"
                        autocomplete="off"
                        @disabled($disabled)
                        @class([
                            'w-full bg-transparent border-0 outline-none focus:ring-0',
                            'text-zinc-800 dark:text-white placeholder-zinc-400 dark:placeholder-zinc-500',
                            $sz['trigger'],
                            'pr-10',
                        ])
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center gap-1 pr-3">
                        @if ($clearable)
                            <button type="button" data-select-clear class="hidden text-zinc-400 hover:text-zinc-600 dark:text-zinc-500 dark:hover:text-zinc-300 transition" tabindex="-1">
                                <svg class="{{ $sz['icon'] }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                </svg>
                            </button>
                        @endif
                        <svg class="{{ $sz['icon'] }} text-zinc-400 dark:text-zinc-500 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            @else
                {{-- Listbox trigger: button --}}
                <button
                    type="button"
                    data-select-trigger
                    id="{{ $id }}"
                    @disabled($disabled)
                    role="combobox"
                    aria-expanded="false"
                    aria-haspopup="listbox"
                    @class([
                        'relative flex w-full items-center text-left rounded-lg border shadow-sm transition duration-100',
                        'bg-white dark:bg-white/10',
                        $borderClasses,
                        $sz['trigger'],
                        'pr-10',
                        'focus:outline-none focus:ring-2',
                        'opacity-50 cursor-not-allowed' => $disabled,
                        'cursor-pointer' => ! $disabled,
                    ])
                >
                    <span data-select-label class="truncate text-zinc-400 dark:text-zinc-500">
                        {{ $placeholder }}
                    </span>

                    <div class="absolute inset-y-0 right-0 flex items-center gap-1 pr-3">
                        @if ($clearable)
                            <button type="button" data-select-clear class="hidden text-zinc-400 hover:text-zinc-600 dark:text-zinc-500 dark:hover:text-zinc-300 transition" tabindex="-1">
                                <svg class="{{ $sz['icon'] }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                </svg>
                            </button>
                        @endif
                        <svg class="{{ $sz['icon'] }} text-zinc-400 dark:text-zinc-500 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            @endif

            {{-- Dropdown panel --}}
            <div
                data-select-panel
                role="listbox"
                class="hidden absolute z-50 mt-1 w-full rounded-xl border border-zinc-200 bg-white shadow-lg dark:border-white/10 dark:bg-zinc-800 opacity-0 scale-95 transition-all duration-150 origin-top"
            >
                @if ($searchable && ! $isCombobox)
                    <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-white/10 px-3 py-2">
                        <svg class="size-4 text-zinc-400 dark:text-zinc-500 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                        </svg>
                        <input
                            type="text"
                            data-select-search
                            class="w-full bg-transparent border-0 p-0 text-sm text-zinc-800 dark:text-white placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-0"
                            placeholder="Search..."
                            autocomplete="off"
                        >
                    </div>
                @endif

                <div data-select-options class="p-1 max-h-64 overflow-y-auto">
                    {{ $slot }}
                </div>

                <div data-select-empty class="hidden px-3 py-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
                    No results found.
                </div>
            </div>
        </div>
    @endif

    @if ($description && ! $hasError)
        <p class="mt-1.5 text-sm text-zinc-500 dark:text-zinc-400">{{ $description }}</p>
    @endif

    @if ($hasError)
        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400">
            {{ $errorMessage }}
        </p>
    @endif
</div>

@once
<style>
    [data-armp-select] [data-option-value][data-highlighted] {
        background-color: rgb(244 244 245); /* zinc-100 */
    }

    @media (prefers-color-scheme: dark) {
        [data-armp-select] [data-option-value][data-highlighted] {
            background-color: rgba(255, 255, 255, 0.05); /* white/5 */
        }
    }
</style>

<script>
(function () {
    class ArmpSelect {
        constructor(root) {
            this.root = root;
            this.config = JSON.parse(root.dataset.selectConfig || '{}');
            this.isOpen = false;
            this.selectedValue = this.config.multiple ? [] : '';
            this.selectedLabel = '';
            this.searchQuery = '';
            this.highlightedIndex = -1;
            this.options = [];

            this.trigger = root.querySelector('[data-select-trigger]');
            this.panel = root.querySelector('[data-select-panel]');
            this.searchInput = root.querySelector('[data-select-search]');
            this.comboboxInput = root.querySelector('[data-select-combobox-input]');
            this.optionsContainer = root.querySelector('[data-select-options]');
            this.hiddenInput = root.querySelector('[data-select-input]');
            this.triggerLabel = root.querySelector('[data-select-label]');
            this.clearButton = root.querySelector('[data-select-clear]');
            this.emptyState = root.querySelector('[data-select-empty]');

            this._collectOptions();
            this._bindEvents();
            this._syncInitialValue();
        }

        _collectOptions() {
            var els = this.optionsContainer ? this.optionsContainer.querySelectorAll('[data-option-value]') : [];
            this.options = Array.from(els).map(function (el, i) {
                return { el: el, value: el.dataset.optionValue, label: el.dataset.optionLabel || el.textContent.trim(), index: i, visible: true };
            });
        }

        _bindEvents() {
            var self = this;

            if (this.trigger) {
                if (this.config.isCombobox) {
                    this.trigger.addEventListener('focus', function () { self.open(); });
                    this.trigger.addEventListener('click', function () { self.open(); });
                    this.trigger.addEventListener('input', function (e) {
                        self.searchQuery = e.target.value.toLowerCase();
                        self._filterOptions();
                        if (!self.isOpen) self.open();
                    });
                } else {
                    this.trigger.addEventListener('click', function () { self.toggle(); });
                }
            }

            document.addEventListener('click', function (e) {
                if (!self.root.contains(e.target)) self.close();
            });

            this.root.addEventListener('keydown', function (e) { self._handleKeydown(e); });

            if (this.searchInput) {
                this.searchInput.addEventListener('input', function (e) {
                    self.searchQuery = e.target.value.toLowerCase();
                    self._filterOptions();
                });
            }

            this.options.forEach(function (opt) {
                opt.el.addEventListener('click', function () { self._selectOption(opt); });
                opt.el.addEventListener('mouseenter', function () {
                    self.highlightedIndex = opt.index;
                    self._updateHighlight();
                });
            });

            if (this.clearButton) {
                this.clearButton.addEventListener('click', function (e) {
                    e.stopPropagation();
                    e.preventDefault();
                    self.clear();
                });
            }
        }

        _syncInitialValue() {
            var val = this.config.initialValue || (this.hiddenInput ? this.hiddenInput.value : '');
            if (!val) return;

            if (this.config.multiple) {
                try { this.selectedValue = Array.isArray(val) ? val : JSON.parse(val); }
                catch (e) { this.selectedValue = []; }
            } else {
                this.selectedValue = val;
                var opt = this.options.find(function (o) { return o.value === val; });
                if (opt) this.selectedLabel = opt.label;
            }

            this._updateDisplay();
            this._updateOptionStates();
        }

        toggle() { this.isOpen ? this.close() : this.open(); }

        open() {
            if (this.config.disabled || this.isOpen) return;
            var self = this;
            this.isOpen = true;
            this.panel.classList.remove('hidden');

            requestAnimationFrame(function () {
                self.panel.classList.remove('opacity-0', 'scale-95');
                self.panel.classList.add('opacity-100', 'scale-100');
            });

            if (this.searchInput) {
                this.searchInput.value = '';
                this.searchQuery = '';
                this._filterOptions();
                setTimeout(function () { self.searchInput.focus(); }, 50);
            }

            if (this.config.isCombobox && this.comboboxInput) {
                this.comboboxInput.select();
            }

            if (!this.config.multiple && this.selectedValue) {
                var idx = this.options.findIndex(function (o) { return o.value === self.selectedValue; });
                if (idx !== -1) this.highlightedIndex = idx;
            } else {
                this.highlightedIndex = this._getFirstVisibleIndex();
            }

            this._updateHighlight();
            if (this.trigger) this.trigger.setAttribute('aria-expanded', 'true');
        }

        close() {
            if (!this.isOpen) return;
            var self = this;
            this.isOpen = false;
            this.panel.classList.remove('opacity-100', 'scale-100');
            this.panel.classList.add('opacity-0', 'scale-95');

            setTimeout(function () {
                if (!self.isOpen) self.panel.classList.add('hidden');
            }, 150);

            this.highlightedIndex = -1;
            this._updateHighlight();
            if (this.trigger) this.trigger.setAttribute('aria-expanded', 'false');

            if (this.config.isCombobox && this.comboboxInput) {
                this.comboboxInput.value = this.selectedLabel;
            }

            if (!this.config.isCombobox && this.trigger) {
                this.trigger.focus();
            }
        }

        _selectOption(opt) {
            if (this.config.multiple) {
                var idx = this.selectedValue.indexOf(opt.value);
                if (idx === -1) {
                    this.selectedValue.push(opt.value);
                } else {
                    this.selectedValue.splice(idx, 1);
                }
            } else {
                this.selectedValue = opt.value;
                this.selectedLabel = opt.label;
                this.close();
            }

            this._updateDisplay();
            this._updateOptionStates();
            this._syncHiddenInput();
        }

        clear() {
            this.selectedValue = this.config.multiple ? [] : '';
            this.selectedLabel = '';
            this._updateDisplay();
            this._updateOptionStates();
            this._syncHiddenInput();

            if (this.config.isCombobox && this.comboboxInput) {
                this.comboboxInput.value = '';
                this.searchQuery = '';
                this._filterOptions();
            }
        }

        _updateDisplay() {
            var self = this;

            if (this.triggerLabel) {
                if (this.config.multiple) {
                    var count = this.selectedValue.length;
                    if (count === 0) {
                        this.triggerLabel.textContent = this.config.placeholder;
                        this.triggerLabel.className = 'truncate text-zinc-400 dark:text-zinc-500';
                    } else if (count === 1) {
                        var match = this.options.find(function (o) { return self.selectedValue.includes(o.value); });
                        this.triggerLabel.textContent = match ? match.label : '1 selected';
                        this.triggerLabel.className = 'truncate text-zinc-800 dark:text-white';
                    } else {
                        this.triggerLabel.textContent = count + ' selected';
                        this.triggerLabel.className = 'truncate text-zinc-800 dark:text-white';
                    }
                } else {
                    if (this.selectedValue) {
                        this.triggerLabel.textContent = this.selectedLabel;
                        this.triggerLabel.className = 'truncate text-zinc-800 dark:text-white';
                    } else {
                        this.triggerLabel.textContent = this.config.placeholder;
                        this.triggerLabel.className = 'truncate text-zinc-400 dark:text-zinc-500';
                    }
                }
            }

            if (this.config.isCombobox && this.comboboxInput && !this.isOpen) {
                this.comboboxInput.value = this.selectedLabel;
            }

            if (this.clearButton) {
                var hasValue = this.config.multiple ? this.selectedValue.length > 0 : !!this.selectedValue;
                this.clearButton.classList.toggle('hidden', !hasValue);
            }
        }

        _updateOptionStates() {
            var self = this;

            this.options.forEach(function (opt) {
                var isSelected = self.config.multiple
                    ? self.selectedValue.includes(opt.value)
                    : self.selectedValue === opt.value;

                var check = opt.el.querySelector('[data-check]');
                if (check) check.style.opacity = isSelected ? '1' : '0';

                var checkbox = opt.el.querySelector('[data-checkbox]');
                var checkboxIcon = opt.el.querySelector('[data-checkbox-icon]');
                if (checkbox) {
                    checkbox.classList.toggle('bg-zinc-800', isSelected);
                    checkbox.classList.toggle('dark:bg-white', isSelected);
                    checkbox.classList.toggle('border-zinc-800', isSelected);
                    checkbox.classList.toggle('dark:border-white', isSelected);
                    checkbox.classList.toggle('border-zinc-300', !isSelected);
                    checkbox.classList.toggle('dark:border-zinc-600', !isSelected);
                    if (checkboxIcon) checkboxIcon.classList.toggle('hidden', !isSelected);
                }

                opt.el.setAttribute('aria-selected', isSelected.toString());
            });
        }

        _updateHighlight() {
            this.options.forEach(function (opt, i) {
                if (i === this.highlightedIndex && opt.visible) {
                    opt.el.setAttribute('data-highlighted', '');
                } else {
                    opt.el.removeAttribute('data-highlighted');
                }
            }.bind(this));

            if (this.highlightedIndex >= 0 && this.options[this.highlightedIndex]) {
                this.options[this.highlightedIndex].el.scrollIntoView({ block: 'nearest' });
            }
        }

        _filterOptions() {
            var self = this;
            var anyVisible = false;

            this.options.forEach(function (opt) {
                var match = !self.searchQuery || opt.label.toLowerCase().includes(self.searchQuery);
                opt.el.classList.toggle('hidden', !match);
                opt.visible = match;
                if (match) anyVisible = true;
            });

            if (this.emptyState) this.emptyState.classList.toggle('hidden', anyVisible);
            if (this.optionsContainer) this.optionsContainer.classList.toggle('hidden', !anyVisible);

            this.highlightedIndex = this._getFirstVisibleIndex();
            this._updateHighlight();
        }

        _getFirstVisibleIndex() {
            for (var i = 0; i < this.options.length; i++) {
                if (this.options[i].visible) return i;
            }
            return -1;
        }

        _handleKeydown(e) {
            if (!this.isOpen && ['Enter', ' ', 'ArrowDown', 'ArrowUp'].indexOf(e.key) !== -1) {
                if (e.key === ' ' && this.config.isCombobox) return;
                e.preventDefault();
                this.open();
                return;
            }

            if (!this.isOpen) return;

            switch (e.key) {
                case 'Escape':
                    e.preventDefault();
                    this.close();
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    this._highlightNext();
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    this._highlightPrev();
                    break;
                case 'Enter':
                    e.preventDefault();
                    if (this.highlightedIndex >= 0 && this.options[this.highlightedIndex] && this.options[this.highlightedIndex].visible) {
                        this._selectOption(this.options[this.highlightedIndex]);
                    }
                    break;
                case 'Tab':
                    this.close();
                    break;
            }
        }

        _highlightNext() {
            var visible = this.options.filter(function (o) { return o.visible; });
            if (visible.length === 0) return;
            var pos = visible.findIndex(function (o) { return o.index === this.highlightedIndex; }.bind(this));
            var next = (pos + 1) % visible.length;
            this.highlightedIndex = visible[next].index;
            this._updateHighlight();
        }

        _highlightPrev() {
            var visible = this.options.filter(function (o) { return o.visible; });
            if (visible.length === 0) return;
            var pos = visible.findIndex(function (o) { return o.index === this.highlightedIndex; }.bind(this));
            var prev = pos <= 0 ? visible.length - 1 : pos - 1;
            this.highlightedIndex = visible[prev].index;
            this._updateHighlight();
        }

        _syncHiddenInput() {
            if (!this.hiddenInput) return;

            if (this.config.multiple && window.Livewire) {
                var prop = null;
                var attrs = Array.from(this.hiddenInput.attributes);
                for (var i = 0; i < attrs.length; i++) {
                    if (attrs[i].name.startsWith('wire:model')) { prop = attrs[i].value; break; }
                }

                if (prop) {
                    var componentEl = this.root.closest('[wire\\:id]');
                    if (componentEl) {
                        var component = window.Livewire.find(componentEl.getAttribute('wire:id'));
                        if (component) {
                            component.set(prop, this.selectedValue.slice(), true);
                            return;
                        }
                    }
                }
            }

            this.hiddenInput.value = this.selectedValue;
            this.hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
            this.hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
        }

        static initAll() {
            document.querySelectorAll('[data-armp-select]:not([data-armp-select-init])').forEach(function (el) {
                el.setAttribute('data-armp-select-init', '');
                new ArmpSelect(el);
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { ArmpSelect.initAll(); });
    } else {
        ArmpSelect.initAll();
    }

    document.addEventListener('livewire:load', function () {
        if (window.Livewire) {
            Livewire.hook('message.processed', function () { ArmpSelect.initAll(); });
        }
    });

    window.ArmpSelect = ArmpSelect;
})();
</script>
@endonce
