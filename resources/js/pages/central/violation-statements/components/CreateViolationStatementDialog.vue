<script setup lang="ts">
import { ref } from "vue";
import { Form } from "@inertiajs/vue3";
import { Loader2 } from "lucide-vue-next";
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";
import ViolationStatementController from "@/actions/App/Http/Controllers/Central/ViolationStatementController";
import ViolationStatementForm from "@/pages/central/violation-statements/components/ViolationStatementForm.vue";

type CategoryOption = { value: string; label: string };

defineProps<{ categories: CategoryOption[] }>();

const open = ref(false);

const initial = {
    statement: "",
    weight: "" as number | string,
    categories: [] as string[],
    keywords: [] as string[],
    reference_image_url: null,
};

const handleSuccess = (): void => {
    open.value = false;
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button size="sm">New Statement</Button>
        </DialogTrigger>
        <DialogContent class="max-h-[90vh] overflow-y-auto sm:max-w-xl">
            <DialogHeader>
                <DialogTitle>New Violation Statement</DialogTitle>
            </DialogHeader>
            <Form
                v-slot="{ errors, processing }"
                :action="ViolationStatementController.store()"
                enctype="multipart/form-data"
                reset-on-success
                @success="handleSuccess"
                class="space-y-6"
            >
                <ViolationStatementForm
                    :initial="initial"
                    :categories="categories"
                    :errors="errors"
                />
                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button type="submit" :disabled="processing">
                        <Loader2 v-if="processing" class="animate-spin" />
                        Create
                    </Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
