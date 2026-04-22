<script setup lang="ts" generic="TValue extends string | number">
import { computed, ref } from "vue";
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Checkbox } from "@/components/ui/checkbox";
import { Badge } from "@/components/ui/badge";
import { Check, ChevronDown, X } from "lucide-vue-next";
import { cn } from "@/lib/utils";

type Option = { value: TValue; label: string };

const props = withDefaults(
    defineProps<{
        options: Option[];
        placeholder?: string;
        searchPlaceholder?: string;
        emptyText?: string;
        showChips?: boolean;
    }>(),
    {
        placeholder: "Select...",
        searchPlaceholder: "Search...",
        emptyText: "No results.",
        showChips: true,
    },
);

const model = defineModel<TValue[]>({ required: true });

const open = ref(false);
const search = ref("");

const optionsByValue = computed(() => {
    const map = new Map<TValue, Option>();
    for (const option of props.options) {
        map.set(option.value, option);
    }
    return map;
});

const filteredOptions = computed(() => {
    const term = search.value.trim().toLowerCase();
    if (!term) return props.options;
    return props.options.filter((o) => o.label.toLowerCase().includes(term));
});

const selectedOptions = computed(() =>
    model.value
        .map((value) => optionsByValue.value.get(value))
        .filter((o): o is Option => o !== undefined),
);

const toggle = (value: TValue): void => {
    const idx = model.value.indexOf(value);
    if (idx === -1) {
        model.value = [...model.value, value];
    } else {
        model.value = model.value.filter((_, i) => i !== idx);
    }
};

const remove = (value: TValue): void => {
    model.value = model.value.filter((v) => v !== value);
};

const triggerLabel = computed(() => {
    if (model.value.length === 0) return props.placeholder;
    if (model.value.length === 1) return selectedOptions.value[0]?.label ?? props.placeholder;
    return `${model.value.length} selected`;
});
</script>

<template>
    <div class="space-y-2">
        <Popover v-model:open="open">
            <PopoverTrigger as-child>
                <Button
                    type="button"
                    variant="outline"
                    role="combobox"
                    :aria-expanded="open"
                    class="w-full justify-between font-normal"
                >
                    <span :class="cn('truncate', model.length === 0 && 'text-muted-foreground')">
                        {{ triggerLabel }}
                    </span>
                    <ChevronDown class="size-4 opacity-50" />
                </Button>
            </PopoverTrigger>
            <PopoverContent class="w-[var(--reka-popover-trigger-width)] p-0" align="start">
                <div class="p-2 border-b">
                    <Input
                        v-model="search"
                        :placeholder="searchPlaceholder"
                        class="h-8"
                    />
                </div>
                <div class="max-h-64 overflow-y-auto p-1">
                    <p v-if="filteredOptions.length === 0" class="px-2 py-4 text-center text-sm text-muted-foreground">
                        {{ emptyText }}
                    </p>
                    <label
                        v-for="option in filteredOptions"
                        :key="String(option.value)"
                        class="flex cursor-pointer items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground"
                    >
                        <Checkbox
                            :model-value="model.includes(option.value)"
                            @update:model-value="() => toggle(option.value)"
                        />
                        <span class="flex-1 truncate">{{ option.label }}</span>
                        <Check v-if="model.includes(option.value)" class="size-3.5 text-muted-foreground" />
                    </label>
                </div>
            </PopoverContent>
        </Popover>

        <div v-if="showChips && selectedOptions.length > 0" class="flex flex-wrap gap-1.5">
            <Badge
                v-for="option in selectedOptions"
                :key="String(option.value)"
                variant="secondary"
                class="gap-1 pr-1"
            >
                {{ option.label }}
                <button
                    type="button"
                    class="rounded-sm hover:bg-muted-foreground/20 p-0.5"
                    @click="remove(option.value)"
                >
                    <X class="size-3" />
                </button>
            </Badge>
        </div>
    </div>
</template>
