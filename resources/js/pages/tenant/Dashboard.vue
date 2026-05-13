<script setup lang="ts">
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import AuditTrackerCard from '@/pages/tenant/dashboard/AuditTrackerCard.vue';
import ExpiringCertificatesCard from '@/pages/tenant/dashboard/ExpiringCertificatesCard.vue';
import KpiCardsRow from '@/pages/tenant/dashboard/KpiCardsRow.vue';
import LocationsCard from '@/pages/tenant/dashboard/LocationsCard.vue';
import OutstandingVendorsCard from '@/pages/tenant/dashboard/OutstandingVendorsCard.vue';
import { useNullablePageProp } from '@/pages/tenant/dashboard/props';
import TrainingCompletionCard from '@/pages/tenant/dashboard/TrainingCompletionCard.vue';
import type { AuditTrackerRow, LocationGradeRow } from '@/pages/tenant/dashboard/types';
import UpcomingRemindersCard from '@/pages/tenant/dashboard/UpcomingRemindersCard.vue';
import ViolationsOverviewCard from '@/pages/tenant/dashboard/ViolationsOverviewCard.vue';
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
const auditTrackerVisible = computed<boolean>(() => !isOverview.value && auditTracker.value !== null);
const primaryCard = computed<'locations' | 'audit_tracker' | null>(() => {
    if (isOverview.value) return 'locations';
    if (auditTracker.value !== null) return 'audit_tracker';
    return null;
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <KpiCardsRow />

<!--            <ViolationsOverviewCard />-->

            <section class="grid gap-4 xl:grid-cols-12">
                <LocationsCard v-if="primaryCard === 'locations'" class="xl:col-span-8" />
                <AuditTrackerCard v-else-if="primaryCard === 'audit_tracker'" class="xl:col-span-8" />
                <TrainingCompletionCard :class="primaryCard !== null ? 'xl:col-span-4' : 'xl:col-span-12'" />
            </section>

            <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <UpcomingRemindersCard />
                <ExpiringCertificatesCard />
                <OutstandingVendorsCard />
            </section>
        </div>
    </AppLayout>
</template>
