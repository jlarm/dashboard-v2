<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import CourseCard from '@/components/courses/CourseCard.vue';
import DotCertButton from '@/components/courses/DotCertButton.vue';
import { dashboard } from '@/routes/dealer';
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
    can_issue_dot_certificate?: boolean;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: dashboard() },
];
</script>

<template>
    <Head title="Dashboard" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <DotCertButton v-if="can_issue_dot_certificate" />
        </template>

        <div class="space-y-4">
            <div>
                <h2 class="text-lg font-semibold text-zinc-900">Your courses</h2>
                <p class="text-sm text-muted-foreground">Complete each course assigned to you to stay current.</p>
            </div>

            <div v-if="courses.length === 0" class="rounded-xl border border-dashed border-zinc-300 p-12 text-center text-sm text-muted-foreground">
                No courses are assigned to you yet.
            </div>
            <div v-else class="grid grid-cols-2 gap-2 md:grid-cols-3 md:gap-4 lg:grid-cols-4">
                <CourseCard
                    v-for="course in courses"
                    :key="course.id"
                    :course="course"
                />
            </div>
        </div>
    </AppLayout>
</template>
