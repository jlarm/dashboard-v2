<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { Button } from "@/components/ui/button";
import { Form, Link } from "@inertiajs/vue3";
import courses from "@/routes/courses";
import { BreadcrumbItem } from "@/types";

type Course = {
    id: number;
    name: string;
    slug: string;
};

type Question = {
    question: string;
    answers: [Record<string, string>];
};

const props = defineProps<{
    course: Course;
    questions: Question[];
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    { title: "Courses", href: courses.index.url() },
    { title: props.course.name, href: courses.show.url(props.course) },
    { title: "Quiz", href: courses.quiz.url(props.course) },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <div class="w-full px-6 py-6">
            <div class="mx-auto flex w-full max-w-6xl flex-col gap-6">
                <div class="flex flex-col gap-3">
                    <h1 class="text-2xl font-semibold tracking-tight">{{ course.name }}</h1>
                    <p class="text-sm text-muted-foreground">Answer all questions to complete the quiz.</p>
                </div>

                <Form
                    :action="courses.quiz.store.url(course)"
                    method="post"
                    class="flex flex-col gap-6"
                    #default="{ errors, processing }"
                >
                    <div
                        v-for="(question, index) in questions"
                        :key="index"
                        class="rounded-xl border bg-muted/30 p-6"
                    >
                        <p class="mb-4 text-sm font-semibold">{{ index + 1 }}. {{ question.question }}</p>
                        <p v-if="errors[`question.${index + 1}`]" class="mb-3 text-sm text-destructive">
                            {{ errors[`question.${index + 1}`] }}
                        </p>
                        <div class="flex flex-col gap-3">
                            <label
                                v-for="(value, key) in question.answers[0]"
                                :key="key"
                                class="flex cursor-pointer items-center gap-3 text-sm"
                            >
                                <input
                                    type="radio"
                                    :name="`question[${index + 1}]`"
                                    :value="key"
                                    :required="key === Object.keys(question.answers[0])[0]"
                                    class="text-primary focus:ring-primary"
                                />
                                <span>{{ value }}</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <Button type="submit" :disabled="processing">
                            {{ processing ? "Submitting..." : "Submit" }}
                        </Button>
                        <Link
                            :href="courses.show.url(course)"
                            class="text-sm text-muted-foreground hover:text-foreground"
                        >
                            Cancel
                        </Link>
                    </div>
                </Form>
            </div>
        </div>
    </AppLayout>
</template>
