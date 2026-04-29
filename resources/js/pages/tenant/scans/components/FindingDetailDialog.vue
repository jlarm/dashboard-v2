<script setup lang="ts">
import { Dialog, DialogContent, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { computed } from 'vue';
import { ExternalLink, Loader2 } from 'lucide-vue-next';

export type Instance = {
    url: string;
    method: string;
    parameters: string;
    attack: string;
    evidence: string;
};

export type Finding = {
    name: string;
    risk_level: string;
    affected_urls: number;
    description: string;
    solution: string;
    references: string[];
    instances: Instance[];
};

const props = defineProps<{
    open: boolean;
    finding: Finding | null;
    enriching: boolean;
}>();

const emit = defineEmits<{
    'update:open': [value: boolean];
}>();

const isOpen = computed({
    get: () => props.open,
    set: (value) => emit('update:open', value),
});

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
        return 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/30';
    }
    return 'bg-sky-50 text-sky-700 border-sky-200 dark:bg-sky-500/10 dark:text-sky-400 dark:border-sky-500/30';
};

const isUrl = (value: string): boolean => {
    try {
        const parsed = new URL(value);
        return parsed.protocol === 'http:' || parsed.protocol === 'https:';
    } catch {
        return false;
    }
};
</script>

<template>
    <Dialog v-model:open="isOpen">
        <DialogContent class="max-h-[90vh] max-w-4xl overflow-y-auto">
            <DialogHeader>
                <DialogTitle>{{ finding?.name ?? 'Finding details' }}</DialogTitle>
                <span
                    v-if="finding"
                    class="mt-1 inline-flex w-fit items-center rounded-md border px-2 py-0.5 text-xs font-semibold"
                    :class="riskBadgeClass(finding.risk_level)"
                >
                    Risk Level: {{ finding.risk_level }}
                </span>
            </DialogHeader>

            <div v-if="enriching" class="flex items-center gap-2 rounded-md border bg-muted/30 px-4 py-3 text-sm text-muted-foreground">
                <Loader2 class="size-4 animate-spin" />
                Loading additional details…
            </div>

            <div v-if="finding" class="space-y-4">
                <section v-if="finding.description" class="rounded-xl border bg-muted/30 p-4">
                    <h4 class="text-sm font-semibold text-foreground">Description</h4>
                    <p class="mt-2 text-sm leading-relaxed whitespace-pre-line text-foreground/90">
                        {{ finding.description }}
                    </p>
                </section>

                <section v-if="finding.solution || finding.references.length > 0" class="rounded-xl border bg-card p-4">
                    <template v-if="finding.solution">
                        <h4 class="text-sm font-semibold text-foreground">Solution</h4>
                        <p class="mt-2 text-sm leading-relaxed whitespace-pre-line text-foreground/90">
                            {{ finding.solution }}
                        </p>
                    </template>

                    <template v-if="finding.references.length > 0">
                        <h5 class="mt-4 text-xs font-semibold uppercase tracking-wide text-muted-foreground">
                            Reference Links
                        </h5>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <template v-for="(reference, i) in finding.references" :key="`ref-${i}`">
                                <a
                                    v-if="isUrl(reference)"
                                    :href="reference"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex max-w-full items-center gap-1.5 rounded-md border border-sky-200 bg-sky-50 px-2.5 py-1 text-xs font-medium text-sky-700 hover:bg-sky-100 dark:border-sky-500/30 dark:bg-sky-500/10 dark:text-sky-400"
                                >
                                    <span class="truncate">{{ reference }}</span>
                                    <ExternalLink class="size-3 shrink-0" />
                                </a>
                                <span
                                    v-else
                                    class="inline-flex max-w-full items-center rounded-md border bg-muted/30 px-2.5 py-1 text-xs text-muted-foreground"
                                >
                                    <span class="truncate">{{ reference }}</span>
                                </span>
                            </template>
                        </div>
                    </template>
                </section>

                <section v-if="finding.instances.length > 0" class="overflow-x-auto rounded-xl border">
                    <Table>
                        <TableHeader class="bg-muted/40">
                            <TableRow>
                                <TableHead>URL</TableHead>
                                <TableHead>Method</TableHead>
                                <TableHead>Parameters</TableHead>
                                <TableHead>Attack</TableHead>
                                <TableHead>Evidence</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="(instance, i) in finding.instances" :key="`inst-${i}`">
                                <TableCell class="text-xs">{{ instance.url }}</TableCell>
                                <TableCell class="text-xs text-muted-foreground">{{ instance.method }}</TableCell>
                                <TableCell class="text-xs text-muted-foreground">{{ instance.parameters }}</TableCell>
                                <TableCell class="text-xs text-muted-foreground">{{ instance.attack }}</TableCell>
                                <TableCell class="text-xs text-muted-foreground">{{ instance.evidence }}</TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </section>

                <p
                    v-if="!finding.description && !finding.solution && finding.references.length === 0 && finding.instances.length === 0 && !enriching"
                    class="text-sm text-muted-foreground"
                >
                    No additional details are available for this finding.
                </p>
            </div>
        </DialogContent>
    </Dialog>
</template>
