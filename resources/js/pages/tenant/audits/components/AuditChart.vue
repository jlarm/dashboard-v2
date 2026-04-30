<script setup lang="ts">
import { computed } from 'vue';
import { ChartContainer } from '@/components/ui/chart';

type Props = {
    labels: string[];
    gradesNumeric: number[];
    gradesLetters: string[];
    violations: number[];
    remediations: number[];
};

const props = defineProps<Props>();

const points = computed(() => props.labels.map((label, index) => ({
    label,
    grade: props.gradesLetters[index] ?? '',
    gradeNumeric: props.gradesNumeric[index] ?? 0,
    violations: props.violations[index] ?? 0,
    remediations: props.remediations[index] ?? 0,
})));

const maxViolations = computed(() => Math.max(1, ...props.violations));
</script>

<template>
    <ChartContainer
        :config="{
            grade: { label: 'Grade', color: 'var(--chart-1)' },
            violations: { label: 'Violations', color: 'var(--chart-2)' },
            remediations: { label: 'Remediations', color: 'var(--chart-3)' },
        }"
        class="aspect-[3/1] w-full"
    >
        <div v-if="!points.length" class="grid h-full place-items-center text-sm text-muted-foreground">
            No audits yet.
        </div>
        <div v-else class="grid h-full grid-cols-4 items-end gap-3 px-2">
            <div v-for="point in points" :key="point.label" class="flex h-full flex-col items-center justify-end gap-1">
                <div class="flex h-full w-full items-end gap-1">
                    <div
                        class="flex-1 rounded-sm bg-[var(--chart-2)]/80"
                        :style="{ height: `${(point.violations / maxViolations) * 80}%` }"
                        :title="`${point.violations} violations`"
                    />
                    <div
                        class="flex-1 rounded-sm bg-[var(--chart-3)]/80"
                        :style="{ height: `${(point.remediations / maxViolations) * 80}%` }"
                        :title="`${point.remediations} remediations`"
                    />
                </div>
                <span class="text-xs text-muted-foreground">{{ point.label }}</span>
                <span class="text-sm font-semibold">{{ point.grade || '—' }}</span>
            </div>
        </div>
    </ChartContainer>
</template>
