<script setup lang="ts">
import { ArrowDownRight, ArrowUpRight, Minus } from 'lucide-vue-next';
import { computed } from 'vue';

type Grade = {
    current: string | null;
    previous: string | null;
    trend: 'improved' | 'declined' | 'stable';
};

const props = defineProps<{
    overall: Grade;
    vulnerability: Grade;
}>();

const cards = computed(() => [
    { label: 'Overall Risk', grade: props.overall },
    { label: 'Vulnerabilities', grade: props.vulnerability },
]);

const trendIcon = (trend: Grade['trend']) =>
    trend === 'improved' ? ArrowUpRight : trend === 'declined' ? ArrowDownRight : Minus;

const trendClass = (trend: Grade['trend']) =>
    trend === 'improved'
        ? 'text-emerald-600 dark:text-emerald-400'
        : trend === 'declined'
          ? 'text-rose-600 dark:text-rose-400'
          : 'text-muted-foreground';
</script>

<template>
    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <article
            v-for="card in cards"
            :key="card.label"
            class="rounded-2xl border bg-card p-5"
        >
            <header class="flex items-center justify-between">
                <p class="text-sm font-medium text-muted-foreground">{{ card.label }}</p>
                <component :is="trendIcon(card.grade.trend)" :class="['size-4', trendClass(card.grade.trend)]" />
            </header>
            <p class="mt-3 text-3xl font-semibold tracking-tight tabular-nums text-foreground">
                {{ card.grade.current ?? '—' }}
            </p>
            <p class="mt-1 text-xs text-muted-foreground">
                Previous: <span class="font-medium text-foreground">{{ card.grade.previous ?? '—' }}</span>
            </p>
        </article>
    </section>
</template>
