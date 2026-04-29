<script setup lang="ts">
import {
    ChartContainer,
    ChartCrosshair,
    ChartTooltip,
    componentToString,
    type ChartConfig,
} from '@/components/ui/chart';
import ChartTooltipContent from '@/components/ui/chart/ChartTooltipContent.vue';
import { CurveType } from '@unovis/ts';
import { VisArea, VisAxis, VisLine, VisXYContainer } from '@unovis/vue';
import { computed } from 'vue';

type Series = {
    critical: number[];
    high: number[];
    medium: number[];
    low: number[];
};

const props = defineProps<{
    categories: string[];
    series: Series;
}>();

type Datum = {
    index: number;
    label: string;
    critical: number;
    high: number;
    medium: number;
    low: number;
};

const data = computed<Datum[]>(() =>
    props.categories.map((label, index) => ({
        index,
        label,
        critical: props.series.critical[index] ?? 0,
        high: props.series.high[index] ?? 0,
        medium: props.series.medium[index] ?? 0,
        low: props.series.low[index] ?? 0,
    })),
);

const chartConfig = {
    critical: { label: 'Critical', color: '#dc2626' },
    high: { label: 'High', color: '#ea580c' },
    medium: { label: 'Medium', color: '#ca8a04' },
    low: { label: 'Low', color: '#0284c7' },
} satisfies ChartConfig;

const x = (d: Datum) => d.index;
const xTickFormat = (value: number): string => props.categories[Math.round(value)] ?? '';

const tooltipTemplate = computed(() =>
    componentToString(chartConfig, ChartTooltipContent, {
        labelFormatter: (label: number | Date) => xTickFormat(typeof label === 'number' ? label : 0),
    }),
);
</script>

<template>
    <article class="rounded-2xl border bg-card p-5">
        <header class="mb-4 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold tracking-tight text-foreground">Vulnerability Trend</h3>
                <p class="text-xs text-muted-foreground">Critical, High, Medium, and Low vulnerabilities across the last 5 scans</p>
            </div>
            <div class="flex flex-wrap gap-3 text-xs">
                <span v-for="series in chartConfig" :key="series.label as string" class="flex items-center gap-1.5">
                    <span class="h-2.5 w-2.5 rounded-sm" :style="{ backgroundColor: series.color }" />
                    <span class="text-muted-foreground">{{ series.label }}</span>
                </span>
            </div>
        </header>

        <ChartContainer
            v-if="data.length > 0"
            :config="chartConfig"
            class="h-72"
            :cursor="false"
        >
            <VisXYContainer :data="data" :margin="{ top: 8, right: 8, bottom: 28, left: 32 }">
                <VisArea
                    :x="x"
                    :y="(d: Datum) => d.low"
                    :color="chartConfig.low.color"
                    :curve-type="CurveType.MonotoneX"
                    :opacity="0.22"
                />
                <VisArea
                    :x="x"
                    :y="(d: Datum) => d.medium"
                    :color="chartConfig.medium.color"
                    :curve-type="CurveType.MonotoneX"
                    :opacity="0.22"
                />
                <VisArea
                    :x="x"
                    :y="(d: Datum) => d.high"
                    :color="chartConfig.high.color"
                    :curve-type="CurveType.MonotoneX"
                    :opacity="0.22"
                />
                <VisArea
                    :x="x"
                    :y="(d: Datum) => d.critical"
                    :color="chartConfig.critical.color"
                    :curve-type="CurveType.MonotoneX"
                    :opacity="0.22"
                />

                <VisLine
                    :x="x"
                    :y="(d: Datum) => d.low"
                    :color="chartConfig.low.color"
                    :curve-type="CurveType.MonotoneX"
                    :line-width="1.75"
                />
                <VisLine
                    :x="x"
                    :y="(d: Datum) => d.medium"
                    :color="chartConfig.medium.color"
                    :curve-type="CurveType.MonotoneX"
                    :line-width="1.75"
                />
                <VisLine
                    :x="x"
                    :y="(d: Datum) => d.high"
                    :color="chartConfig.high.color"
                    :curve-type="CurveType.MonotoneX"
                    :line-width="1.75"
                />
                <VisLine
                    :x="x"
                    :y="(d: Datum) => d.critical"
                    :color="chartConfig.critical.color"
                    :curve-type="CurveType.MonotoneX"
                    :line-width="1.75"
                />

                <VisAxis
                    type="x"
                    :tick-format="xTickFormat"
                    :num-ticks="categories.length"
                    :grid-line="false"
                    :domain-line="false"
                />
                <VisAxis type="y" :num-ticks="4" :domain-line="false" />

                <ChartCrosshair :template="tooltipTemplate" />
                <ChartTooltip />
            </VisXYContainer>
        </ChartContainer>

        <div v-else class="py-12 text-center text-sm text-muted-foreground">
            No scan history available yet.
        </div>
    </article>
</template>
