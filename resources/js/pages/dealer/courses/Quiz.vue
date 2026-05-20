<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import { Button } from '@/components/ui/button';
import courses from '@/routes/dealer/courses';
import type { BreadcrumbItem } from '@/types';

type Question = {
    question: string;
    correctAnswer?: string;
    answers: Array<Record<string, string>>;
};

type CourseProp = {
    id: number;
    name: string;
    slug: string;
    questions: Question[];
};

const props = defineProps<{
    course: CourseProp;
}>();

const initialAnswers: Record<string, string> = {};
props.course.questions.forEach((_, i) => {
    initialAnswers[String(i + 1)] = '';
});

const form = useForm<{ question: Record<string, string> }>({ question: initialAnswers });

const submit = (): void => {
    form.post(courses.results.store.url({ course: props.course.slug }));
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Courses', href: courses.index.url() },
    { title: props.course.name, href: courses.show.url({ course: props.course.slug }) },
    { title: 'Quiz', href: courses.quiz.url({ course: props.course.slug }) },
];
</script>

<template>
    <Head :title="`${course.name} — Quiz`" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <form class="space-y-5" @submit.prevent="submit">
            <div
                v-for="(question, i) in course.questions"
                :key="i"
                class="rounded-lg border border-zinc-200 bg-zinc-50 p-6"
            >
                <p class="mb-5 text-sm font-semibold">{{ i + 1 }}. {{ question.question }}</p>
                <div class="space-y-2">
                    <label
                        v-for="(value, key) in question.answers[0]"
                        :key="key"
                        class="flex items-center gap-3 text-sm"
                    >
                        <input
                            v-model="form.question[String(i + 1)]"
                            type="radio"
                            :name="`question-${i + 1}`"
                            :value="key"
                            required
                        />
                        <span>{{ value }}</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <Button type="submit" :disabled="form.processing">Submit</Button>
                <Button type="button" variant="ghost" as="a" :href="courses.show.url({ course: course.slug })">
                    Cancel
                </Button>
            </div>
        </form>
    </AppLayout>
</template>
