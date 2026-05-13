<script setup lang="ts">
import { computed } from 'vue';

type Tone = 'positive' | 'negative' | 'warning' | 'neutral';

type Props = {
    label: string;
    value: string | number;
    caption?: string;
    delta?: string;
    tone?: Tone;
};

const props = withDefaults(defineProps<Props>(), {
    tone: 'neutral',
});

const valueClass = computed(() => {
    switch (props.tone) {
        case 'positive':
            return 'text-emerald-600 dark:text-emerald-400';
        case 'negative':
            return 'text-rose-600 dark:text-rose-400';
        case 'warning':
            return 'text-amber-600 dark:text-amber-400';
        default:
            return 'text-foreground';
    }
});

const pillClass = computed(() => {
    switch (props.tone) {
        case 'positive':
            return 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400';
        case 'negative':
            return 'bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400';
        case 'warning':
            return 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400';
        default:
            return 'bg-muted text-muted-foreground';
    }
});
</script>

<template>
    <article class="rounded-xl border bg-muted/40 p-2">
        <header class="flex items-center justify-between px-2 py-1.5">
            <h3 class="text-[11px] font-medium tracking-[0.14em] text-muted-foreground uppercase">
                {{ label }}
            </h3>
            <slot name="action" />
        </header>
        <div class="rounded-lg border bg-card px-4 py-3">
            <div class="flex items-baseline justify-between gap-2">
                <div class="flex items-baseline gap-2">
                    <span
                        class="text-2xl font-semibold leading-none tracking-tight tabular-nums"
                        :class="valueClass"
                    >
                        {{ value }}
                    </span>
                    <span
                        v-if="delta"
                        class="inline-flex items-center gap-1 rounded-md px-1.5 py-0.5 text-xs font-semibold"
                        :class="pillClass"
                    >
                        {{ delta }}
                    </span>
                </div>
                <slot name="valueAction" />
            </div>
            <p v-if="caption" class="mt-2 text-xs text-muted-foreground">
                {{ caption }}
            </p>
        </div>
    </article>
</template>
