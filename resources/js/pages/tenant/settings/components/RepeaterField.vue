<script setup lang="ts">
import { Plus, Trash2 } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const props = withDefaults(
    defineProps<{
        label: string;
        modelValue: string[];
        addLabel?: string;
        placeholder?: string;
        type?: string;
    }>(),
    {
        addLabel: 'Add',
        placeholder: '',
        type: 'text',
    },
);

const emit = defineEmits<{ 'update:modelValue': [string[]] }>();

const updateAt = (index: number, value: string): void => {
    const next = [...props.modelValue];
    next[index] = value;
    emit('update:modelValue', next);
};

const removeAt = (index: number): void => {
    emit('update:modelValue', props.modelValue.filter((_, i) => i !== index));
};

const add = (): void => {
    emit('update:modelValue', [...props.modelValue, '']);
};
</script>

<template>
    <div class="grid gap-1.5">
        <Label>{{ label }}</Label>
        <div v-if="modelValue.length > 0" class="space-y-2">
            <div v-for="(value, index) in modelValue" :key="index" class="flex items-center gap-2">
                <Input
                    :type="type"
                    :placeholder="placeholder"
                    :model-value="value"
                    class="flex-1"
                    @update:model-value="(next) => updateAt(index, String(next ?? ''))"
                />
                <Button
                    type="button"
                    variant="outline"
                    size="icon"
                    class="shrink-0 hover:bg-red-50 hover:text-red-500"
                    @click="removeAt(index)"
                >
                    <Trash2 />
                </Button>
            </div>
        </div>
        <Button type="button" variant="outline" size="sm" class="w-fit" @click="add">
            <Plus />
            {{ addLabel }}
        </Button>
    </div>
</template>
