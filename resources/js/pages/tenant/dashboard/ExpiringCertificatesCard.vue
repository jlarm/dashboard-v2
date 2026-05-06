<script setup lang="ts">
import type { ExpiringCert } from './types';

// Placeholder data — to be wired to a real query in a follow-up.
const certs: ExpiringCert[] = [
    { name: 'Jane Doe', type: 'Respirator Fit Test', expires: '14d' },
    { name: 'Carlos Rivera', type: 'OSHA 10', expires: '23d' },
    { name: 'Priya Shah', type: 'GLBA Privacy Training', expires: '31d' },
    { name: 'Mike Chen', type: 'Hazmat Refresher', expires: '44d' },
];
</script>

<template>
    <article class="overflow-hidden rounded-2xl border bg-card">
        <header class="flex items-center justify-between bg-muted/40 px-5 py-3">
            <h3 class="text-sm font-medium text-foreground">Expiring Certificates</h3>
            <span class="text-xs text-muted-foreground">{{ certs.length }}</span>
        </header>
        <ul class="divide-y">
            <li
                v-for="cert in certs"
                :key="cert.name + cert.type"
                class="flex items-center justify-between gap-3 px-5 py-3"
            >
                <div class="min-w-0">
                    <p class="truncate text-sm font-medium text-foreground">{{ cert.name }}</p>
                    <p class="truncate text-xs text-muted-foreground">{{ cert.type }}</p>
                </div>
                <span class="shrink-0 rounded-md bg-amber-50 px-1.5 py-0.5 text-xs font-semibold tabular-nums text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                    {{ cert.expires }}
                </span>
            </li>
        </ul>
    </article>
</template>
