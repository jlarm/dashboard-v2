<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { usePageProp } from './props';
import type { ViolationsBucket, ViolationsOverviewProps } from './types';

const violationsOverview = usePageProp<ViolationsOverviewProps>('violations_overview', {
    monthly: [],
    quarterly: [],
    yearly: [],
});

const period = ref<'Monthly' | 'Quarterly' | 'Yearly'>('Monthly');

const buckets = computed<ViolationsBucket[]>(() => {
    const key = period.value === 'Monthly' ? 'monthly' : period.value === 'Quarterly' ? 'quarterly' : 'yearly';
    return violationsOverview.value[key];
});

const focusedIdx = ref(0);

watch(buckets, (next) => {
    focusedIdx.value = Math.max(0, next.length - 1);
}, { immediate: true });

const chart = computed(() => {
    const rows = buckets.value;
    const w = 1000;
    const h = 280;
    const pad = { top: 24, right: 24, bottom: 34, left: 48 };
    const innerW = w - pad.left - pad.right;
    const innerH = h - pad.top - pad.bottom;
    const dataMax = rows.length > 0 ? Math.max(0, ...rows.flatMap((m) => [m.opened, m.closed])) : 0;
    const yMax = Math.max(2, dataMax + 1);
    const lineArea = innerH * 0.78;
    const barArea = innerH * 0.22;
    const stepX = rows.length > 1 ? innerW / (rows.length - 1) : innerW;

    const toX = (i: number) => pad.left + i * stepX;
    const toY = (v: number) => pad.top + lineArea - (v / yMax) * lineArea;

    const path = (key: 'opened' | 'closed') =>
        rows
            .map((m, i) => {
                const x = toX(i);
                const y = toY(m[key]);
                return `${i === 0 ? 'M' : 'L'}${x.toFixed(1)},${y.toFixed(1)}`;
            })
            .join(' ');

    // Background micro-bars — 8 per period, pseudo-random variance around total violations
    const bars: { x: number; y: number; height: number; width: number }[] = [];
    const perPeriod = 8;
    const barWidth = 3;
    const barMax = Math.max(1, ...rows.map((m) => m.opened + m.closed));
    for (let m = 0; m < rows.length; m++) {
        for (let b = 0; b < perPeriod; b++) {
            const seed = (m * 19 + b * 37) % 100;
            const variance = 0.4 + (seed / 100) * 1.0;
            const value = (rows[m].opened + rows[m].closed) * variance;
            const heightPct = Math.min(1, value / (barMax * 1.3));
            const height = Math.max(2, heightPct * barArea);
            const clusterStart = m === 0 ? toX(0) + 6 : toX(m) - stepX / 2 + 6;
            const clusterWidth = stepX - 12;
            const baseX = clusterStart + (b / (perPeriod - 1)) * clusterWidth;
            bars.push({
                x: baseX - barWidth / 2,
                y: pad.top + innerH - height,
                height,
                width: barWidth,
            });
        }
    }

    const yLabels = [0, Math.round(yMax / 3), Math.round((yMax / 3) * 2), Math.round(yMax)].map((v) => ({ y: toY(v), value: v }));

    return {
        w,
        h,
        pad,
        openedPath: path('opened'),
        closedPath: path('closed'),
        openedPoint: (i: number) => ({ x: toX(i), y: toY(rows[i]?.opened ?? 0) }),
        closedPoint: (i: number) => ({ x: toX(i), y: toY(rows[i]?.closed ?? 0) }),
        xLabels: rows.map((m, i) => ({ x: toX(i), label: m.label })),
        yLabels,
        bars,
    };
});

const focusedData = computed(() => {
    const i = Math.min(focusedIdx.value, buckets.value.length - 1);
    const safeI = Math.max(0, i);
    return {
        m: buckets.value[safeI] ?? { label: '—', opened: 0, closed: 0 },
        p1: chart.value.openedPoint(safeI),
        p2: chart.value.closedPoint(safeI),
    };
});

const tooltipLeftPct = computed(() => (focusedData.value.p1.x / chart.value.w) * 100);
const tooltipTopPct = computed(() => (Math.min(focusedData.value.p1.y, focusedData.value.p2.y) / chart.value.h) * 100);

// Anchor the tooltip to the left/center/right edge of the focused point
// based on horizontal position, so it never overflows the chart container.
const tooltipTranslateClass = computed<string>(() => {
    const pct = tooltipLeftPct.value;
    if (pct < 15) return 'translate-x-0';
    if (pct > 85) return '-translate-x-full';
    return '-translate-x-1/2';
});

const onChartHover = (event: MouseEvent): void => {
    const target = event.currentTarget as HTMLElement | null;
    if (target === null || buckets.value.length === 0) return;
    const rect = target.getBoundingClientRect();
    if (rect.width === 0) return;
    const ratio = (event.clientX - rect.left) / rect.width;
    const idx = Math.round(ratio * (buckets.value.length - 1));
    focusedIdx.value = Math.max(0, Math.min(buckets.value.length - 1, idx));
};

const onChartLeave = (): void => {
    focusedIdx.value = Math.max(0, buckets.value.length - 1);
};
</script>

<template>
    <section class="rounded-2xl border bg-card">
        <div class="flex flex-wrap items-start justify-between gap-4 px-6 pt-6">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-foreground">Violations Overview</h2>
                <p class="mt-1 text-sm text-muted-foreground">Opened vs closed across all audit types.</p>
            </div>
            <div class="flex items-center gap-2 rounded-full bg-muted/50 p-1">
                <button
                    v-for="opt in ['Monthly', 'Quarterly', 'Yearly'] as const"
                    :key="opt"
                    class="rounded-full px-3 py-1 text-xs font-medium transition-colors"
                    :class="period === opt ? 'bg-card text-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground'"
                    @click="period = opt"
                >
                    {{ opt }}
                </button>
            </div>
        </div>

        <div class="relative px-4 pt-4 pb-2" @mousemove="onChartHover" @mouseleave="onChartLeave">
            <svg :viewBox="`0 0 ${chart.w} ${chart.h}`" class="h-72 w-full" preserveAspectRatio="none">
                <g>
                    <line
                        v-for="(l, i) in chart.yLabels"
                        :key="'g' + i"
                        :x1="chart.pad.left"
                        :x2="chart.w - chart.pad.right"
                        :y1="l.y"
                        :y2="l.y"
                        class="stroke-border"
                        stroke-width="1"
                        stroke-dasharray="2 4"
                        vector-effect="non-scaling-stroke"
                    />
                </g>
                <g class="fill-muted-foreground">
                    <text
                        v-for="(l, i) in chart.yLabels"
                        :key="'y' + i"
                        :x="chart.pad.left - 12"
                        :y="l.y + 4"
                        text-anchor="end"
                        font-size="11"
                    >
                        {{ l.value }}
                    </text>
                </g>
                <g class="fill-muted-foreground/20">
                    <rect
                        v-for="(bar, i) in chart.bars"
                        :key="'b' + i"
                        :x="bar.x"
                        :y="bar.y"
                        :width="bar.width"
                        :height="bar.height"
                        rx="1.5"
                    />
                </g>
                <path
                    :d="chart.closedPath"
                    fill="none"
                    stroke="#D946A6"
                    stroke-width="2.25"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    vector-effect="non-scaling-stroke"
                />
                <path
                    :d="chart.openedPath"
                    fill="none"
                    stroke="#1C2551"
                    stroke-width="2.25"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    vector-effect="non-scaling-stroke"
                    class="dark:stroke-indigo-300"
                />
                <line
                    :x1="focusedData.p1.x"
                    :x2="focusedData.p1.x"
                    :y1="chart.pad.top - 8"
                    :y2="chart.h - chart.pad.bottom"
                    class="stroke-border"
                    stroke-width="1"
                    stroke-dasharray="3 3"
                    vector-effect="non-scaling-stroke"
                />
                <g>
                    <circle
                        :cx="focusedData.p1.x"
                        :cy="focusedData.p1.y"
                        r="5"
                        fill="white"
                        stroke="#1C2551"
                        stroke-width="2"
                        class="dark:stroke-indigo-300"
                    />
                    <circle
                        :cx="focusedData.p2.x"
                        :cy="focusedData.p2.y"
                        r="5"
                        fill="white"
                        stroke="#D946A6"
                        stroke-width="2"
                    />
                </g>
                <g class="fill-muted-foreground">
                    <text
                        v-for="(l, i) in chart.xLabels"
                        :key="'x' + i"
                        :x="l.x"
                        :y="chart.h - 10"
                        text-anchor="middle"
                        font-size="11"
                    >
                        {{ l.label }}
                    </text>
                </g>
            </svg>

            <div
                class="pointer-events-none absolute flex -translate-y-[calc(100%+14px)] items-stretch gap-0 rounded-xl bg-[#0B0F1E] px-3 py-2.5 text-white shadow-lg ring-1 ring-white/5"
                :class="tooltipTranslateClass"
                :style="{ left: `${tooltipLeftPct}%`, top: `${tooltipTopPct}%` }"
            >
                <div class="flex items-center gap-2 pr-3">
                    <span class="h-8 w-0.5 rounded-full bg-indigo-400" />
                    <div class="leading-tight">
                        <p class="text-sm font-semibold tabular-nums">{{ focusedData.m.opened }}</p>
                        <p class="text-[10px] text-white/60">Opened · {{ focusedData.m.label }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 border-l border-white/10 pl-3">
                    <span class="h-8 w-0.5 rounded-full bg-[#D946A6]" />
                    <div class="leading-tight">
                        <p class="text-sm font-semibold tabular-nums">{{ focusedData.m.closed }}</p>
                        <p class="text-[10px] text-white/60">Closed · {{ focusedData.m.label }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-5 border-t px-6 py-3 text-xs">
            <span class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-sm bg-[#1C2551] dark:bg-indigo-300" />
                <span class="text-muted-foreground">Opened</span>
            </span>
            <span class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-sm bg-[#D946A6]" />
                <span class="text-muted-foreground">Closed</span>
            </span>
            <span class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-sm bg-muted-foreground/30" />
                <span class="text-muted-foreground">Volume</span>
            </span>
        </div>
    </section>
</template>
