<script setup lang="ts">
import { ref, toRef, watch } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { Input } from "@/components/ui/input";
import AppPagination from "@/components/AppPagination.vue";
import type { BreadcrumbItem } from "@/types";
import type { PaginatedResponse } from "@/types/paginator";
import courseManagementRoutes from "@/routes/course-management";
import ImportCourseDialog from "@/pages/central/course-management/components/ImportCourseDialog.vue";
import { Video } from "lucide-vue-next";
import { useDebounceFn } from "@vueuse/core";

type Course = {
    id: number;
    name: string;
    slug: string;
    has_video: boolean;
};

const props = defineProps<{
    courses: PaginatedResponse<Course>;
    filters: { search?: string };
}>();

const search = ref(props.filters.search ?? "");
const cachedCourses = ref(props.courses);

watch(toRef(props, "courses"), (next) => {
    if (next) {
        cachedCourses.value = next;
    }
});

const performSearch = useDebounceFn(() => {
    router.get(
        courseManagementRoutes.index.url(),
        { search: search.value || undefined },
        { preserveState: true, replace: true, preserveScroll: true },
    );
}, 300);

watch(search, performSearch);

const breadcrumbItems: BreadcrumbItem[] = [
    { title: "Course Management", href: courseManagementRoutes.index.url() },
];
</script>

<template>
    <Head title="Course Management" />
    <AppLayout :breadcrumbs="breadcrumbItems">
        <template #actions>
            <ImportCourseDialog />
        </template>

        <Input v-model="search" placeholder="Search courses..." class="w-1/3 mb-5" />

        <div class="rounded-md border">
            <Table>
                <TableHeader class="[&_tr]:border-b bg-muted sticky top-0 z-10">
                    <TableRow>
                        <TableHead>Name</TableHead>
                        <TableHead class="w-32">Video</TableHead>
                        <TableHead class="w-0 text-right pr-4" />
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-if="cachedCourses.data.length === 0">
                        <TableCell colspan="3" class="py-8 text-center text-sm text-muted-foreground">
                            No courses found{{ search ? ` for "${search}"` : "" }}.
                        </TableCell>
                    </TableRow>
                    <TableRow v-for="course in cachedCourses.data" :key="course.id">
                        <TableCell>{{ course.name }}</TableCell>
                        <TableCell>
                            <Badge v-if="course.has_video" variant="secondary" class="gap-1">
                                <Video class="size-3" />
                                Video
                            </Badge>
                        </TableCell>
                        <TableCell class="w-0 pr-4 text-right whitespace-nowrap">
                            <Link
                                :href="courseManagementRoutes.edit(course.slug).url"
                                class="text-primary hover:underline"
                            >
                                Edit
                            </Link>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <div class="mt-4">
            <AppPagination :pagination="cachedCourses" />
        </div>
    </AppLayout>
</template>
