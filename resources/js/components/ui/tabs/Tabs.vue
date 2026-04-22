<script setup lang="ts">
import type { HTMLAttributes } from "vue";
import { TabsRoot, type TabsRootProps, useForwardPropsEmits } from "reka-ui";
import { cn } from "@/lib/utils";

const props = defineProps<TabsRootProps & { class?: HTMLAttributes["class"] }>();
const emits = defineEmits<{
    (e: "update:modelValue", payload: string | number): void;
}>();

const forwarded = useForwardPropsEmits(props, emits);
</script>

<template>
    <TabsRoot
        v-bind="forwarded"
        :class="cn('flex flex-col gap-2', props.class)"
    >
        <slot />
    </TabsRoot>
</template>
