<script setup lang="ts">
import { index as employeesIndex, show as employeesShow } from '@/routes/dealer/employees';
import { Link } from '@inertiajs/vue3';
import { ChevronRight } from 'lucide-vue-next';
import { computed } from 'vue';
import { usePageProp } from './props';
import type { TrainingComplianceSnapshot, TrainingComplianceStatus } from './types';

const snapshot = usePageProp<TrainingComplianceSnapshot>('training_compliance_snapshot', {
    overdue: 0,
    at_risk: 0,
    compliant: 0,
    unassigned: 0,
    employees: 0,
    priority_alerts: [],
});

type SegmentTone = 'overdue' | 'at_risk' | 'compliant' | 'unassigned';

type Segment = {
    label: string;
    tone: SegmentTone;
    value: number;
};

const segments = computed<Segment[]>(() => [
    { label: 'Overdue', tone: 'overdue', value: snapshot.value.overdue },
    { label: 'At Risk', tone: 'at_risk', value: snapshot.value.at_risk },
    { label: 'Compliant', tone: 'compliant', value: snapshot.value.compliant },
    { label: 'Unassigned', tone: 'unassigned', value: snapshot.value.unassigned },
]);

const compliantPercent = computed<number>(() => {
    if (snapshot.value.employees === 0) return 0;
    return Math.round((snapshot.value.compliant / snapshot.value.employees) * 100);
});

const segmentWidth = (value: number): string => {
    if (snapshot.value.employees === 0) return '0%';
    return `${(value / snapshot.value.employees) * 100}%`;
};

const segmentBg = (tone: SegmentTone): string => {
    switch (tone) {
        case 'overdue':
            return 'bg-rose-500 dark:bg-rose-400';
        case 'at_risk':
            return 'bg-amber-500 dark:bg-amber-400';
        case 'compliant':
            return 'bg-emerald-500 dark:bg-emerald-400';
        case 'unassigned':
            return 'bg-slate-400 dark:bg-slate-500';
    }
};

const segmentDot = (tone: SegmentTone): string => {
    switch (tone) {
        case 'overdue':
            return 'bg-rose-500';
        case 'at_risk':
            return 'bg-amber-500';
        case 'compliant':
            return 'bg-emerald-500';
        case 'unassigned':
            return 'bg-slate-400';
    }
};

const statusPill = (status: TrainingComplianceStatus): string => {
    switch (status) {
        case 'overdue':
            return 'bg-rose-50 text-rose-700 dark:bg-rose-500/15 dark:text-rose-300';
        case 'at_risk':
            return 'bg-amber-50 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300';
        case 'compliant':
            return 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-300';
        default:
            return 'bg-muted text-muted-foreground';
    }
};

const statusLabel = (status: TrainingComplianceStatus): string => {
    switch (status) {
        case 'overdue':
            return 'Overdue';
        case 'at_risk':
            return 'At Risk';
        case 'compliant':
            return 'Compliant';
        default:
            return 'Unassigned';
    }
};

const employeeShowUrl = (slug: string): string => employeesShow.url({ user: slug });
const employeesIndexUrl = employeesIndex.url();
</script>

<template>
    <article class="overflow-hidden rounded-2xl border bg-card">
        <header class="bg-muted/40 px-5 py-3">
            <h3 class="text-sm font-medium text-foreground">Training Compliance Snapshot</h3>
        </header>

        <div class="px-5 py-5">
            <div class="flex items-baseline justify-between gap-4">
                <p class="text-sm text-foreground">
                    <span class="text-2xl font-bold tabular-nums">{{ snapshot.compliant }}</span>
                    <span class="text-muted-foreground"> of </span>
                    <span class="font-semibold tabular-nums">{{ snapshot.employees }}</span>
                    <span class="text-muted-foreground"> compliant</span>
                </p>
                <p class="text-2xl font-bold tabular-nums text-emerald-700 dark:text-emerald-300">
                    {{ compliantPercent }}%
                </p>
            </div>

            <div class="mt-3 flex h-3 w-full overflow-hidden rounded-full bg-muted">
                <div
                    v-for="segment in segments"
                    :key="segment.tone"
                    :class="segmentBg(segment.tone)"
                    :style="{ width: segmentWidth(segment.value) }"
                    :title="`${segment.label}: ${segment.value}`"
                />
            </div>

            <ul class="mt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs">
                <template v-for="segment in segments" :key="segment.tone">
                    <li v-if="segment.value > 0" class="flex items-center gap-2">
                        <span class="size-2 rounded-full" :class="segmentDot(segment.tone)" />
                        <span class="text-muted-foreground">{{ segment.label }}</span>
                        <span class="font-semibold tabular-nums text-foreground">{{ segment.value }}</span>
                    </li>
                </template>
            </ul>
        </div>

        <div v-if="snapshot.priority_alerts.length > 0" class="border-t">
            <ul class="divide-y">
                <li v-for="alert in snapshot.priority_alerts" :key="alert.user_slug">
                    <Link
                        :href="employeeShowUrl(alert.user_slug)"
                        class="flex items-center justify-between gap-4 px-5 py-3 hover:bg-muted/30"
                    >
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-foreground">{{ alert.name }}</p>
                            <p class="mt-0.5 text-xs text-muted-foreground">
                                {{ alert.valid_completed }} / {{ alert.total_required }} current
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span
                                class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium"
                                :class="statusPill(alert.status)"
                            >
                                {{ statusLabel(alert.status) }}
                            </span>
                            <ChevronRight class="size-4 text-muted-foreground" aria-hidden="true" />
                        </div>
                    </Link>
                </li>
            </ul>
            <Link
                :href="employeesIndexUrl"
                class="flex items-center justify-center border-t bg-muted/20 px-5 py-3 text-sm font-medium text-sky-700 hover:bg-muted/40 dark:text-sky-400"
            >
                View all employees
            </Link>
        </div>
    </article>
</template>
