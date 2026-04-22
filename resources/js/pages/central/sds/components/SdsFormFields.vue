<script setup lang="ts">
import { ref, watch } from "vue";
import { Field, FieldError, FieldLabel } from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import { FileUpload } from "@/components/ui/file-upload";
import KeywordsRepeater from "@/pages/central/violation-statements/components/KeywordsRepeater.vue";

type SdsFormValues = {
    name: string;
    manufacturer: string;
    keywords: string[];
    file_name: string | null;
};

const props = defineProps<{
    initial: SdsFormValues;
    errors?: Record<string, string>;
    requireFile?: boolean;
}>();

const keywords = ref<string[]>([...props.initial.keywords]);

watch(
    () => props.initial.keywords,
    (next) => { keywords.value = [...next]; },
);
</script>

<template>
    <div class="space-y-5">
        <Field>
            <FieldLabel for="name">Name *</FieldLabel>
            <Input id="name" name="name" :default-value="initial.name" />
            <FieldError v-if="errors?.name">{{ errors.name }}</FieldError>
        </Field>

        <Field>
            <FieldLabel for="manufacturer">Manufacturer</FieldLabel>
            <Input id="manufacturer" name="manufacturer" :default-value="initial.manufacturer" />
            <FieldError v-if="errors?.manufacturer">{{ errors.manufacturer }}</FieldError>
        </Field>

        <Field>
            <FieldLabel>Keywords</FieldLabel>
            <KeywordsRepeater v-model="keywords" />
            <FieldError v-if="errors?.keywords">{{ errors.keywords }}</FieldError>
        </Field>

        <Field>
            <FieldLabel>{{ requireFile ? "PDF File *" : "Replace PDF" }}</FieldLabel>
            <p v-if="!requireFile && initial.file_name" class="text-xs text-muted-foreground">
                Current file: <span class="font-mono">{{ initial.file_name }}</span>
            </p>
            <FileUpload name="file" accept=".pdf" hint="PDF only — up to 5 MB" />
            <FieldError v-if="errors?.file">{{ errors.file }}</FieldError>
        </Field>
    </div>
</template>
