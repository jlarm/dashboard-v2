<script setup lang="ts">
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import scan from '@/routes/dealer/scan';
import { ChevronDown, ChevronRight, ShieldAlert } from 'lucide-vue-next';
import { ref } from 'vue';
import FindingDetailDialog, { type Finding, type Instance } from '@/pages/tenant/scans/components/FindingDetailDialog.vue';

type OpenPort = {
    port_number: string;
    port_description: string | null;
    risk_level: string;
};

type Counts = {
    critical: number;
    high: number;
    medium: number;
    low: number;
    total: number;
};

type Asset = {
    name: string;
    ip_address: string | null;
    open_ports: OpenPort[];
    findings: Finding[];
    counts: Counts;
    tone: 'critical' | 'high' | 'medium' | 'low' | 'clean';
};

const props = defineProps<{
    lastScanFinished: string | null;
    assets: Asset[];
}>();

const expandedKey = ref<string | null>(null);
const dialogOpen = ref(false);
const dialogFinding = ref<Finding | null>(null);
const enriching = ref(false);
const enrichedFor = ref<string | null>(null);
const dialogAssetIp = ref<string | null>(null);

const toneStyles = {
    critical: { tile: 'bg-rose-100 text-rose-700 dark:bg-rose-500/15 dark:text-rose-400', border: 'border-rose-300', label: 'Critical', dotColor: 'bg-rose-500', activeDots: 4 },
    high: { tile: 'bg-orange-100 text-orange-700 dark:bg-orange-500/15 dark:text-orange-400', border: 'border-orange-300', label: 'High', dotColor: 'bg-orange-500', activeDots: 3 },
    medium: { tile: 'bg-amber-100 text-amber-700 dark:bg-amber-500/15 dark:text-amber-400', border: 'border-amber-300', label: 'Medium', dotColor: 'bg-amber-500', activeDots: 2 },
    low: { tile: 'bg-sky-100 text-sky-700 dark:bg-sky-500/15 dark:text-sky-400', border: 'border-sky-300', label: 'Low', dotColor: 'bg-sky-500', activeDots: 1 },
    clean: { tile: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-400', border: 'border-emerald-300', label: 'Clean', dotColor: 'bg-emerald-500', activeDots: 1 },
} as const;

const portToneClass = (risk: string): string => {
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
    return 'bg-muted text-foreground border-border';
};

const findingBadgeClass = (risk: string): string => {
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
        return 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/30';
    }
    return 'bg-sky-50 text-sky-700 border-sky-200 dark:bg-sky-500/10 dark:text-sky-400 dark:border-sky-500/30';
};

const assetKey = (asset: Asset, index: number): string => asset.ip_address ?? `asset-${index}`;

const toggle = (key: string): void => {
    expandedKey.value = expandedKey.value === key ? null : key;
};

const findingNeedsEnrichment = (finding: Finding): boolean =>
    !finding.description && !finding.solution && finding.references.length === 0 && finding.instances.length === 0;

const enrichmentKey = (assetIp: string, findingName: string): string => `${assetIp}::${findingName}`;

const openFinding = async (asset: Asset, finding: Finding): Promise<void> => {
    dialogFinding.value = { ...finding };
    dialogAssetIp.value = asset.ip_address;
    dialogOpen.value = true;

    if (!asset.ip_address || !findingNeedsEnrichment(finding)) {
        return;
    }

    const key = enrichmentKey(asset.ip_address, finding.name);
    if (enrichedFor.value === key) {
        return;
    }

    enriching.value = true;
    try {
        const url = scan.externalFinding.url({
            query: { asset_ip: asset.ip_address, finding_name: finding.name },
        });
        const response = await fetch(url, { headers: { Accept: 'application/json' } });
        if (!response.ok) {
            return;
        }
        const payload = (await response.json()) as { finding: Finding | null };
        if (payload.finding && dialogFinding.value && dialogFinding.value.name === finding.name) {
            dialogFinding.value = {
                ...dialogFinding.value,
                description: payload.finding.description || dialogFinding.value.description,
                solution: payload.finding.solution || dialogFinding.value.solution,
                references: payload.finding.references.length > 0 ? payload.finding.references : dialogFinding.value.references,
                instances: payload.finding.instances.length > 0 ? payload.finding.instances : dialogFinding.value.instances,
            };
            enrichedFor.value = key;
        }
    } finally {
        enriching.value = false;
    }
};
</script>

<template>
    <article class="rounded-2xl border bg-card">
        <header class="flex flex-wrap items-start justify-between gap-3 border-b px-5 py-4">
            <div class="flex items-start gap-2">
                <ShieldAlert class="mt-0.5 size-5 text-rose-600 dark:text-rose-400" />
                <div>
                    <h3 class="text-sm font-semibold tracking-tight text-foreground">External IP Attack Surface</h3>
                    <p class="text-xs text-muted-foreground">External scan assets and their vulnerabilities</p>
                </div>
            </div>
            <div v-if="assets.length > 0" class="text-right text-xs text-muted-foreground">
                <p v-if="lastScanFinished">Last scanned: {{ lastScanFinished }}</p>
                <p class="mt-0.5 font-medium text-foreground">
                    {{ assets.length }} external {{ assets.length === 1 ? 'asset' : 'assets' }}
                </p>
            </div>
        </header>

        <div v-if="assets.length === 0" class="border-2 border-dashed bg-muted/20 px-5 py-12 text-center">
            <h4 class="text-sm font-semibold text-foreground">No external scan data found</h4>
            <p class="mt-1 text-xs text-muted-foreground">
                External scans help identify your internet-facing attack surface.
            </p>
        </div>

        <ul v-else class="divide-y">
            <li v-for="(asset, index) in assets" :key="assetKey(asset, index)">
                <button
                    type="button"
                    class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left transition-colors hover:bg-muted/40"
                    :class="{ 'bg-muted/30': expandedKey === assetKey(asset, index) }"
                    @click="toggle(assetKey(asset, index))"
                >
                    <span class="flex min-w-0 items-center gap-3">
                        <component
                            :is="expandedKey === assetKey(asset, index) ? ChevronDown : ChevronRight"
                            class="size-4 shrink-0 text-muted-foreground"
                        />
                        <span
                            class="grid size-9 shrink-0 place-items-center rounded-lg"
                            :class="toneStyles[asset.tone].tile"
                        >
                            <ShieldAlert class="size-4" />
                        </span>
                        <span class="min-w-0">
                            <span class="block truncate text-sm font-semibold text-foreground">
                                {{ asset.name }}
                            </span>
                            <span class="mt-0.5 flex items-center gap-2 text-xs text-muted-foreground">
                                <span>{{ asset.ip_address ?? '—' }}</span>
                                <template v-if="asset.open_ports.length > 0">
                                    <span class="text-muted-foreground/60">·</span>
                                    <span>{{ asset.open_ports.length }} open {{ asset.open_ports.length === 1 ? 'port' : 'ports' }}</span>
                                </template>
                            </span>
                        </span>
                    </span>
                    <span class="flex shrink-0 items-center gap-3">
                        <span
                            v-if="asset.counts.total > 0"
                            class="inline-flex items-center rounded-md border px-2 py-0.5 text-xs font-semibold"
                            :class="findingBadgeClass(toneStyles[asset.tone].label)"
                        >
                            {{ asset.counts.total }} {{ asset.counts.total === 1 ? 'vulnerability' : 'vulnerabilities' }}
                        </span>
                        <span class="flex items-center gap-2">
                            <span class="flex items-center gap-0.5">
                                <span
                                    v-for="i in 4"
                                    :key="i"
                                    class="h-3.5 w-1 rounded-full"
                                    :class="i <= toneStyles[asset.tone].activeDots ? toneStyles[asset.tone].dotColor : 'bg-muted'"
                                />
                            </span>
                            <span class="text-xs text-muted-foreground">{{ toneStyles[asset.tone].label }}</span>
                        </span>
                    </span>
                </button>

                <div v-if="expandedKey === assetKey(asset, index)" class="space-y-5 border-t bg-muted/10 px-5 py-4">
                    <section v-if="asset.open_ports.length > 0">
                        <h4 class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">
                            Open Ports ({{ asset.open_ports.length }})
                        </h4>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span
                                v-for="port in asset.open_ports"
                                :key="`${asset.ip_address}-${port.port_number}`"
                                class="inline-flex items-center gap-2 rounded-md border px-3 py-1.5 text-xs font-medium"
                                :class="portToneClass(port.risk_level)"
                            >
                                <span class="font-bold">{{ port.port_number }}</span>
                                <span v-if="port.port_description">{{ port.port_description }}</span>
                                <span class="rounded bg-white/40 px-1.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide dark:bg-black/20">
                                    {{ port.risk_level }}
                                </span>
                            </span>
                        </div>
                    </section>

                    <section v-if="asset.findings.length > 0">
                        <h4 class="text-xs font-semibold uppercase tracking-wide text-muted-foreground">
                            Vulnerability Findings
                        </h4>
                        <div class="mt-2 overflow-x-auto rounded-md border">
                            <Table>
                                <TableHeader class="bg-muted/40">
                                    <TableRow>
                                        <TableHead>Flaw</TableHead>
                                        <TableHead>Risk Level</TableHead>
                                        <TableHead class="text-right">Affected URLs</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow
                                        v-for="(finding, fi) in asset.findings"
                                        :key="`${asset.ip_address}-${fi}`"
                                        class="cursor-pointer hover:bg-muted/40"
                                        @click="openFinding(asset, finding)"
                                    >
                                        <TableCell class="font-medium text-foreground">
                                            {{ finding.name }}
                                        </TableCell>
                                        <TableCell>
                                            <span
                                                class="inline-flex items-center rounded-md border px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide"
                                                :class="findingBadgeClass(finding.risk_level)"
                                            >
                                                {{ finding.risk_level }}
                                            </span>
                                        </TableCell>
                                        <TableCell class="text-right tabular-nums text-muted-foreground">
                                            {{ finding.affected_urls }}
                                        </TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </section>

                    <p v-else-if="asset.findings.length === 0 && asset.open_ports.length === 0" class="text-sm text-muted-foreground">
                        No vulnerabilities detected for this asset.
                    </p>
                </div>
            </li>
        </ul>

        <FindingDetailDialog
            v-model:open="dialogOpen"
            :finding="dialogFinding"
            :enriching="enriching"
        />
    </article>
</template>
