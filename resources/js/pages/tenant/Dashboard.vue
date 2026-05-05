<script setup lang="ts">
import StatCard from '@/components/StatCard.vue';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { dashboard } from '@/routes/dealer';
import { auditReport as dashboardAuditReportRoute, auditTypeReport as dashboardAuditTypeReportRoute } from '@/routes/dealer/dashboard';
import type { BreadcrumbItem } from '@/types';
import type { StoreOption } from '@/types/global';
import { Head, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

const page = usePage();

const currentStoreName = computed(() => {
    const stores = page.props.stores ?? [];
    const currentId = page.props.auth.current_store_id;

    if (currentId !== null) {
        const match = stores.find((store: StoreOption) => store.id === currentId);
        if (match) {
            return match.name;
        }
    }

    return stores.length === 1 ? stores[0].name : 'Overview';
});

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    {
        title: 'Dashboard',
        href: dashboard(),
    },
]);

// Row 1 — KPI cards
type PillTone = 'positive' | 'negative' | 'warning' | 'neutral';

type CompliancePillar = {
    key: string;
    label: string;
    applicable: boolean;
    score: number | null;
    applicable_stores: number;
    inapplicable_stores: number;
};

type ComplianceProps = {
    score: number | null;
    previous_score: number | null;
    delta: number | null;
    pillars: CompliancePillar[];
    computed_at: string | null;
    caption: string;
};

type OverdueRemediationsProps = {
    count: number | null;
    high_severity_count: number | null;
    previous_count: number | null;
    delta_pct: number | null;
};

type ExpiredTrainingProps = {
    count: number | null;
    expiring_soon_count: number | null;
    previous_count: number | null;
    delta_pct: number | null;
};

type CriticalVulnerabilitiesProps = {
    critical_count: number;
    days_since_last_scan: number | null;
};

const compliance = computed<ComplianceProps>(() => {
    const fallback: ComplianceProps = {
        score: null,
        previous_score: null,
        delta: null,
        pillars: [],
        computed_at: null,
        caption: '',
    };
    return ((page.props as Record<string, unknown>).compliance as ComplianceProps | undefined) ?? fallback;
});

const overdueRemediations = computed<OverdueRemediationsProps | null>(() => {
    return ((page.props as Record<string, unknown>).overdue_remediations as OverdueRemediationsProps | null | undefined) ?? null;
});

const expiredTraining = computed<ExpiredTrainingProps>(() => {
    const fallback: ExpiredTrainingProps = {
        count: null,
        expiring_soon_count: null,
        previous_count: null,
        delta_pct: null,
    };
    return ((page.props as Record<string, unknown>).expired_training as ExpiredTrainingProps | undefined) ?? fallback;
});

const criticalVulnerabilities = computed<CriticalVulnerabilitiesProps | null>(() => {
    return ((page.props as Record<string, unknown>).critical_vulnerabilities as CriticalVulnerabilitiesProps | null | undefined) ?? null;
});

type Kpi = { label: string; value: string; delta: string; tone: PillTone; caption: string };

const complianceKpi = computed<Kpi>(() => {
    const score = compliance.value.score;
    const delta = compliance.value.delta;
    const tone: PillTone = delta === null ? 'neutral' : delta > 0 ? 'positive' : delta < 0 ? 'negative' : 'neutral';
    const deltaLabel = delta === null ? '—' : `${delta > 0 ? '↗' : delta < 0 ? '↘' : ''} ${Math.abs(delta).toFixed(1)} pts`;

    return {
        label: 'Compliance Score',
        value: score === null ? '—' : Math.round(score).toString(),
        delta: deltaLabel,
        tone,
        caption: compliance.value.caption || 'Compared to the previous month',
    };
});

const overdueRemediationsKpi = computed<Kpi | null>(() => {
    if (overdueRemediations.value === null) {
        return null;
    }

    const { count, high_severity_count: high, delta_pct: deltaPct } = overdueRemediations.value;
    // Fewer overdue items = improvement, so a negative delta is positive in tone.
    const tone: PillTone = deltaPct === null ? 'neutral' : deltaPct < 0 ? 'positive' : deltaPct > 0 ? 'negative' : 'neutral';
    const deltaLabel = deltaPct === null
        ? '—'
        : `${deltaPct > 0 ? '↗' : deltaPct < 0 ? '↘' : ''} ${Math.abs(deltaPct).toFixed(0)}%`;
    const caption = high === null
        ? 'No prior period to compare.'
        : `${high} high severity still open`;

    return {
        label: 'Overdue Remediations',
        value: count === null ? '—' : count.toString(),
        delta: deltaLabel,
        tone,
        caption,
    };
});

const expiredTrainingKpi = computed<Kpi>(() => {
    const { count, expiring_soon_count: expiringSoon, delta_pct: deltaPct } = expiredTraining.value;
    // Rising expired count is bad, so positive delta = negative tone.
    const tone: PillTone = deltaPct === null ? 'neutral' : deltaPct > 0 ? 'negative' : deltaPct < 0 ? 'positive' : 'neutral';
    const deltaLabel = deltaPct === null
        ? '—'
        : `${deltaPct > 0 ? '↗' : deltaPct < 0 ? '↘' : ''} ${Math.abs(deltaPct).toFixed(0)}%`;
    const caption = expiringSoon === null
        ? 'No prior period to compare.'
        : `${expiringSoon} more expire in 30 days`;

    return {
        label: 'Expired Training',
        value: count === null ? '—' : count.toString(),
        delta: deltaLabel,
        tone,
        caption,
    };
});

const criticalVulnerabilitiesKpi = computed<Kpi | null>(() => {
    if (criticalVulnerabilities.value === null) {
        return null;
    }

    const { critical_count: count, days_since_last_scan: days } = criticalVulnerabilities.value;
    const tone: PillTone = days === null ? 'neutral' : days <= 30 ? 'warning' : 'negative';
    const delta = days === null ? '—' : `${days}d`;

    return {
        label: 'Critical Vulnerabilities',
        value: count.toString(),
        delta,
        tone,
        caption: 'Days since last scan',
    };
});

const kpis = computed<Kpi[]>(() => {
    return [complianceKpi.value, overdueRemediationsKpi.value, expiredTrainingKpi.value, criticalVulnerabilitiesKpi.value]
        .filter((kpi): kpi is Kpi => kpi !== null);
});

const kpiGridClass = computed<string>(() => {
    switch (kpis.value.length) {
        case 1: return 'grid-cols-1';
        case 2: return 'grid-cols-1 sm:grid-cols-2';
        case 3: return 'grid-cols-1 sm:grid-cols-2 xl:grid-cols-3';
        case 4: return 'grid-cols-1 sm:grid-cols-2 xl:grid-cols-4';
        default: return 'grid-cols-1';
    }
});

const pillClass = (tone: PillTone) =>
    tone === 'positive'
        ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400'
        : tone === 'warning'
          ? 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400'
          : tone === 'negative'
            ? 'bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400'
            : 'bg-muted text-muted-foreground';

// Row 2 — Violations opened vs closed, last 6 periods
type ViolationsBucket = { label: string; opened: number; closed: number };
type ViolationsOverviewProps = {
    monthly: ViolationsBucket[];
    quarterly: ViolationsBucket[];
    yearly: ViolationsBucket[];
};

const period = ref<'Monthly' | 'Quarterly' | 'Yearly'>('Monthly');

const violationsOverview = computed<ViolationsOverviewProps>(() => {
    const fallback: ViolationsOverviewProps = { monthly: [], quarterly: [], yearly: [] };
    return ((page.props as Record<string, unknown>).violations_overview as ViolationsOverviewProps | undefined) ?? fallback;
});

const months = computed<ViolationsBucket[]>(() => {
    const key = period.value === 'Monthly' ? 'monthly' : period.value === 'Quarterly' ? 'quarterly' : 'yearly';
    return violationsOverview.value[key];
});

const focusedIdx = ref(0);

watch(months, (next) => {
    focusedIdx.value = Math.max(0, next.length - 1);
}, { immediate: true });

const chart = computed(() => {
    const buckets = months.value;
    const w = 1000;
    const h = 280;
    const pad = { top: 24, right: 24, bottom: 34, left: 48 };
    const innerW = w - pad.left - pad.right;
    const innerH = h - pad.top - pad.bottom;
    const dataMax = buckets.length > 0 ? Math.max(0, ...buckets.flatMap((m) => [m.opened, m.closed])) : 0;
    const yMax = Math.max(2, dataMax + 1);
    const lineArea = innerH * 0.78;
    const barArea = innerH * 0.22;
    const stepX = buckets.length > 1 ? innerW / (buckets.length - 1) : innerW;

    const toX = (i: number) => pad.left + i * stepX;
    const toY = (v: number) => pad.top + lineArea - (v / yMax) * lineArea;

    const path = (key: 'opened' | 'closed') =>
        buckets
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
    const barMax = Math.max(1, ...buckets.map((m) => m.opened + m.closed));
    for (let m = 0; m < buckets.length; m++) {
        for (let b = 0; b < perPeriod; b++) {
            const seed = (m * 19 + b * 37) % 100;
            const variance = 0.4 + (seed / 100) * 1.0;
            const value = (buckets[m].opened + buckets[m].closed) * variance;
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
        openedPoint: (i: number) => ({ x: toX(i), y: toY(buckets[i]?.opened ?? 0) }),
        closedPoint: (i: number) => ({ x: toX(i), y: toY(buckets[i]?.closed ?? 0) }),
        xLabels: buckets.map((m, i) => ({ x: toX(i), label: m.label })),
        yLabels,
        bars,
    };
});

const focusedData = computed(() => {
    const i = Math.min(focusedIdx.value, months.value.length - 1);
    const safeI = Math.max(0, i);
    return {
        m: months.value[safeI] ?? { label: '—', opened: 0, closed: 0 },
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
    if (target === null || months.value.length === 0) return;
    const rect = target.getBoundingClientRect();
    if (rect.width === 0) return;
    const ratio = (event.clientX - rect.left) / rect.width;
    const idx = Math.round(ratio * (months.value.length - 1));
    focusedIdx.value = Math.max(0, Math.min(months.value.length - 1, idx));
};

const onChartLeave = (): void => {
    focusedIdx.value = Math.max(0, months.value.length - 1);
};

// Row 3a — Audit tracker table
type AuditStatus = 'passing' | 'action_required' | 'overdue';
type AuditTrackerRow = {
    type_key: string;
    type_label: string;
    last_audit_date: string | null;
    grade: string | null;
    delta_label: string | null;
    status: AuditStatus;
    has_report: boolean;
};

const auditTracker = computed<AuditTrackerRow[] | null>(() => {
    return ((page.props as Record<string, unknown>).audit_tracker as AuditTrackerRow[] | null | undefined) ?? null;
});

const statusLabels: Record<AuditStatus, string> = {
    passing: 'Passing',
    action_required: 'Action Required',
    overdue: 'Overdue',
};

const statusPill = (s: AuditStatus): string =>
    s === 'passing'
        ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400'
        : s === 'action_required'
          ? 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400'
          : 'bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400';

const gradeClass = (grade: string | null): string => {
    switch (grade) {
        case 'A': return 'text-emerald-700 dark:text-emerald-400';
        case 'B': return 'text-sky-700 dark:text-sky-400';
        case 'C': return 'text-amber-700 dark:text-amber-400';
        case 'D':
        case 'F': return 'text-rose-700 dark:text-rose-400';
        default: return 'text-muted-foreground';
    }
};

const auditReportUrl = dashboardAuditReportRoute.url();

const auditTypeReportUrl = (typeKey: string): string => dashboardAuditTypeReportRoute.url({ type: typeKey });

// Row 3b — Training currency by dept
const departmentCompletion = [
    { label: 'All', value: 94, headcount: 142 },
    { label: 'Sales', value: 100, headcount: 38 },
    { label: 'Accounting', value: 78, headcount: 9 },
    { label: 'Service', value: 97, headcount: 31 },
    { label: 'Parts', value: 75, headcount: 12 },
    { label: 'Body Shop', value: 88, headcount: 17 },
    { label: 'Finance', value: 100, headcount: 8 },
    { label: 'Porter / Driver', value: 100, headcount: 27 },
];

const completionBar = (v: number) =>
    v >= 95
        ? 'bg-emerald-500'
        : v >= 85
          ? 'bg-sky-500'
          : v >= 75
            ? 'bg-amber-500'
            : 'bg-rose-500';

// Row 4 — action cards
const upcomingReminders: { title: string; assignee: string; due: string; tone: PillTone }[] = [
    { title: 'OSHA eyewash station remediation', assignee: 'Service Mgr', due: '2d', tone: 'negative' },
    { title: 'Annual GLBA safeguards review', assignee: 'Finance Dir', due: '5d', tone: 'warning' },
    { title: 'Body shop ventilation follow-up', assignee: 'BodyShop Mgr', due: '9d', tone: 'warning' },
    { title: 'Vendor questionnaire — DealerTrack', assignee: 'Compliance', due: '12d', tone: 'neutral' },
];

const reminderDot = (tone: PillTone) =>
    tone === 'negative'
        ? 'bg-rose-500'
        : tone === 'warning'
          ? 'bg-amber-500'
          : tone === 'positive'
            ? 'bg-emerald-500'
            : 'bg-sky-500';

const expiringCerts = [
    { name: 'Jane Doe', type: 'Respirator Fit Test', expires: '14d' },
    { name: 'Carlos Rivera', type: 'OSHA 10', expires: '23d' },
    { name: 'Priya Shah', type: 'GLBA Privacy Training', expires: '31d' },
    { name: 'Mike Chen', type: 'Hazmat Refresher', expires: '44d' },
];

const outstandingVendors = [
    { name: 'DealerTrack', lastContacted: '11d ago' },
    { name: 'RouteOne', lastContacted: '6d ago' },
    { name: 'CDK Global', lastContacted: '3d ago' },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <!-- Row 1 — KPI cards -->
            <section class="grid gap-4" :class="kpiGridClass">
                <StatCard
                    v-for="kpi in kpis"
                    :key="kpi.label"
                    :label="kpi.label"
                    :value="kpi.value"
                    :delta="kpi.delta"
                    :tone="kpi.tone"
                    :caption="kpi.caption"
                >
                    <template #action>
                        <button
                            class="grid size-6 place-items-center rounded-md text-muted-foreground hover:bg-muted/60 hover:text-foreground"
                            aria-label="Options"
                        >
                            <svg viewBox="0 0 16 16" class="size-3.5" fill="currentColor">
                                <circle cx="3" cy="8" r="1.25" />
                                <circle cx="8" cy="8" r="1.25" />
                                <circle cx="13" cy="8" r="1.25" />
                            </svg>
                        </button>
                    </template>
                </StatCard>
            </section>

            <!-- Row 2 — Violations overview chart -->
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

            <!-- Row 3 — Audit tracker + Training currency -->
            <section class="grid gap-4 xl:grid-cols-12">
                <article v-if="auditTracker !== null" class="overflow-hidden rounded-2xl border bg-card xl:col-span-8">
                    <div class="flex flex-wrap items-start justify-between gap-4 px-6 pt-6 pb-5">
                        <div>
                            <h2 class="text-xl font-semibold tracking-tight text-foreground">Audit & Violation Tracker</h2>
                            <p class="mt-1 text-sm text-muted-foreground">Latest grade and status per audit category.</p>
                        </div>
                        <a
                            :href="auditReportUrl"
                            class="inline-flex items-center gap-1.5 rounded-lg border px-3 py-1.5 text-xs font-medium text-foreground hover:bg-muted/60"
                        >
                            Download report
                            <span aria-hidden>↗</span>
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[480px] border-t text-sm">
                            <thead>
                                <tr class="bg-muted/40 text-left text-xs font-medium tracking-wide text-muted-foreground uppercase">
                                    <th class="py-3 pl-6 font-medium">Audit Type</th>
                                    <th class="py-3 font-medium">Last Audit</th>
                                    <th class="py-3 font-medium">Grade</th>
                                    <th class="py-3 font-medium">Status</th>
                                    <th class="py-3 pr-6 font-medium text-right">Report</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <tr v-for="row in auditTracker" :key="row.type_key" class="hover:bg-muted/20">
                                    <td class="py-4 pl-6 font-medium text-foreground">{{ row.type_label }}</td>
                                    <td class="py-4 text-muted-foreground">{{ row.last_audit_date }}</td>
                                    <td class="py-4">
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-lg font-semibold" :class="gradeClass(row.grade)">
                                                {{ row.grade ?? '—' }}
                                            </span>
                                            <span v-if="row.delta_label" class="text-xs text-muted-foreground">{{ row.delta_label }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <span
                                            class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium"
                                            :class="statusPill(row.status)"
                                        >
                                            {{ statusLabels[row.status] }}
                                        </span>
                                    </td>
                                    <td class="py-4 pr-6 text-right">
                                        <a
                                            v-if="row.has_report"
                                            :href="auditTypeReportUrl(row.type_key)"
                                            class="inline-flex items-center gap-1.5 rounded-lg border px-3 py-1.5 text-xs font-medium text-foreground hover:bg-muted/60"
                                        >
                                            Download
                                            <span aria-hidden>↗</span>
                                        </a>
                                        <span v-else class="text-xs text-muted-foreground">—</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </article>

                <article class="overflow-hidden rounded-2xl border bg-card" :class="auditTracker === null ? 'xl:col-span-12' : 'xl:col-span-4'">
                    <header class="flex items-center justify-between bg-muted/40 px-5 py-3">
                        <h3 class="text-sm font-medium text-foreground">Training Currency</h3>
                        <span class="text-xs text-muted-foreground">By department</span>
                    </header>
                    <ul class="divide-y">
                        <li
                            v-for="row in departmentCompletion"
                            :key="row.label"
                            class="grid grid-cols-[1fr_auto] items-center gap-3 px-5 py-3"
                        >
                            <div class="min-w-0">
                                <div class="flex items-baseline gap-2">
                                    <span class="text-sm font-medium text-foreground">{{ row.label }}</span>
                                    <span class="text-[11px] text-muted-foreground">n={{ row.headcount }}</span>
                                </div>
                                <div class="mt-2 h-1.5 w-full overflow-hidden rounded-full bg-muted">
                                    <div class="h-full rounded-full" :class="completionBar(row.value)" :style="{ width: `${row.value}%` }" />
                                </div>
                            </div>
                            <span class="w-10 text-right text-sm font-semibold tabular-nums text-foreground">{{ row.value }}%</span>
                        </li>
                    </ul>
                </article>
            </section>

            <!-- Row 4 — action cards -->
            <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <article class="overflow-hidden rounded-2xl border bg-card">
                    <header class="flex items-center justify-between bg-muted/40 px-5 py-3">
                        <h3 class="text-sm font-medium text-foreground">Upcoming Reminders</h3>
                        <span class="text-xs text-muted-foreground">{{ upcomingReminders.length }}</span>
                    </header>
                    <ul class="divide-y">
                        <li
                            v-for="item in upcomingReminders"
                            :key="item.title"
                            class="flex items-start gap-3 px-5 py-3"
                        >
                            <span class="mt-1.5 size-1.5 shrink-0 rounded-full" :class="reminderDot(item.tone)" />
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm text-foreground">{{ item.title }}</p>
                                <p class="mt-0.5 text-xs text-muted-foreground">{{ item.assignee }}</p>
                            </div>
                            <span
                                class="shrink-0 rounded-md px-1.5 py-0.5 text-xs font-semibold tabular-nums"
                                :class="pillClass(item.tone)"
                            >
                                {{ item.due }}
                            </span>
                        </li>
                    </ul>
                </article>

                <article class="overflow-hidden rounded-2xl border bg-card">
                    <header class="flex items-center justify-between bg-muted/40 px-5 py-3">
                        <h3 class="text-sm font-medium text-foreground">Expiring Certificates</h3>
                        <span class="text-xs text-muted-foreground">{{ expiringCerts.length }}</span>
                    </header>
                    <ul class="divide-y">
                        <li
                            v-for="cert in expiringCerts"
                            :key="cert.name + cert.type"
                            class="flex items-center justify-between gap-3 px-5 py-3"
                        >
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-foreground">{{ cert.name }}</p>
                                <p class="truncate text-xs text-muted-foreground">{{ cert.type }}</p>
                            </div>
                            <span class="shrink-0 rounded-md bg-amber-50 px-1.5 py-0.5 text-xs font-semibold tabular-nums text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                {{ cert.expires }}
                            </span>
                        </li>
                    </ul>
                </article>

                <article class="overflow-hidden rounded-2xl border bg-card">
                    <header class="flex items-center justify-between bg-muted/40 px-5 py-3">
                        <h3 class="text-sm font-medium text-foreground">Outstanding Vendor Forms</h3>
                        <span class="text-xs text-muted-foreground">{{ outstandingVendors.length }}</span>
                    </header>
                    <ul class="divide-y">
                        <li
                            v-for="v in outstandingVendors"
                            :key="v.name"
                            class="flex items-center justify-between gap-3 px-5 py-3"
                        >
                            <span class="text-sm font-medium text-foreground">{{ v.name }}</span>
                            <span class="text-xs text-muted-foreground">{{ v.lastContacted }}</span>
                        </li>
                    </ul>
                </article>
            </section>
        </div>
    </AppLayout>
</template>
