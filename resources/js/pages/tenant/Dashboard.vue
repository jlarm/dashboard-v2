<script setup lang="ts">
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import AuditTrackerCard from '@/pages/tenant/dashboard/AuditTrackerCard.vue';
import ConsultantNotesCard from '@/pages/tenant/dashboard/ConsultantNotesCard.vue';
import KpiCardsRow from '@/pages/tenant/dashboard/KpiCardsRow.vue';
import LocationsCard from '@/pages/tenant/dashboard/LocationsCard.vue';
import ManualsCard from '@/pages/tenant/dashboard/ManualsCard.vue';
import { useNullablePageProp, usePageProp } from '@/pages/tenant/dashboard/props';
import TrainingComplianceSnapshotCard from '@/pages/tenant/dashboard/TrainingComplianceSnapshotCard.vue';
import TrainingCompletionCard from '@/pages/tenant/dashboard/TrainingCompletionCard.vue';
import type { AuditTrackerRow, ConsultantNote, LocationGradeRow, ManualsSummary } from '@/pages/tenant/dashboard/types';
import { dashboard } from '@/routes/dealer';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    {
        title: 'Dashboard',
        href: dashboard(),
    },
]);

// Overview mode (multiple stores in scope) replaces the per-audit Audit
// Tracker card with a per-store grades table.
const locationGrades = useNullablePageProp<LocationGradeRow[]>('location_grades');
const isOverview = computed<boolean>(() => locationGrades.value !== null);

const auditTracker = useNullablePageProp<AuditTrackerRow[]>('audit_tracker');
const primaryCard = computed<'locations' | 'audit_tracker' | null>(() => {
    if (isOverview.value) return 'locations';
    if (auditTracker.value !== null) return 'audit_tracker';
    return null;
});

// Single-store context shows either Consultant Notes (super-admin / Consultant)
// or the Manuals adoption summary (everyone else). The controller emits
// exactly one of these props based on the viewer's role.
const consultantNote = useNullablePageProp<ConsultantNote>('consultant_note');
const manualsSummary = useNullablePageProp<ManualsSummary>('manuals_summary');

const hasSingleStoreCard = computed<boolean>(
    () => consultantNote.value !== null || manualsSummary.value !== null,
);

// Hidden for Managers / Employees / Porter-Drivers — they don't get
// the executive KPI roll-up.
const showKpiCards = usePageProp<boolean>('show_kpi_cards', true);
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <KpiCardsRow v-if="showKpiCards" />

            <section class="grid gap-4 xl:grid-cols-12">
                <LocationsCard v-if="primaryCard === 'locations'" class="xl:col-span-8" />
                <AuditTrackerCard v-else-if="primaryCard === 'audit_tracker'" class="xl:col-span-8" />
                <TrainingCompletionCard :class="primaryCard !== null ? 'xl:col-span-4' : 'xl:col-span-12'" />
            </section>

            <section v-if="hasSingleStoreCard" class="grid gap-4 xl:grid-cols-12">
                <ConsultantNotesCard v-if="consultantNote !== null" class="xl:col-span-4" />
                <ManualsCard v-else-if="manualsSummary !== null" class="xl:col-span-4" />
                <TrainingComplianceSnapshotCard class="xl:col-span-8" />
            </section>
            <TrainingComplianceSnapshotCard v-else />
        </div>
    </AppLayout>
</template>
