<script setup lang="ts">
import {PaginatedResponse} from "@/types";
import {User} from "@/types/user";
import {Table, TableBody, TableCell, TableHead, TableHeader, TableRow} from "@/components/ui/table";
import {Deferred, Link} from "@inertiajs/vue3";
import {Badge} from "@/components/ui/badge";
import {Button} from "@/components/ui/button";
import employees from "@/routes/employees";

defineProps<{
    users: PaginatedResponse<User>;
    totalCoursesCount?: number;
}>();
</script>

<template>
    <div class="overflow-hidden rounded-lg border">
        <Table>
            <TableHeader class="[&_tr]:border-b bg-muted sticky top-0 z-10">
                <TableRow>
                    <TableHead>Name</TableHead>
                    <TableHead>Email</TableHead>
                    <TableHead>Completed Courses</TableHead>
                    <TableHead>Role</TableHead>
                    <TableHead></TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="user in users.data" :key="user.id">
                    <TableCell>{{ user.name }}</TableCell>
                    <TableCell>{{ user.email }}</TableCell>
                    <TableCell
                    >
                        {{ user.completed_courses_count }} of
                        <Deferred data="totalCoursesCount">
                            <template #fallback>
                                <span>0</span>
                            </template>

                            <span>{{ totalCoursesCount }}</span>
                        </Deferred>
                    </TableCell
                    >
                    <TableCell>
                        <Badge>{{ user.role }}</Badge>
                    </TableCell>
                    <TableCell class="text-right">
                        <Button size="sm" variant="outline" as-child>
                            <Link :href="employees.show.url(user)">View</Link>
                        </Button
                        >
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
