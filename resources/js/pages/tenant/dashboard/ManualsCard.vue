<script setup lang="ts">
import { index as cmsIndex } from '@/routes/dealer/manual/cms';
import { index as ispIndex } from '@/routes/dealer/manual/isp';
import { index as oshaIndex } from '@/routes/dealer/manual/osha';
import { index as redFlagIndex } from '@/routes/dealer/manual/red-flag';
import { Link } from '@inertiajs/vue3';
import { Flag, Globe, HandHelping, ShieldCheck } from 'lucide-vue-next';
import { type Component, computed } from 'vue';
import { useNullablePageProp } from './props';
import type { ManualsSummary } from './types';

const manuals = useNullablePageProp<ManualsSummary>('manuals_summary');

type ManualKey = 'isp' | 'osha' | 'red_flag' | 'cms';

type ManualTile = {
    key: ManualKey;
    label: string;
    icon: Component;
    href: string;
};

const tiles = computed<ManualTile[]>(() => [
    { key: 'isp', label: 'ISP', icon: Globe, href: ispIndex.url() },
    { key: 'osha', label: 'OSHA', icon: HandHelping, href: oshaIndex.url() },
    { key: 'red_flag', label: 'Red Flag', icon: Flag, href: redFlagIndex.url() },
    { key: 'cms', label: 'CMS', icon: ShieldCheck, href: cmsIndex.url() },
]);
</script>

<template>
    <article v-if="manuals !== null" class="overflow-hidden rounded-2xl border bg-card">
        <header class="bg-muted/40 px-5 py-3">
            <h3 class="text-sm font-medium text-foreground">Manuals</h3>
        </header>

        <div class="grid gap-3 px-5 py-5">
            <Link
                v-for="tile in tiles"
                :key="tile.key"
                :href="tile.href"
                class="block rounded-xl border bg-muted/40 p-2 transition hover:bg-muted/60"
            >
                <header class="flex items-center justify-between px-2 py-1.5">
                    <h4 class="text-[11px] font-medium tracking-[0.14em] text-muted-foreground uppercase">
                        {{ tile.label }}
                    </h4>
                    <component
                        :is="tile.icon"
                        class="size-4 text-muted-foreground"
                        aria-hidden="true"
                    />
                </header>
                <div class="flex items-center justify-between rounded-lg border bg-card px-4 py-3">
                    <span
                        class="text-sm font-semibold"
                        :class="manuals[tile.key] ? 'text-emerald-600 dark:text-emerald-400' : 'text-muted-foreground'"
                    >
                        {{ manuals[tile.key] ? 'Active' : 'Inactive' }}
                    </span>
                    <span
                        class="text-muted-foreground"
                        aria-hidden="true"
                    >
                        ›
                    </span>
                </div>
            </Link>
        </div>
    </article>
</template>
