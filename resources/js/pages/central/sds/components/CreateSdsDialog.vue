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

const open = ref(false);

const initial = {
    name: "",
    manufacturer: "",
    keywords: [] as string[],
    file_name: null,
};

const handleSuccess = (): void => {
    open.value = false;
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button size="sm">Add SDS Sheet</Button>
        </DialogTrigger>
        <DialogContent class="max-h-[90vh] overflow-y-auto sm:max-w-xl">
            <DialogHeader>
                <DialogTitle>Add SDS Sheet</DialogTitle>
            </DialogHeader>
            <Form
                v-slot="{ errors, processing }"
                :action="SdsController.store()"
                enctype="multipart/form-data"
                reset-on-success
                @success="handleSuccess"
                class="space-y-6"
            >
                <SdsFormFields :initial="initial" :errors="errors" require-file />
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
