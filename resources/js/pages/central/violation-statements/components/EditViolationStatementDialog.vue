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

type Statement = {
    id: number;
    statement: string;
    weight: number;
    categories: string[];
    keywords: string[];
    reference_image_url: string | null;
};

const props = defineProps<{
    statement: Statement;
    categories: CategoryOption[];
}>();

const open = ref(false);

const initial = {
    statement: props.statement.statement,
    weight: props.statement.weight,
    categories: props.statement.categories,
    keywords: props.statement.keywords,
    reference_image_url: props.statement.reference_image_url,
};

const handleSuccess = (): void => {
    open.value = false;
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>
        <DialogContent class="max-h-[90vh] overflow-y-auto sm:max-w-xl">
            <DialogHeader>
                <DialogTitle>Edit Violation Statement</DialogTitle>
            </DialogHeader>
            <Form
                v-slot="{ errors, processing }"
                :action="ViolationStatementController.update({ violationStatement: statement.id })"
                enctype="multipart/form-data"
                @success="handleSuccess"
                class="space-y-6"
            >
                <ViolationStatementForm
                    :initial="initial"
                    :categories="categories"
                    :errors="errors"
                    allow-image-removal
                />
                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button type="submit" :disabled="processing">
                        <Loader2 v-if="processing" class="animate-spin" />
                        Save
                    </Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
