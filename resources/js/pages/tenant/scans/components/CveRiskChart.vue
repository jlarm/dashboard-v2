<script setup lang="ts">
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

const palette = {
    critical: '#dc2626',
    high: '#ea580c',
    medium: '#ca8a04',
    low: '#0284c7',
} as const;

const maxValue = computed(() => {
    const all = [...props.series.critical, ...props.series.high, ...props.series.medium, ...props.series.low];
    const max = Math.max(...all, 0);
    return max === 0 ? 1 : max;
});

const chart = computed(() => {
    const w = 600;
    const h = 240;
    const pad = { top: 20, right: 16, bottom: 32, left: 36 };
    const innerW = w - pad.left - pad.right;
    const innerH = h - pad.top - pad.bottom;
    const points = props.categories.length;

    if (points === 0) {
        return null;
    }

    const stepX = points <= 1 ? innerW : innerW / (points - 1);
    const yScale = (v: number) => pad.top + innerH - (v / maxValue.value) * innerH;
    const toX = (i: number) => (points <= 1 ? pad.left + innerW / 2 : pad.left + i * stepX);

    const buildPath = (data: number[]) =>
        data
            .map((value, i) => `${i === 0 ? 'M' : 'L'}${toX(i).toFixed(1)},${yScale(value).toFixed(1)}`)
            .join(' ');

    const yTicks = [0, 0.25, 0.5, 0.75, 1].map((ratio) => ({
        y: pad.top + innerH - innerH * ratio,
        value: Math.round(maxValue.value * ratio),
    }));

    return {
        w,
        h,
        pad,
        innerW,
        innerH,
        critical: { path: buildPath(props.series.critical), points: props.series.critical.map((v, i) => ({ x: toX(i), y: yScale(v), v })) },
        high: { path: buildPath(props.series.high), points: props.series.high.map((v, i) => ({ x: toX(i), y: yScale(v), v })) },
        medium: { path: buildPath(props.series.medium), points: props.series.medium.map((v, i) => ({ x: toX(i), y: yScale(v), v })) },
        low: { path: buildPath(props.series.low), points: props.series.low.map((v, i) => ({ x: toX(i), y: yScale(v), v })) },
        xLabels: props.categories.map((label, i) => ({ x: toX(i), label })),
        yLabels: yTicks,
    };
});

const legend: { key: keyof Series; label: string }[] = [
    { key: 'critical', label: 'Critical' },
    { key: 'high', label: 'High' },
    { key: 'medium', label: 'Medium' },
    { key: 'low', label: 'Low' },
];
</script>

<template>
    <article class="rounded-2xl border bg-card p-5">
        <header class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold tracking-tight text-foreground">Vulnerability Trend</h3>
                <p class="text-xs text-muted-foreground">Across the last 5 scans</p>
            </div>
        </header>

        <div v-if="chart" class="mt-4">
            <svg :viewBox="`0 0 ${chart.w} ${chart.h}`" class="h-56 w-full" preserveAspectRatio="none">
                <g>
                    <line
                        v-for="(tick, i) in chart.yLabels"
                        :key="`grid-${i}`"
                        :x1="chart.pad.left"
                        :x2="chart.w - chart.pad.right"
                        :y1="tick.y"
                        :y2="tick.y"
                        class="stroke-border"
                        stroke-width="1"
                        stroke-dasharray="2 4"
                        vector-effect="non-scaling-stroke"
                    />
                </g>
                <g class="fill-muted-foreground">
                    <text
                        v-for="(tick, i) in chart.yLabels"
                        :key="`y-${i}`"
                        :x="chart.pad.left - 6"
                        :y="tick.y + 4"
                        text-anchor="end"
                        font-size="10"
                    >
                        {{ tick.value }}
                    </text>
                </g>
                <path :d="chart.low.path" :stroke="palette.low" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" />
                <path :d="chart.medium.path" :stroke="palette.medium" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" />
                <path :d="chart.high.path" :stroke="palette.high" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" />
                <path :d="chart.critical.path" :stroke="palette.critical" stroke-width="2.25" fill="none" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" />
                <g class="fill-muted-foreground">
                    <text
                        v-for="(label, i) in chart.xLabels"
                        :key="`x-${i}`"
                        :x="label.x"
                        :y="chart.h - 10"
                        text-anchor="middle"
                        font-size="10"
                    >
                        {{ label.label }}
                    </text>
                </g>
            </svg>

            <div class="mt-3 flex flex-wrap items-center justify-end gap-4 text-xs">
                <span v-for="series in legend" :key="series.key" class="flex items-center gap-1.5">
                    <span class="h-2.5 w-2.5 rounded-sm" :style="{ backgroundColor: palette[series.key] }" />
                    <span class="text-muted-foreground">{{ series.label }}</span>
                </span>
            </div>
        </div>

        <div v-else class="mt-6 py-8 text-center text-sm text-muted-foreground">
            No scan history available yet.
        </div>
    </article>
</template>
