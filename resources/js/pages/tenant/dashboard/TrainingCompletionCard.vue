<script setup lang="ts">
import { usePageProp } from './props';
import type { DepartmentCompletion } from './types';

const departments = usePageProp<DepartmentCompletion[]>('training_completion', []);

const completionBar = (v: number): string => {
    if (v >= 95) return 'bg-arm-green-500';
    if (v >= 85) return 'bg-arm-blue-400';
    if (v >= 75) return 'bg-arm-orange-400';
    return 'bg-arm-orange-600';
};
</script>

<template>
    <article class="overflow-hidden rounded-2xl border bg-card">
        <header class="flex items-center justify-between bg-muted/40 px-5 py-3">
            <h3 class="text-sm font-medium text-foreground">Training Completion</h3>
            <span class="text-xs text-muted-foreground">By department</span>
        </header>
        <p
            v-if="departments.length === 0"
            class="px-5 py-6 text-sm text-muted-foreground"
        >
            No employees in scope.
        </p>
        <ul v-else class="divide-y">
            <li
                v-for="row in departments"
                :key="row.label"
                class="grid grid-cols-[1fr_auto] items-center gap-3 px-5 py-3"
            >
                <div class="min-w-0">
                    <span class="text-sm font-medium text-foreground">{{ row.label }}</span>
                    <div class="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-muted">
                        <div class="h-full rounded-full" :class="completionBar(row.value)" :style="{ width: `${row.value}%` }" />
                    </div>
                </div>
                <span class="w-10 text-right text-sm font-semibold tabular-nums text-foreground">{{ row.value }}%</span>
            </li>
        </ul>
    </article>
</template>
