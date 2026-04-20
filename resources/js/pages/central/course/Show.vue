<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { Button } from "@/components/ui/button";
import courses from "@/routes/courses";
import { BreadcrumbItem } from "@/types";
import { router } from "@inertiajs/vue3";
import { computed, ref } from "vue";

type Course = {
    id: number;
    name: string;
    slug: string;
};

type Slide = {
    title?: string | null;
    description?: string | null;
};

const props = defineProps<{
    course: Course;
    player_embed_url: string | null;
    video_completed: boolean;
    quiz_link: string;
    slides: Slide[];
}>();

const showSlidesFallback = ref(false);
const activeSlide = ref(0);

const usingSlides = computed((): boolean => {
    return props.slides.length > 0 && (showSlidesFallback.value || !props.player_embed_url);
});

const currentSlide = computed((): Slide | null => {
    return props.slides[activeSlide.value] ?? null;
});

const toTitleCase = (str: string): string =>
    str.toLowerCase().replace(/\b\w/g, (c) => c.toUpperCase());

const canTakeQuizFromSlides = computed((): boolean => {
    return usingSlides.value && activeSlide.value === props.slides.length - 1;
});

const markComplete = (): void => {
    router.post(courses.progress.store.url(props.course), {}, { preserveScroll: true });
};

const showSlides = (): void => {
    showSlidesFallback.value = true;
    activeSlide.value = 0;
};

const showVideo = (): void => {
    showSlidesFallback.value = false;
    activeSlide.value = 0;
};

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: "Courses",
        href: courses.index.url(),
    },
    {
        title: props.course.name,
        href: courses.show.url(props.course),
    }
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <div class="w-full px-6 py-6">
            <div class="mx-auto flex w-full max-w-6xl flex-col gap-6">
            <div class="flex flex-col gap-3">
                <h1 class="text-2xl font-semibold tracking-tight">{{ course.name }}</h1>
                <p class="text-sm text-muted-foreground">
                    <span v-if="video_completed">Video completed. Continue to the quiz when ready.</span>
                    <span v-else-if="player_embed_url">Finish the video before taking the quiz.</span>
                    <span v-else-if="slides.length > 0">Review the course slides, then continue to the quiz.</span>
                    <span v-else>No video or slide deck is available for this course.</span>
                </p>
            </div>

            <div
                v-if="player_embed_url && !showSlidesFallback"
                class="mx-auto w-full max-w-5xl overflow-hidden rounded-xl border bg-black"
            >
                <iframe
                    :src="player_embed_url"
                    :title="course.name"
                    allow="autoplay; fullscreen; picture-in-picture; encrypted-media"
                    allowfullscreen
                    webkitallowfullscreen
                    mozallowfullscreen
                    class="aspect-video w-full"
                />
            </div>

            <div v-else-if="usingSlides && currentSlide" class="flex flex-col gap-6 rounded-xl border p-6">
                <div class="flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-muted-foreground">
                            Slide {{ activeSlide + 1 }} of {{ slides.length }}
                        </p>

                        <div class="flex items-center gap-4">
                            <div class="h-2 w-32 overflow-hidden rounded-full bg-muted">
                                <div
                                    class="h-full bg-primary transition-all"
                                    :style="{ width: `${((activeSlide + 1) / slides.length) * 100}%` }"
                                />
                            </div>
                            <span class="text-sm text-muted-foreground">
                        {{ Math.round(((activeSlide + 1) / slides.length) * 100) }}%
                    </span>
                        </div>
                    </div>

                    <h2 class="font-semibold">
                        {{ toTitleCase(currentSlide.title || course.name) }}
                    </h2>
                </div>

                <div
                    class="prose max-w-none dark:prose-invert"
                    v-html="currentSlide.description || ''"
                />

                <div class="flex flex-wrap items-center justify-between gap-3">
                    <Button
                        type="button"
                        variant="outline"
                        :disabled="activeSlide === 0"
                        @click="activeSlide -= 1"
                    >
                        Previous
                    </Button>

                    <div class="flex flex-wrap items-center gap-3">
                        <Button
                            v-if="player_embed_url"
                            type="button"
                            variant="outline"
                            @click="showVideo"
                        >
                            View Video
                        </Button>

                        <Button
                            v-if="activeSlide < slides.length - 1"
                            type="button"
                            @click="activeSlide += 1"
                        >
                            Next
                        </Button>

                        <Button v-else as-child>
                            <a :href="quiz_link">Take the Quiz</a>
                        </Button>
                    </div>
                </div>
            </div>

            <div v-else class="rounded-xl border border-dashed p-8 text-sm text-muted-foreground">
                Course content is not available right now. Refresh the page or try again later.
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <Button
                    v-if="!video_completed && player_embed_url && !showSlidesFallback"
                    type="button"
                    @click="markComplete"
                >
                    Mark as Complete
                </Button>

                <Button
                    v-if="video_completed && !canTakeQuizFromSlides"
                    as-child
                >
                    <a :href="quiz_link">Take the Quiz</a>
                </Button>
            </div>
            </div>
        </div>
    </AppLayout>
</template>
