<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Role } from '@/constants/roles';
import dealJackets from '@/routes/dealer/audit/deal-jackets';
import type { BreadcrumbItem } from '@/types';

type DealJacketRow = {
    id: number;
    uuid: string;
    audit_date: string;
    customer_name: string | null;
    customer_deal_number: string | null;
    finance_manager_name: string | null;
    total_passed: number;
    total_failed: number;
    total_high_risk: number;
    percentage: number;
};

type Group = {
    id: number;
    uuid: string;
    completed: boolean;
    created_at: string | null;
    store_name: string;
    deal_jackets: DealJacketRow[];
    total_passed: number;
    total_failed: number;
    total_high_risk: number;
};

const props = defineProps<{
    group: Group;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Deal Jackets', href: dealJackets.index.url() },
    {
        title: formatDate(props.group.created_at),
        href: dealJackets.show.url({ dealJacketGroup: props.group.uuid }),
    },
];

const page = usePage<{ auth: { roles: string[] } }>();
const canManage = computed(() => {
    const roles = page.props.auth?.roles ?? [];
    return roles.includes(Role.SuperAdmin) || roles.includes(Role.Consultant);
});

const passRate = computed(() => {
    const total = props.group.total_passed + props.group.total_failed;
    if (total === 0) return null;
    return Math.round((props.group.total_passed / total) * 100);
});

const deleteJacket = (jacket: DealJacketRow): void => {
    if (!confirm(`Delete deal jacket for ${jacket.customer_name || 'unnamed customer'}?`)) return;
    router.delete(
        dealJackets.destroy.url({ dealJacketGroup: props.group.uuid, dealJacket: jacket.uuid }),
        { preserveScroll: true },
    );
};

function formatDate(iso: string | null | undefined): string {
    if (!iso) return '';
    return new Date(iso).toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
}

const formatAuditDate = (iso: string): string => {
    if (!iso) return '';
    return new Date(iso).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
};
</script>

<template>
    <Head :title="`Deal Jackets ${formatDate(group.created_at)}`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <Link
                v-if="canManage && !group.completed"
                :href="dealJackets.create.url({ dealJacketGroup: group.uuid })"
            >
                <Button>
                    <Plus class="size-4" />
                    Add Deal Jacket
                </Button>
            </Link>
        </template>

        <div class="space-y-5">
            <Card class="rounded-2xl shadow-none">
                <CardHeader class="flex flex-row items-start justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-wider text-muted-foreground">Deal Jacket Audit</p>
                        <CardTitle class="text-xl tracking-tight">{{ formatDate(group.created_at) }}</CardTitle>
                        <p class="text-sm text-muted-foreground">{{ group.store_name }}</p>
                    </div>
                    <Badge
                        v-if="group.completed"
                        class="bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200"
                    >
                        Completed
                    </Badge>
                    <Badge v-else class="bg-amber-100 text-amber-700 ring-1 ring-amber-200">In progress</Badge>
                </CardHeader>
                <CardContent>
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                        <div class="rounded-lg border bg-muted/40 px-3 py-3 text-center">
                            <p class="text-xs uppercase tracking-wider text-muted-foreground">Jackets</p>
                            <p class="mt-1 text-xl font-semibold">{{ group.deal_jackets.length }}</p>
                        </div>
                        <div class="rounded-lg border bg-muted/40 px-3 py-3 text-center">
                            <p class="text-xs uppercase tracking-wider text-muted-foreground">Pass / Fail</p>
                            <p class="mt-1 text-xl font-semibold">
                                <span class="text-emerald-700">{{ group.total_passed }}</span>
                                <span class="text-muted-foreground"> / </span>
                                <span class="text-red-700">{{ group.total_failed }}</span>
                            </p>
                        </div>
                        <div class="rounded-lg border bg-muted/40 px-3 py-3 text-center">
                            <p class="text-xs uppercase tracking-wider text-muted-foreground">High-risk</p>
                            <p class="mt-1 text-xl font-semibold text-red-700">{{ group.total_high_risk }}</p>
                        </div>
                        <div class="rounded-lg border bg-muted/40 px-3 py-3 text-center">
                            <p class="text-xs uppercase tracking-wider text-muted-foreground">Pass rate</p>
                            <p class="mt-1 text-xl font-semibold">{{ passRate ?? '—' }}<span v-if="passRate !== null" class="text-sm font-normal text-muted-foreground">%</span></p>
                        </div>
                    </div>
                </CardContent>
            </Card>

            <Card class="gap-0 rounded-2xl py-0 shadow-none">
                <CardHeader class="flex flex-row items-center justify-between border-b bg-muted/50 py-3">
                    <CardTitle class="text-sm">Deal jackets</CardTitle>
                </CardHeader>
                <CardContent class="px-0">
                <Table v-if="group.deal_jackets.length > 0">
                    <TableHeader class="bg-muted/40 [&_tr]:border-b">
                        <TableRow>
                            <TableHead>Customer</TableHead>
                            <TableHead>Deal #</TableHead>
                            <TableHead>Finance manager</TableHead>
                            <TableHead>Date</TableHead>
                            <TableHead>Pass / Fail</TableHead>
                            <TableHead>Score</TableHead>
                            <TableHead class="w-0" />
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="jacket in group.deal_jackets" :key="jacket.id">
                            <TableCell class="font-medium">{{ jacket.customer_name || '—' }}</TableCell>
                            <TableCell class="text-muted-foreground">{{ jacket.customer_deal_number || '—' }}</TableCell>
                            <TableCell class="text-muted-foreground">{{ jacket.finance_manager_name || 'House' }}</TableCell>
                            <TableCell class="text-muted-foreground">{{ formatAuditDate(jacket.audit_date) }}</TableCell>
                            <TableCell>
                                <span class="text-emerald-700">{{ jacket.total_passed }}</span>
                                <span class="text-muted-foreground"> / </span>
                                <span class="text-red-700">{{ jacket.total_failed }}</span>
                            </TableCell>
                            <TableCell>{{ jacket.percentage }}%</TableCell>
                            <TableCell class="text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <Link
                                        v-if="canManage && !group.completed"
                                        :href="dealJackets.edit.url({ dealJacketGroup: group.uuid, dealJacket: jacket.uuid })"
                                    >
                                        <Button variant="ghost" size="sm">
                                            <Pencil class="size-4" />
                                            <span class="sr-only">Edit</span>
                                        </Button>
                                    </Link>
                                    <Button
                                        v-if="canManage && !group.completed"
                                        variant="ghost"
                                        size="sm"
                                        class="text-destructive hover:text-destructive"
                                        @click="deleteJacket(jacket)"
                                    >
                                        <Trash2 class="size-4" />
                                        <span class="sr-only">Delete</span>
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <p v-else class="px-5 py-12 text-center text-sm text-muted-foreground">
                    No deal jackets yet. Click "Add Deal Jacket" to start.
                </p>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
