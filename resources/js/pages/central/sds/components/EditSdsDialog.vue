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
import SdsController from "@/actions/App/Http/Controllers/Central/SdsController";
import SdsFormFields from "@/pages/central/sds/components/SdsFormFields.vue";

type Sheet = {
    uuid: string;
    name: string;
    manufacturer: string | null;
    keywords: string[];
    file_name: string | null;
};

const props = defineProps<{
    sheet: Sheet;
}>();

const open = ref(false);

const initial = {
    name: props.sheet.name,
    manufacturer: props.sheet.manufacturer ?? "",
    keywords: props.sheet.keywords,
    file_name: props.sheet.file_name,
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
                <DialogTitle>Edit SDS Sheet</DialogTitle>
            </DialogHeader>
            <Form
                v-slot="{ errors, processing }"
                :action="SdsController.update({ sds: sheet.uuid })"
                enctype="multipart/form-data"
                @success="handleSuccess"
                class="space-y-6"
            >
                <SdsFormFields :initial="initial" :errors="errors" />
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
