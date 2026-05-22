<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { CheckCircle2, ClipboardList, Eye, FileDown, MoreVertical, Pencil, RotateCcw, Trash2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Button } from '@/components/ui/button';
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppPagination from '@/components/AppPagination.vue';
import AuditGradePicker from './components/AuditGradePicker.vue';
import GradesOverTimeChart from './components/GradesOverTimeChart.vue';
import ViolationsRemediationsChart from './components/ViolationsRemediationsChart.vue';
import { Role } from '@/constants/roles';
import { useAuditRoutes } from '@/composables/useAuditRoutes';
import type { BreadcrumbItem } from '@/types';
import type { PaginatedResponse } from '@/types/paginator';
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
    is_completed: boolean;
    completed_date: string | null;
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
    audits: PaginatedResponse<Audit>;
    legacy_audits: LegacyAudit[];
    chart: {
        labels: string[];
        gradesNumeric: number[];
        gradesLetters: string[];
        violations: number[];
        remediations: number[];
    };
}>();

const routes = useAuditRoutes(props.type);

const breadcrumbs: BreadcrumbItem[] = [
    { title: `${props.label} Audits`, href: routes.index.url() },
];

const page = usePage<{ auth: { roles: string[] } }>();
const canManageAudits = computed(() => {
    const roles = page.props.auth?.roles ?? [];
    return roles.includes(Role.SuperAdmin) || roles.includes(Role.Consultant);
});

const deleteAudit = (audit: Audit): void => {
    if (!confirm(`Delete the audit from ${audit.date}? This cannot be undone.`)) return;
    router.delete(routes.destroy.url({ audit: audit.uuid }), { preserveScroll: true });
};

const markComplete = (audit: Audit): void => {
    router.post(routes.complete.url({ audit: audit.uuid }), {}, { preserveScroll: true });
};

const reopenAudit = (audit: Audit): void => {
    if (!confirm(`Reopen the audit from ${audit.date}?`)) return;
    router.delete(routes.reopen.url({ audit: audit.uuid }), { preserveScroll: true });
};
</script>

<template>
    <Head :title="`${label} Audits`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <Link v-if="store && canManageAudits" :href="routes.create.url({ store: store.id })">
                <Button>
                    New audit
                </Button>
            </Link>
        </template>

        <div class="space-y-5">
            <div class="grid gap-4 md:grid-cols-2">
                <GradesOverTimeChart
                    :labels="chart.labels"
                    :grades-numeric="chart.gradesNumeric"
                    :grades-letters="chart.gradesLetters"
                />
                <ViolationsRemediationsChart
                    :labels="chart.labels"
                    :violations="chart.violations"
                    :remediations="chart.remediations"
                />
            </div>

            <div class="rounded-md border">
                <Table class="hidden md:table">
                    <TableHeader class="bg-muted/50 [&_tr]:border-b">
                        <TableRow>
                            <TableHead>Quarter</TableHead>
                            <TableHead>Date</TableHead>
                            <TableHead>Grade</TableHead>
                            <TableHead>Violations</TableHead>
                            <TableHead>Remediation</TableHead>
                            <TableHead class="w-0" />
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="audits.data.length > 0">
                            <TableRow v-for="audit in audits.data" :key="audit.id">
                                <TableCell class="font-medium text-foreground">{{ audit.quarter }}</TableCell>
                                <TableCell class="text-muted-foreground">{{ audit.date }}</TableCell>
                                <TableCell>
                                    <AuditGradePicker
                                        :type="type"
                                        :audit-uuid="audit.uuid"
                                        :grade="audit.grade"
                                        :editable="canManageAudits && audit.is_completed"
                                        align="start"
                                    />
                                </TableCell>
                                <TableCell class="text-muted-foreground">{{ audit.violation_count }}</TableCell>
                                <TableCell class="text-muted-foreground">
                                    {{ audit.remediation_count }} / {{ audit.violation_count }}
                                    ({{ audit.remediation_progress }}%)
                                </TableCell>
                                <TableCell class="w-0 whitespace-nowrap pr-4 text-right">
                                    <Popover>
                                        <PopoverTrigger as-child>
                                            <Button variant="outline" size="icon" aria-label="Open actions">
                                                <MoreVertical class="size-4" />
                                            </Button>
                                        </PopoverTrigger>
                                        <PopoverContent
                                            align="end"
                                            :side-offset="4"
                                            :collision-padding="16"
                                            class="z-[60] w-48 p-1"
                                        >
                                            <Link
                                                v-if="audit.is_completed"
                                                :href="routes.show.url({ audit: audit.uuid })"
                                                class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent"
                                            >
                                                <Eye class="size-4" />
                                                View
                                            </Link>
                                            <Link
                                                v-if="canManageAudits && !audit.is_completed"
                                                :href="routes.edit.url({ audit: audit.uuid })"
                                                class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent"
                                            >
                                                <Pencil class="size-4" />
                                                Edit
                                            </Link>
                                            <button
                                                v-if="canManageAudits && !audit.is_completed"
                                                type="button"
                                                class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-left text-sm hover:bg-accent"
                                                @click="markComplete(audit)"
                                            >
                                                <CheckCircle2 class="size-4 text-emerald-600" />
                                                Mark complete
                                            </button>
                                            <button
                                                v-if="canManageAudits && audit.is_completed"
                                                type="button"
                                                class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-left text-sm hover:bg-accent"
                                                @click="reopenAudit(audit)"
                                            >
                                                <RotateCcw class="size-4" />
                                                Reopen
                                            </button>
                                            <Link
                                                v-if="audit.is_completed"
                                                :href="routes.remediation.url({ audit: audit.uuid })"
                                                class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent"
                                            >
                                                <ClipboardList class="size-4" />
                                                Remediate
                                            </Link>
                                            <a
                                                v-if="audit.is_completed"
                                                :href="routes.download.url({ audit: audit.uuid })"
                                                target="_blank"
                                                rel="noopener"
                                                class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent"
                                            >
                                                <FileDown class="size-4" />
                                                Download PDF
                                            </a>
                                            <template v-if="canManageAudits">
                                                <div class="my-1 h-px bg-border" />
                                                <button
                                                    type="button"
                                                    class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-left text-sm text-destructive hover:bg-accent"
                                                    @click="deleteAudit(audit)"
                                                >
                                                    <Trash2 class="size-4" />
                                                    Delete
                                                </button>
                                            </template>
                                        </PopoverContent>
                                    </Popover>
                                </TableCell>
                            </TableRow>
                        </template>
                        <TableRow v-else>
                            <TableCell colspan="6" class="py-12 text-center">
                                <ClipboardList class="mx-auto size-10 text-muted-foreground" />
                                <p class="mt-3 text-sm text-foreground">No audits yet.</p>
                                <div v-if="store && canManageAudits" class="mt-4">
                                    <Button as-child size="sm">
                                        <Link :href="routes.create.url({ store: store.id })">
                                            New audit
                                        </Link>
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <!-- Stacked card layout (mobile) -->
                <div class="md:hidden">
                    <template v-if="audits.data.length > 0">
                        <div
                            v-for="audit in audits.data"
                            :key="audit.id"
                            class="space-y-2 border-b p-4 last:border-b-0"
                        >
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="font-medium text-foreground">{{ audit.quarter }}</p>
                                    <p class="text-xs text-muted-foreground">{{ audit.date }}</p>
                                </div>
                                <div class="flex shrink-0 items-center gap-2">
                                    <AuditGradePicker
                                        :type="type"
                                        :audit-uuid="audit.uuid"
                                        :grade="audit.grade"
                                        :editable="canManageAudits && audit.is_completed"
                                        align="end"
                                    />
                                    <Popover>
                                        <PopoverTrigger as-child>
                                            <Button variant="outline" size="icon" aria-label="Open actions">
                                                <MoreVertical class="size-4" />
                                            </Button>
                                        </PopoverTrigger>
                                        <PopoverContent
                                            align="end"
                                            :side-offset="4"
                                            :collision-padding="16"
                                            class="z-[60] w-48 p-1"
                                        >
                                            <Link
                                                v-if="audit.is_completed"
                                                :href="routes.show.url({ audit: audit.uuid })"
                                                class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent"
                                            >
                                                <Eye class="size-4" />
                                                View
                                            </Link>
                                            <Link
                                                v-if="canManageAudits && !audit.is_completed"
                                                :href="routes.edit.url({ audit: audit.uuid })"
                                                class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent"
                                            >
                                                <Pencil class="size-4" />
                                                Edit
                                            </Link>
                                            <button
                                                v-if="canManageAudits && !audit.is_completed"
                                                type="button"
                                                class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-left text-sm hover:bg-accent"
                                                @click="markComplete(audit)"
                                            >
                                                <CheckCircle2 class="size-4 text-emerald-600" />
                                                Mark complete
                                            </button>
                                            <button
                                                v-if="canManageAudits && audit.is_completed"
                                                type="button"
                                                class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-left text-sm hover:bg-accent"
                                                @click="reopenAudit(audit)"
                                            >
                                                <RotateCcw class="size-4" />
                                                Reopen
                                            </button>
                                            <Link
                                                v-if="audit.is_completed"
                                                :href="routes.remediation.url({ audit: audit.uuid })"
                                                class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent"
                                            >
                                                <ClipboardList class="size-4" />
                                                Remediate
                                            </Link>
                                            <a
                                                v-if="audit.is_completed"
                                                :href="routes.download.url({ audit: audit.uuid })"
                                                target="_blank"
                                                rel="noopener"
                                                class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent"
                                            >
                                                <FileDown class="size-4" />
                                                Download PDF
                                            </a>
                                            <template v-if="canManageAudits">
                                                <div class="my-1 h-px bg-border" />
                                                <button
                                                    type="button"
                                                    class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-left text-sm text-destructive hover:bg-accent"
                                                    @click="deleteAudit(audit)"
                                                >
                                                    <Trash2 class="size-4" />
                                                    Delete
                                                </button>
                                            </template>
                                        </PopoverContent>
                                    </Popover>
                                </div>
                            </div>
                            <p class="text-sm text-muted-foreground">
                                {{ audit.violation_count }} violations
                                · {{ audit.remediation_count }} / {{ audit.violation_count }} remediated ({{ audit.remediation_progress }}%)
                            </p>
                        </div>
                    </template>
                    <div v-else class="py-12 text-center">
                        <ClipboardList class="mx-auto size-10 text-muted-foreground" />
                        <p class="mt-3 text-sm text-foreground">No audits yet.</p>
                        <div v-if="store && canManageAudits" class="mt-4">
                            <Button as-child size="sm">
                                <Link :href="routes.create.url({ store: store.id })">
                                    New audit
                                </Link>
                            </Button>
                        </div>
                    </div>
                </div>
            </div>

            <AppPagination :pagination="audits" :only="['audits']" />

            <div v-if="legacy_audits.length" class="space-y-2">
                <h2 class="text-sm font-semibold tracking-tight">Archived audits</h2>
                <div class="rounded-md border">
                    <Table>
                        <TableHeader class="bg-muted/50 [&_tr]:border-b">
                            <TableRow>
                                <TableHead>Quarter</TableHead>
                                <TableHead>Date</TableHead>
                                <TableHead>Grade</TableHead>
                                <TableHead class="w-0 text-right">Report</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="legacy in legacy_audits" :key="legacy.id">
                                <TableCell class="font-medium text-foreground">{{ legacy.quarter }}</TableCell>
                                <TableCell class="text-muted-foreground">{{ legacy.audit_date }}</TableCell>
                                <TableCell class="text-muted-foreground">{{ legacy.grade ?? '—' }}</TableCell>
                                <TableCell class="w-0 whitespace-nowrap pr-4 text-right">
                                    <span class="text-xs italic text-muted-foreground">
                                        {{ legacy.has_pdf ? 'Available' : 'No PDF' }}
                                    </span>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
