<script setup lang="ts">
import {PaginatedResponse} from "@/types/paginator";
import {BreadcrumbItem} from "@/types";
import AppLayout from "@/layouts/AppLayout.vue";
import AppPagination from "@/components/AppPagination.vue";
import {Table, TableBody, TableCell, TableHead, TableHeader, TableRow} from "@/components/ui/table";
import { ChevronRight } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";
import {Badge} from "@/components/ui/badge";
import courseRoutes from '@/routes/courses';

type Course = {
    id: number;
    name: string;
    slug: string;
    percentage: number;
    status: { label: string; color: string };
}

defineProps<{
    courses: PaginatedResponse<Course>;
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: "Courses",
        href: courseRoutes.index.url(),
    }
]
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <div class="overflow-hidden rounded-lg border">
            <Table>
                <TableHeader class="[&_tr]:border-b bg-muted sticky top-0 z-10">
                    <TableRow>
                        <TableHead>Name</TableHead>
                        <TableHead>Score</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead></TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow
                        v-for="course in courses.data"
                        :key="course.id"
                        class="cursor-pointer"
                        @click="router.visit(courseRoutes.show(course))"
                    >
                        <TableCell>{{ course.name }}</TableCell>
                        <TableCell>{{ course.percentage ?? '-' }}</TableCell>
                        <TableCell>
                            <Badge variant="secondary" :class="`bg-${course.status.color}-500 border-none text-white`">{{ course.status.label }}</Badge>
                        </TableCell>
                        <TableCell>
                            <ChevronRight class="size-4" />
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
        <AppPagination :pagination="courses" />
    </AppLayout>
</template>
