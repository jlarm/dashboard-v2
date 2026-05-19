<script setup lang="ts">
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { router } from '@inertiajs/vue3';
import { ChevronDown, ChevronRight, ExternalLink } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

type Cve = {
    id: string;
    title: string;
    risk: string;
    score: number | null;
    published_date: string | null;
    affected_targets: string | null;
    num_affected_targets: number | null;
    type: string;
};

type CveAssetType = 'all' | 'internal' | 'external_ip' | 'external_web';

const ASSET_TYPE_LABELS: Record<Exclude<CveAssetType, 'all'>, string> = {
    internal: 'Internal authenticated',
    external_ip: 'External — IP addresses',
    external_web: 'External — web applications',
};

const props = defineProps<{
    cves: Cve[];
    availableAssetTypes: string[];
    initialAssetType: string | null;
}>();

const assetTypeOptions = computed(() =>
    (Object.keys(ASSET_TYPE_LABELS) as Array<keyof typeof ASSET_TYPE_LABELS>)
        .filter((key) => props.availableAssetTypes.includes(key))
        .map((key) => ({ value: key, label: ASSET_TYPE_LABELS[key] })),
);

const PAGE_SIZE = 5;

const assetType = ref<CveAssetType>((props.initialAssetType as CveAssetType) ?? 'all');
const currentPage = ref(1);
const expandedId = ref<string | null>(null);

watch(
    () => props.initialAssetType,
    (next) => {
        assetType.value = (next as CveAssetType) ?? 'all';
    },
);

watch(assetType, (next) => {
    expandedId.value = null;
    currentPage.value = 1;
    router.reload({
        only: ['cveList', 'filters'],
        data: { cve_asset_type: next === 'all' ? undefined : next },
        preserveScroll: true,
        preserveState: true,
        replace: true,
    });
});

const totalPages = computed(() => Math.max(1, Math.ceil(props.cves.length / PAGE_SIZE)));

const pagedCves = computed(() => {
    const start = (currentPage.value - 1) * PAGE_SIZE;
    return props.cves.slice(start, start + PAGE_SIZE);
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

const toggleAccordion = (id: string): void => {
    expandedId.value = expandedId.value === id ? null : id;
};

const goToPage = (page: number): void => {
    currentPage.value = Math.max(1, Math.min(page, totalPages.value));
    expandedId.value = null;
};

const riskDots = (risk: string): { active: number; tone: string } => {
    const lc = risk.toLowerCase();
    if (lc === 'critical') {
        return { active: 4, tone: 'bg-rose-500' };
    }
    if (lc === 'high') {
        return { active: 3, tone: 'bg-orange-500' };
    }
    if (lc === 'medium') {
        return { active: 2, tone: 'bg-amber-500' };
    }
    if (lc === 'low') {
        return { active: 1, tone: 'bg-sky-500' };
    }
    return { active: 0, tone: 'bg-muted' };
};

const isCve = (id: string): boolean => /^CVE-/i.test(id);
</script>

<template>
    <article class="rounded-2xl border bg-card">
        <header class="flex flex-wrap items-center justify-between gap-3 border-b px-5 py-4">
            <div>
                <h3 class="text-sm font-semibold tracking-tight text-foreground">Security Vulnerabilities</h3>
                <p class="text-xs text-muted-foreground">CVEs and findings, sorted by risk</p>
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

        <ul v-if="cves.length > 0" class="divide-y">
            <li v-for="cve in pagedCves" :key="cve.id">
                <button
                    type="button"
                    class="flex w-full items-center justify-between gap-3 px-5 py-3 text-left transition-colors hover:bg-muted/40"
                    :class="{ 'bg-muted/30': expandedId === cve.id }"
                    @click="toggleAccordion(cve.id)"
                >
                    <span class="flex items-center gap-2 min-w-0">
                        <component
                            :is="expandedId === cve.id ? ChevronDown : ChevronRight"
                            class="size-4 shrink-0 text-muted-foreground"
                        />
                        <span class="truncate text-sm font-semibold text-foreground">{{ cve.id }}</span>
                    </span>
                    <span class="flex shrink-0 items-center gap-2">
                        <span class="flex items-center gap-0.5">
                            <span
                                v-for="i in 4"
                                :key="i"
                                class="h-3.5 w-1 rounded-full"
                                :class="i <= riskDots(cve.risk).active ? riskDots(cve.risk).tone : 'bg-muted'"
                            />
                        </span>
                        <span class="text-xs text-muted-foreground">{{ cve.risk }}</span>
                    </span>
                </button>
                <div v-if="expandedId === cve.id" class="space-y-3 border-t px-12 py-4">
                    <p class="text-sm text-foreground">{{ cve.title }}</p>
                    <dl class="grid grid-cols-1 gap-y-1 text-xs text-muted-foreground sm:grid-cols-2 sm:gap-x-6">
                        <div v-if="cve.score !== null" class="flex justify-between sm:block">
                            <dt class="font-medium text-foreground">Score</dt>
                            <dd>{{ cve.score }}</dd>
                        </div>
                        <div v-if="cve.published_date" class="flex justify-between sm:block">
                            <dt class="font-medium text-foreground">Published</dt>
                            <dd>{{ cve.published_date }}</dd>
                        </div>
                        <div v-if="cve.affected_targets" class="flex justify-between sm:block">
                            <dt class="font-medium text-foreground">Affected targets</dt>
                            <dd>{{ cve.affected_targets }}</dd>
                        </div>
                        <div v-if="cve.num_affected_targets !== null" class="flex justify-between sm:block">
                            <dt class="font-medium text-foreground">Number of targets</dt>
                            <dd>{{ cve.num_affected_targets }}</dd>
                        </div>
                    </dl>
                    <a
                        v-if="isCve(cve.id)"
                        :href="`https://nvd.nist.gov/vuln/detail/${cve.id}`"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex items-center gap-1.5 rounded-md border px-2.5 py-1 text-xs font-medium text-foreground hover:bg-muted"
                    >
                        View on NVD
                        <ExternalLink class="size-3" />
                    </a>
                </div>
            </li>
        </ul>

        <div v-else class="px-5 py-10 text-center text-sm text-muted-foreground">
            No vulnerabilities match this filter.
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
