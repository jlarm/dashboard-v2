<script setup lang="ts">
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Info } from 'lucide-vue-next';
import { computed, ref } from 'vue';

type Tone = 'positive' | 'negative' | 'warning' | 'neutral';

type InfoContent = {
    title: string;
    description: string;
};

type Props = {
    label: string;
    value: string | number;
    caption?: string;
    delta?: string;
    tone?: Tone;
    deltaTone?: Tone;
    info?: InfoContent;
};

const props = withDefaults(defineProps<Props>(), {
    tone: 'neutral',
});

const infoOpen = ref<boolean>(false);

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
    switch (props.deltaTone ?? props.tone) {
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
            <Dialog v-if="info" v-model:open="infoOpen">
                <DialogTrigger
                    class="grid size-5 cursor-pointer place-items-center rounded-md text-muted-foreground hover:bg-muted/60 hover:text-foreground"
                    :aria-label="`About ${label}`"
                >
                    <Info class="size-3.5" />
                </DialogTrigger>
                <DialogContent class="sm:max-w-md">
                    <DialogHeader>
                        <DialogTitle>{{ info.title }}</DialogTitle>
                        <DialogDescription class="pt-1 text-sm leading-relaxed text-muted-foreground">
                            {{ info.description }}
                        </DialogDescription>
                    </DialogHeader>
                </DialogContent>
            </Dialog>
            <slot v-else name="action" />
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
