<script setup lang="ts">
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { router } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

type Port = {
    port_number: string;
    port_description: string | null;
    risk_level: string;
    machine_count: number;
};

type PortAssetType = 'all' | 'internal' | 'external_ip';

const ASSET_TYPE_LABELS: Record<Exclude<PortAssetType, 'all'>, string> = {
    internal: 'Internal authenticated',
    external_ip: 'External — IP addresses',
};

const props = defineProps<{
    ports: Port[];
    availableAssetTypes: string[];
    initialAssetType: string | null;
}>();

const assetTypeOptions = computed(() =>
    (Object.keys(ASSET_TYPE_LABELS) as Array<keyof typeof ASSET_TYPE_LABELS>)
        .filter((key) => props.availableAssetTypes.includes(key))
        .map((key) => ({ value: key, label: ASSET_TYPE_LABELS[key] })),
);

const PAGE_SIZE = 5;

const assetType = ref<PortAssetType>((props.initialAssetType as PortAssetType) ?? 'all');
const currentPage = ref(1);

watch(
    () => props.initialAssetType,
    (next) => {
        assetType.value = (next as PortAssetType) ?? 'all';
    },
);

watch(assetType, (next) => {
    currentPage.value = 1;
    router.reload({
        only: ['openPorts', 'filters'],
        data: { port_asset_type: next === 'all' ? undefined : next },
        preserveScroll: true,
        preserveState: true,
        replace: true,
    });
});

const totalPages = computed(() => Math.max(1, Math.ceil(props.ports.length / PAGE_SIZE)));

const pagedPorts = computed(() => {
    const start = (currentPage.value - 1) * PAGE_SIZE;
    return props.ports.slice(start, start + PAGE_SIZE);
});

const displayedPages = computed<(number | '…')[]>(() => {
    const pages: (number | '…')[] = [1];

    if (currentPage.value > 4) {
        pages.push('…');
    }

    for (let i = Math.max(2, currentPage.value - 2); i <= Math.min(currentPage.value + 2, totalPages.value - 1); i += 1) {
        if (i !== 1 && i !== totalPages.value) {
            pages.push(i);
        }
    }

    if (currentPage.value < totalPages.value - 3) {
        pages.push('…');
    }

    if (totalPages.value > 1) {
        pages.push(totalPages.value);
    }

    return pages;
});

const goToPage = (page: number): void => {
    currentPage.value = Math.max(1, Math.min(page, totalPages.value));
};

const riskBadgeClass = (risk: string): string => {
    const lc = risk.toLowerCase();
    if (lc === 'critical') {
        return 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/30';
    }
    if (lc === 'high') {
        return 'bg-orange-50 text-orange-700 border-orange-200 dark:bg-orange-500/10 dark:text-orange-400 dark:border-orange-500/30';
    }
    if (lc === 'medium') {
        return 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/30';
    }
    if (lc === 'low') {
        return 'bg-sky-50 text-sky-700 border-sky-200 dark:bg-sky-500/10 dark:text-sky-400 dark:border-sky-500/30';
    }
    return 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/30';
};
</script>

<template>
    <article class="rounded-2xl border bg-card">
        <header class="flex flex-wrap items-center justify-between gap-3 border-b px-5 py-4">
            <div>
                <h3 class="text-sm font-semibold tracking-tight text-foreground">Open Port Vulnerabilities</h3>
                <p class="text-xs text-muted-foreground">Listening ports across scanned assets</p>
            </div>
            <Select v-if="assetTypeOptions.length > 1" v-model="assetType">
                <SelectTrigger class="w-56">
                    <SelectValue />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="all">All asset types</SelectItem>
                    <SelectItem v-for="option in assetTypeOptions" :key="option.value" :value="option.value">
                        {{ option.label }}
                    </SelectItem>
                </SelectContent>
            </Select>
        </header>

        <div class="overflow-x-auto">
            <Table>
                <TableHeader class="bg-muted/40 [&_tr]:border-b">
                    <TableRow>
                        <TableHead>Port</TableHead>
                        <TableHead>Description</TableHead>
                        <TableHead>Risk Level</TableHead>
                        <TableHead class="text-right">Machines</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="ports.length > 0">
                        <TableRow v-for="port in pagedPorts" :key="port.port_number">
                            <TableCell class="font-medium tabular-nums text-foreground">{{ port.port_number }}</TableCell>
                            <TableCell class="text-muted-foreground">{{ port.port_description ?? '—' }}</TableCell>
                            <TableCell>
                                <span
                                    class="inline-flex items-center rounded-md border px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide"
                                    :class="riskBadgeClass(port.risk_level)"
                                >
                                    {{ port.risk_level }}
                                </span>
                            </TableCell>
                            <TableCell class="text-right tabular-nums text-foreground">{{ port.machine_count }}</TableCell>
                        </TableRow>
                    </template>
                    <TableRow v-else>
                        <TableCell colspan="4" class="py-10 text-center text-sm text-muted-foreground">
                            No open ports match this filter.
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <nav v-if="totalPages > 1" class="flex items-center justify-center gap-1 border-t px-5 py-3 text-sm">
            <button
                type="button"
                class="rounded-md px-2 py-1 text-muted-foreground hover:bg-muted disabled:pointer-events-none disabled:opacity-50"
                :disabled="currentPage <= 1"
                @click="goToPage(currentPage - 1)"
            >
                Previous
            </button>
            <template v-for="(page, i) in displayedPages" :key="`${page}-${i}`">
                <span v-if="page === '…'" class="px-1.5 text-muted-foreground">…</span>
                <button
                    v-else
                    type="button"
                    class="rounded-md px-2.5 py-1"
                    :class="page === currentPage ? 'bg-muted text-foreground' : 'text-muted-foreground hover:bg-muted'"
                    @click="goToPage(page)"
                >
                    {{ page }}
                </button>
            </template>
            <button
                type="button"
                class="rounded-md px-2 py-1 text-muted-foreground hover:bg-muted disabled:pointer-events-none disabled:opacity-50"
                :disabled="currentPage >= totalPages"
                @click="goToPage(currentPage + 1)"
            >
                Next
            </button>
        </nav>
    </article>
</template>
