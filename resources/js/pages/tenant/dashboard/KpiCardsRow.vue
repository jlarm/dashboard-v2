<script setup lang="ts">
import StatCard from '@/components/StatCard.vue';
import { auditReport } from '@/routes/dealer/dashboard';
import { Download } from 'lucide-vue-next';
import { computed } from 'vue';
import { useNullablePageProp, usePageProp } from './props';
import type {
    ComplianceProps,
    CriticalVulnerabilitiesProps,
    ExpiredTrainingProps,
    Kpi,
    OverdueRemediationsProps,
    PillTone,
} from './types';

const canDownloadAuditReport = usePageProp<boolean>('can_download_audit_report', false);
const auditReportUrl = auditReport.url();

const compliance = usePageProp<ComplianceProps>('compliance', {
    score: null,
    grade: null,
    previous_score: null,
    delta: null,
    pillars: [],
    computed_at: null,
    caption: '',
});

const overdueRemediations = useNullablePageProp<OverdueRemediationsProps>('overdue_remediations');

const expiredTraining = usePageProp<ExpiredTrainingProps>('expired_training', {
    count: null,
    expiring_soon_count: null,
    previous_count: null,
    delta_pct: null,
});

const criticalVulnerabilities = useNullablePageProp<CriticalVulnerabilitiesProps>('critical_vulnerabilities');

const complianceKpi = computed<Kpi>(() => {
    const grade = compliance.value.grade;
    const delta = compliance.value.delta;
    const tone: PillTone = delta === null ? 'neutral' : delta > 0 ? 'positive' : delta < 0 ? 'negative' : 'neutral';
    const deltaLabel = delta === null ? '—' : `${delta > 0 ? '↗' : delta < 0 ? '↘' : ''} ${Math.abs(delta).toFixed(1)} pts`;

    return {
        label: 'Compliance Grade',
        value: grade ?? '—',
        delta: deltaLabel,
        tone,
        caption: compliance.value.caption || 'Compared to the previous month',
        info: {
            title: 'Compliance Grade',
            description:
                'An A–F letter that blends audit grades (60%), training completion (25%), and vendor compliance (15%) across your scoped locations. Open audit remediations cap the grade — 1–2 opens cap at B, 3+ opens cap at C.',
        },
    };
});

const overdueRemediationsKpi = computed<Kpi | null>(() => {
    if (overdueRemediations.value === null) return null;

    const { count, high_severity_count: high, delta_pct: deltaPct } = overdueRemediations.value;
    // Fewer overdue items = improvement, so a negative delta is positive in tone.
    const tone: PillTone = deltaPct === null ? 'neutral' : deltaPct < 0 ? 'positive' : deltaPct > 0 ? 'negative' : 'neutral';
    const deltaLabel = deltaPct === null
        ? '—'
        : `${deltaPct > 0 ? '↗' : deltaPct < 0 ? '↘' : ''} ${Math.abs(deltaPct).toFixed(0)}%`;
    const caption = high === null ? 'No prior period to compare.' : `${high} high severity still open`;

    return {
        label: 'Overdue Remediations',
        value: count === null ? '—' : count.toString(),
        delta: deltaLabel,
        tone,
        caption,
        info: {
            title: 'Overdue Remediations',
            description:
                'Open audit findings (OSHA, GLBA, Body Shop) past their remediation due date based on each store\'s active Remediation Settings. The high-severity sub-count flags items that materially threaten your grade. The trend pill compares against the prior month\'s snapshot.',
        },
    };
});

const expiredTrainingKpi = computed<Kpi>(() => {
    const { count, expiring_soon_count: expiringSoon, delta_pct: deltaPct } = expiredTraining.value;
    // Rising expired count is bad, so positive delta = negative tone.
    const tone: PillTone = deltaPct === null ? 'neutral' : deltaPct > 0 ? 'negative' : deltaPct < 0 ? 'positive' : 'neutral';
    const deltaLabel = deltaPct === null
        ? '—'
        : `${deltaPct > 0 ? '↗' : deltaPct < 0 ? '↘' : ''} ${Math.abs(deltaPct).toFixed(0)}%`;
    const caption = expiringSoon === null ? 'No prior period to compare.' : `${expiringSoon} more expire in 30 days`;

    return {
        label: 'Expired Training',
        value: count === null ? '—' : count.toString(),
        delta: deltaLabel,
        tone,
        caption,
        info: {
            title: 'Expired Training',
            description:
                'Employees in scope with at least one required course past its expiration date. "More expire in 30 days" warns of upcoming lapses so you can renew before they tip into expired.',
        },
    };
});

const criticalVulnerabilitiesKpi = computed<Kpi | null>(() => {
    if (criticalVulnerabilities.value === null) return null;

    const { critical_count: count, days_since_last_scan: days } = criticalVulnerabilities.value;
    const tone: PillTone = days === null ? 'neutral' : days <= 30 ? 'warning' : 'negative';
    const delta = days === null ? '—' : `${days}d`;

    return {
        label: 'Critical Vulnerabilities',
        value: count.toString(),
        delta,
        tone,
        caption: 'Days since last scan',
        info: {
            title: 'Critical Vulnerabilities',
            description:
                'Critical-severity findings currently open across your scoped locations. The pill shows the number of days since the most recent scan — older than 30 days means the count may be stale.',
        },
    };
});

const kpis = computed<Kpi[]>(() => {
    return [complianceKpi.value, overdueRemediationsKpi.value, expiredTrainingKpi.value, criticalVulnerabilitiesKpi.value]
        .filter((kpi): kpi is Kpi => kpi !== null);
});

const gridClass = computed<string>(() => {
    switch (kpis.value.length) {
        case 1: return 'grid-cols-1';
        case 2: return 'grid-cols-1 sm:grid-cols-2';
        case 3: return 'grid-cols-1 sm:grid-cols-2 xl:grid-cols-3';
        case 4: return 'grid-cols-1 sm:grid-cols-2 xl:grid-cols-4';
        default: return 'grid-cols-1';
    }
});
</script>

<template>
    <section class="grid gap-4" :class="gridClass">
        <StatCard
            v-for="kpi in kpis"
            :key="kpi.label"
            :label="kpi.label"
            :value="kpi.value"
            :delta="kpi.delta"
            :tone="kpi.tone"
            :caption="kpi.caption"
            :info="kpi.info"
        >
            <template v-if="kpi.label === 'Compliance Grade' && canDownloadAuditReport" #valueAction>
                <a
                    :href="auditReportUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-1 text-xs font-medium text-sky-700 hover:underline dark:text-sky-400"
                >
                    <Download class="size-3" aria-hidden="true" />
                    Download Summary
                </a>
            </template>
        </StatCard>
    </section>
</template>
