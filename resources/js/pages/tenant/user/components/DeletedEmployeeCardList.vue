<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Undo2 } from 'lucide-vue-next';

export type DeletedEmployee = {
    id: number;
    name: string;
    email: string;
    department_name: string | null;
    deleted_at: string | null;
    deleted_at_formatted: string | null;
};

defineProps<{
    employees: DeletedEmployee[];
}>();

const emit = defineEmits<{
    restore: [employee: DeletedEmployee];
}>();
</script>

<template>
    <div class="overflow-hidden rounded-md border">
        <ul v-if="employees.length > 0" class="divide-y">
            <li
                v-for="employee in employees"
                :key="employee.id"
                class="flex items-start gap-3 p-3"
            >
                <div class="min-w-0 flex-1 space-y-1.5">
                    <p class="truncate font-medium" :title="employee.name">
                        {{ employee.name }}
                    </p>

                    <p class="truncate text-sm lowercase text-muted-foreground" :title="employee.email">
                        {{ employee.email }}
                    </p>

                    <p class="flex flex-wrap items-center gap-x-1.5 text-sm text-muted-foreground">
                        <span class="truncate">{{ employee.department_name ?? '—' }}</span>
                        <span aria-hidden="true">·</span>
                        <span class="truncate">Deleted {{ employee.deleted_at_formatted ?? '—' }}</span>
                    </p>
                </div>

                <Button
                    variant="outline"
                    size="icon"
                    class="size-8 shrink-0"
                    :aria-label="`Restore ${employee.name}`"
                    @click="emit('restore', employee)"
                >
                    <Undo2 class="size-4" />
                </Button>
            </li>
        </ul>

        <p v-else class="py-10 text-center text-sm text-muted-foreground">
            No deleted employees.
        </p>
    </div>
</template>
