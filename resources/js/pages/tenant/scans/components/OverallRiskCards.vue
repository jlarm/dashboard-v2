<script setup lang="ts">
import StatCard from '@/components/StatCard.vue';
import { computed } from 'vue';

type Trend = 'improved' | 'declined' | 'stable';

type Grade = {
    current: string | null;
    previous: string | null;
    trend: Trend;
};

const props = defineProps<{
    overall: Grade;
    vulnerability: Grade;
}>();

const trendArrow = (trend: Trend): string => (trend === 'improved' ? '↗' : trend === 'declined' ? '↘' : '—');

const trendTone = (trend: Trend): 'positive' | 'negative' | 'neutral' =>
    trend === 'improved' ? 'positive' : trend === 'declined' ? 'negative' : 'neutral';

// Colour the grade by its own quality, not the trend — a B should not look
// alarming just because it slipped from a B+.
const gradeTone = (grade: string | null): 'positive' | 'warning' | 'negative' | 'neutral' => {
    switch (grade?.charAt(0).toUpperCase()) {
        case 'A':
        case 'B':
            return 'positive';
        case 'C':
            return 'warning';
        case 'D':
        case 'F':
            return 'negative';
        default:
            return 'neutral';
    }
};

const cards = computed(() => [
    { label: 'Overall Risk', grade: props.overall },
    { label: 'Vulnerabilities', grade: props.vulnerability },
]);
</script>

<template>
    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <StatCard
            v-for="card in cards"
            :key="card.label"
            :label="card.label"
            :value="card.grade.current ?? '—'"
            :delta="trendArrow(card.grade.trend)"
            :tone="gradeTone(card.grade.current)"
            :delta-tone="trendTone(card.grade.trend)"
            :caption="`Previous: ${card.grade.previous ?? '—'}`"
        />
    </section>
</template>
