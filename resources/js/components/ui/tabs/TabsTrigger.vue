<script setup lang="ts">
import type { HTMLAttributes } from "vue";
import { TabsTrigger, type TabsTriggerProps } from "reka-ui";
import { cn } from "@/lib/utils";

const props = defineProps<TabsTriggerProps & { class?: HTMLAttributes["class"] }>();
</script>

<template>
    <TabsTrigger
        v-bind="props"
        :class="cn(
            'relative -mb-px inline-flex items-center justify-center gap-1.5 border-b-2 border-transparent px-3 pb-2.5 pt-1 text-sm font-medium text-muted-foreground whitespace-nowrap transition-colors',
            'hover:text-foreground focus-visible:outline-none focus-visible:ring-[3px] focus-visible:ring-ring/50 disabled:pointer-events-none disabled:opacity-50',
            'data-[state=active]:border-primary data-[state=active]:text-foreground',
            props.class,
        )"
    >
        <slot />
    </TabsTrigger>
</template>
