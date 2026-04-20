<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { BreadcrumbItem } from "@/types";
import employees from "@/routes/employees";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { PaginatedResponse } from "@/types/paginator";
import AppPagination from "@/components/AppPagination.vue";
import { Head } from "@inertiajs/vue3";
import SubNavigation from "@/pages/central/user/components/SubNavigation.vue";
import {OpenInvite} from "@/types/user";
import DeleteInviteDialog from "@/pages/central/user/components/DeleteInviteDialog.vue";
import InviteUserDialog from "@/pages/central/user/components/InviteUserDialog.vue";

defineProps<{
    openInvites: PaginatedResponse<OpenInvite>;
}>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: "Employees",
        href: employees.index.url(),
    },
    {
        title: "Invites",
        href: employees.invites.url(),
    },
];
</script>

<template>
    <Head title="Employee Invites" />
    <AppLayout :breadcrumbs="breadcrumbItems">
        <template #actions>
            <SubNavigation />
            <InviteUserDialog />
        </template>
        <div>
            <div class="rounded-md border">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Name</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>Role</TableHead>
                            <TableHead>Expires</TableHead>
                            <TableHead></TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-for="invite in openInvites.data"
                            :key="invite.id"
                        >
                            <TableCell>{{ invite.name }}</TableCell>
                            <TableCell>{{ invite.email }}</TableCell>
                            <TableCell>
                                <Badge>{{ invite.role }}</Badge>
                            </TableCell>
                            <TableCell>{{
                                    new Date(invite.expires_at).toLocaleDateString()
                                }}</TableCell>
                            <TableCell class="flex justify-end">
                                <DeleteInviteDialog :invite="invite" />
                            </TableCell>
                        </TableRow>
                        <TableRow v-if="openInvites.data.length === 0">
                            <TableCell
                                colspan="4"
                                class="text-center text-muted-foreground"
                            >No open invites.</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
            <AppPagination :pagination="openInvites" />
        </div>
    </AppLayout>
</template>
