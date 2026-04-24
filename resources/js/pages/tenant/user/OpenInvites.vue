<script setup lang="ts">
import AppPagination from '@/components/AppPagination.vue';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import { Tooltip, TooltipContent, TooltipTrigger } from '@/components/ui/tooltip';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import ImportEmployeesDialog from '@/pages/tenant/user/components/ImportEmployeesDialog.vue';
import SubNavigation from '@/pages/tenant/user/components/SubNavigation.vue';
import employees from '@/routes/dealer/employees';
import type { BreadcrumbItem } from '@/types';
import type { PaginatedResponse } from '@/types/paginator';
import { Head, router } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { RotateCcw, Send, Trash2 } from 'lucide-vue-next';
import { computed, reactive, ref, watch } from 'vue';

type Department = { id: number; name: string };

type OpenInvite = {
    id: number;
    name: string;
    email: string;
    department_id: number | null;
    store_names: string[];
    last_sent_at: string | null;
    last_sent_at_formatted: string | null;
    sent_by: string | null;
};

type Filters = {
    search: string;
    department_id: number | null;
};

const props = defineProps<{
    invites: PaginatedResponse<OpenInvite>;
    filters: Filters;
    departments: Department[];
    multipleStores: boolean;
}>();

const breadcrumbs = computed<BreadcrumbItem[]>(() => [
    { title: 'Employees', href: employees.index.url() },
    { title: 'Open Invites', href: employees.openInvites.url() },
]);

const search = ref(props.filters.search);
const localFilters = reactive<{ department_id: number | null }>({
    department_id: props.filters.department_id,
});

const selected = ref<number[]>([]);
const importDialogOpen = ref(false);
const inviteToDelete = ref<OpenInvite | null>(null);
const inviteToResend = ref<OpenInvite | null>(null);
const resendingIds = ref<Set<number>>(new Set());
const bulkSending = ref(false);
const deleting = ref(false);

const departmentMap = computed(() => {
    const map = new Map<number, string>();
    for (const dept of props.departments) {
        map.set(dept.id, dept.name);
    }
    return map;
});

const buildQuery = (): Record<string, string> => {
    const query: Record<string, string> = {};
    if (search.value !== '') {
        query.search = search.value;
    }
    if (localFilters.department_id !== null) {
        query.department_id = String(localFilters.department_id);
    }
    return query;
};

const reload = () => {
    router.get(employees.openInvites.url(), buildQuery(), {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['invites', 'filters'],
    });
};

const debouncedSearch = useDebounceFn(reload, 300);
watch(search, debouncedSearch);
watch(() => localFilters.department_id, reload);

const resetFilters = () => {
    search.value = '';
    localFilters.department_id = null;
    reload();
};

const hasActiveFilters = computed(
    () => search.value !== '' || localFilters.department_id !== null,
);

const toggleSelection = (id: number, checked: boolean) => {
    if (checked) {
        if (!selected.value.includes(id)) {
            selected.value.push(id);
        }
    } else {
        selected.value = selected.value.filter((value) => value !== id);
    }
};

const pageIds = computed(() => props.invites.data.map((invite) => invite.id));
const allOnPageSelected = computed(
    () => pageIds.value.length > 0 && pageIds.value.every((id) => selected.value.includes(id)),
);

const toggleSelectPage = (checked: boolean) => {
    if (checked) {
        const merged = new Set(selected.value);
        for (const id of pageIds.value) {
            merged.add(id);
        }
        selected.value = Array.from(merged);
    } else {
        selected.value = selected.value.filter((id) => !pageIds.value.includes(id));
    }
};

watch(
    () => props.invites,
    () => {
        const visible = new Set(pageIds.value);
        selected.value = selected.value.filter((id) => visible.has(id));
    },
);

const confirmResend = (invite: OpenInvite) => {
    inviteToResend.value = invite;
};

const cancelResend = () => {
    inviteToResend.value = null;
};

const performResend = () => {
    if (!inviteToResend.value) {
        return;
    }

    const invite = inviteToResend.value;
    resendingIds.value.add(invite.id);
    router.post(
        employees.openInvites.resendOne.url({ invite: invite.id }),
        {},
        {
            preserveScroll: true,
            onFinish: () => {
                resendingIds.value.delete(invite.id);
                inviteToResend.value = null;
            },
        },
    );
};

const resendSelected = () => {
    if (selected.value.length === 0) {
        return;
    }

    bulkSending.value = true;
    router.post(
        employees.openInvites.resend.url(),
        { invite_ids: selected.value },
        {
            preserveScroll: true,
            onSuccess: () => {
                selected.value = [];
            },
            onFinish: () => {
                bulkSending.value = false;
            },
        },
    );
};

const confirmDelete = (invite: OpenInvite) => {
    inviteToDelete.value = invite;
};

const cancelDelete = () => {
    inviteToDelete.value = null;
};

const performDelete = () => {
    if (!inviteToDelete.value) {
        return;
    }

    deleting.value = true;
    router.delete(
        employees.openInvites.destroy.url({ invite: inviteToDelete.value.id }),
        {
            preserveScroll: true,
            onFinish: () => {
                deleting.value = false;
                inviteToDelete.value = null;
            },
        },
    );
};
</script>

<template>
    <Head title="Open Invites" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <template #actions>
            <SubNavigation @import="importDialogOpen = true" />
        </template>

        <ImportEmployeesDialog v-model:open="importDialogOpen" />

        <div class="space-y-5">
            <div class="flex flex-wrap items-center gap-2">
                <div class="w-64">
                    <Input v-model="search" type="search" placeholder="Search by name or email" />
                </div>

                <div v-if="departments.length > 1" class="w-56">
                    <Select
                        :model-value="localFilters.department_id === null ? '' : String(localFilters.department_id)"
                        @update:model-value="(value) => (localFilters.department_id = value ? Number(value) : null)"
                    >
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="All departments" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem
                                v-for="department in departments"
                                :key="department.id"
                                :value="String(department.id)"
                            >
                                {{ department.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                <Button
                    v-if="hasActiveFilters"
                    variant="ghost"
                    size="sm"
                    @click="resetFilters"
                >
                    <RotateCcw class="size-3.5" />
                    Reset
                </Button>

                <div class="ml-auto">
                    <Button
                        v-if="selected.length > 0"
                        size="sm"
                        :disabled="bulkSending"
                        @click="resendSelected"
                    >
                        <Send class="size-4" />
                        {{ bulkSending ? 'Sending...' : `Resend ${selected.length} invite${selected.length === 1 ? '' : 's'}` }}
                    </Button>
                </div>
            </div>

            <div class="overflow-x-auto rounded-md border">
                <Table>
                    <TableHeader class="bg-muted">
                        <TableRow>
                            <TableHead class="w-10">
                                <input
                                    type="checkbox"
                                    :checked="allOnPageSelected"
                                    :disabled="invites.data.length === 0"
                                    class="size-4 rounded border-input text-primary focus:ring-2 focus:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                                    aria-label="Select all on page"
                                    @change="(event) => toggleSelectPage((event.target as HTMLInputElement).checked)"
                                />
                            </TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead v-if="multipleStores">Store(s)</TableHead>
                            <TableHead>Department</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>Last sent</TableHead>
                            <TableHead>Sent by</TableHead>
                            <TableHead class="text-right" />
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-if="invites.data.length === 0">
                            <TableCell :colspan="multipleStores ? 8 : 7" class="py-10 text-center text-muted-foreground">
                                No open invites.
                            </TableCell>
                        </TableRow>
                        <TableRow v-for="invite in invites.data" :key="invite.id">
                            <TableCell>
                                <input
                                    type="checkbox"
                                    :checked="selected.includes(invite.id)"
                                    class="size-4 rounded border-input text-primary focus:ring-2 focus:ring-ring"
                                    :aria-label="`Select ${invite.name}`"
                                    @change="(event) => toggleSelection(invite.id, (event.target as HTMLInputElement).checked)"
                                />
                            </TableCell>
                            <TableCell class="font-medium">{{ invite.name }}</TableCell>
                            <TableCell v-if="multipleStores">{{ invite.store_names.join(', ') || '—' }}</TableCell>
                            <TableCell>{{ invite.department_id === null ? '—' : (departmentMap.get(invite.department_id) ?? '—') }}</TableCell>
                            <TableCell class="lowercase">{{ invite.email }}</TableCell>
                            <TableCell>{{ invite.last_sent_at_formatted ?? '—' }}</TableCell>
                            <TableCell>{{ invite.sent_by ?? '—' }}</TableCell>
                            <TableCell>
                                <div class="flex justify-end">
                                    <ButtonGroup>
                                        <Tooltip>
                                            <TooltipTrigger as-child>
                                                <Button
                                                    variant="outline"
                                                    size="icon"
                                                    :disabled="resendingIds.has(invite.id)"
                                                    :aria-label="`Resend invite to ${invite.name}`"
                                                    @click="confirmResend(invite)"
                                                >
                                                    <Send class="size-4" />
                                                </Button>
                                            </TooltipTrigger>
                                            <TooltipContent>
                                                {{ resendingIds.has(invite.id) ? 'Sending...' : 'Resend invite' }}
                                            </TooltipContent>
                                        </Tooltip>
                                        <Tooltip>
                                            <TooltipTrigger as-child>
                                                <Button
                                                    variant="outline"
                                                    size="icon"
                                                    class="text-red-600 hover:bg-red-50 hover:text-red-700"
                                                    :aria-label="`Delete invite to ${invite.name}`"
                                                    @click="confirmDelete(invite)"
                                                >
                                                    <Trash2 class="size-4" />
                                                </Button>
                                            </TooltipTrigger>
                                            <TooltipContent>Delete invite</TooltipContent>
                                        </Tooltip>
                                    </ButtonGroup>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <AppPagination :pagination="invites" />
        </div>

        <Dialog :open="inviteToDelete !== null" @update:open="(value) => !value && cancelDelete()">
            <DialogContent class="sm:max-w-md">
                <DialogHeader>
                    <DialogTitle>Delete invite?</DialogTitle>
                    <DialogDescription v-if="inviteToDelete">
                        This will cancel the invite for
                        <span class="font-medium">{{ inviteToDelete.name }}</span>
                        ({{ inviteToDelete.email }}). They won't be able to register using the link in their email.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <Button variant="outline" :disabled="deleting" @click="cancelDelete">Cancel</Button>
                    <Button variant="destructive" :disabled="deleting" @click="performDelete">
                        {{ deleting ? 'Deleting...' : 'Delete invite' }}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>

        <Dialog :open="inviteToResend !== null" @update:open="(value) => !value && cancelResend()">
            <DialogContent class="sm:max-w-md">
                <DialogHeader>
                    <DialogTitle>Resend invite?</DialogTitle>
                    <DialogDescription v-if="inviteToResend">
                        Send the registration email again to
                        <span class="font-medium">{{ inviteToResend.name }}</span>
                        ({{ inviteToResend.email }}).
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <Button
                        variant="outline"
                        :disabled="inviteToResend !== null && resendingIds.has(inviteToResend.id)"
                        @click="cancelResend"
                    >
                        Cancel
                    </Button>
                    <Button
                        :disabled="inviteToResend !== null && resendingIds.has(inviteToResend.id)"
                        @click="performResend"
                    >
                        {{ inviteToResend !== null && resendingIds.has(inviteToResend.id) ? 'Sending...' : 'Send invite' }}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>
