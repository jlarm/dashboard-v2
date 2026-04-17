<script setup lang="ts">
import { computed } from 'vue';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import type { Log } from '@/types';

const props = defineProps<{
    open: boolean;
    log: Log | null;
}>();

defineEmits<{
    'update:open': [value: boolean];
}>();

const formattedPayload = computed(() => {
    if (props.log === null) {
        return '';
    }

    return JSON.stringify(props.log.payload, null, 2);
});
</script>

<template>
    <Dialog :open="open" @update:open="$emit('update:open', $event)">
        <DialogContent class="max-w-3xl">
            <DialogHeader class="space-y-3">
                <DialogTitle>Mailgun payload</DialogTitle>
                <DialogDescription>
                    {{ log?.event_type ?? 'Log' }} for
                    {{ log?.recipient ?? 'unknown recipient' }}
                </DialogDescription>
            </DialogHeader>

            <pre class="max-h-[70vh] overflow-auto rounded-lg border bg-muted/30 p-4 text-xs leading-5 whitespace-pre-wrap break-all">{{ formattedPayload }}</pre>
        </DialogContent>
    </Dialog>
</template>
