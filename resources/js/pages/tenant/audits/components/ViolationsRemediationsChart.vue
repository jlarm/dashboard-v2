<script setup lang="ts">
import { computed } from 'vue';
import {
    ChartContainer,
    ChartCrosshair,
    ChartTooltip,
    componentToString,
    type ChartConfig,
} from '@/components/ui/chart';
import ChartTooltipContent from '@/components/ui/chart/ChartTooltipContent.vue';
import { CurveType } from '@unovis/ts';
import { VisArea, VisAxis, VisLine, VisScatter, VisXYContainer } from '@unovis/vue';

const props = defineProps<{
    labels: string[];
    violations: number[];
    remediations: number[];
}>();

type Datum = {
    index: number;
    label: string;
    violations: number;
    remediations: number;
};

const data = computed<Datum[]>(() =>
    props.labels.map((label, index) => ({
        index,
        label,
        violations: props.violations[index] ?? 0,
        remediations: props.remediations[index] ?? 0,
    })),
);

const chartConfig = {
    violations: { label: 'Violations', color: '#dc2626' },
    remediations: { label: 'Remediations', color: '#16a34a' },
} satisfies ChartConfig;

const x = (d: Datum) => d.index;
const xTickFormat = (value: number): string => props.labels[Math.round(value)] ?? '';

const tooltipTemplate = computed(() =>
    componentToString(chartConfig, ChartTooltipContent, {
        labelFormatter: (label: number | Date) =>
            xTickFormat(typeof label === 'number' ? label : 0),
    }),
);
</script>

<template>
    <article class="rounded-2xl border bg-card p-5">
        <header class="mb-4 flex items-start justify-between gap-3">
            <div>
                <h3 class="text-sm font-semibold tracking-tight">Violations &amp; Remediations</h3>
                <p class="text-xs text-muted-foreground">Total violations and completed remediations per audit</p>
            </div>
            <div class="flex flex-wrap gap-3 text-xs">
                <span v-for="series in chartConfig" :key="series.label as string" class="flex items-center gap-1.5">
                    <span class="size-2.5 rounded-full" :style="{ backgroundColor: series.color }" />
                    <span class="text-muted-foreground">{{ series.label }}</span>
                </span>
            </div>
        </header>

        <ChartContainer
            v-if="data.length > 0"
            :config="chartConfig"
            class="h-64"
            :cursor="false"
        >
            <VisXYContainer :data="data" :margin="{ top: 16, right: 16, bottom: 28, left: 32 }">
                <VisArea
                    :x="x"
                    :y="(d: Datum) => d.violations"
                    :color="chartConfig.violations.color"
                    :curve-type="CurveType.MonotoneX"
                    :opacity="0.18"
                />
                <VisArea
                    :x="x"
                    :y="(d: Datum) => d.remediations"
                    :color="chartConfig.remediations.color"
                    :curve-type="CurveType.MonotoneX"
                    :opacity="0.18"
                />
                <VisLine
                    :x="x"
                    :y="(d: Datum) => d.violations"
                    :color="chartConfig.violations.color"
                    :curve-type="CurveType.MonotoneX"
                    :line-width="2.25"
                />
                <VisLine
                    :x="x"
                    :y="(d: Datum) => d.remediations"
                    :color="chartConfig.remediations.color"
                    :curve-type="CurveType.MonotoneX"
                    :line-width="2.25"
                />
                <VisScatter
                    :x="x"
                    :y="(d: Datum) => d.violations"
                    :color="chartConfig.violations.color"
                    :size="6"
                />
                <VisScatter
                    :x="x"
                    :y="(d: Datum) => d.remediations"
                    :color="chartConfig.remediations.color"
                    :size="6"
                />

                <VisAxis
                    type="x"
                    :tick-format="xTickFormat"
                    :num-ticks="labels.length"
                    :grid-line="false"
                    :domain-line="false"
                />
                <VisAxis type="y" :num-ticks="5" :domain-line="false" />

                <ChartCrosshair :template="tooltipTemplate" />
                <ChartTooltip />
            </VisXYContainer>
        </ChartContainer>

        <div v-else class="grid h-64 place-items-center text-sm text-muted-foreground">
            No audit history yet.
        </div>
    </article>
</template>
