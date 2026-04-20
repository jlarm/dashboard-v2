<script setup lang="ts">
import { ref } from "vue";
import { Form } from "@inertiajs/vue3";
import { Loader2 } from "lucide-vue-next";
import { Button } from "@/components/ui/button";
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
import { Input } from "@/components/ui/input";
import { Checkbox } from "@/components/ui/checkbox";
import { Field, FieldError, FieldLabel } from "@/components/ui/field";
import dealershipRoutes from "@/routes/dealerships";

type Consultant = {
    id: number;
    name: string;
};

defineProps<{
    consultants: Consultant[];
}>();

const open = ref(false);
const selectedConsultantIds = ref<number[]>([]);

function toggleConsultant(id: number): void {
    const idx = selectedConsultantIds.value.indexOf(id);
    if (idx === -1) {
        selectedConsultantIds.value.push(id);
    } else {
        selectedConsultantIds.value.splice(idx, 1);
    }
}

function handleSuccess(): void {
    open.value = false;
    selectedConsultantIds.value = [];
}
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button size="sm">Create Dealership</Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Create Dealership</DialogTitle>
                <DialogDescription>
                    Enter the dealership name, or the group name if there are multiple locations.
                </DialogDescription>
            </DialogHeader>
            <Form
                v-slot="{ errors, processing }"
                :action="dealershipRoutes.store()"
                reset-on-success
                @success="handleSuccess"
                class="space-y-4"
            >
                <!-- Hidden inputs carry selected consultant IDs to the server -->
                <input
                    v-for="id in selectedConsultantIds"
                    :key="id"
                    type="hidden"
                    name="consultant_ids[]"
                    :value="id"
                />

                <Field>
                    <FieldLabel for="dealership-name">Name</FieldLabel>
                    <Input
                        id="dealership-name"
                        name="name"
                        type="text"
                        placeholder="Dealership Name"
                    />
                    <FieldError v-if="errors.name">{{ errors.name }}</FieldError>
                </Field>

                <Field v-if="consultants.length > 0">
                    <FieldLabel>Assign Consultants</FieldLabel>
                    <div class="max-h-40 overflow-y-auto rounded-md border divide-y">
                        <label
                            v-for="consultant in consultants"
                            :key="consultant.id"
                            class="flex cursor-pointer select-none items-center gap-3 px-3 py-2 hover:bg-muted/50"
                        >
                            <Checkbox
                                :model-value="selectedConsultantIds.includes(consultant.id)"
                                @update:model-value="toggleConsultant(consultant.id)"
                            />
                            <span class="text-sm">{{ consultant.name }}</span>
                        </label>
                    </div>
                    <FieldError v-if="errors['consultant_ids']">
                        {{ errors["consultant_ids"] }}
                    </FieldError>
                </Field>

                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Close</Button>
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
