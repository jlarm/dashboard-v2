<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Field, FieldError, FieldLabel } from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import { Trash2 } from "lucide-vue-next";

export type AdditionalLocation = {
    name: string;
    address: string;
    city: string;
    state: string;
    zip: string;
    contact_name: string;
    contact_title: string;
    contact_email: string;
};

const props = defineProps<{
    modelValue: AdditionalLocation[];
    errors?: Record<string, string>;
    disabled?: boolean;
}>();

const emit = defineEmits<{
    (e: "update:modelValue", value: AdditionalLocation[]): void;
}>();

const emptyLocation = (): AdditionalLocation => ({
    name: "",
    address: "",
    city: "",
    state: "",
    zip: "",
    contact_name: "",
    contact_title: "",
    contact_email: "",
});

const addLocation = (): void => {
    emit("update:modelValue", [...props.modelValue, emptyLocation()]);
};

const removeLocation = (index: number): void => {
    const next = props.modelValue.slice();
    next.splice(index, 1);
    emit("update:modelValue", next);
};

const updateField = (index: number, field: keyof AdditionalLocation, value: string): void => {
    const next = props.modelValue.map((loc, i) => (i === index ? { ...loc, [field]: value } : loc));
    emit("update:modelValue", next);
};

const fieldError = (index: number, field: keyof AdditionalLocation): string | undefined =>
    props.errors?.[`additional_locations.${index}.${field}`];
</script>

<template>
    <div class="space-y-6">
        <div v-for="(location, index) in modelValue" :key="index" class="border rounded-md p-4 space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="text-base font-semibold">Additional Location {{ index + 1 }}</h3>
                <Button
                    type="button"
                    variant="ghost"
                    size="sm"
                    :disabled="disabled"
                    @click="removeLocation(index)"
                >
                    <Trash2 class="h-4 w-4 text-red-500" />
                </Button>
            </div>
            <input type="hidden" :name="`additional_locations[${index}][name]`" :value="location.name" />
            <input type="hidden" :name="`additional_locations[${index}][address]`" :value="location.address" />
            <input type="hidden" :name="`additional_locations[${index}][city]`" :value="location.city" />
            <input type="hidden" :name="`additional_locations[${index}][state]`" :value="location.state" />
            <input type="hidden" :name="`additional_locations[${index}][zip]`" :value="location.zip" />
            <input type="hidden" :name="`additional_locations[${index}][contact_name]`" :value="location.contact_name" />
            <input type="hidden" :name="`additional_locations[${index}][contact_title]`" :value="location.contact_title" />
            <input type="hidden" :name="`additional_locations[${index}][contact_email]`" :value="location.contact_email" />

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-6">
                <Field class="sm:col-span-6">
                    <FieldLabel>Dealership Name</FieldLabel>
                    <Input
                        :model-value="location.name"
                        @update:model-value="(v) => updateField(index, 'name', String(v))"
                        :disabled="disabled"
                    />
                    <FieldError v-if="fieldError(index, 'name')">{{ fieldError(index, 'name') }}</FieldError>
                </Field>
                <Field class="sm:col-span-6">
                    <FieldLabel>Address</FieldLabel>
                    <Input
                        :model-value="location.address"
                        @update:model-value="(v) => updateField(index, 'address', String(v))"
                        :disabled="disabled"
                    />
                    <FieldError v-if="fieldError(index, 'address')">{{ fieldError(index, 'address') }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel>City</FieldLabel>
                    <Input
                        :model-value="location.city"
                        @update:model-value="(v) => updateField(index, 'city', String(v))"
                        :disabled="disabled"
                    />
                    <FieldError v-if="fieldError(index, 'city')">{{ fieldError(index, 'city') }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel>State</FieldLabel>
                    <Input
                        :model-value="location.state"
                        @update:model-value="(v) => updateField(index, 'state', String(v))"
                        :disabled="disabled"
                    />
                    <FieldError v-if="fieldError(index, 'state')">{{ fieldError(index, 'state') }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel>Zip</FieldLabel>
                    <Input
                        :model-value="location.zip"
                        @update:model-value="(v) => updateField(index, 'zip', String(v))"
                        :disabled="disabled"
                    />
                    <FieldError v-if="fieldError(index, 'zip')">{{ fieldError(index, 'zip') }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel>Contact Name</FieldLabel>
                    <Input
                        :model-value="location.contact_name"
                        @update:model-value="(v) => updateField(index, 'contact_name', String(v))"
                        :disabled="disabled"
                    />
                    <FieldError v-if="fieldError(index, 'contact_name')">{{ fieldError(index, 'contact_name') }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel>Contact Title</FieldLabel>
                    <Input
                        :model-value="location.contact_title"
                        @update:model-value="(v) => updateField(index, 'contact_title', String(v))"
                        :disabled="disabled"
                    />
                    <FieldError v-if="fieldError(index, 'contact_title')">{{ fieldError(index, 'contact_title') }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel>Contact Email</FieldLabel>
                    <Input
                        type="email"
                        :model-value="location.contact_email"
                        @update:model-value="(v) => updateField(index, 'contact_email', String(v))"
                        :disabled="disabled"
                    />
                    <FieldError v-if="fieldError(index, 'contact_email')">{{ fieldError(index, 'contact_email') }}</FieldError>
                </Field>
            </div>
        </div>
        <Button type="button" variant="outline" :disabled="disabled" @click="addLocation">Add Location</Button>
    </div>
</template>
