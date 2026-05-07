<script setup lang="ts">
import { auditReport, auditTypeReport } from '@/routes/dealer/dashboard';
import { useNullablePageProp } from './props';
import type { AuditStatus, AuditTrackerRow } from './types';

const auditTracker = useNullablePageProp<AuditTrackerRow[]>('audit_tracker');

const statusLabels: Record<AuditStatus, string> = {
    passing: 'Passing',
    action_required: 'Action Required',
    overdue: 'Overdue',
};

const statusPill = (status: AuditStatus): string => {
    switch (status) {
        case 'passing':
            return 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400';
        case 'action_required':
            return 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400';
        default:
            return 'bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400';
    }
};

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

const auditReportUrl = auditReport.url();
const auditTypeReportUrl = (typeKey: string): string => auditTypeReport.url({ type: typeKey });
</script>

<template>
    <article v-if="auditTracker !== null" class="overflow-hidden rounded-2xl border bg-card">
        <div class="flex flex-wrap items-start justify-between gap-4 px-6 pt-6 pb-5">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-foreground">Audit Tracker</h2>
                <p class="mt-1 text-sm text-muted-foreground">Latest grade and status per audit category.</p>
            </div>
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
</template>
