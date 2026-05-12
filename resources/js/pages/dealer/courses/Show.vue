<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import { ArrowRight, CheckCircle, PlayCircle } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { useVimeoPlayer } from '@/composables/useVimeoPlayer';
import courses from '@/routes/dealer/courses';
import type { BreadcrumbItem } from '@/types';

type VideoMeta = { player_embed_url: string; title: string };
type Slide = { title: string; description: string };

const props = defineProps<{
    course: { id: number; name: string; slug: string };
    video: VideoMeta | null;
    slides: Slide[] | null;
    quiz_url: string;
    video_completed: boolean;
    has_results: boolean;
    can_issue_dot_certificate: boolean;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Courses', href: courses.index.url() },
    { title: props.course.name, href: courses.show.url({ course: props.course.slug }) },
];

const iframeRef = ref<HTMLIFrameElement | null>(null);
const showSlides = ref(props.video === null);
const activeSlide = ref(0);

const slideCount = computed(() => props.slides?.length ?? 0);
const isLastSlide = computed(() => slideCount.value > 0 && activeSlide.value === slideCount.value - 1);
const slidePercent = computed(() => (slideCount.value === 0 ? 0 : Math.round(((activeSlide.value + 1) / slideCount.value) * 100)));

const { loading, error } = useVimeoPlayer({
    iframe: iframeRef,
    videoId: props.course.id ? String(props.course.id) : null,
    hasSlides: (props.slides?.length ?? 0) > 0,
    onEnded: () => {
        router.post(
            courses.videoComplete.url({ course: props.course.slug }),
            {},
            {
                preserveScroll: true,
                onSuccess: () => router.reload(),
            },
        );
    },
    onShowSlides: () => {
        showSlides.value = true;
    },
});

const goToQuiz = (): void => {
    window.location.href = props.quiz_url;
};
</script>

<template>
    <Head :title="course.name" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-5">
            <div v-if="video && !showSlides" class="mx-auto max-w-4xl space-y-6">
                <div class="flex items-center justify-between rounded-lg border border-zinc-200 bg-white p-4 shadow-sm">
                    <div v-if="video_completed" class="flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-700">
                        <CheckCircle class="size-4" />
                        Video Completed
                    </div>
                    <div v-else class="flex items-center gap-2 rounded-full border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm font-medium text-zinc-600">
                        <PlayCircle class="size-4" />
                        Watch to continue
                    </div>
                    <Button v-if="video_completed" @click="goToQuiz">
                        Take the Quiz
                        <ArrowRight class="size-4" />
                    </Button>
                </div>

                <div class="relative">
                    <div v-if="loading" class="absolute inset-0 z-10 flex items-center justify-center rounded-lg bg-zinc-100">
                        <span class="text-sm text-zinc-600">Loading video…</span>
                    </div>
                    <div v-if="error" class="absolute inset-0 z-10 flex flex-col items-center justify-center gap-3 rounded-lg bg-red-50 p-6 text-center">
                        <p class="text-sm text-red-700">{{ error }}</p>
                        <div class="flex gap-3">
                            <Button variant="destructive" @click="() => window.location.reload()">Refresh page</Button>
                            <Button v-if="slides && slides.length > 0" variant="default" @click="showSlides = true">
                                View slides instead
                            </Button>
                        </div>
                    </div>
                    <iframe
                        ref="iframeRef"
                        :src="video.player_embed_url"
                        :title="video.title"
                        oncontextmenu="return false"
                        allow="autoplay; fullscreen; picture-in-picture; encrypted-media"
                        allowfullscreen
                        class="h-[500px] w-full rounded-xl border"
                    />
                </div>
            </div>

            <div v-else-if="slides && slides.length > 0" class="mx-auto max-w-4xl space-y-4">
                <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm">
                    <h2 class="mb-3 text-lg font-semibold">{{ slides[activeSlide].title }}</h2>
                    <div class="prose prose-sm max-w-none" v-html="slides[activeSlide].description" />
                </div>

                <div class="flex items-center gap-3">
                    <Button :disabled="activeSlide === 0" variant="outline" @click="activeSlide--">Previous</Button>
                    <div class="flex-1">
                        <div class="h-2 overflow-hidden rounded-full bg-zinc-200">
                            <div class="h-full rounded-full bg-emerald-500 transition-all" :style="{ width: `${slidePercent}%` }" />
                        </div>
                        <p class="mt-1 text-center text-xs text-zinc-500">{{ activeSlide + 1 }} / {{ slideCount }}</p>
                    </div>
                    <Button v-if="isLastSlide" @click="goToQuiz">Take Quiz</Button>
                    <Button v-else @click="activeSlide++">Next</Button>
                </div>
            </div>

            <div v-else class="rounded-xl border border-dashed border-zinc-300 p-12 text-center text-sm text-muted-foreground">
                This course has no playable content yet.
            </div>
        </div>
    </AppLayout>
</template>
