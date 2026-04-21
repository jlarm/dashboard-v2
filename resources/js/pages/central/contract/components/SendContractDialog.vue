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
import { Loader2, Plus, X } from "lucide-vue-next";

const props = defineProps<{
    contract: { uuid: string };
}>();

const open = ref(false);
const emails = ref<string[]>([]);
const currentEmail = ref("");
const inlineError = ref<string | null>(null);

const addEmail = (): void => {
    const value = currentEmail.value.trim().toLowerCase();
    if (!value) {
        inlineError.value = "Please enter an email address.";
        return;
    }
    if (!/^\S+@\S+\.\S+$/.test(value)) {
        inlineError.value = "That does not look like a valid email address.";
        return;
    }
    if (emails.value.includes(value)) {
        inlineError.value = "That email address is already in the list.";
        return;
    }
    emails.value.push(value);
    currentEmail.value = "";
    inlineError.value = null;
};

const removeEmail = (index: number): void => {
    emails.value.splice(index, 1);
};

const handleSuccess = (): void => {
    emails.value = [];
    currentEmail.value = "";
    open.value = false;
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button class="w-full">Send for Review</Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Send Contract for Review</DialogTitle>
                <DialogDescription>
                    Add one or more dealer email addresses to receive the signed-URL review link.
                </DialogDescription>
            </DialogHeader>
            <div class="space-y-3">
                <Field>
                    <FieldLabel for="email">Email Address</FieldLabel>
                    <div class="flex gap-2">
                        <Input
                            id="email"
                            type="email"
                            v-model="currentEmail"
                            placeholder="dealer@example.com"
                            @keyup.enter.prevent="addEmail"
                        />
                        <Button type="button" variant="secondary" @click="addEmail">
                            <Plus class="h-4 w-4" />
                        </Button>
                    </div>
                    <FieldError v-if="inlineError">{{ inlineError }}</FieldError>
                </Field>
                <ul v-if="emails.length" class="divide-y rounded-md border">
                    <li
                        v-for="(email, index) in emails"
                        :key="email"
                        class="flex items-center justify-between px-3 py-2 text-sm"
                    >
                        <span>{{ email }}</span>
                        <Button type="button" size="sm" variant="ghost" @click="removeEmail(index)">
                            <X class="h-4 w-4" />
                        </Button>
                    </li>
                </ul>
            </div>
            <Form
                v-slot="{ errors, processing }"
                :action="ContractSendController.review(props.contract.uuid)"
                @success="handleSuccess"
            >
                <input v-for="email in emails" :key="email" type="hidden" name="emails[]" :value="email" />
                <FieldError v-if="errors.emails">{{ errors.emails }}</FieldError>
                <DialogFooter class="mt-4">
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Close</Button>
                    </DialogClose>
                    <Button type="submit" :disabled="processing || emails.length === 0">
                        <Loader2 v-if="processing" class="animate-spin" />
                        Send
                    </Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
