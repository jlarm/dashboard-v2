<script setup lang="ts">
type ActivityEntry = {
    id: number;
    name: string;
    status: string;
    step: number | null;
    created_at_for_humans?: string;
};

defineProps<{
    entries: ActivityEntry[];
}>();
</script>

<template>
    <div class="border rounded-md p-4 max-h-[320px] overflow-y-auto">
        <h2 class="text-sm font-semibold leading-6">Activity</h2>
        <ul role="list" class="space-y-4 mt-3">
            <li v-if="entries.length === 0" class="text-xs text-muted-foreground italic">No activity yet.</li>
            <li v-for="(entry, index) in entries" :key="entry.id" class="relative flex gap-x-4">
                <div v-if="index !== entries.length - 1" class="absolute left-0 top-0 flex w-6 justify-center -bottom-4">
                    <div class="w-px bg-border"></div>
                </div>
                <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-background">
                    <div class="h-1.5 w-1.5 rounded-full bg-muted-foreground/40 ring-1 ring-border"></div>
                </div>
                <p class="flex-auto py-0.5 text-xs leading-5 text-muted-foreground">
                    <span class="font-medium text-foreground">{{ entry.name }}</span>
                    {{ entry.status }}.
                </p>
                <time v-if="entry.created_at_for_humans" class="flex-none py-0.5 text-xs leading-5 text-muted-foreground">
                    {{ entry.created_at_for_humans }}
                </time>
            </li>
        </ul>
    </div>
</template>
