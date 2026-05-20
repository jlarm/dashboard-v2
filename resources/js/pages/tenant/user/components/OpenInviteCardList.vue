<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Send, Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';

export type Department = { id: number; name: string };

export type OpenInvite = {
    id: number;
    name: string;
    email: string;
    department_id: number | null;
    store_names: string[];
    last_sent_at: string | null;
    last_sent_at_formatted: string | null;
    sent_by: string | null;
};

const props = defineProps<{
    invites: OpenInvite[];
    departments: Department[];
    multipleStores: boolean;
    resendingIds: Set<number>;
}>();

const emit = defineEmits<{
    resend: [invite: OpenInvite];
    delete: [invite: OpenInvite];
}>();

const selected = defineModel<number[]>('selected', { default: () => [] });

const departmentMap = computed<Map<number, string>>(() => {
    const map = new Map<number, string>();
    for (const department of props.departments) {
        map.set(department.id, department.name);
    }
    return map;
});

const departmentName = (invite: OpenInvite): string => {
    if (invite.department_id === null) {
        return '—';
    }
    return departmentMap.value.get(invite.department_id) ?? '—';
};

const isSelected = (id: number): boolean => selected.value.includes(id);

const toggleSelection = (id: number, value: boolean | 'indeterminate'): void => {
    if (value) {
        if (!selected.value.includes(id)) {
            selected.value = [...selected.value, id];
        }
        return;
    }

    selected.value = selected.value.filter((value) => value !== id);
};

const allSelected = computed<boolean>(() =>
    props.invites.length > 0 && props.invites.every((invite) => isSelected(invite.id)),
);

const headerState = computed<boolean | 'indeterminate'>(() => {
    if (allSelected.value) {
        return true;
    }

    return props.invites.some((invite) => isSelected(invite.id)) ? 'indeterminate' : false;
});

const toggleAll = (value: boolean | 'indeterminate'): void => {
    if (value) {
        const merged = new Set(selected.value);
        for (const invite of props.invites) {
            merged.add(invite.id);
        }
        selected.value = Array.from(merged);
        return;
    }

    const pageIds = new Set(props.invites.map((invite) => invite.id));
    selected.value = selected.value.filter((id) => !pageIds.has(id));
};
</script>

<template>
    <div class="overflow-hidden rounded-md border">
        <label
            v-if="invites.length > 0"
            class="flex items-center gap-3 border-b bg-muted px-3 py-2.5 text-sm font-medium text-muted-foreground"
        >
            <Checkbox
                :model-value="headerState"
                aria-label="Select all on page"
                @update:model-value="toggleAll"
            />
            Select all on this page
        </label>

        <ul v-if="invites.length > 0" class="divide-y">
            <li
                v-for="invite in invites"
                :key="invite.id"
                :data-state="isSelected(invite.id) ? 'selected' : undefined"
                class="flex gap-3 p-3 data-[state=selected]:bg-muted/50"
            >
                <Checkbox
                    class="mt-0.5 shrink-0"
                    :model-value="isSelected(invite.id)"
                    :aria-label="`Select ${invite.name}`"
                    @update:model-value="(value) => toggleSelection(invite.id, value)"
                />

                <div class="min-w-0 flex-1 space-y-1.5">
                    <div class="flex items-start gap-2">
                        <span class="min-w-0 flex-1 truncate font-medium" :title="invite.name">
                            {{ invite.name }}
                        </span>

                        <div class="flex shrink-0 items-center gap-1">
                            <Button
                                variant="outline"
                                size="icon"
                                class="size-8"
                                :disabled="resendingIds.has(invite.id)"
                                :aria-label="`Resend invite to ${invite.name}`"
                                @click="emit('resend', invite)"
                            >
                                <Send class="size-4" />
                            </Button>
                            <Button
                                variant="outline"
                                size="icon"
                                class="size-8 text-red-600 hover:bg-red-50 hover:text-red-700"
                                :aria-label="`Delete invite to ${invite.name}`"
                                @click="emit('delete', invite)"
                            >
                                <Trash2 class="size-4" />
                            </Button>
                        </div>
                    </div>

                    <p class="truncate text-sm lowercase text-muted-foreground" :title="invite.email">
                        {{ invite.email }}
                    </p>

                    <p class="flex flex-wrap items-center gap-x-1.5 text-sm text-muted-foreground">
                        <template v-if="multipleStores">
                            <span class="truncate">{{ invite.store_names.join(', ') || '—' }}</span>
                            <span aria-hidden="true">·</span>
                        </template>
                        <span class="truncate">{{ departmentName(invite) }}</span>
                    </p>

                    <p class="text-xs text-muted-foreground">
                        Last sent {{ invite.last_sent_at_formatted ?? '—' }}
                        <template v-if="invite.sent_by"> · by {{ invite.sent_by }}</template>
                    </p>
                </div>
            </li>
        </ul>

        <p v-else class="py-10 text-center text-sm text-muted-foreground">
            No open invites.
        </p>
    </div>
</template>
