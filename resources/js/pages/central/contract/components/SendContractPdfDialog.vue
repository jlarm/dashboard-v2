<script setup lang="ts">
import { ref } from "vue";
import { Form } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Field, FieldError, FieldLabel } from "@/components/ui/field";
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import ContractSendController from "@/actions/App/Http/Controllers/Central/ContractSendController";
import { Loader2 } from "lucide-vue-next";

const props = defineProps<{
    contract: { uuid: string };
}>();

const open = ref(false);

const handleSuccess = (): void => {
    open.value = false;
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button variant="outline" class="w-full">Send Signed PDF</Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Send Signed Contract PDF</DialogTitle>
                <DialogDescription>Email the signed PDF to the dealer.</DialogDescription>
            </DialogHeader>
            <Form
                v-slot="{ errors, processing }"
                :action="ContractSendController.pdf(props.contract.uuid)"
                reset-on-success
                @success="handleSuccess"
                class="space-y-4"
            >
                <Field>
                    <FieldLabel for="email">Email Address</FieldLabel>
                    <Input id="email" name="email" type="email" placeholder="dealer@example.com" />
                    <FieldError v-if="errors.email">{{ errors.email }}</FieldError>
                </Field>
                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Close</Button>
                    </DialogClose>
                    <Button type="submit" :disabled="processing">
                        <Loader2 v-if="processing" class="animate-spin" />
                        Send
                    </Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
