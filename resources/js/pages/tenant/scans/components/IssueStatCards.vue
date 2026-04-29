<script setup lang="ts">
import StatCard from '@/components/StatCard.vue';
import { computed } from 'vue';

type Counts = {
    total: number | null;
    critical: number | null;
    high: number | null;
    medium: number | null;
    low: number | null;
    grade: string | null;
};

type Tone = 'positive' | 'negative' | 'warning' | 'neutral';

const props = defineProps<{
    counts: Counts;
}>();

const fmt = (value: number | string | null): string => (value === null ? '—' : String(value));

const cells = computed<{ label: string; value: string; tone: Tone }[]>(() => [
    { label: 'Issues', value: fmt(props.counts.total), tone: 'neutral' },
    { label: 'Critical', value: fmt(props.counts.critical), tone: 'negative' },
    { label: 'High', value: fmt(props.counts.high), tone: 'negative' },
    { label: 'Medium', value: fmt(props.counts.medium), tone: 'warning' },
    { label: 'Low', value: fmt(props.counts.low), tone: 'neutral' },
    { label: 'Grade', value: fmt(props.counts.grade), tone: 'neutral' },
]);
</script>

<template>
    <section class="grid grid-cols-2 gap-4 lg:grid-cols-6">
        <StatCard
            v-for="cell in cells"
            :key="cell.label"
            :label="cell.label"
            :value="cell.value"
            :tone="cell.tone"
        />
    </section>
</template>
