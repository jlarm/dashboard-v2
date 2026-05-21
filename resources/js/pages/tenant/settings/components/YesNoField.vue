<script setup lang="ts">
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

type YesNoValue = string | boolean;

withDefaults(
    defineProps<{
        label: string;
        modelValue: YesNoValue | null;
        yesValue?: YesNoValue;
        noValue?: YesNoValue;
        error?: string;
    }>(),
    {
        yesValue: '1',
        noValue: '0',
    },
);

defineEmits<{ 'update:modelValue': [YesNoValue] }>();
</script>

<template>
    <div class="grid gap-1.5">
        <Label>{{ label }}</Label>
        <div class="flex gap-6">
            <label class="flex cursor-pointer items-center gap-2 text-sm">
                <input
                    type="radio"
                    class="size-4 border-input text-primary focus:ring-primary"
                    :checked="modelValue === yesValue"
                    @change="$emit('update:modelValue', yesValue)"
                />
                <span>Yes</span>
            </label>
            <label class="flex cursor-pointer items-center gap-2 text-sm">
                <input
                    type="radio"
                    class="size-4 border-input text-primary focus:ring-primary"
                    :checked="modelValue === noValue"
                    @change="$emit('update:modelValue', noValue)"
                />
                <span>No</span>
            </label>
        </div>
        <InputError :message="error" />
    </div>
</template>
