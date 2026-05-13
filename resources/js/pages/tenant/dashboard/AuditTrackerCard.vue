<script setup lang="ts">
import { auditTypeReport } from '@/routes/dealer/dashboard';
import { Download } from 'lucide-vue-next';
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

const auditTypeReportUrl = (typeKey: string): string => auditTypeReport.url({ type: typeKey });
</script>

<template>
    <article v-if="auditTracker !== null" class="overflow-hidden rounded-2xl border bg-card">
        <header class="bg-muted/40 px-5 py-3">
            <h3 class="text-sm font-medium text-foreground">Audit Tracker</h3>
        </header>
        <div class="overflow-x-auto">
            <table class="w-full min-w-120 text-sm">
                <tbody class="divide-y">
                    <tr v-for="row in auditTracker" :key="row.type_key" class="hover:bg-muted/20">
                        <td class="py-4 pl-5 font-medium text-foreground">{{ row.type_label }}</td>
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
                        <td class="py-4 pr-5 text-right">
                            <a
                                v-if="row.has_report"
                                :href="auditTypeReportUrl(row.type_key)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 rounded-lg border px-3 py-1.5 text-xs font-medium text-foreground hover:bg-muted/60"
                            >
                                <Download class="size-3.5" aria-hidden="true" />
                                Download
                            </a>
                            <span v-else class="text-xs text-muted-foreground">—</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </article>
</template>
