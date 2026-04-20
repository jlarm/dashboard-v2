<script setup lang="ts">
import { PaginatedResponse } from "@/types/paginator";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import {DeletedUser} from "@/types/user";

defineProps<{
    users: PaginatedResponse<DeletedUser>;
}>();
</script>

<template>
    <Table>
        <TableHeader>
            <TableRow>
                <TableHead>Name</TableHead>
                <TableHead>Email</TableHead>
                <TableHead>Deleted</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="user in users.data" :key="user.id">
                <TableCell>{{ user.name }}</TableCell>
                <TableCell>{{ user.email }}</TableCell>
                <TableCell>{{ new Date(user.deleted_at).toLocaleDateString() }}</TableCell>
            </TableRow>
            <TableRow v-if="users.data.length === 0">
                <TableCell colspan="3" class="text-center text-muted-foreground">No deleted users.</TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
