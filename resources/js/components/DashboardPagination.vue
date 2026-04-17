<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import type { PaginationLink } from '@/types';

defineProps<{
    from: number | null;
    to: number | null;
    total: number;
    links: PaginationLink[];
}>();

const formatPageLabel = (value: string): string => {
    return value
        .replace(/&laquo;/g, '')
        .replace(/&raquo;/g, '')
        .replace(/<[^>]+>/g, '')
        .trim();
};
</script>

<template>
    <div
        v-if="total > 0"
        class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
    >
        <p class="text-sm text-muted-foreground">
            Showing {{ from ?? 0 }}-{{ to ?? 0 }} of
            {{ total }} logs
        </p>

        <div class="flex flex-wrap gap-2">
            <template v-for="link in links" :key="`${link.label}-${link.url}`">
                <Button
                    v-if="link.url === null"
                    variant="outline"
                    size="sm"
                    :disabled="true"
                >
                    {{ formatPageLabel(link.label) }}
                </Button>

                <Button
                    v-else
                    as-child
                    :variant="link.active ? 'default' : 'outline'"
                    size="sm"
                >
                    <Link :href="link.url" preserve-scroll>
                        {{ formatPageLabel(link.label) }}
                    </Link>
                </Button>
            </template>
        </div>
    </div>
</template>
