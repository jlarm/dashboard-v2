<script setup lang="ts">
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Field, FieldError, FieldLabel } from "@/components/ui/field";
import { Loader2 } from "lucide-vue-next";
import SlidesRepeater from "@/pages/central/course-management/components/SlidesRepeater.vue";
import courseManagementRoutes from "@/routes/course-management";

type Slide = { title: string; description: string };

const props = defineProps<{
    slug: string;
    name: string;
    videoId: string | null;
    slides: Slide[];
}>();

const form = useForm({
    name: props.name,
    video_id: props.videoId ?? "",
    slides: props.slides.map((slide) => ({
        title: slide.title ?? "",
        description: slide.description ?? "",
    })),
});

const slides = ref<Slide[]>(form.slides);

const submit = (): void => {
    form.slides = slides.value;
    form.patch(courseManagementRoutes.update(props.slug).url, {
        preserveScroll: true,
    });
};
</script>

<template>
    <form class="space-y-6" @submit.prevent="submit">
        <Field>
            <FieldLabel for="name">Name *</FieldLabel>
            <Input id="name" v-model="form.name" />
            <FieldError v-if="form.errors.name">{{ form.errors.name }}</FieldError>
        </Field>

        <Field>
            <FieldLabel for="video_id">Video ID</FieldLabel>
            <Input id="video_id" v-model="form.video_id" />
            <FieldError v-if="form.errors.video_id">{{ form.errors.video_id }}</FieldError>
        </Field>

        <div>
            <p class="text-sm font-medium mb-3">Slides *</p>
            <SlidesRepeater v-model="slides" />
            <FieldError v-if="form.errors.slides">{{ form.errors.slides }}</FieldError>
        </div>

        <div class="flex justify-end">
            <Button type="submit" :disabled="form.processing">
                <Loader2 v-if="form.processing" class="animate-spin" />
                Save Slides
            </Button>
        </div>
    </form>
</template>
