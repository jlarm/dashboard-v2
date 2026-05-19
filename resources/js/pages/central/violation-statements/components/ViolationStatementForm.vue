<script setup lang="ts">
import { ref, watch } from "vue";
import { Field, FieldError, FieldLabel } from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import { Checkbox } from "@/components/ui/checkbox";
import KeywordsRepeater from "@/pages/central/violation-statements/components/KeywordsRepeater.vue";
import { Button } from "@/components/ui/button";

type CategoryOption = { value: string; label: string };

type ViolationStatementFormValues = {
    statement: string;
    weight: number | string;
    categories: string[];
    keywords: string[];
    reference_image_url: string | null;
};

const props = defineProps<{
    initial: ViolationStatementFormValues;
    categories: CategoryOption[];
    errors?: Record<string, string>;
    disabled?: boolean;
    allowImageRemoval?: boolean;
}>();

const selectedCategories = ref<string[]>([...props.initial.categories]);
const keywords = ref<string[]>([...props.initial.keywords]);
const removeImage = ref(false);

watch(
    () => props.initial.categories,
    (next) => {
        selectedCategories.value = [...next];
    },
);

watch(
    () => props.initial.keywords,
    (next) => {
        keywords.value = [...next];
    },
);

const toggleCategory = (value: string): void => {
    const idx = selectedCategories.value.indexOf(value);
    if (idx === -1) {
        selectedCategories.value.push(value);
    } else {
        selectedCategories.value.splice(idx, 1);
    }
};
</script>

<template>
    <div class="space-y-6">
        <input
            v-for="category in selectedCategories"
            :key="category"
            type="hidden"
            name="categories[]"
            :value="category"
        />

        <Field>
            <FieldLabel for="statement">Statement *</FieldLabel>
            <Input
                id="statement"
                name="statement"
                :default-value="initial.statement"
                :disabled="disabled"
            />
            <FieldError v-if="errors?.statement">{{ errors.statement }}</FieldError>
        </Field>

        <Field>
            <FieldLabel for="weight">Weight *</FieldLabel>
            <Input
                id="weight"
                name="weight"
                type="number"
                min="1"
                max="10"
                :default-value="initial.weight"
                :disabled="disabled"
            />
            <FieldError v-if="errors?.weight">{{ errors.weight }}</FieldError>
        </Field>

        <div>
            <p class="text-sm font-medium mb-3">Categories *</p>
            <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
                <label
                    v-for="category in categories"
                    :key="category.value"
                    class="flex items-center gap-2"
                >
                    <Checkbox
                        :model-value="selectedCategories.includes(category.value)"
                        :disabled="disabled"
                        @update:model-value="() => toggleCategory(category.value)"
                    />
                    <span class="text-sm">{{ category.label }}</span>
                </label>
            </div>
            <FieldError v-if="errors?.categories">{{ errors.categories }}</FieldError>
        </div>

        <Field>
            <FieldLabel>Keywords</FieldLabel>
            <KeywordsRepeater v-model="keywords" :disabled="disabled" />
            <FieldError v-if="errors?.keywords">{{ errors.keywords }}</FieldError>
        </Field>

        <Field>
            <FieldLabel for="image">Reference Image</FieldLabel>
            <div v-if="initial.reference_image_url && !removeImage" class="mb-2 space-y-2">
                <img
                    :src="initial.reference_image_url"
                    alt="Reference"
                    class="h-32 w-32 rounded border object-cover"
                />
                <Button
                    v-if="allowImageRemoval"
                    type="button"
                    size="sm"
                    variant="outline"
                    :disabled="disabled"
                    @click="removeImage = true"
                >
                    Remove image
                </Button>
            </div>
            <input v-if="removeImage" type="hidden" name="remove_image" value="1" />
            <Input
                v-if="!initial.reference_image_url || removeImage"
                id="image"
                name="image"
                type="file"
                accept="image/*"
                :disabled="disabled"
            />
            <FieldError v-if="errors?.image">{{ errors.image }}</FieldError>
        </Field>
    </div>
</template>
