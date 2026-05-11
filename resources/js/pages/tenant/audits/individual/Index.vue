<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ClipboardList, FileDown, Plus, Trash2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import individual from '@/routes/dealer/audit/individual';
import type { BreadcrumbItem } from '@/types';

type Audit = {
    id: number;
    uuid: string;
    audit_date: string;
    quarter: string;
    year: number;
    has_pdf: boolean;
    child_count: number;
    draft_count: number;
};

const props = defineProps<{
    store: { id: number; name: string };
    audits: Audit[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Deal Jackets Archived', href: individual.index.url() },
];

const createParent = (): void => {
    router.post(individual.create.url(), {}, { preserveScroll: true });
};

const deleteAudit = (audit: Audit): void => {
    if (!confirm(`Delete ${audit.quarter} ${audit.year} audit and all child deal jackets?`)) return;
    router.delete(individual.destroy.url({ individualAudit: audit.uuid }), { preserveScroll: true });
};

const formatDate = (iso: string): string => {
    if (!iso) return '';
    return new Date(iso).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};
</script>

<template>
    <Head title="Deal Jacket Audits" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <Button @click="createParent">
                <Plus class="size-4" />
                New audit
            </Button>
        </template>

        <div class="space-y-5 px-4 py-6">
            <header class="space-y-1">
                <h1 class="text-xl font-semibold tracking-tight">Deal Jacket Audits</h1>
                <p class="text-sm text-muted-foreground">{{ props.store.name }}</p>
            </header>

            <div class="rounded-md border">
                <Table>
                    <TableHeader class="bg-muted/50 [&_tr]:border-b">
                        <TableRow>
                            <TableHead>Period</TableHead>
                            <TableHead>Audit date</TableHead>
                            <TableHead>Deal jackets</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead class="w-0" />
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="audits.length > 0">
                            <TableRow v-for="audit in audits" :key="audit.id">
                                <TableCell class="font-medium">{{ audit.quarter }} {{ audit.year }}</TableCell>
                                <TableCell class="text-muted-foreground">{{ formatDate(audit.audit_date) }}</TableCell>
                                <TableCell>
                                    <span>{{ audit.child_count }}</span>
                                    <span v-if="audit.draft_count > 0" class="ml-2 text-xs text-muted-foreground">
                                        ({{ audit.draft_count }} draft)
                                    </span>
                                </TableCell>
                                <TableCell>
                                    <Badge v-if="audit.has_pdf" class="bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200">Report ready</Badge>
                                    <Badge v-else class="bg-muted text-muted-foreground ring-1 ring-border">In progress</Badge>
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <Link :href="individual.show.url({ individualAudit: audit.uuid })">
                                            <Button variant="ghost" size="sm">
                                                <ClipboardList class="size-4" />
                                                <span class="sr-only">Open</span>
                                            </Button>
                                        </Link>
                                        <a v-if="audit.has_pdf" :href="individual.download.url({ individualAudit: audit.uuid })">
                                            <Button variant="ghost" size="sm">
                                                <FileDown class="size-4" />
                                                <span class="sr-only">Download</span>
                                            </Button>
                                        </a>
                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            class="text-destructive hover:text-destructive"
                                            @click="deleteAudit(audit)"
                                        >
                                            <Trash2 class="size-4" />
                                            <span class="sr-only">Delete</span>
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                        </template>
                        <TableRow v-else>
                            <TableCell colspan="5" class="py-12 text-center text-sm text-muted-foreground">
                                No deal jacket audits yet. Click "New audit" to start.
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
    </AppLayout>
</template>
