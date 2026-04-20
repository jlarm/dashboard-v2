<script setup lang="ts">
import { Form } from "@inertiajs/vue3";
import { ref } from "vue";
import { Loader2 } from "lucide-vue-next";
import { Button } from "@/components/ui/button";
import {
    Field,
    FieldError,
    FieldLabel,
} from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import {
    Dialog,
    DialogClose,
    DialogContent, DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import invites from "@/routes/employees/invites";

const open = ref(false);

const handleSuccess = (): void => {
    open.value = false;
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button size="sm">Invite Employee</Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Invite Employee</DialogTitle>
                <DialogDescription>The invited user will register as a Consultant.</DialogDescription>
            </DialogHeader>
            <Form
                v-slot="{ errors, processing }"
                :action="invites.store()"
                reset-on-success
                @success="handleSuccess"
                class="space-y-5"
            >
                <Field>
                    <FieldLabel for="invite-name">Name</FieldLabel>
                    <Input
                        id="invite-name"
                        name="name"
                        type="text"
                        placeholder="Name"
                    />
                    <FieldError v-if="errors.name">{{
                            errors.name
                        }}</FieldError>
                </Field>
                <Field>
                    <FieldLabel for="invite-email">Email</FieldLabel>
                    <Input
                        id="invite-email"
                        name="email"
                        type="email"
                        placeholder="Email"
                    />
                    <FieldError v-if="errors.email">{{
                            errors.email
                        }}</FieldError>
                </Field>
                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Close</Button>
                    </DialogClose>
                    <Button type="submit" :disabled="processing">
                        <Loader2 v-if="processing" class="animate-spin" />
                        Invite
                    </Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
