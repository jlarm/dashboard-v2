<script setup lang="ts">
import { BreadcrumbItem } from "@/types";
import employees from "@/routes/employees";
import AppLayout from "@/layouts/AppLayout.vue";
import { PaginatedResponse } from "@/types/paginator";
import AppPagination from "@/components/AppPagination.vue";
import { Head } from "@inertiajs/vue3";
import {DeletedUser} from "@/types/user";
import SubNavigation from "@/pages/central/user/components/SubNavigation.vue";
import DeletedTable from "@/pages/central/user/components/DeletedTable.vue";
import InviteUserDialog from "@/pages/central/user/components/InviteUserDialog.vue";

defineProps<{
    users: PaginatedResponse<DeletedUser>;
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: "Employees",
        href: employees.index.url(),
    },
    {
        title: "Deleted",
        href: employees.deleted.url(),
    }
]
</script>

<template>
    <Head title="Deleted Employees" />
    <AppLayout :breadcrumbs="breadcrumbItems">
        <template #actions>
            <SubNavigation />
            <InviteUserDialog />
        </template>
        <div>
            <div class="rounded-md border">
                <DeletedTable :users="users" />
            </div>
            <AppPagination :pagination="users" />
        </div>
    </AppLayout>
</template>
