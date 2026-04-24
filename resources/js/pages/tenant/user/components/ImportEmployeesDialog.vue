<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import employees from '@/routes/dealer/employees';
import { useForm, usePage } from '@inertiajs/vue3';
import { Download } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

type ImportErrorRow = {
    row: number;
    errors: string[];
    values: Record<string, unknown>;
};

const open = defineModel<boolean>('open', { required: true });

const page = usePage<{ flash?: { import_errors?: ImportErrorRow[] } }>();

const fileInput = ref<HTMLInputElement | null>(null);

const form = useForm<{ spreadsheet: File | null }>({
    spreadsheet: null,
});

const importErrors = computed<ImportErrorRow[]>(
    () => page.props.flash?.import_errors ?? [],
);

watch(open, (isOpen) => {
    if (isOpen) {
        form.reset();
        form.clearErrors();
    }
});

const onFileChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    form.spreadsheet = target.files?.[0] ?? null;
};

const submit = () => {
    form.post(employees.import.url(), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            open.value = false;
            if (fileInput.value) {
                fileInput.value.value = '';
            }
        },
    });
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogContent class="sm:max-w-lg">
            <DialogHeader>
                <DialogTitle>Import Employees</DialogTitle>
                <DialogDescription>
                    Upload a JSON file to invite employees in bulk.
                </DialogDescription>
                <a
                    href="/templates/employees-import-template.json"
                    download="employees-import-template.json"
                    class="mt-1 inline-flex w-fit items-center gap-1 text-sm text-primary underline-offset-2 hover:underline"
                >
                    <Download class="size-3.5" />
                    Download template
                </a>
            </DialogHeader>

            <form class="space-y-4" @submit.prevent="submit">
                <div class="space-y-2">
                    <Label for="spreadsheet">Employees file</Label>
                    <input
                        id="spreadsheet"
                        ref="fileInput"
                        type="file"
                        accept=".json,application/json"
                        class="block w-full rounded-md border border-input bg-background text-sm file:mr-3 file:border-0 file:bg-muted file:px-3 file:py-2 file:text-sm file:font-medium"
                        @change="onFileChange"
                    />
                    <p class="text-xs text-muted-foreground">Must be a .json file (max 10 MB).</p>
                    <p v-if="form.errors.spreadsheet" class="text-sm text-red-600">
                        {{ form.errors.spreadsheet }}
                    </p>
                </div>

                <div
                    v-if="importErrors.length > 0"
                    class="space-y-2 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-800"
                >
                    <p class="font-medium">Import errors</p>
                    <ul class="space-y-2">
                        <li
                            v-for="(error, index) in importErrors"
                            :key="index"
                            class="rounded border border-red-200 bg-white p-2 text-xs"
                        >
                            <p class="font-medium">Row {{ error.row }}</p>
                            <p>{{ error.errors.join(', ') }}</p>
                            <pre class="mt-1 whitespace-pre-wrap break-all text-[11px] text-red-900/80">{{ JSON.stringify(error.values) }}</pre>
                        </li>
                    </ul>
                </div>

                <DialogFooter>
                    <Button type="button" variant="outline" :disabled="form.processing" @click="open = false">
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing || !form.spreadsheet">
                        {{ form.processing ? 'Importing...' : 'Submit' }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
