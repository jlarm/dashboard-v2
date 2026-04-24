<script setup lang="ts">
import EmployeeShowLayout from '@/pages/tenant/user/components/EmployeeShowLayout.vue';
import type { EmployeeShowProps } from '@/pages/tenant/user/components/types';
import { setLayoutProps } from '@inertiajs/vue3';

defineOptions({ layout: EmployeeShowLayout });

defineProps<EmployeeShowProps>();

setLayoutProps<{ activeTab: 'overview' }>({ activeTab: 'overview' });
</script>

<template>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <section class="rounded-md border bg-card p-4">
            <h2 class="text-sm font-semibold text-muted-foreground">Department</h2>
            <p class="mt-1 text-sm">{{ employee.department_name ?? '—' }}</p>
        </section>

        <section class="rounded-md border bg-card p-4">
            <h2 class="text-sm font-semibold text-muted-foreground">Roles</h2>
            <div v-if="employee.roles.length > 0" class="mt-2 flex flex-wrap gap-1">
                <span
                    v-for="role in employee.roles"
                    :key="role.id"
                    class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-500/10"
                >
                    {{ role.name }}
                </span>
            </div>
            <p v-else class="mt-1 text-sm text-muted-foreground">No roles assigned</p>
        </section>

        <section class="rounded-md border bg-card p-4 md:col-span-2">
            <h2 class="text-sm font-semibold text-muted-foreground">Last login</h2>
            <p v-if="employee.last_login_at" class="mt-1 text-sm">
                {{ employee.last_login_at }}
                <span class="text-muted-foreground">· {{ employee.last_login_at_relative }}</span>
            </p>
            <p v-else class="mt-1 text-sm text-muted-foreground">Never logged in</p>
        </section>

        <section class="rounded-md border bg-card p-4 md:col-span-2">
            <h2 class="text-sm font-semibold text-muted-foreground">Locations</h2>
            <div v-if="employee.stores.length > 0" class="mt-2 flex flex-wrap gap-1">
                <span
                    v-for="store in employee.stores"
                    :key="store.id"
                    class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-500/10"
                >
                    {{ store.name }}
                </span>
            </div>
            <p v-else class="mt-1 text-sm text-muted-foreground">Not assigned to any locations</p>
        </section>

        <section class="rounded-md border bg-card p-4 md:col-span-2">
            <h2 class="text-sm font-semibold text-muted-foreground">Training summary</h2>
            <dl class="mt-3 grid grid-cols-2 gap-4 text-sm sm:grid-cols-4">
                <div>
                    <dt class="text-xs text-muted-foreground">Required</dt>
                    <dd class="mt-1 font-medium">{{ employee.training.total_required }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-muted-foreground">Completed</dt>
                    <dd class="mt-1 font-medium">{{ employee.training.valid_completed }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-muted-foreground">Expiring soon</dt>
                    <dd class="mt-1 font-medium text-amber-700">{{ employee.training.expiring_soon }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-muted-foreground">Expired</dt>
                    <dd class="mt-1 font-medium text-red-700">{{ employee.training.expired }}</dd>
                </div>
            </dl>
        </section>
    </div>
</template>
