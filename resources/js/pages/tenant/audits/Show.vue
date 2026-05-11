<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import {
    CheckCircle2,
    ClipboardList,
    FileDown,
    ImageOff,
    MessageSquare,
    Pencil,
} from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Role } from '@/constants/roles';
import { useAuditRoutes } from '@/composables/useAuditRoutes';
import type { BreadcrumbItem } from '@/types';
import type { SharedAuditType } from '@/composables/useAuditRoutes';

type Photo = { id: number; position: number; url: string };
type Remediation = {
    id: number;
    comment: string;
    completed: boolean;
    user_name: string | null;
    photo_url: string | null;
    updated_at: string | null;
};
type Violation = {
    id: number;
    uuid: string;
    statement_id: number | null;
    statement: string;
    comment: string;
    violation_date: string | null;
    risk: boolean;
    severity: number | null;
    show_reference_image: boolean;
    reference_image_url: string | null;
    photos: Photo[];
    remediation: Remediation | null;
};
type AuditComment = {
    id: number;
    user_name: string;
    comment: string;
    created_at: string;
    photo_url: string | null;
};
type AuditDetail = {
    id: number;
    uuid: string;
    date: string;
    grade: string | null;
    violation_count: number;
    remediation_count: number;
    rating: number | string;
    has_pdf: boolean;
    has_remediation_pdf: boolean;
    store_name: string;
    violations: Violation[];
    comments: AuditComment[];
};

const props = defineProps<{
    type: SharedAuditType;
    label: string;
    audit: AuditDetail;
}>();

const routes = useAuditRoutes(props.type);

const breadcrumbs: BreadcrumbItem[] = [
    { title: `${props.label} Audits`, href: routes.index.url() },
    { title: props.audit.date, href: routes.show.url({ audit: props.audit.uuid }) },
];

const page = usePage<{ auth: { roles: string[] } }>();
const canManageAudits = computed(() => {
    const roles = page.props.auth?.roles ?? [];
    return roles.includes(Role.SuperAdmin) || roles.includes(Role.Consultant);
});

const remediationProgress = computed(() => {
    if (props.audit.violation_count === 0) return 0;
    return Math.round((props.audit.remediation_count / props.audit.violation_count) * 100);
});

const formatDate = (iso: string | null | undefined): string => {
    if (!iso) return '';
    try {
        return new Date(iso).toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric',
        });
    } catch {
        return '';
    }
};

const initials = (name: string): string => name
    .split(/\s+/)
    .filter(Boolean)
    .slice(0, 2)
    .map((part) => part[0]?.toUpperCase() ?? '')
    .join('') || '?';

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

const severityBadgeClass = (value: number): string => {
    if (value <= 3) return 'bg-yellow-100 text-yellow-700 ring-yellow-200 dark:bg-yellow-900/40 dark:text-yellow-300';
    if (value <= 7) return 'bg-orange-100 text-orange-700 ring-orange-200 dark:bg-orange-900/40 dark:text-orange-300';
    return 'bg-red-100 text-red-700 ring-red-200 dark:bg-red-900/40 dark:text-red-300';
};
</script>

<template>
    <Head :title="`${label} audit ${audit.date}`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <Link :href="routes.remediation.url({ audit: audit.uuid })">
                <Button variant="outline" size="sm">
                    <ClipboardList class="size-4" />
                    <span class="hidden sm:inline">Remediate</span>
                </Button>
            </Link>
            <Link v-if="canManageAudits" :href="routes.edit.url({ audit: audit.uuid })">
                <Button variant="outline" size="sm">
                    <Pencil class="size-4" />
                    <span class="hidden sm:inline">Edit</span>
                </Button>
            </Link>
            <a v-if="audit.has_pdf" :href="routes.download.url({ audit: audit.uuid })">
                <Button variant="outline" size="sm">
                    <FileDown class="size-4" />
                    <span class="hidden sm:inline">PDF</span>
                </Button>
            </a>
        </template>

        <div class="mx-auto flex max-w-3xl flex-col gap-4 px-3 pb-8 pt-4 sm:px-6">
            <!-- Summary card -->
            <section class="rounded-2xl border bg-card p-5 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-wider text-muted-foreground">{{ label }} audit</p>
                        <h1 class="text-2xl font-semibold tracking-tight">{{ formatDate(audit.date) }}</h1>
                        <p v-if="audit.store_name" class="text-sm text-muted-foreground">{{ audit.store_name }}</p>
                    </div>
                    <span
                        class="inline-flex size-12 items-center justify-center rounded-full text-lg font-bold ring-1"
                        :class="gradeBadgeClass(audit.grade)"
                    >
                        {{ audit.grade ?? '—' }}
                    </span>
                </div>

                <div class="mt-5 grid grid-cols-3 gap-3 text-center">
                    <div class="rounded-lg border bg-muted/40 px-3 py-3">
                        <p class="text-xs uppercase tracking-wider text-muted-foreground">Rating</p>
                        <p class="mt-1 text-xl font-semibold">{{ audit.rating }}</p>
                    </div>
                    <div class="rounded-lg border bg-muted/40 px-3 py-3">
                        <p class="text-xs uppercase tracking-wider text-muted-foreground">Violations</p>
                        <p class="mt-1 text-xl font-semibold">{{ audit.violation_count }}</p>
                    </div>
                    <div class="rounded-lg border bg-muted/40 px-3 py-3">
                        <p class="text-xs uppercase tracking-wider text-muted-foreground">Remediated</p>
                        <p class="mt-1 text-xl font-semibold">
                            {{ audit.remediation_count }}<span class="text-sm font-normal text-muted-foreground">/{{ audit.violation_count }}</span>
                        </p>
                    </div>
                </div>

                <div v-if="audit.violation_count > 0" class="mt-4">
                    <div class="mb-1.5 flex items-center justify-between text-xs">
                        <span class="text-muted-foreground">Remediation progress</span>
                        <span class="font-semibold">{{ remediationProgress }}%</span>
                    </div>
                    <div class="h-2 overflow-hidden rounded-full bg-muted">
                        <div
                            class="h-full rounded-full bg-emerald-500 transition-all"
                            :style="{ width: `${remediationProgress}%` }"
                        />
                    </div>
                </div>
            </section>

            <!-- Violations -->
            <section class="space-y-3">
                <div class="flex items-baseline gap-2 px-1">
                    <h2 class="text-lg font-semibold tracking-tight">Violations</h2>
                    <Badge variant="secondary" class="rounded-full">{{ audit.violation_count }}</Badge>
                </div>

                <div
                    v-if="!audit.violations.length"
                    class="rounded-lg border bg-card p-10 text-center"
                >
                    <CheckCircle2 class="mx-auto mb-3 size-8 text-emerald-500" />
                    <p class="text-sm font-medium">No violations recorded</p>
                    <p class="mt-1 text-xs text-muted-foreground">This audit is clean.</p>
                </div>

                <article
                    v-for="violation in audit.violations"
                    :key="violation.id"
                    class="overflow-hidden rounded-lg border border-border bg-card shadow-sm"
                >
                    <header class="flex items-start gap-3 px-4 pt-4">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold leading-snug">{{ violation.statement }}</p>
                            <div class="mt-1.5 flex flex-wrap gap-1.5">
                                <Badge v-if="violation.risk" class="bg-red-600 text-white">High Risk</Badge>
                                <span
                                    v-if="violation.severity !== null"
                                    class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium ring-1"
                                    :class="severityBadgeClass(violation.severity)"
                                >
                                    Severity {{ violation.severity }}
                                </span>
                                <Badge
                                    v-if="violation.remediation?.completed"
                                    class="bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-300"
                                >
                                    <CheckCircle2 class="size-3" />
                                    Remediated
                                </Badge>
                                <span
                                    v-if="violation.violation_date"
                                    class="text-xs text-muted-foreground"
                                >
                                    Observed {{ formatDate(violation.violation_date) }}
                                </span>
                            </div>
                        </div>
                    </header>

                    <div class="space-y-4 px-4 pb-4 pt-3">
                        <p v-if="violation.comment" class="rounded-md border-l-2 border-border bg-muted/30 px-3 py-2 text-sm leading-relaxed">
                            {{ violation.comment }}
                        </p>
                        <p v-else class="flex items-center gap-1.5 text-xs italic text-muted-foreground">
                            <ImageOff class="size-3.5" />
                            No comment.
                        </p>

                        <div v-if="violation.photos.length" class="grid grid-cols-3 gap-2">
                            <a
                                v-for="photo in violation.photos"
                                :key="photo.id"
                                :href="photo.url"
                                target="_blank"
                                class="aspect-square overflow-hidden rounded-md ring-1 ring-border transition hover:opacity-90"
                            >
                                <img :src="photo.url" class="size-full object-cover" alt="" />
                            </a>
                        </div>

                        <div
                            v-if="violation.reference_image_url && violation.show_reference_image"
                            class="rounded-md border bg-muted/30 p-3"
                        >
                            <p class="mb-2 text-xs uppercase tracking-wider text-muted-foreground">Reference image</p>
                            <a :href="violation.reference_image_url" target="_blank" class="block">
                                <img
                                    :src="violation.reference_image_url"
                                    class="max-h-48 rounded-md object-cover ring-1 ring-border"
                                    alt="Reference"
                                />
                            </a>
                        </div>

                        <!-- Remediation panel -->
                        <div
                            v-if="violation.remediation"
                            class="rounded-lg border p-3"
                            :class="violation.remediation.completed
                                ? 'border-emerald-300 bg-emerald-50/60 dark:border-emerald-900/60 dark:bg-emerald-950/30'
                                : 'border-border bg-muted/30'"
                        >
                            <div class="flex items-start gap-2">
                                <CheckCircle2
                                    class="mt-0.5 size-4 shrink-0"
                                    :class="violation.remediation.completed ? 'text-emerald-500' : 'text-muted-foreground'"
                                />
                                <div class="min-w-0 flex-1 space-y-1">
                                    <div class="flex flex-wrap items-baseline gap-x-2">
                                        <p
                                            class="text-xs font-semibold uppercase tracking-wider"
                                            :class="violation.remediation.completed ? 'text-emerald-700 dark:text-emerald-300' : 'text-muted-foreground'"
                                        >
                                            Remediation {{ violation.remediation.completed ? 'completed' : 'in progress' }}
                                        </p>
                                        <p v-if="violation.remediation.user_name" class="text-xs text-muted-foreground">
                                            by {{ violation.remediation.user_name }}
                                        </p>
                                    </div>
                                    <p v-if="violation.remediation.comment" class="text-sm">{{ violation.remediation.comment }}</p>
                                    <a
                                        v-if="violation.remediation.photo_url"
                                        :href="violation.remediation.photo_url"
                                        target="_blank"
                                        class="mt-2 block w-fit"
                                    >
                                        <img
                                            :src="violation.remediation.photo_url"
                                            class="max-h-40 rounded-md object-cover ring-1 ring-border"
                                            alt="Remediation"
                                        />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </section>

            <!-- Comments -->
            <section class="space-y-3">
                <div class="flex items-baseline gap-2 px-1">
                    <h2 class="flex items-center gap-1.5 text-lg font-semibold tracking-tight">
                        <MessageSquare class="size-4 text-muted-foreground" />
                        Comments
                    </h2>
                    <Badge variant="secondary" class="rounded-full">{{ audit.comments.length }}</Badge>
                </div>

                <p
                    v-if="!audit.comments.length"
                    class="rounded-lg border bg-card p-6 text-center text-sm text-muted-foreground"
                >
                    No comments yet.
                </p>

                <div
                    v-for="comment in audit.comments"
                    :key="comment.id"
                    class="rounded-lg border bg-card p-3 shadow-sm"
                >
                    <div class="flex items-start gap-3">
                        <span class="grid size-9 shrink-0 place-items-center rounded-full bg-primary/10 text-xs font-semibold text-primary">
                            {{ initials(comment.user_name) }}
                        </span>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-baseline gap-x-2">
                                <p class="text-sm font-semibold">{{ comment.user_name }}</p>
                                <p class="text-xs text-muted-foreground">{{ formatDate(comment.created_at) }}</p>
                            </div>
                            <p class="mt-1 whitespace-pre-wrap text-sm">{{ comment.comment }}</p>
                            <a
                                v-if="comment.photo_url"
                                :href="comment.photo_url"
                                target="_blank"
                                class="mt-2 block w-fit"
                            >
                                <img
                                    :src="comment.photo_url"
                                    class="max-h-40 rounded-md object-cover ring-1 ring-border"
                                    alt=""
                                />
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
