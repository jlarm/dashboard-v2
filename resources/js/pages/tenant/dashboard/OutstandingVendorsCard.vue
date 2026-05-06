<script setup lang="ts">
import type { OutstandingVendor } from './types';

// Placeholder data — to be wired to a real query in a follow-up.
const vendors: OutstandingVendor[] = [
    { name: 'DealerTrack', lastContacted: '11d ago' },
    { name: 'RouteOne', lastContacted: '6d ago' },
    { name: 'CDK Global', lastContacted: '3d ago' },
];
</script>

<template>
    <article class="overflow-hidden rounded-2xl border bg-card">
        <header class="flex items-center justify-between bg-muted/40 px-5 py-3">
            <h3 class="text-sm font-medium text-foreground">Outstanding Vendor Forms</h3>
            <span class="text-xs text-muted-foreground">{{ vendors.length }}</span>
        </header>
        <ul class="divide-y">
            <li
                v-for="v in vendors"
                :key="v.name"
                class="flex items-center justify-between gap-3 px-5 py-3"
            >
                <span class="text-sm font-medium text-foreground">{{ v.name }}</span>
                <span class="text-xs text-muted-foreground">{{ v.lastContacted }}</span>
            </li>
        </ul>
    </article>
</template>
