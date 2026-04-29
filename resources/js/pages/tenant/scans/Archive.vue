<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import scan from '@/routes/dealer/scan';
import type { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, FileText } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import UploadScanReportForm from '@/pages/tenant/scans/components/UploadScanReportForm.vue';

type ScanReport = {
    id: number;
    type: string;
    url: string;
    created_at_formatted: string;
};

type GroupedReports = Record<string, Record<string, ScanReport>>;

type Stats = {
    grade: string | null;
    exploits: { high: number | null; medium: number | null; low: number | null };
    cves: { high: number | null; medium: number | null; low: number | null };
};

const props = defineProps<{
    store: { id: number; name: string };
    canUpload: boolean;
    externalReports: GroupedReports;
    externalStats: Stats;
    internalReports: GroupedReports;
    internalStats: Stats;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Scans', href: scan.index.url() },
    { title: 'Archive', href: scan.archive.url() },
];

const activeTab = ref<'external' | 'internal' | 'upload'>('external');

const externalDays = computed(() => Object.keys(props.externalReports));
const internalDays = computed(() => Object.keys(props.internalReports));

const reportTypeLabel = (type: string): string => {
    const lc = type.toLowerCase();
    if (lc === 'executive') {
        return 'Executive';
    }
    if (lc === 'technical') {
        return 'Technical';
    }
    return type.charAt(0).toUpperCase() + type.slice(1);
};
</script>

<template>
    <Head title="Scans Archive" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6">
            <div class="flex items-start gap-3">
                <Link
                    :href="scan.index.url()"
                    class="inline-flex size-8 shrink-0 items-center justify-center rounded-md border text-muted-foreground hover:bg-muted hover:text-foreground"
                    aria-label="Back to scans"
                >
                    <ArrowLeft class="size-4" />
                </Link>
                <Heading
                    title="Scans Archive"
                    :description="`Archived scan reports for ${store.name}.`"
                />
            </div>

            <Tabs v-model="activeTab" class="w-full">
                <TabsList class="mx-auto inline-flex">
                    <TabsTrigger value="external">External</TabsTrigger>
                    <TabsTrigger value="internal">Internal</TabsTrigger>
                    <TabsTrigger v-if="canUpload" value="upload">Upload Form</TabsTrigger>
                </TabsList>

                <TabsContent value="external" class="mt-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div :class="externalDays.length > 0 ? 'md:col-span-2' : 'md:col-span-3'">
                            <article class="rounded-2xl border bg-card p-5">
                                <header class="mb-3">
                                    <h2 class="text-base font-semibold tracking-tight text-foreground">External Reports</h2>
                                    <p class="text-xs text-muted-foreground">Archived external scan PDFs grouped by date</p>
                                </header>
                                <ul v-if="externalDays.length > 0" class="divide-y text-sm">
                                    <li v-for="day in externalDays" :key="`ext-${day}`" class="flex items-center justify-between py-3">
                                        <span class="text-foreground">{{ day }}</span>
                                        <span class="flex items-center gap-4">
                                            <a
                                                v-for="report in externalReports[day]"
                                                :key="report.id"
                                                :href="report.url"
                                                target="_blank"
                                                rel="noopener"
                                                class="inline-flex items-center gap-1.5 text-muted-foreground transition-colors hover:text-foreground"
                                            >
                                                <FileText class="size-4 text-rose-500" />
                                                {{ reportTypeLabel(report.type) }}
                                            </a>
                                        </span>
                                    </li>
                                </ul>
                                <p v-else class="py-6 text-center text-sm text-muted-foreground">
                                    Scans are not setup or have not been run yet.
                                </p>
                            </article>
                        </div>
                        <aside v-if="externalDays.length > 0" class="space-y-4">
                            <article class="rounded-2xl border bg-card p-5 text-center">
                                <h3 class="text-sm font-semibold tracking-tight text-foreground">Grade</h3>
                                <span class="mt-3 inline-grid size-14 place-items-center rounded-full bg-muted">
                                    <span class="text-xl font-semibold text-foreground">{{ externalStats.grade ?? '—' }}</span>
                                </span>
                            </article>
                            <article class="rounded-2xl border bg-card p-5">
                                <h3 class="text-sm font-semibold tracking-tight text-foreground">Exploits</h3>
                                <ul class="mt-3 divide-y text-xs text-muted-foreground">
                                    <li class="flex justify-between gap-x-4 py-2"><span class="text-rose-600">High</span><span>{{ externalStats.exploits.high ?? '—' }}</span></li>
                                    <li class="flex justify-between gap-x-4 py-2"><span class="text-amber-600">Medium</span><span>{{ externalStats.exploits.medium ?? '—' }}</span></li>
                                    <li class="flex justify-between gap-x-4 py-2"><span class="text-sky-600">Low</span><span>{{ externalStats.exploits.low ?? '—' }}</span></li>
                                </ul>
                            </article>
                            <article class="rounded-2xl border bg-card p-5">
                                <h3 class="text-sm font-semibold tracking-tight text-foreground">CVEs</h3>
                                <ul class="mt-3 divide-y text-xs text-muted-foreground">
                                    <li class="flex justify-between gap-x-4 py-2"><span class="text-rose-600">High</span><span>{{ externalStats.cves.high ?? '—' }}</span></li>
                                    <li class="flex justify-between gap-x-4 py-2"><span class="text-amber-600">Medium</span><span>{{ externalStats.cves.medium ?? '—' }}</span></li>
                                    <li class="flex justify-between gap-x-4 py-2"><span class="text-sky-600">Low</span><span>{{ externalStats.cves.low ?? '—' }}</span></li>
                                </ul>
                            </article>
                        </aside>
                    </div>
                </TabsContent>

                <TabsContent value="internal" class="mt-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div :class="internalDays.length > 0 ? 'md:col-span-2' : 'md:col-span-3'">
                            <article class="rounded-2xl border bg-card p-5">
                                <header class="mb-3">
                                    <h2 class="text-base font-semibold tracking-tight text-foreground">Internal Reports</h2>
                                    <p class="text-xs text-muted-foreground">Archived internal scan PDFs grouped by date</p>
                                </header>
                                <ul v-if="internalDays.length > 0" class="divide-y text-sm">
                                    <li v-for="day in internalDays" :key="`int-${day}`" class="flex items-center justify-between py-3">
                                        <span class="text-foreground">{{ day }}</span>
                                        <span class="flex items-center gap-4">
                                            <a
                                                v-for="report in internalReports[day]"
                                                :key="report.id"
                                                :href="report.url"
                                                target="_blank"
                                                rel="noopener"
                                                class="inline-flex items-center gap-1.5 text-muted-foreground transition-colors hover:text-foreground"
                                            >
                                                <FileText class="size-4 text-rose-500" />
                                                {{ reportTypeLabel(report.type) }}
                                            </a>
                                        </span>
                                    </li>
                                </ul>
                                <p v-else class="py-6 text-center text-sm text-muted-foreground">
                                    Scans are not setup or have not been run yet.
                                </p>
                            </article>
                        </div>
                        <aside v-if="internalDays.length > 0" class="space-y-4">
                            <article class="rounded-2xl border bg-card p-5 text-center">
                                <h3 class="text-sm font-semibold tracking-tight text-foreground">Grade</h3>
                                <span class="mt-3 inline-grid size-14 place-items-center rounded-full bg-muted">
                                    <span class="text-xl font-semibold text-foreground">{{ internalStats.grade ?? '—' }}</span>
                                </span>
                            </article>
                            <article class="rounded-2xl border bg-card p-5">
                                <h3 class="text-sm font-semibold tracking-tight text-foreground">Exploits</h3>
                                <ul class="mt-3 divide-y text-xs text-muted-foreground">
                                    <li class="flex justify-between gap-x-4 py-2"><span class="text-rose-600">High</span><span>{{ internalStats.exploits.high ?? '—' }}</span></li>
                                    <li class="flex justify-between gap-x-4 py-2"><span class="text-amber-600">Medium</span><span>{{ internalStats.exploits.medium ?? '—' }}</span></li>
                                    <li class="flex justify-between gap-x-4 py-2"><span class="text-sky-600">Low</span><span>{{ internalStats.exploits.low ?? '—' }}</span></li>
                                </ul>
                            </article>
                            <article class="rounded-2xl border bg-card p-5">
                                <h3 class="text-sm font-semibold tracking-tight text-foreground">CVEs</h3>
                                <ul class="mt-3 divide-y text-xs text-muted-foreground">
                                    <li class="flex justify-between gap-x-4 py-2"><span class="text-rose-600">High</span><span>{{ internalStats.cves.high ?? '—' }}</span></li>
                                    <li class="flex justify-between gap-x-4 py-2"><span class="text-amber-600">Medium</span><span>{{ internalStats.cves.medium ?? '—' }}</span></li>
                                    <li class="flex justify-between gap-x-4 py-2"><span class="text-sky-600">Low</span><span>{{ internalStats.cves.low ?? '—' }}</span></li>
                                </ul>
                            </article>
                        </aside>
                    </div>
                </TabsContent>

                <TabsContent v-if="canUpload" value="upload" class="mt-6">
                    <UploadScanReportForm />
                </TabsContent>
            </Tabs>
        </div>
    </AppLayout>
</template>
