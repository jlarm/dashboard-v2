<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { CheckCircle2, ClipboardList, Eye, FileDown, MoreVertical, Pencil, Pencil as PencilIcon, Plus, RotateCcw, Trash2 } from 'lucide-vue-next';
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

const gradeOptions = ['A', 'B', 'C', 'D', 'F'] as const;
const gradePopoverFor = ref<number | null>(null);
const savingGradeFor = ref<number | null>(null);

const setGrade = (audit: Audit, grade: string): void => {
    savingGradeFor.value = audit.id;
    router.patch(
        routes.grade.url({ audit: audit.uuid }),
        { grade },
        {
            preserveScroll: true,
            onSuccess: () => {
                gradePopoverFor.value = null;
            },
            onFinish: () => {
                savingGradeFor.value = null;
            },
        },
    );
};

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

const gradeBadgeClass = (grade: string | null): string => {
    switch (grade) {
        case 'A':
            return 'bg-emerald-100 text-emerald-700 ring-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-300 dark:ring-emerald-900/60';
        case 'B':
            return 'bg-sky-100 text-sky-700 ring-sky-200 dark:bg-sky-900/40 dark:text-sky-300 dark:ring-sky-900/60';
        case 'C':
            return 'bg-yellow-100 text-yellow-700 ring-yellow-200 dark:bg-yellow-900/40 dark:text-yellow-300 dark:ring-yellow-900/60';
        case 'D':
            return 'bg-orange-100 text-orange-700 ring-orange-200 dark:bg-orange-900/40 dark:text-orange-300 dark:ring-orange-900/60';
        case 'F':
            return 'bg-red-100 text-red-700 ring-red-200 dark:bg-red-900/40 dark:text-red-300 dark:ring-red-900/60';
        default:
            return 'bg-muted text-muted-foreground ring-border';
    }
};
</script>

<template>
    <Head :title="`${label} Audits`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <Link v-if="store && canManageAudits" :href="routes.create.url({ store: store.id })">
                <Button>
                    <Plus class="size-4" />
                    New {{ label }} audit
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
                <Table>
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
                                    <Popover
                                        v-if="canManageAudits && audit.is_completed"
                                        :open="gradePopoverFor === audit.id"
                                        @update:open="(value) => gradePopoverFor = value ? audit.id : null"
                                    >
                                        <PopoverTrigger as-child>
                                            <button
                                                type="button"
                                                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 transition hover:opacity-80"
                                                :class="gradeBadgeClass(audit.grade)"
                                                :disabled="savingGradeFor === audit.id"
                                            >
                                                {{ audit.grade ?? 'Set grade' }}
                                                <PencilIcon class="size-3 opacity-60" />
                                            </button>
                                        </PopoverTrigger>
                                        <PopoverContent class="w-auto p-2" align="start">
                                            <div class="flex gap-1">
                                                <button
                                                    v-for="option in gradeOptions"
                                                    :key="option"
                                                    type="button"
                                                    class="grid size-9 place-items-center rounded-md text-sm font-semibold ring-1 transition hover:opacity-80"
                                                    :class="[
                                                        gradeBadgeClass(option),
                                                        audit.grade === option ? 'ring-2 ring-foreground' : '',
                                                    ]"
                                                    :disabled="savingGradeFor === audit.id"
                                                    @click="setGrade(audit, option)"
                                                >
                                                    {{ option }}
                                                </button>
                                            </div>
                                        </PopoverContent>
                                    </Popover>
                                    <span
                                        v-else
                                        class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1"
                                        :class="gradeBadgeClass(audit.grade)"
                                    >
                                        {{ audit.grade ?? '—' }}
                                    </span>
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
                                            <Plus class="size-3.5" />
                                            New {{ label }} audit
                                        </Link>
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
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
