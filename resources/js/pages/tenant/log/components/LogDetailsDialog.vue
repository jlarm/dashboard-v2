<script setup lang="ts">
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';

type ActivityLog = {
    id: number;
    event: string | null;
    description: string;
    subject_type: string | null;
    subject_id: number | string | null;
    causer_name: string | null;
    created_at: string | null;
    created_at_diff: string | null;
    created_at_human: string | null;
    properties: Record<string, unknown>;
};

defineProps<{
    log: ActivityLog | null;
    eventVariant: (event: string | null) => 'default' | 'secondary' | 'destructive' | 'outline';
}>();

const open = defineModel<boolean>('open', { required: true });
</script>

<template>
    <Dialog v-model:open="open">
        <DialogContent class="sm:max-w-lg">
            <template v-if="log">
                <DialogHeader>
                    <DialogTitle>Log Details #{{ log.id }}</DialogTitle>
                </DialogHeader>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-medium text-foreground">Activity</p>
                        <Badge :variant="eventVariant(log.event)" class="mt-1">
                            {{ log.description }}
                        </Badge>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-foreground">User</p>
                        <p class="mt-1 text-sm text-muted-foreground">
                            {{ log.causer_name ?? 'System' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-foreground">Date &amp; time</p>
                        <p class="mt-1 text-sm text-muted-foreground">
                            {{ log.created_at_human }}
                            <span v-if="log.created_at_diff" class="ml-1 text-xs">
                                ({{ log.created_at_diff }})
                            </span>
                        </p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-foreground">Model</p>
                        <p class="mt-1">
                            <code v-if="log.subject_type" class="rounded bg-muted px-2 py-1 text-xs">
                                {{ log.subject_type }}<span v-if="log.subject_id">#{{ log.subject_id }}</span>
                            </code>
                            <span v-else class="text-sm text-muted-foreground">—</span>
                        </p>
                    </div>

                    <div v-if="Object.keys(log.properties).length > 0">
                        <p class="text-sm font-medium text-foreground">Properties</p>
                        <pre class="mt-1 max-h-64 overflow-auto rounded-md bg-muted p-3 text-xs">{{ JSON.stringify(log.properties, null, 2) }}</pre>
                    </div>
                </div>

                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Close</Button>
                    </DialogClose>
                </DialogFooter>
            </template>
        </DialogContent>
    </Dialog>
</template>
