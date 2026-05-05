<script setup lang="ts">
import { computed, ref, watch } from "vue";
import { Head } from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import SlidesForm from "@/pages/central/course-management/components/SlidesForm.vue";
import QuizForm from "@/pages/central/course-management/components/QuizForm.vue";
import SettingsForm from "@/pages/central/course-management/components/SettingsForm.vue";
import courseManagementRoutes from "@/routes/course-management";
import type { BreadcrumbItem } from "@/types";

type Slide = { title: string; description: string };
type RawAnswer = Record<string, string> | { key: string; value: string };
type RawQuestion = { question?: string; answers?: RawAnswer[]; correctAnswer?: string };

type Course = {
    id: number;
    name: string;
    slug: string;
    video_id: string | null;
    slides: Slide[];
    questions: RawQuestion[];
    department_ids: number[];
    role_ids: number[];
    states_required: string[];
    replaces_course_slugs: string[];
    tenant_ids: string[];
};

type Options = {
    departments: { value: number; label: string }[];
    roles: { value: number; label: string }[];
    states: { value: string; label: string }[];
    courses: { value: string; label: string }[];
    tenants: { value: string; label: string }[];
};

const props = defineProps<{
    course: Course;
    options: Options;
}>();

const VALID_TABS = ["slides", "quiz", "settings"] as const;
type Tab = (typeof VALID_TABS)[number];

const initialTabFromUrl = (): Tab => {
    if (typeof window === "undefined") return "slides";
    const param = new URL(window.location.href).searchParams.get("tab");
    return VALID_TABS.includes(param as Tab) ? (param as Tab) : "slides";
};

const activeTab = ref<Tab>(initialTabFromUrl());

watch(activeTab, (tab) => {
    const url = new URL(window.location.href);
    if (tab === "slides") {
        url.searchParams.delete("tab");
    } else {
        url.searchParams.set("tab", tab);
    }
    window.history.replaceState({}, "", url.toString());
});

const breadcrumbItems = computed<BreadcrumbItem[]>(() => [
    { title: "Course Management", href: courseManagementRoutes.index.url() },
    { title: props.course.name, href: courseManagementRoutes.edit(props.course.slug).url },
]);
</script>

<template>
    <Head :title="course.name" />
    <AppLayout :breadcrumbs="breadcrumbItems">
        <div class="max-w-4xl space-y-6">
            <div>
                <h1 class="text-2xl font-bold">{{ course.name }}</h1>
                <p class="text-sm text-muted-foreground">
                    Manage the slides, quiz, and settings for this course.
                </p>
            </div>

            <Tabs v-model="activeTab" class="w-full">
                <TabsList class="flex w-full">
                    <TabsTrigger value="slides">Slides</TabsTrigger>
                    <TabsTrigger value="quiz">Quiz</TabsTrigger>
                    <TabsTrigger value="settings">Settings</TabsTrigger>
                </TabsList>

                <TabsContent value="slides" class="pt-6">
                    <SlidesForm
                        :slug="course.slug"
                        :name="course.name"
                        :video-id="course.video_id"
                        :slides="course.slides"
                    />
                </TabsContent>

                <TabsContent value="quiz" class="pt-6">
                    <QuizForm :slug="course.slug" :questions="course.questions" />
                </TabsContent>

                <TabsContent value="settings" class="pt-6">
                    <SettingsForm
                        :slug="course.slug"
                        :department-ids="course.department_ids"
                        :role-ids="course.role_ids"
                        :states-required="course.states_required"
                        :replaces-course-slugs="course.replaces_course_slugs"
                        :tenant-ids="course.tenant_ids"
                        :options="options"
                    />
                </TabsContent>
            </Tabs>
        </div>
    </AppLayout>
</template>
