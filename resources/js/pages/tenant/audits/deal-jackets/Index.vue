<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { CheckCircle2, ClipboardList, Trash2 } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import { Role } from '@/constants/roles';
import dealJackets from '@/routes/dealer/audit/deal-jackets';
import type { BreadcrumbItem } from '@/types';

type Group = {
    id: number;
    uuid: string;
    created_at: string;
    completed: boolean;
    deal_jackets_count: number;
    total_passed: number;
    total_failed: number;
    total_high_risk: number;
    average_percentage: number | null;
};

type Charts = {
    pass_rate: { labels: string[]; data: number[] };
    common_issues: { labels: string[]; data: number[] };
};

const props = defineProps<{
    store: { id: number; name: string };
    groups: Group[];
    charts: Charts;
    flash_group_uuid: string | null;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Deal Jackets', href: dealJackets.index.url() },
];

const page = usePage<{ auth: { roles: string[] } }>();
const canManage = computed(() => {
    const roles = page.props.auth?.roles ?? [];
    return roles.includes(Role.SuperAdmin) || roles.includes(Role.Consultant);
});

const startGroup = (): void => {
    router.post(dealJackets.start.url(), {}, { preserveScroll: true });
};

const deleteGroup = (group: Group): void => {
    if (!confirm('Delete this Deal Jacket group and all its deal jackets? This cannot be undone.')) return;
    router.delete(dealJackets.destroyGroup.url({ dealJacketGroup: group.uuid }), { preserveScroll: true });
};

const completeGroup = (group: Group): void => {
    if (!confirm('Mark this Deal Jacket group complete? Completed groups are visible to all roles.')) return;
    router.post(dealJackets.complete.url({ dealJacketGroup: group.uuid }), {}, { preserveScroll: true });
};

const formatDate = (iso: string): string => {
    if (!iso) return '';
    return new Date(iso).toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
};

const formatPercent = (value: number | null): string => {
    if (value === null) return '—';
    return `${Math.round(value)}%`;
};
</script>

<template>
    <Head title="Deal Jacket Audits" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <Button v-if="canManage" @click="startGroup">
                New audit
            </Button>
        </template>

        <div class="space-y-5">
            <div class="grid gap-4 md:grid-cols-2">
                <Card class="rounded-2xl shadow-none">
                    <CardHeader>
                        <CardTitle class="text-sm">Pass rate trend</CardTitle>
                        <CardDescription class="text-xs">Last 8 completed quarters</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <p v-if="charts.pass_rate.data.length === 0" class="text-center text-sm text-muted-foreground">
                            No completed quarters yet.
                        </p>
                        <ul v-else class="space-y-2">
                            <li
                                v-for="(label, i) in charts.pass_rate.labels"
                                :key="`${label}-${i}`"
                                class="flex items-center gap-3 text-sm"
                            >
                                <span class="w-16 truncate text-xs text-muted-foreground">{{ label }}</span>
                                <div class="h-2 flex-1 overflow-hidden rounded-full bg-muted">
                                    <div
                                        class="h-full rounded-full bg-emerald-500 transition-all"
                                        :style="{ width: `${charts.pass_rate.data[i]}%` }"
                                    />
                                </div>
                                <span class="w-12 text-right text-xs tabular-nums">{{ Math.round(charts.pass_rate.data[i]) }}%</span>
                            </li>
                        </ul>
                    </CardContent>
                </Card>

                <Card class="rounded-2xl shadow-none">
                    <CardHeader>
                        <CardTitle class="text-sm">Top issues</CardTitle>
                        <CardDescription class="text-xs">Most common failures across the last 4 quarters</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <p v-if="charts.common_issues.data.length === 0" class="text-center text-sm text-muted-foreground">
                            No data yet.
                        </p>
                        <ul v-else class="space-y-2 text-sm">
                            <li
                                v-for="(label, i) in charts.common_issues.labels"
                                :key="`${label}-${i}`"
                                class="flex items-center justify-between gap-3"
                            >
                                <span class="truncate text-muted-foreground">{{ label }}</span>
                                <Badge class="bg-red-100 text-red-700 ring-1 ring-red-200">{{ charts.common_issues.data[i] }}</Badge>
                            </li>
                        </ul>
                    </CardContent>
                </Card>
            </div>

            <Card class="gap-0 rounded-2xl py-0 shadow-none">
                <CardHeader class="flex flex-row items-center justify-between border-b bg-muted/50 py-3">
                    <CardTitle class="text-sm">Quarterly audits</CardTitle>
                    <span class="text-xs text-muted-foreground">{{ groups.length }} groups</span>
                </CardHeader>
                <CardContent class="px-0">
                <div v-if="groups.length === 0" class="px-5 py-12 text-center text-sm text-muted-foreground">
                    No Deal Jacket groups yet. Click "New audit" to start.
                </div>
                <ul v-else class="divide-y">
                    <li
                        v-for="group in groups"
                        :key="group.id"
                        class="flex flex-col gap-2 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:gap-4"
                    >
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <p class="text-sm font-medium">{{ formatDate(group.created_at) }}</p>
                                <Badge v-if="group.completed" class="bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200">Completed</Badge>
                                <Badge v-else class="bg-amber-100 text-amber-700 ring-1 ring-amber-200">In progress</Badge>
                            </div>
                            <p class="mt-0.5 text-xs text-muted-foreground">
                                {{ group.deal_jackets_count }} deal jackets
                                · {{ group.total_passed }} pass / {{ group.total_failed }} fail
                                <span v-if="group.total_high_risk > 0" class="text-red-600">· {{ group.total_high_risk }} high-risk</span>
                                · avg {{ formatPercent(group.average_percentage) }}
                            </p>
                        </div>
                        <TooltipProvider :delay-duration="150">
                            <div class="-ml-2 flex items-center gap-1 sm:ml-0">
                                <Tooltip>
                                    <TooltipTrigger as-child>
                                        <Link :href="dealJackets.show.url({ dealJacketGroup: group.uuid })">
                                            <Button variant="ghost" size="sm">
                                                <ClipboardList class="size-4" />
                                                <span class="sr-only">Open</span>
                                            </Button>
                                        </Link>
                                    </TooltipTrigger>
                                    <TooltipContent>Open</TooltipContent>
                                </Tooltip>
                                <Tooltip v-if="canManage && !group.completed">
                                    <TooltipTrigger as-child>
                                        <Button variant="ghost" size="sm" @click="completeGroup(group)">
                                            <CheckCircle2 class="size-4" />
                                            <span class="sr-only">Mark complete</span>
                                        </Button>
                                    </TooltipTrigger>
                                    <TooltipContent>Mark complete</TooltipContent>
                                </Tooltip>
                                <Tooltip v-if="canManage">
                                    <TooltipTrigger as-child>
                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            class="text-destructive hover:text-destructive"
                                            @click="deleteGroup(group)"
                                        >
                                            <Trash2 class="size-4" />
                                            <span class="sr-only">Delete</span>
                                        </Button>
                                    </TooltipTrigger>
                                    <TooltipContent>Delete group</TooltipContent>
                                </Tooltip>
                            </div>
                        </TooltipProvider>
                    </li>
                </ul>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
