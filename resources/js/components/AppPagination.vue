<script setup lang="ts" generic="T">
import { Link } from "@inertiajs/vue3";
import {
    ChevronLeftIcon,
    ChevronRightIcon,
    ChevronsLeft,
    ChevronsRight,
} from "lucide-vue-next";
import { buttonVariants } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import type { PaginatedResponse } from "@/types/paginator";

type NavKey = "first" | "prev" | "next" | "last";

const props = withDefaults(
    defineProps<{
        pagination: PaginatedResponse<T>;
        preserveScroll?: boolean;
        preserveState?: boolean;
        only?: string[];
        class?: string;
    }>(),
    {
        preserveScroll: true,
        preserveState: true,
    },
);

const controls: { key: NavKey; label: string }[] = [
    { key: "first", label: "First page" },
    { key: "prev", label: "Previous page" },
    { key: "next", label: "Next page" },
    { key: "last", label: "Last page" },
];

const linkClass = cn(
    buttonVariants({ variant: "outline", size: "icon" }),
    "rounded-md",
);
const disabledClass = cn(linkClass, "pointer-events-none opacity-50");
</script>

<template>
    <div
        v-if="pagination.meta.total > 0"
        :class="
            cn(
                'flex flex-col gap-3 px-3 sm:flex-row sm:items-center sm:justify-between',
                props.class,
            )
        "
    >
        <p class="text-sm text-muted-foreground">
            <template v-if="pagination.meta.from !== null && pagination.meta.to !== null">
                Showing {{ pagination.meta.from }} to {{ pagination.meta.to }} of
                {{ pagination.meta.total }} results
            </template>
            <template v-else>
                Showing {{ pagination.meta.total }} results
            </template>
        </p>

        <nav
            v-if="pagination.meta.last_page > 1"
            aria-label="Pagination"
            class="flex items-center gap-1"
        >
            <template v-for="control in controls" :key="control.key">
                <Link
                    v-if="pagination.links[control.key]"
                    :href="pagination.links[control.key] as string"
                    :preserve-scroll="preserveScroll"
                    :preserve-state="preserveState"
                    :only="only"
                    :aria-label="control.label"
                    :class="linkClass"
                >
                    <ChevronsLeft v-if="control.key === 'first'" class="size-4" />
                    <ChevronLeftIcon v-else-if="control.key === 'prev'" class="size-4" />
                    <ChevronRightIcon v-else-if="control.key === 'next'" class="size-4" />
                    <ChevronsRight v-else class="size-4" />
                    <span class="sr-only">{{ control.label }}</span>
                </Link>
                <span
                    v-else
                    :aria-label="control.label"
                    aria-disabled="true"
                    :class="disabledClass"
                >
                    <ChevronsLeft v-if="control.key === 'first'" class="size-4" />
                    <ChevronLeftIcon v-else-if="control.key === 'prev'" class="size-4" />
                    <ChevronRightIcon v-else-if="control.key === 'next'" class="size-4" />
                    <ChevronsRight v-else class="size-4" />
                    <span class="sr-only">{{ control.label }}</span>
                </span>
            </template>
        </nav>
    </div>
</template>
