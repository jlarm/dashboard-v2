<script setup lang="ts">
import { computed } from 'vue';

type Counts = {
    total: number | null;
    critical: number | null;
    high: number | null;
    medium: number | null;
    low: number | null;
    grade: string | null;
};

const props = defineProps<{
    counts: Counts;
}>();

const fmt = (value: number | string | null) => (value === null ? '—' : value);

const cells = computed(() => [
    { label: 'Issues', value: fmt(props.counts.total), tone: 'neutral' as const },
    { label: 'Critical', value: fmt(props.counts.critical), tone: 'critical' as const },
    { label: 'High', value: fmt(props.counts.high), tone: 'high' as const },
    { label: 'Medium', value: fmt(props.counts.medium), tone: 'medium' as const },
    { label: 'Low', value: fmt(props.counts.low), tone: 'low' as const },
    { label: 'Grade', value: fmt(props.counts.grade), tone: 'neutral' as const },
]);

const toneClass = (tone: 'neutral' | 'critical' | 'high' | 'medium' | 'low') => {
    if (tone === 'critical') {
        return {
            card: 'border-rose-200 bg-rose-50/60 dark:border-rose-500/20 dark:bg-rose-500/10',
            value: 'text-rose-700 dark:text-rose-400',
        };
    }
    if (tone === 'high') {
        return {
            card: 'border-orange-200 bg-orange-50/60 dark:border-orange-500/20 dark:bg-orange-500/10',
            value: 'text-orange-700 dark:text-orange-400',
        };
    }
    if (tone === 'medium') {
        return {
            card: 'border-amber-200 bg-amber-50/60 dark:border-amber-500/20 dark:bg-amber-500/10',
            value: 'text-amber-700 dark:text-amber-400',
        };
    }
    if (tone === 'low') {
        return {
            card: 'border-sky-200 bg-sky-50/60 dark:border-sky-500/20 dark:bg-sky-500/10',
            value: 'text-sky-700 dark:text-sky-400',
        };
    }
    return {
        card: 'bg-card',
        value: 'text-foreground',
    };
};
</script>

<template>
    <section class="grid grid-cols-2 gap-4 lg:grid-cols-6">
        <article
            v-for="cell in cells"
            :key="cell.label"
            class="rounded-2xl border p-4"
            :class="toneClass(cell.tone).card"
        >
            <p class="text-xs font-medium text-muted-foreground">{{ cell.label }}</p>
            <p class="mt-2 text-2xl font-semibold tabular-nums" :class="toneClass(cell.tone).value">
                {{ cell.value }}
            </p>
        </article>
    </section>
</template>
