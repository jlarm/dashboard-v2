<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import IssueStatCards from '@/pages/tenant/scans/components/IssueStatCards.vue';
import OverallRiskCards from '@/pages/tenant/scans/components/OverallRiskCards.vue';
import scan from '@/routes/dealer/scan';
import type { BreadcrumbItem } from '@/types';
import { Deferred, Head, Link, usePage } from '@inertiajs/vue3';
import { AlertTriangle, FileSearch, Settings as SettingsIcon, ShieldAlert } from 'lucide-vue-next';
import { computed } from 'vue';

type RiskGrade = {
    current: string | null;
    previous: string | null;
    trend: 'improved' | 'declined' | 'stable';
};

type Counts = {
    total: number | null;
    critical: number | null;
    high: number | null;
    medium: number | null;
    low: number | null;
    grade: string | null;
};

type DashboardPayload = {
    is_configured: boolean;
    has_short_name: boolean;
    has_scan_data: boolean;
    has_external_scans: boolean;
    has_internal_scans: boolean;
    overall_risk: RiskGrade;
    vulnerability_risk: RiskGrade;
    issue_counts: Counts;
    last_scan_date: string | null;
};

type DeferredDashboard = {
    data: DashboardPayload | null;
    error: string | null;
};

type StoreOverviewItem = {
    id: number;
    name: string;
    reports_count: number;
    latest_scan_report_date: string | null;
};

type StoreSummary = {
    id: number;
    name: string;
};

const props = defineProps<{
    mode: 'overview' | 'dashboard' | 'error';
    overview: StoreOverviewItem[];
    dashboard: DeferredDashboard | null;
    store: StoreSummary | null;
    error: string | null;
}>();

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Scans', href: scan.index.url() }];

const canAccessSettings = computed(() => {
    const roles = usePage().props.auth.roles;
    return roles.includes('super-admin') || roles.includes('Consultant');
});
</script>

<template>
    <Head title="Scans" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-5">
            <header class="flex flex-wrap items-start justify-between gap-3">
                <Heading
                    title="Scans"
                    :description="
                        mode === 'overview'
                            ? 'Vulnerability and exposure scans across your stores.'
                            : store
                              ? `Vulnerability and exposure findings for ${store.name}.`
                              : 'Vulnerability and exposure findings.'
                    "
                />
                <div v-if="mode === 'dashboard' && canAccessSettings" class="flex items-center gap-2">
                    <Button as-child variant="outline" size="sm">
                        <Link :href="scan.settings.url()">
                            <SettingsIcon class="size-3.5" />
                            Settings
                        </Link>
                    </Button>
                </div>
            </header>

            <!-- Multi-store overview -->
            <template v-if="mode === 'overview'">
                <section class="rounded-2xl border bg-card p-6">
                    <h2 class="text-base font-semibold text-foreground">IT Scans Overview</h2>
                    <p class="mt-1 text-sm text-muted-foreground">
                        Showing all stores in scope. Select a store from the switcher for detailed scan insights and report downloads.
                    </p>
                </section>

                <section v-if="overview.length > 0" class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <article
                        v-for="store in overview"
                        :key="store.id"
                        class="rounded-2xl border bg-card p-5"
                    >
                        <header class="flex items-start justify-between gap-3">
                            <h3 class="text-base font-semibold tracking-tight text-foreground">{{ store.name }}</h3>
                            <span class="inline-flex items-center rounded-md bg-muted px-2 py-0.5 text-xs font-medium text-muted-foreground">
                                {{ store.reports_count }} reports
                            </span>
                        </header>
                        <dl class="mt-4 space-y-1 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-muted-foreground">Last archived scan</dt>
                                <dd class="font-medium text-foreground">
                                    {{ store.latest_scan_report_date ?? 'No archived scans' }}
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-muted-foreground">Store ID</dt>
                                <dd class="font-mono text-xs text-foreground">{{ store.id }}</dd>
                            </div>
                        </dl>
                    </article>
                </section>

                <section v-else class="rounded-2xl border bg-card py-16 text-center">
                    <FileSearch class="mx-auto size-10 text-muted-foreground" />
                    <p class="mt-3 text-sm text-foreground">No stores in your scope have scan history.</p>
                </section>
            </template>

            <!-- Error state when current store cannot be resolved -->
            <section v-else-if="mode === 'error' && error" class="rounded-2xl border border-rose-200 bg-rose-50/60 p-6 dark:border-rose-500/30 dark:bg-rose-500/10">
                <div class="flex items-start gap-3">
                    <AlertTriangle class="mt-0.5 size-5 text-rose-600 dark:text-rose-400" />
                    <div>
                        <h2 class="text-base font-semibold text-rose-900 dark:text-rose-200">Connection Error</h2>
                        <p class="mt-1 text-sm text-rose-800 dark:text-rose-300">{{ error }}</p>
                    </div>
                </div>
            </section>

            <!-- Single-store dashboard -->
            <template v-else-if="mode === 'dashboard'">
                <Deferred data="dashboard">
                    <template #fallback>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="h-28 animate-pulse rounded-2xl border bg-muted/40" />
                                <div class="h-28 animate-pulse rounded-2xl border bg-muted/40" />
                            </div>
                            <div class="grid grid-cols-2 gap-4 lg:grid-cols-6">
                                <div v-for="n in 6" :key="n" class="h-24 animate-pulse rounded-2xl border bg-muted/40" />
                            </div>
                            <div class="h-72 animate-pulse rounded-2xl border bg-muted/40" />
                        </div>
                    </template>

                    <template v-if="dashboard?.error">
                        <section class="rounded-2xl border border-rose-200 bg-rose-50/60 p-6 dark:border-rose-500/30 dark:bg-rose-500/10">
                            <div class="flex items-start gap-3">
                                <AlertTriangle class="mt-0.5 size-5 text-rose-600 dark:text-rose-400" />
                                <div>
                                    <h2 class="text-base font-semibold text-rose-900 dark:text-rose-200">Connection Error</h2>
                                    <p class="mt-1 text-sm text-rose-800 dark:text-rose-300">{{ dashboard.error }}</p>
                                </div>
                            </div>
                        </section>
                    </template>

                    <template v-else-if="dashboard?.data">
                        <section v-if="!dashboard.data.is_configured" class="rounded-2xl border border-amber-200 bg-amber-50/60 p-6 dark:border-amber-500/30 dark:bg-amber-500/10">
                            <div class="flex items-start gap-3">
                                <ShieldAlert class="mt-0.5 size-5 text-amber-600 dark:text-amber-400" />
                                <div>
                                    <h2 class="text-base font-semibold text-amber-900 dark:text-amber-200">API Not Configured</h2>
                                    <p class="mt-1 text-sm text-amber-800 dark:text-amber-300">
                                        The API credentials have not been configured. Please contact your administrator to set up the API integration to view scan data.
                                    </p>
                                </div>
                            </div>
                        </section>

                        <section v-else-if="!dashboard.data.has_short_name" class="rounded-2xl border bg-card py-16 text-center">
                            <p class="text-2xl font-semibold tracking-tight italic text-foreground">
                                Contact your consultant today to get started.
                            </p>
                        </section>

                        <template v-else>
                            <div class="space-y-5">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <h2 class="text-base font-semibold text-foreground">Overall Risk Assessment</h2>
                                        <p class="text-sm text-muted-foreground">
                                            Current security posture across all scan types
                                            <template v-if="dashboard.data.last_scan_date">
                                                · Last scan: <span class="font-medium text-foreground">{{ dashboard.data.last_scan_date }}</span>
                                            </template>
                                        </p>
                                    </div>
                                </div>

                                <OverallRiskCards
                                    :overall="dashboard.data.overall_risk"
                                    :vulnerability="dashboard.data.vulnerability_risk"
                                />

                                <IssueStatCards :counts="dashboard.data.issue_counts" />

                                <!-- Placeholder cards for widgets ported in next commit -->
                                <section v-if="dashboard.data.has_external_scans" class="rounded-2xl border bg-card p-6 text-sm text-muted-foreground">
                                    External IP exposure widget — coming in the next commit.
                                </section>

                                <section v-if="dashboard.data.has_internal_scans" class="grid grid-cols-1 gap-5 md:grid-cols-3">
                                    <div class="rounded-2xl border bg-card p-6 text-sm text-muted-foreground md:col-span-2">
                                        CVE list + open ports widgets — coming in the next commit.
                                    </div>
                                    <div class="rounded-2xl border bg-card p-6 text-sm text-muted-foreground">
                                        CVE risk chart — coming in the next commit.
                                    </div>
                                </section>

                                <section
                                    v-if="!dashboard.data.has_external_scans && !dashboard.data.has_internal_scans"
                                    class="rounded-2xl border bg-card p-6"
                                >
                                    <div class="flex items-start gap-3">
                                        <FileSearch class="mt-0.5 size-5 text-muted-foreground" />
                                        <div>
                                            <h2 class="text-base font-semibold text-foreground">No Scan Results Available</h2>
                                            <p class="mt-1 text-sm text-muted-foreground">
                                                No completed scans were found for this instance. Scan results will appear here once a scan has been completed.
                                            </p>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </template>
                    </template>
                </Deferred>
            </template>
        </div>
    </AppLayout>
</template>
