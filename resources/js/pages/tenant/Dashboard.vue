<script setup lang="ts">
import { Skeleton } from '@/components/ui/skeleton';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import AuditQuickStartLinks from '@/pages/tenant/dashboard/AuditQuickStartLinks.vue';
import { useNullablePageProp, usePageProp } from '@/pages/tenant/dashboard/props';
import type { AuditTrackerRow, ConsultantNote, ManualsSummary } from '@/pages/tenant/dashboard/types';
import { dashboard } from '@/routes/dealer';
import type { BreadcrumbItem } from '@/types';
import { Deferred, Head } from '@inertiajs/vue3';
import { computed, defineAsyncComponent } from 'vue';

// Dashboard renders ~7 cards for executive-tier users; lazy-loading each
// chunk keeps the initial page paint fast and means a manager view only
// downloads the single snapshot card it actually renders.
const AuditTrackerCard = defineAsyncComponent(() => import('@/pages/tenant/dashboard/AuditTrackerCard.vue'));
const ConsultantNotesCard = defineAsyncComponent(() => import('@/pages/tenant/dashboard/ConsultantNotesCard.vue'));
const KpiCardsRow = defineAsyncComponent(() => import('@/pages/tenant/dashboard/KpiCardsRow.vue'));
const LocationsCard = defineAsyncComponent(() => import('@/pages/tenant/dashboard/LocationsCard.vue'));
const ManualsCard = defineAsyncComponent(() => import('@/pages/tenant/dashboard/ManualsCard.vue'));
const TrainingComplianceSnapshotCard = defineAsyncComponent(() => import('@/pages/tenant/dashboard/TrainingComplianceSnapshotCard.vue'));
const TrainingCompletionCard = defineAsyncComponent(() => import('@/pages/tenant/dashboard/TrainingCompletionCard.vue'));

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    {
        title: 'Dashboard',
        href: dashboard(),
    },
]);

// Overview mode (multiple stores in scope) replaces the per-audit Audit
// Tracker card with a per-store grades table. The sync is_overview flag
// lets us pick the layout immediately; the actual locations data arrives
// in a deferred follow-up.
const isOverview = usePageProp<boolean>('is_overview', false);

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

// Managers (and any role restricted from the executive KPI roll-up) only
// see the Training Compliance Snapshot — the rest of the dashboard is
// scoped to higher-tier roles. We piggyback on the same controller flag
// since the role set is identical.
const showKpiCards = usePageProp<boolean>('show_kpi_cards', true);
const showFullDashboard = computed<boolean>(() => showKpiCards.value);

// Super-admins / Consultants viewing a single store get a row of links to
// kick off a new audit for that store, sitting above the KPI cards.
const auditQuickStartStoreId = useNullablePageProp<number>('audit_quick_start_store_id');
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <template v-if="showFullDashboard">
                <AuditQuickStartLinks
                    v-if="auditQuickStartStoreId !== null"
                    :store-id="auditQuickStartStoreId"
                />

                <KpiCardsRow />

                <section class="grid gap-4 xl:grid-cols-12">
                    <Deferred v-if="primaryCard === 'locations'" data="location_grades">
                        <template #fallback>
                            <Skeleton class="h-72 rounded-2xl xl:col-span-8" />
                        </template>
                        <LocationsCard class="xl:col-span-8" />
                    </Deferred>
                    <AuditTrackerCard v-else-if="primaryCard === 'audit_tracker'" class="xl:col-span-8" />

                    <Deferred data="training_completion">
                        <template #fallback>
                            <Skeleton
                                :class="primaryCard !== null ? 'xl:col-span-4' : 'xl:col-span-12'"
                                class="h-72 rounded-2xl"
                            />
                        </template>
                        <TrainingCompletionCard :class="primaryCard !== null ? 'xl:col-span-4' : 'xl:col-span-12'" />
                    </Deferred>
                </section>

                <section v-if="hasSingleStoreCard" class="grid gap-4 xl:grid-cols-12">
                    <ConsultantNotesCard v-if="consultantNote !== null" class="xl:col-span-4" />
                    <ManualsCard v-else-if="manualsSummary !== null" class="xl:col-span-4" />
                    <Deferred data="training_compliance_snapshot">
                        <template #fallback>
                            <Skeleton class="h-72 rounded-2xl xl:col-span-8" />
                        </template>
                        <TrainingComplianceSnapshotCard class="xl:col-span-8" />
                    </Deferred>
                </section>
                <Deferred v-else data="training_compliance_snapshot">
                    <template #fallback>
                        <Skeleton class="h-72 rounded-2xl" />
                    </template>
                    <TrainingComplianceSnapshotCard />
                </Deferred>
            </template>

            <Deferred v-else data="training_compliance_snapshot">
                <template #fallback>
                    <Skeleton class="h-72 rounded-2xl" />
                </template>
                <TrainingComplianceSnapshotCard />
            </Deferred>
        </div>
    </AppLayout>
</template>
