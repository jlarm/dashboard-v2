<script setup lang="ts">
import { ref, watch } from "vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { X } from "lucide-vue-next";

const props = defineProps<{
    modelValue: string[];
    disabled?: boolean;
}>();

const emit = defineEmits<{
    (e: "update:modelValue", value: string[]): void;
}>();

const keywords = ref<string[]>([...props.modelValue]);
const draft = ref("");

watch(
    () => props.modelValue,
    (next) => {
        keywords.value = [...next];
    },
);

const sync = (): void => {
    emit("update:modelValue", [...keywords.value]);
};

const addKeyword = (): void => {
    const value = draft.value.trim();

    if (value === "" || keywords.value.includes(value)) {
        draft.value = "";
        return;
    }

    keywords.value.push(value);
    draft.value = "";
    sync();
};

const removeKeyword = (index: number): void => {
    keywords.value.splice(index, 1);
    sync();
};

const handleKeydown = (event: KeyboardEvent): void => {
    if (event.key === "Enter" || event.key === ",") {
        event.preventDefault();
        addKeyword();
    }
};
</script>

<template>
    <div class="space-y-2">
        <input
            v-for="keyword in keywords"
            :key="keyword"
            type="hidden"
            name="keywords[]"
            :value="keyword"
        />

        <div class="flex gap-2">
            <Input
                v-model="draft"
                :disabled="disabled"
                placeholder="Add keyword and press Enter"
                @keydown="handleKeydown"
            />
            <Button type="button" variant="outline" :disabled="disabled || draft.trim() === ''" @click="addKeyword">
                Add
            </Button>
        </div>

        <div v-if="keywords.length > 0" class="flex flex-wrap gap-2">
            <span
                v-for="(keyword, index) in keywords"
                :key="keyword"
                class="inline-flex items-center gap-1 rounded-full bg-muted px-3 py-1 text-xs"
            >
                {{ keyword }}
                <button
                    v-if="!disabled"
                    type="button"
                    class="text-muted-foreground hover:text-foreground"
                    @click="removeKeyword(index)"
                >
                    <X class="h-3 w-3" />
                </button>
            </span>
        </div>
    </div>
</template>
