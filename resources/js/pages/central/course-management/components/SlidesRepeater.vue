<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Field, FieldLabel } from "@/components/ui/field";
import RichTextEditor from "@/components/RichTextEditor.vue";
import { Plus, Trash2 } from "lucide-vue-next";

type Slide = { title: string; description: string };

const model = defineModel<Slide[]>({ required: true });

const addSlide = (): void => {
    model.value = [...model.value, { title: "", description: "" }];
};

const removeSlide = (index: number): void => {
    model.value = model.value.filter((_, i) => i !== index);
};
</script>

<template>
    <div class="space-y-4">
        <div
            v-for="(slide, index) in model"
            :key="index"
            class="rounded-md border border-border bg-card p-4 space-y-3"
        >
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium">Slide {{ index + 1 }}</p>
                <Button
                    type="button"
                    variant="ghost"
                    size="sm"
                    class="text-destructive hover:text-destructive"
                    @click="removeSlide(index)"
                >
                    <Trash2 class="size-4" />
                </Button>
            </div>

            <Field>
                <FieldLabel :for="`slide-title-${index}`">Title</FieldLabel>
                <Input :id="`slide-title-${index}`" v-model="slide.title" />
            </Field>

            <Field>
                <FieldLabel>Description</FieldLabel>
                <RichTextEditor v-model="slide.description" />
            </Field>
        </div>

        <Button type="button" variant="outline" size="sm" @click="addSlide">
            <Plus class="size-4" />
            Add Slide
        </Button>
    </div>
</template>
