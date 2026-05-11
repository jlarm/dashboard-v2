<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { FileDown, Pencil, Plus, Sparkles, Trash2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import individual from '@/routes/dealer/audit/individual';
import type { BreadcrumbItem } from '@/types';

type Child = {
    id: number;
    uuid: string;
    audit_date: string;
    customer_name: string | null;
    customer_number: string | null;
    manager_name: string | null;
    draft: boolean;
};

type AuditDetail = {
    id: number;
    uuid: string;
    parent_id: number | null;
    audit_date: string;
    deal_jacket_date: string | null;
    customer_name: string | null;
    customer_number: string | null;
    manager_id: number | null;
    manager_name: string | null;
    mileage: string | null;
    draft: boolean;
    has_pdf: boolean;
    store_name: string;
    quarter: string;
    year: number;
    children: Child[];
};

const props = defineProps<{
    audit: AuditDetail;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Deal Jackets Archived', href: individual.index.url() },
    { title: `${props.audit.quarter} ${props.audit.year}`, href: individual.show.url({ individualAudit: props.audit.uuid }) },
];

const dealJackets = computed<Child[]>(() => [
    {
        id: props.audit.id,
        uuid: props.audit.uuid,
        audit_date: props.audit.audit_date,
        customer_name: props.audit.customer_name,
        customer_number: props.audit.customer_number,
        manager_name: props.audit.manager_name,
        draft: props.audit.draft,
    },
    ...props.audit.children,
]);

const draftCount = computed(() => dealJackets.value.filter((c) => c.draft).length);
const totalCount = computed(() => dealJackets.value.length);

const addDealJacket = (): void => {
    router.post(
        individual.createChild.url({ individualAudit: props.audit.uuid }),
        {},
        { preserveScroll: true },
    );
};

const generateReport = (): void => {
    router.post(
        individual.generate.url({ individualAudit: props.audit.uuid }),
        {},
        { preserveScroll: true },
    );
};

const deleteChild = (child: Child): void => {
    if (!confirm(`Delete deal jacket for ${child.customer_name ?? 'unnamed customer'}?`)) return;
    router.delete(individual.destroy.url({ individualAudit: child.uuid }), { preserveScroll: true });
};

const formatDate = (iso: string | null | undefined): string => {
    if (!iso) return '';
    return new Date(iso).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};
</script>

<template>
    <Head :title="`Deal Jackets ${audit.quarter} ${audit.year}`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <Button v-if="!audit.has_pdf" variant="outline" size="sm" @click="addDealJacket">
                <Plus class="size-4" />
                <span class="hidden sm:inline">Add deal jacket</span>
            </Button>
            <Button v-if="!audit.has_pdf" variant="outline" size="sm" @click="generateReport">
                <Sparkles class="size-4" />
                <span class="hidden sm:inline">Generate report</span>
            </Button>
            <a v-if="audit.has_pdf" :href="individual.download.url({ individualAudit: audit.uuid })">
                <Button variant="outline" size="sm">
                    <FileDown class="size-4" />
                    <span class="hidden sm:inline">Download PDF</span>
                </Button>
            </a>
        </template>

        <div class="mx-auto max-w-4xl space-y-5 px-3 py-6 sm:px-6">
            <header class="flex items-start justify-between gap-4 rounded-lg border bg-card p-5 shadow-sm">
                <div>
                    <p class="text-xs uppercase tracking-wider text-muted-foreground">Deal Jacket Audit</p>
                    <h1 class="text-xl font-semibold tracking-tight">{{ audit.quarter }} {{ audit.year }}</h1>
                    <p class="text-sm text-muted-foreground">{{ audit.store_name }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-muted-foreground">{{ totalCount }} jackets</p>
                    <p v-if="draftCount > 0" class="text-xs text-amber-700">{{ draftCount }} draft</p>
                </div>
            </header>

            <section class="rounded-lg border bg-card">
                <header class="flex items-center justify-between border-b px-5 py-3">
                    <h2 class="text-sm font-semibold">Deal jackets</h2>
                </header>
                <ul class="divide-y">
                    <li
                        v-for="child in dealJackets"
                        :key="child.id"
                        class="flex items-center justify-between gap-4 px-5 py-4"
                    >
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <p class="truncate text-sm font-medium">
                                    {{ child.customer_name || 'Unnamed customer' }}
                                </p>
                                <Badge v-if="child.draft" class="bg-amber-100 text-amber-700 ring-1 ring-amber-200">Draft</Badge>
                            </div>
                            <p class="text-xs text-muted-foreground">
                                <span v-if="child.customer_number">#{{ child.customer_number }} · </span>
                                <span v-if="child.manager_name">{{ child.manager_name }} · </span>
                                <span>{{ formatDate(child.audit_date) }}</span>
                            </p>
                        </div>
                        <div class="flex items-center gap-1">
                            <Link :href="individual.edit.url({ individualAudit: child.uuid })">
                                <Button variant="ghost" size="sm">
                                    <Pencil class="size-4" />
                                    <span class="sr-only">Edit</span>
                                </Button>
                            </Link>
                            <Button
                                v-if="child.uuid !== audit.uuid"
                                variant="ghost"
                                size="sm"
                                class="text-destructive hover:text-destructive"
                                @click="deleteChild(child)"
                            >
                                <Trash2 class="size-4" />
                                <span class="sr-only">Delete</span>
                            </Button>
                        </div>
                    </li>
                </ul>
            </section>
        </div>
    </AppLayout>
</template>
