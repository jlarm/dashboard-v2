<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, FileDown, Pencil } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import osha from '@/routes/dealer/audit/osha';
import type { BreadcrumbItem } from '@/types';
import type { AuditTypeSlug } from '@/components/audits/audit-types';

type Photo = { id: number; position: number; url: string };
type Remediation = { id: number; comment: string; completed: boolean; user_name: string | null; photo_url: string | null };
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
    comments: Array<{ id: number; user_name: string; body: string; created_at: string }>;
};

const props = defineProps<{
    type: AuditTypeSlug;
    label: string;
    audit: AuditDetail;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: `${props.label} Audits`, href: osha.index.url() },
    { title: props.audit.date, href: osha.show.url({ audit: props.audit.uuid }) },
];
</script>

<template>
    <Head :title="`${label} audit ${audit.date}`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <Link :href="osha.index.url()">
                <Button variant="ghost">
                    <ArrowLeft class="size-4" />
                    Back
                </Button>
            </Link>
            <Link :href="osha.edit.url({ audit: audit.uuid })">
                <Button variant="outline">
                    <Pencil class="size-3.5" />
                    Edit
                </Button>
            </Link>
            <a v-if="audit.has_pdf" :href="osha.download.url({ audit: audit.uuid })">
                <Button variant="outline">
                    <FileDown class="size-3.5" />
                    PDF
                </Button>
            </a>
        </template>

        <div class="space-y-6 p-4">
            <div class="grid gap-4 rounded-lg border bg-card p-4 sm:grid-cols-4">
                <div>
                    <p class="text-xs text-muted-foreground">Date</p>
                    <p class="font-medium">{{ audit.date }}</p>
                </div>
                <div>
                    <p class="text-xs text-muted-foreground">Grade</p>
                    <p class="font-medium">{{ audit.grade ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-muted-foreground">Rating</p>
                    <p class="font-medium">{{ audit.rating }}</p>
                </div>
                <div>
                    <p class="text-xs text-muted-foreground">Violations</p>
                    <p class="font-medium">{{ audit.violation_count }} ({{ audit.remediation_count }} remediated)</p>
                </div>
            </div>

            <div class="space-y-3">
                <h2 class="text-base font-semibold">Violations</h2>
                <div v-if="!audit.violations.length" class="rounded-lg border bg-card p-6 text-center text-sm text-muted-foreground">
                    No violations recorded for this audit.
                </div>
                <div v-for="violation in audit.violations" :key="violation.id" class="rounded-lg border bg-card p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div class="space-y-1">
                            <p class="font-medium">{{ violation.statement }}</p>
                            <p v-if="violation.comment" class="text-sm text-muted-foreground">{{ violation.comment }}</p>
                        </div>
                        <div class="flex flex-wrap gap-1">
                            <Badge v-if="violation.risk" variant="destructive">Risk</Badge>
                            <Badge v-if="violation.severity !== null" variant="secondary">Severity {{ violation.severity }}</Badge>
                            <Badge v-if="violation.remediation?.completed" variant="default">Remediated</Badge>
                        </div>
                    </div>
                    <div v-if="violation.photos.length" class="mt-3 flex flex-wrap gap-2">
                        <img
                            v-for="photo in violation.photos"
                            :key="photo.id"
                            :src="photo.url"
                            class="size-20 rounded object-cover"
                            alt=""
                        />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
