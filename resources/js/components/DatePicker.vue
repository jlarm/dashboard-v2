<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import { CalendarDate, type DateValue, getLocalTimeZone, parseDate } from '@internationalized/date';
import { CalendarIcon } from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{
    modelValue: string | null;
    name?: string;
    id?: string;
    placeholder?: string;
    disabled?: boolean;
    maxValue?: string;
    minValue?: string;
}>();

const emit = defineEmits<{
    (event: 'update:modelValue', value: string | null): void;
}>();

const toCalendar = (value: string | null | undefined): DateValue | undefined => {
    if (!value) {
        return undefined;
    }

    try {
        return parseDate(value);
    } catch {
        return undefined;
    }
};

const calendarValue = computed<DateValue | undefined>(() => toCalendar(props.modelValue));
const maxValue = computed<DateValue | undefined>(() => toCalendar(props.maxValue));
const minValue = computed<DateValue | undefined>(() => toCalendar(props.minValue));

const formattedValue = computed(() => {
    if (!calendarValue.value) {
        return '';
    }

    return calendarValue.value
        .toDate(getLocalTimeZone())
        .toLocaleDateString(undefined, { month: 'long', day: 'numeric', year: 'numeric' });
});

const handleUpdate = (value: DateValue | undefined): void => {
    if (!value) {
        emit('update:modelValue', null);
        return;
    }

    const d = value as CalendarDate;
    const iso = `${String(d.year).padStart(4, '0')}-${String(d.month).padStart(2, '0')}-${String(d.day).padStart(2, '0')}`;
    emit('update:modelValue', iso);
};
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button
                :id="id"
                type="button"
                variant="outline"
                :disabled="disabled"
                :class="cn(
                    'w-full justify-start text-left font-normal shadow-none',
                    !modelValue && 'text-muted-foreground',
                )"
            >
                <CalendarIcon class="mr-2 size-4" />
                <span>{{ formattedValue || placeholder || 'Select a date' }}</span>
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <Calendar
                :model-value="calendarValue"
                :max-value="maxValue"
                :min-value="minValue"
                initial-focus
                @update:model-value="handleUpdate"
            />
        </PopoverContent>
    </Popover>
    <input v-if="name" type="hidden" :name="name" :value="modelValue ?? ''" />
</template>
