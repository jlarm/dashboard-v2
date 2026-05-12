<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import CourseCard from '@/components/courses/CourseCard.vue';
import coursesRoutes from '@/routes/dealer/courses';
import type { BreadcrumbItem } from '@/types';

type CourseListItem = {
    id: number;
    name: string;
    slug: string;
    status: 'never' | 'passed' | 'failed' | 'expired';
    status_label: string;
    percentage: number | null;
    last_taken_at: string | null;
    has_questions: boolean;
    is_locked: boolean;
    module_index: number | null;
};

defineProps<{
    courses: CourseListItem[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Courses', href: coursesRoutes.index.url() },
    { title: 'All courses', href: coursesRoutes.all.url() },
];
</script>

<template>
    <Head title="All courses" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div v-if="courses.length === 0" class="rounded-xl border border-dashed border-zinc-300 p-12 text-center text-sm text-muted-foreground">
            No courses available.
        </div>
        <div v-else class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            <CourseCard
                v-for="course in courses"
                :key="course.id"
                :course="course"
            />
        </div>
    </AppLayout>
</template>
