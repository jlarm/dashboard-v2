(function() {
    'use strict';

    class Datepicker {
        constructor(element) {
            this.element = element;
            this.inputId = element.getAttribute('data-datepicker');
            this.input = document.getElementById(this.inputId);
            this.calendar = document.getElementById('calendar-' + this.inputId);

            if (!this.input || !this.calendar) {
                return;
            }

            this.format = element.getAttribute('data-format') || 'Y-m-d';
            this.minDate = element.getAttribute('data-min-date') ? new Date(element.getAttribute('data-min-date')) : null;
            this.maxDate = element.getAttribute('data-max-date') ? new Date(element.getAttribute('data-max-date')) : null;
            this.selectedDate = null;
            this.currentMonth = new Date().getMonth();
            this.currentYear = new Date().getFullYear();

            this.monthSelect = this.calendar.querySelector('[data-select="month"]');
            this.yearSelect = this.calendar.querySelector('[data-select="year"]');
            this.calendarGrid = this.calendar.querySelector('[data-calendar-grid]');

            this.init();
        }

        init() {
            const initialValue = this.element.getAttribute('data-value');
            if (initialValue) {
                this.selectedDate = new Date(initialValue);
                this.currentMonth = this.selectedDate.getMonth();
                this.currentYear = this.selectedDate.getFullYear();
                this.updateInput();
            }

            this.generateYearOptions();
            this.bindEvents();
            this.renderCalendar();
        }

        bindEvents() {
            this.input.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.toggle();
            });

            this.calendar.querySelector('[data-action="prev-month"]').addEventListener('click', (e) => {
                e.preventDefault();
                this.previousMonth();
            });

            this.calendar.querySelector('[data-action="next-month"]').addEventListener('click', (e) => {
                e.preventDefault();
                this.nextMonth();
            });

            this.calendar.querySelector('[data-action="today"]').addEventListener('click', (e) => {
                e.preventDefault();
                this.selectToday();
            });

            this.calendar.querySelector('[data-action="clear"]').addEventListener('click', (e) => {
                e.preventDefault();
                this.clear();
            });

            this.monthSelect.addEventListener('change', (e) => {
                this.currentMonth = parseInt(e.target.value);
                this.renderCalendar();
            });

            this.yearSelect.addEventListener('change', (e) => {
                this.currentYear = parseInt(e.target.value);
                this.renderCalendar();
            });

            document.addEventListener('click', (e) => {
                if (!this.element.contains(e.target)) {
                    this.close();
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !this.calendar.classList.contains('hidden')) {
                    this.close();
                }
            });
        }

        generateYearOptions() {
            const currentYear = new Date().getFullYear();
            const startYear = currentYear - 100;
            const endYear = currentYear + 10;

            for (let year = startYear; year <= endYear; year++) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                this.yearSelect.appendChild(option);
            }
        }

        renderCalendar() {
            this.monthSelect.value = this.currentMonth;
            this.yearSelect.value = this.currentYear;

            const firstDay = new Date(this.currentYear, this.currentMonth, 1);
            const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
            const prevLastDay = new Date(this.currentYear, this.currentMonth, 0);

            const firstDayOfWeek = firstDay.getDay();
            const lastDateOfMonth = lastDay.getDate();
            const prevLastDate = prevLastDay.getDate();

            this.calendarGrid.innerHTML = '';

            // Previous month days
            for (let i = firstDayOfWeek - 1; i >= 0; i--) {
                const day = prevLastDate - i;
                const date = new Date(this.currentYear, this.currentMonth - 1, day);
                this.createDayButton(date, day, false);
            }

            // Current month days
            for (let day = 1; day <= lastDateOfMonth; day++) {
                const date = new Date(this.currentYear, this.currentMonth, day);
                this.createDayButton(date, day, true);
            }

            // Next month days
            const remainingDays = 42 - this.calendarGrid.children.length;
            for (let day = 1; day <= remainingDays; day++) {
                const date = new Date(this.currentYear, this.currentMonth + 1, day);
                this.createDayButton(date, day, false);
            }
        }

        createDayButton(date, day, isCurrentMonth) {
            const button = document.createElement('button');
            button.type = 'button';
            button.textContent = day;
            button.className = 'aspect-square p-1 text-sm rounded-lg transition font-medium';

            const compareDate = new Date(date);
            compareDate.setHours(0, 0, 0, 0);

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const isToday = compareDate.getTime() === today.getTime();
            const isSelected = this.selectedDate && compareDate.getTime() === new Date(this.selectedDate).setHours(0, 0, 0, 0);
            const isDisabled = this.isDateDisabled(compareDate);

            if (!isCurrentMonth) {
                button.classList.add('text-gray-400', 'dark:text-gray-600');
            }

            if (isSelected) {
                button.classList.add('bg-arm-blue-600', 'text-white', 'hover:bg-arm-blue-700');
            } else if (isToday) {
                button.classList.add('bg-arm-blue-100', 'text-arm-blue-600', 'dark:bg-arm-blue-900', 'dark:text-arm-blue-300');
            } else {
                button.classList.add('hover:bg-gray-100', 'dark:hover:bg-gray-700', 'text-gray-900', 'dark:text-gray-100');
            }

            if (isDisabled) {
                button.disabled = true;
                button.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.selectDate(date);
                });
            }

            this.calendarGrid.appendChild(button);
        }

        isDateDisabled(date) {
            if (this.minDate && date < this.minDate) return true;
            if (this.maxDate && date > this.maxDate) return true;
            return false;
        }

        selectDate(date) {
            this.selectedDate = new Date(date);
            this.selectedDate.setHours(0, 0, 0, 0);
            this.updateInput();
            this.updateWireModel();
            this.renderCalendar();
            this.close();
        }

        selectToday() {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (!this.isDateDisabled(today)) {
                this.selectedDate = today;
                this.currentMonth = today.getMonth();
                this.currentYear = today.getFullYear();
                this.updateInput();
                this.updateWireModel();
                this.renderCalendar();
                this.close();
            }
        }

        clear() {
            this.selectedDate = null;
            this.input.value = '';
            this.updateWireModel();
            this.renderCalendar();
            this.close();
        }

        updateInput() {
            if (!this.selectedDate) {
                this.input.value = '';
                return;
            }

            const year = this.selectedDate.getFullYear();
            const month = String(this.selectedDate.getMonth() + 1).padStart(2, '0');
            const day = String(this.selectedDate.getDate()).padStart(2, '0');

            this.input.value = this.format
                .replace('Y', year)
                .replace('m', month)
                .replace('d', day);
        }

        updateWireModel() {
            if (!window.Livewire) return;

            // Check for wire:model with any modifier (wire:model, wire:model.lazy, wire:model.defer, etc.)
            let modelName = null;
            for (let attr of this.input.attributes) {
                if (attr.name.startsWith('wire:model')) {
                    modelName = attr.value;
                    break;
                }
            }

            if (!modelName) return;

            const componentEl = this.input.closest('[wire\\:id]');
            if (componentEl) {
                const componentId = componentEl.getAttribute('wire:id');
                const component = window.Livewire.find(componentId);
                if (component) {
                    component.set(modelName, this.input.value);
                }
            }
        }

        toggle() {
            if (this.calendar.classList.contains('hidden')) {
                this.open();
            } else {
                this.close();
            }
        }

        open() {
            this.calendar.classList.remove('hidden');
            this.renderCalendar();
        }

        close() {
            this.calendar.classList.add('hidden');
        }

        previousMonth() {
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
            this.renderCalendar();
        }

        nextMonth() {
            if (this.currentMonth === 11) {
                this.currentMonth = 0;
                this.currentYear++;
            } else {
                this.currentMonth++;
            }
            this.renderCalendar();
        }
    }

    function initDatepickers() {
        document.querySelectorAll('[data-datepicker]').forEach(element => {
            if (!element._datepickerInitialized) {
                new Datepicker(element);
                element._datepickerInitialized = true;
            }
        });
    }

    // Initialize on DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDatepickers);
    } else {
        initDatepickers();
    }

    // Support for Livewire
    document.addEventListener('livewire:navigated', initDatepickers);
    document.addEventListener('livewire:load', initDatepickers);
})();
