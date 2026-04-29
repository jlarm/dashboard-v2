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
            :tone="trendTone(card.grade.trend)"
            :caption="`Previous: ${card.grade.previous ?? '—'}`"
        />
    </section>
</template>
