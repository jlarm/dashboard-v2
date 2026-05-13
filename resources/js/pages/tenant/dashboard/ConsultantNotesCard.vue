<script setup lang="ts">
import DashboardController from '@/actions/App/Http/Controllers/Tenant/DashboardController';
import { useForm } from '@inertiajs/vue3';
import { Pencil } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import { useNullablePageProp } from './props';
import type { ConsultantNote } from './types';

const consultantNote = useNullablePageProp<ConsultantNote>('consultant_note');

const isEditing = ref(false);

const form = useForm<{ note: string }>({
    note: consultantNote.value?.note ?? '',
});

watch(consultantNote, (next) => {
    form.defaults({ note: next?.note ?? '' });
    if (! isEditing.value) {
        form.note = next?.note ?? '';
    }
});

const trimmedNote = computed<string>(() => (consultantNote.value?.note ?? '').trim());

function startEditing(): void {
    form.note = consultantNote.value?.note ?? '';
    isEditing.value = true;
}

function cancelEditing(): void {
    form.note = consultantNote.value?.note ?? '';
    form.clearErrors();
    isEditing.value = false;
}

function save(): void {
    form.post(DashboardController.updateConsultantNote.url(), {
        preserveScroll: true,
        onSuccess: () => {
            isEditing.value = false;
        },
    });
}
</script>

<template>
    <article v-if="consultantNote !== null" class="overflow-hidden rounded-2xl border bg-card">
        <header class="bg-muted/40 px-5 py-3">
            <h3 class="text-sm font-medium text-foreground">Consultant Notes</h3>
        </header>

        <div class="px-5 py-5">
            <p class="text-xs italic text-muted-foreground">
                Add any notes you would like to refer back to. Only you as the consultant will see these notes.
            </p>

            <div v-if="!isEditing" class="relative mt-4 rounded-xl border bg-muted/30 p-4 pr-14">
                <p
                    v-if="trimmedNote !== ''"
                    class="text-sm whitespace-pre-line text-foreground"
                >{{ trimmedNote }}</p>
                <p v-else class="text-sm italic text-muted-foreground">
                    No notes yet. Click the pencil to add one.
                </p>
                <button
                    type="button"
                    class="absolute right-3 bottom-3 inline-flex size-9 items-center justify-center rounded-md bg-slate-700 text-white hover:bg-slate-800 dark:bg-slate-600 dark:hover:bg-slate-500"
                    aria-label="Edit consultant notes"
                    @click="startEditing"
                >
                    <Pencil class="size-4" />
                </button>
            </div>

            <form v-else class="mt-4 space-y-3" @submit.prevent="save">
                <textarea
                    v-model="form.note"
                    rows="6"
                    maxlength="5000"
                    class="w-full rounded-xl border bg-background p-3 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-sky-500"
                    placeholder="Add a note…"
                />
                <p v-if="form.errors.note" class="text-xs text-rose-600">{{ form.errors.note }}</p>
                <div class="flex items-center justify-end gap-2">
                    <button
                        type="button"
                        class="rounded-md px-3 py-1.5 text-sm text-muted-foreground hover:bg-muted/60"
                        :disabled="form.processing"
                        @click="cancelEditing"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="rounded-md bg-slate-700 px-3 py-1.5 text-sm font-medium text-white hover:bg-slate-800 disabled:opacity-50 dark:bg-slate-600 dark:hover:bg-slate-500"
                        :disabled="form.processing"
                    >
                        {{ form.processing ? 'Saving…' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>
    </article>
</template>
