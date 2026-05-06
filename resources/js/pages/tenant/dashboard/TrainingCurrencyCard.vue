<script setup lang="ts">
import type { DepartmentCompletion } from './types';

// Placeholder data — to be wired to a real query in a follow-up.
const departments: DepartmentCompletion[] = [
    { label: 'All', value: 94, headcount: 142 },
    { label: 'Sales', value: 100, headcount: 38 },
    { label: 'Accounting', value: 78, headcount: 9 },
    { label: 'Service', value: 97, headcount: 31 },
    { label: 'Parts', value: 75, headcount: 12 },
    { label: 'Body Shop', value: 88, headcount: 17 },
    { label: 'Finance', value: 100, headcount: 8 },
    { label: 'Porter / Driver', value: 100, headcount: 27 },
];

const completionBar = (v: number): string => {
    if (v >= 95) return 'bg-emerald-500';
    if (v >= 85) return 'bg-sky-500';
    if (v >= 75) return 'bg-amber-500';
    return 'bg-rose-500';
};
</script>

<template>
    <article class="overflow-hidden rounded-2xl border bg-card">
        <header class="flex items-center justify-between bg-muted/40 px-5 py-3">
            <h3 class="text-sm font-medium text-foreground">Training Currency</h3>
            <span class="text-xs text-muted-foreground">By department</span>
        </header>
        <ul class="divide-y">
            <li
                v-for="row in departments"
                :key="row.label"
                class="grid grid-cols-[1fr_auto] items-center gap-3 px-5 py-3"
            >
                <div class="min-w-0">
                    <div class="flex items-baseline gap-2">
                        <span class="text-sm font-medium text-foreground">{{ row.label }}</span>
                        <span class="text-[11px] text-muted-foreground">n={{ row.headcount }}</span>
                    </div>
                    <div class="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-muted">
                        <div class="h-full rounded-full" :class="completionBar(row.value)" :style="{ width: `${row.value}%` }" />
                    </div>
                </div>
                <span class="w-10 text-right text-sm font-semibold tabular-nums text-foreground">{{ row.value }}%</span>
            </li>
        </ul>
    </article>
</template>
