<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import SignaturePad from '@/components/manuals/SignaturePad.vue';

defineProps<{
    nameValue: string | null;
    signatureValue: string | null;
    nameLabel?: string;
    nameError?: string | null;
    signatureError?: string | null;
    required?: boolean;
}>();

defineEmits<{
    'update:nameValue': [value: string];
    'update:signatureValue': [value: string | null];
}>();
</script>

<template>
    <div class="rounded-lg border bg-card p-4 space-y-3">
        <div>
            <Label class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">
                {{ nameLabel ?? 'Name' }}
                <span v-if="required" class="text-destructive">*</span>
            </Label>
            <Input
                :model-value="nameValue ?? ''"
                placeholder="Type your name"
                @update:model-value="$emit('update:nameValue', String($event))"
                :class="nameError ? 'border-destructive' : ''"
            />
            <p v-if="nameError" class="mt-1 text-xs text-destructive">{{ nameError }}</p>
        </div>
        <SignaturePad
            :model-value="signatureValue"
            :error="signatureError ?? null"
            @update:model-value="$emit('update:signatureValue', $event)"
        />
    </div>
</template>
