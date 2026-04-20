<script setup lang="ts">
import {BreadcrumbItem, PaginatedResponse} from "@/types";
import {User} from "@/types/user";
import employees from "@/routes/employees";
import {Head} from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import IndexTable from "@/pages/central/user/components/IndexTable.vue";
import AppPagination from "@/components/AppPagination.vue";
import SubNavigation from "@/pages/central/user/components/SubNavigation.vue";
import InviteUserDialog from "@/pages/central/user/components/InviteUserDialog.vue";

defineProps<{
    users: PaginatedResponse<User>;
    totalCoursesCount?: number;
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: "Employees",
        href: employees.index.url(),
    }
]
</script>

<template>
    <Head title="Employees" />
    <AppLayout :breadcrumbs="breadcrumbItems">
        <template #actions>
            <SubNavigation />
            <InviteUserDialog />
        </template>
        <div>
            <IndexTable :users="users" :totalCoursesCount="totalCoursesCount" />
            <div class="mt-3">
                <AppPagination :pagination="users" />
            </div>
        </div>
    </AppLayout>
</template>
