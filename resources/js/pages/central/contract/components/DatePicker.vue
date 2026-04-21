<script setup lang="ts">
import { computed } from "vue";
import { CalendarDate, type DateValue, getLocalTimeZone, parseDate } from "@internationalized/date";
import { CalendarIcon } from "lucide-vue-next";
import { Button } from "@/components/ui/button";
import { Calendar } from "@/components/ui/calendar";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import { cn } from "@/lib/utils";

const props = defineProps<{
    modelValue: string | null;
    name: string;
    id?: string;
    placeholder?: string;
    disabled?: boolean;
}>();

const emit = defineEmits<{
    (event: "update:modelValue", value: string | null): void;
}>();

const calendarValue = computed<DateValue | undefined>(() => {
    if (!props.modelValue) {
        return undefined;
    }

    try {
        return parseDate(props.modelValue);
    } catch {
        return undefined;
    }
});

const formattedValue = computed(() => {
    if (!calendarValue.value) {
        return "";
    }

    return calendarValue.value
        .toDate(getLocalTimeZone())
        .toLocaleDateString(undefined, { month: "long", day: "numeric", year: "numeric" });
});

const handleUpdate = (value: DateValue | undefined): void => {
    if (!value) {
        emit("update:modelValue", null);
        return;
    }

    const d = value as CalendarDate;
    const iso = `${String(d.year).padStart(4, "0")}-${String(d.month).padStart(2, "0")}-${String(d.day).padStart(2, "0")}`;
    emit("update:modelValue", iso);
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
                    'w-full justify-start text-left font-normal',
                    !modelValue && 'text-muted-foreground',
                )"
            >
                <CalendarIcon class="mr-2 h-4 w-4" />
                <span>{{ formattedValue || placeholder || 'Select a date' }}</span>
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <Calendar
                :model-value="calendarValue"
                initial-focus
                @update:model-value="handleUpdate"
            />
        </PopoverContent>
    </Popover>
    <input type="hidden" :name="name" :value="modelValue ?? ''" />
</template>
