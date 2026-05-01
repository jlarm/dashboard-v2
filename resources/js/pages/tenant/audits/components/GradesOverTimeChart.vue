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
    gradesNumeric: number[];
    gradesLetters: string[];
}>();

type Datum = {
    index: number;
    label: string;
    grade: number;
    letter: string;
};

const data = computed<Datum[]>(() =>
    props.labels.map((label, index) => ({
        index,
        label,
        grade: props.gradesNumeric[index] ?? 0,
        letter: props.gradesLetters[index] ?? '',
    })),
);

const chartConfig = {
    grade: { label: 'Grade', color: '#3b82f6' },
} satisfies ChartConfig;

const x = (d: Datum) => d.index;
const y = (d: Datum) => d.grade;
const xTickFormat = (value: number): string => props.labels[Math.round(value)] ?? '';
const yTickFormat = (value: number): string => ['F', 'D', 'C', 'B', 'A'][Math.round(value)] ?? '';

const tooltipTemplate = computed(() =>
    componentToString(chartConfig, ChartTooltipContent, {
        labelFormatter: (label: number | Date) =>
            xTickFormat(typeof label === 'number' ? label : 0),
    }),
);
</script>

<template>
    <article class="rounded-2xl border bg-card p-5">
        <header class="mb-4">
            <h3 class="text-sm font-semibold tracking-tight">Grades Over Time</h3>
            <p class="text-xs text-muted-foreground">Historical audit grades</p>
        </header>

        <ChartContainer
            v-if="data.length > 0"
            :config="chartConfig"
            class="h-64"
            :cursor="false"
        >
            <VisXYContainer
                :data="data"
                :margin="{ top: 16, right: 16, bottom: 28, left: 32 }"
                :y-domain="[0, 4]"
            >
                <VisArea
                    :x="x"
                    :y="y"
                    :color="chartConfig.grade.color"
                    :curve-type="CurveType.MonotoneX"
                    :opacity="0.18"
                />
                <VisLine
                    :x="x"
                    :y="y"
                    :color="chartConfig.grade.color"
                    :curve-type="CurveType.MonotoneX"
                    :line-width="2.25"
                />
                <VisScatter
                    :x="x"
                    :y="y"
                    :color="chartConfig.grade.color"
                    :size="6"
                />

                <VisAxis
                    type="x"
                    :tick-format="xTickFormat"
                    :num-ticks="labels.length"
                    :grid-line="false"
                    :domain-line="false"
                />
                <VisAxis
                    type="y"
                    :tick-values="[0, 1, 2, 3, 4]"
                    :tick-format="yTickFormat"
                    :domain-line="false"
                />

                <ChartCrosshair :template="tooltipTemplate" />
                <ChartTooltip />
            </VisXYContainer>
        </ChartContainer>

        <div v-else class="grid h-64 place-items-center text-sm text-muted-foreground">
            No audit history yet.
        </div>
    </article>
</template>
