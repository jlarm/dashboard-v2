<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Plus, FileDown, Pencil } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AuditChart from './components/AuditChart.vue';
import osha from '@/routes/dealer/audit/osha';
import type { BreadcrumbItem } from '@/types';
import type { AuditTypeSlug } from '@/components/audits/audit-types';

type Audit = {
    id: number;
    uuid: string;
    date: string;
    quarter: string;
    grade: string | null;
    violation_count: number;
    remediation_count: number;
    remediation_progress: number;
    comment_count: number;
    has_pdf: boolean;
    has_remediation_pdf: boolean;
    store_name: string;
};

type LegacyAudit = {
    id: number;
    audit_date: string;
    quarter: string;
    grade: string | null;
    has_pdf: boolean;
};

const props = defineProps<{
    type: AuditTypeSlug;
    label: string;
    store: { id: number; name: string } | null;
    audits: Audit[];
    legacy_audits: LegacyAudit[];
    chart: {
        labels: string[];
        gradesNumeric: number[];
        gradesLetters: string[];
        violations: number[];
        remediations: number[];
    };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: `${props.label} Audits`, href: osha.index.url() },
];
</script>

<template>
    <Head :title="`${label} Audits`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <Link v-if="store" :href="osha.create.url({ store: store.id })">
                <Button>
                    <Plus class="size-4" />
                    New {{ label }} audit
                </Button>
            </Link>
        </template>

        <div class="space-y-6 p-4">
            <div class="rounded-lg border bg-card p-4">
                <h2 class="mb-3 text-base font-semibold">Recent grades</h2>
                <AuditChart v-bind="chart" />
            </div>

            <div class="rounded-lg border bg-card">
                <div class="border-b p-4">
                    <h2 class="text-base font-semibold">Audits</h2>
                </div>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Quarter</TableHead>
                            <TableHead>Date</TableHead>
                            <TableHead>Grade</TableHead>
                            <TableHead>Violations</TableHead>
                            <TableHead>Remediation</TableHead>
                            <TableHead class="text-right">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="!audits.length">
                            <TableCell colspan="6" class="text-center text-sm text-muted-foreground">
                                No audits yet.
                            </TableCell>
                        </TableRow>
                        <TableRow v-for="audit in audits" :key="audit.id">
                            <TableCell>{{ audit.quarter }}</TableCell>
                            <TableCell>{{ audit.date }}</TableCell>
                            <TableCell>{{ audit.grade ?? '—' }}</TableCell>
                            <TableCell>{{ audit.violation_count }}</TableCell>
                            <TableCell>
                                {{ audit.remediation_count }} / {{ audit.violation_count }}
                                ({{ audit.remediation_progress }}%)
                            </TableCell>
                            <TableCell class="space-x-2 text-right">
                                <Link :href="osha.show.url({ audit: audit.uuid })">
                                    <Button size="sm" variant="ghost">View</Button>
                                </Link>
                                <Link :href="osha.edit.url({ audit: audit.uuid })">
                                    <Button size="sm" variant="outline">
                                        <Pencil class="size-3.5" />
                                        Edit
                                    </Button>
                                </Link>
                                <a v-if="audit.has_pdf" :href="osha.download.url({ audit: audit.uuid })">
                                    <Button size="sm" variant="outline">
                                        <FileDown class="size-3.5" />
                                        PDF
                                    </Button>
                                </a>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <div v-if="legacy_audits.length" class="rounded-lg border bg-card">
                <div class="border-b p-4">
                    <h2 class="text-base font-semibold">Archived audits</h2>
                    <p class="text-xs text-muted-foreground">Legacy {{ label }} audits with downloadable reports.</p>
                </div>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Quarter</TableHead>
                            <TableHead>Date</TableHead>
                            <TableHead>Grade</TableHead>
                            <TableHead class="text-right">Report</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="legacy in legacy_audits" :key="legacy.id">
                            <TableCell>{{ legacy.quarter }}</TableCell>
                            <TableCell>{{ legacy.audit_date }}</TableCell>
                            <TableCell>{{ legacy.grade ?? '—' }}</TableCell>
                            <TableCell class="text-right">
                                <span v-if="!legacy.has_pdf" class="text-xs text-muted-foreground">No PDF</span>
                                <span v-else class="text-xs text-muted-foreground">Available</span>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
