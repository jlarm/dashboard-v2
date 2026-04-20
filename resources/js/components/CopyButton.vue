<script setup lang="ts">
import {ref} from "vue";
import {Button} from "@/components/ui/button";
import {Copy, Check} from "lucide-vue-next";

const props = defineProps<{
    textToCopy: string;
}>()

const isCopied = ref(false)

const copyText = async (): Promise<void> => {
    try {
        await navigator.clipboard.writeText(props.textToCopy)
        isCopied.value = true

        setTimeout(() => {
            isCopied.value = false
        }, 2000)
    } catch (err: unknown) {
        console.error("Failed to copy text: ", err)
    }
}
</script>

<template>
    <Button
        type="button"
        variant="ghost"
        size="icon-sm"
        class="size-6 text-zinc-500 hover:bg-zinc-200 hover:text-zinc-700 cursor-pointer dark:text-zinc-400 dark:hover:bg-zinc-700 dark:hover:text-zinc-200"
        :title="isCopied ? 'Copied' : 'Copy ID'"
        :aria-label="isCopied ? 'Copied' : 'Copy ID'"
        @click="copyText"
        :disabled="isCopied"
    >
        <Copy v-if="!isCopied" class="size-3.5" />
        <Check v-else class="size-3.5" />
    </Button>
</template>
