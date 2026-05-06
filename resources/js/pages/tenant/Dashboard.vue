<script setup lang="ts">
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import AuditTrackerCard from '@/pages/tenant/dashboard/AuditTrackerCard.vue';
import ExpiringCertificatesCard from '@/pages/tenant/dashboard/ExpiringCertificatesCard.vue';
import KpiCardsRow from '@/pages/tenant/dashboard/KpiCardsRow.vue';
import OutstandingVendorsCard from '@/pages/tenant/dashboard/OutstandingVendorsCard.vue';
import { useNullablePageProp } from '@/pages/tenant/dashboard/props';
import TrainingCurrencyCard from '@/pages/tenant/dashboard/TrainingCurrencyCard.vue';
import type { AuditTrackerRow } from '@/pages/tenant/dashboard/types';
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

// Used by the Row 3 layout to expand Training Currency when the
// Audit & Violation Tracker card is hidden.
const auditTracker = useNullablePageProp<AuditTrackerRow[]>('audit_tracker');
const auditTrackerVisible = computed<boolean>(() => auditTracker.value !== null);
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <KpiCardsRow />

<!--            <ViolationsOverviewCard />-->

            <section class="grid gap-4 xl:grid-cols-12">
                <AuditTrackerCard v-if="auditTrackerVisible" class="xl:col-span-8" />
                <TrainingCurrencyCard :class="auditTrackerVisible ? 'xl:col-span-4' : 'xl:col-span-12'" />
            </section>

            <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <UpcomingRemindersCard />
                <ExpiringCertificatesCard />
                <OutstandingVendorsCard />
            </section>
        </div>
    </AppLayout>
</template>
