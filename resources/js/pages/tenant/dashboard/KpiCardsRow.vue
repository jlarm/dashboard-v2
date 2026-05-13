<script setup lang="ts">
import StatCard from '@/components/StatCard.vue';
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

const compliance = usePageProp<ComplianceProps>('compliance', {
    score: null,
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
        />
    </section>
</template>
