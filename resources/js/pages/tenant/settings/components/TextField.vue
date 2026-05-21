<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

withDefaults(
    defineProps<{
        label: string;
        modelValue: string;
        error?: string;
        type?: string;
        placeholder?: string;
    }>(),
    {
        type: 'text',
        placeholder: '',
    },
);

defineEmits<{ 'update:modelValue': [string] }>();
</script>

<template>
    <div class="grid gap-1.5">
        <Label>{{ label }}</Label>
        <Input
            :type="type"
            :placeholder="placeholder"
            :model-value="modelValue"
            @update:model-value="(value) => $emit('update:modelValue', String(value ?? ''))"
        />
        <InputError :message="error" />
    </div>
</template>
