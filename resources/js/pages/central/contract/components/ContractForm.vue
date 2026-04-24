<script setup lang="ts">
import { ref, watch } from "vue";
import { Field, FieldError, FieldLabel } from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import { Checkbox } from "@/components/ui/checkbox";
import DatePicker from "@/components/DatePicker.vue";
import AdditionalLocationsRepeater, {
    type AdditionalLocation,
} from "@/pages/central/contract/components/AdditionalLocationsRepeater.vue";

type ServiceOption = { value: string; label: string };
type Consultant = { id: number; name: string };

type ContractFormValues = {
    user_id: number | null;
    contract_type: string;
    dealer_name: string;
    agreement_date: string;
    commence_date: string;
    yearly_inspection_total: number | string;
    initial_fee: number | string;
    monthly_fee: number | string;
    services: string[];
    dealer_physical_address: string | null;
    dealer_physical_city: string | null;
    dealer_physical_state: string | null;
    dealer_physical_zip: string | null;
    dealer_phone: string | null;
    dealer_qi_name: string | null;
    dealer_qi_email: string | null;
    dealer_billing_address: string | null;
    dealer_billing_city: string | null;
    dealer_billing_state: string | null;
    dealer_billing_zip: string | null;
    dealer_billing_fax: string | null;
    dealer_billing_contact_name: string | null;
    dealer_billing_contact_title: string | null;
    dealer_billing_contact_email: string | null;
    additional_locations: AdditionalLocation[];
};

const props = defineProps<{
    initial: ContractFormValues;
    services: ServiceOption[];
    consultants?: Consultant[];
    errors?: Record<string, string>;
    processing?: boolean;
    disabled?: boolean;
    showConsultant?: boolean;
}>();

const selectedServices = ref<string[]>([...props.initial.services]);
const additionalLocations = ref<AdditionalLocation[]>([...props.initial.additional_locations]);
const agreementDate = ref<string | null>(props.initial.agreement_date || null);
const commenceDate = ref<string | null>(props.initial.commence_date || null);

watch(
    () => props.initial.services,
    (next) => {
        selectedServices.value = [...next];
    },
);

watch(
    () => props.initial.additional_locations,
    (next) => {
        additionalLocations.value = [...next];
    },
);

watch(
    () => props.initial.agreement_date,
    (next) => {
        agreementDate.value = next || null;
    },
);

watch(
    () => props.initial.commence_date,
    (next) => {
        commenceDate.value = next || null;
    },
);

const toggleService = (value: string): void => {
    const idx = selectedServices.value.indexOf(value);
    if (idx === -1) {
        selectedServices.value.push(value);
    } else {
        selectedServices.value.splice(idx, 1);
    }
};
</script>

<template>
    <div class="space-y-10">
        <input
            v-for="service in selectedServices"
            :key="service"
            type="hidden"
            name="services[]"
            :value="service"
        />

        <Field v-if="showConsultant && consultants">
            <FieldLabel for="user_id">Consultant</FieldLabel>
            <select
                id="user_id"
                name="user_id"
                :value="initial.user_id ?? ''"
                :disabled="disabled"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs disabled:cursor-not-allowed disabled:opacity-50"
            >
                <option value="">—</option>
                <option v-for="c in consultants" :key="c.id" :value="c.id">{{ c.name }}</option>
            </select>
            <FieldError v-if="errors?.user_id">{{ errors.user_id }}</FieldError>
        </Field>

        <Field>
            <FieldLabel for="contract_type">Contract Type *</FieldLabel>
            <select
                id="contract_type"
                name="contract_type"
                :value="initial.contract_type"
                :disabled="disabled"
                class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-xs disabled:cursor-not-allowed disabled:opacity-50"
            >
                <option value=""></option>
                <option value="yearly">Yearly</option>
                <option value="monthly">Month to Month</option>
            </select>
            <FieldError v-if="errors?.contract_type">{{ errors.contract_type }}</FieldError>
        </Field>

        <div class="border-b pb-10 grid grid-cols-1 gap-6 sm:grid-cols-6">
            <Field class="sm:col-span-6">
                <FieldLabel for="dealer_name">Dealership Name *</FieldLabel>
                <Input id="dealer_name" name="dealer_name" :default-value="initial.dealer_name" :disabled="disabled" />
                <FieldError v-if="errors?.dealer_name">{{ errors.dealer_name }}</FieldError>
            </Field>

            <Field class="sm:col-span-3">
                <FieldLabel for="agreement_date">Agreement Date *</FieldLabel>
                <DatePicker
                    id="agreement_date"
                    name="agreement_date"
                    v-model="agreementDate"
                    :disabled="disabled"
                />
                <FieldError v-if="errors?.agreement_date">{{ errors.agreement_date }}</FieldError>
            </Field>

            <Field class="sm:col-span-3">
                <FieldLabel for="commence_date">Commencement Date *</FieldLabel>
                <DatePicker
                    id="commence_date"
                    name="commence_date"
                    v-model="commenceDate"
                    :disabled="disabled"
                />
                <FieldError v-if="errors?.commence_date">{{ errors.commence_date }}</FieldError>
            </Field>

            <Field class="sm:col-span-6">
                <FieldLabel for="yearly_inspection_total">Total Number of Yearly Inspections *</FieldLabel>
                <Input id="yearly_inspection_total" name="yearly_inspection_total" type="number" :default-value="initial.yearly_inspection_total" :disabled="disabled" />
                <FieldError v-if="errors?.yearly_inspection_total">{{ errors.yearly_inspection_total }}</FieldError>
            </Field>

            <Field class="sm:col-span-3">
                <FieldLabel for="initial_fee">Initial Fee *</FieldLabel>
                <Input id="initial_fee" name="initial_fee" type="number" step="0.01" :default-value="initial.initial_fee" :disabled="disabled" />
                <FieldError v-if="errors?.initial_fee">{{ errors.initial_fee }}</FieldError>
            </Field>

            <Field class="sm:col-span-3">
                <FieldLabel for="monthly_fee">Monthly Fee *</FieldLabel>
                <Input id="monthly_fee" name="monthly_fee" type="number" step="0.01" :default-value="initial.monthly_fee" :disabled="disabled" />
                <FieldError v-if="errors?.monthly_fee">{{ errors.monthly_fee }}</FieldError>
            </Field>

            <div class="sm:col-span-6">
                <p class="text-sm font-medium mb-3">Services *</p>
                <div class="space-y-2">
                    <label v-for="service in services" :key="service.value" class="flex items-center gap-2">
                        <Checkbox
                            :model-value="selectedServices.includes(service.value)"
                            :disabled="disabled"
                            @update:model-value="() => toggleService(service.value)"
                        />
                        <span class="text-sm">{{ service.label }}</span>
                    </label>
                </div>
                <FieldError v-if="errors?.services">{{ errors.services }}</FieldError>
            </div>
        </div>

        <div class="border-b pb-10">
            <h2 class="text-base font-semibold leading-7 mb-4">Dealership Physical Address</h2>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                <Field class="sm:col-span-6">
                    <FieldLabel for="dealer_physical_address">Address</FieldLabel>
                    <Input id="dealer_physical_address" name="dealer_physical_address" :default-value="initial.dealer_physical_address ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_physical_address">{{ errors.dealer_physical_address }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel for="dealer_physical_city">City</FieldLabel>
                    <Input id="dealer_physical_city" name="dealer_physical_city" :default-value="initial.dealer_physical_city ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_physical_city">{{ errors.dealer_physical_city }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel for="dealer_physical_state">State</FieldLabel>
                    <Input id="dealer_physical_state" name="dealer_physical_state" :default-value="initial.dealer_physical_state ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_physical_state">{{ errors.dealer_physical_state }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel for="dealer_physical_zip">Zip Code</FieldLabel>
                    <Input id="dealer_physical_zip" name="dealer_physical_zip" :default-value="initial.dealer_physical_zip ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_physical_zip">{{ errors.dealer_physical_zip }}</FieldError>
                </Field>
                <Field class="sm:col-span-6">
                    <FieldLabel for="dealer_phone">Phone Number</FieldLabel>
                    <Input id="dealer_phone" name="dealer_phone" type="tel" :default-value="initial.dealer_phone ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_phone">{{ errors.dealer_phone }}</FieldError>
                </Field>
                <Field class="sm:col-span-3">
                    <FieldLabel for="dealer_qi_name">Qualified Individual Name</FieldLabel>
                    <Input id="dealer_qi_name" name="dealer_qi_name" :default-value="initial.dealer_qi_name ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_qi_name">{{ errors.dealer_qi_name }}</FieldError>
                </Field>
                <Field class="sm:col-span-3">
                    <FieldLabel for="dealer_qi_email">Qualified Individual Email</FieldLabel>
                    <Input id="dealer_qi_email" name="dealer_qi_email" type="email" :default-value="initial.dealer_qi_email ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_qi_email">{{ errors.dealer_qi_email }}</FieldError>
                </Field>
            </div>
        </div>

        <div class="border-b pb-10">
            <h2 class="text-base font-semibold leading-7 mb-4">Additional Locations</h2>
            <AdditionalLocationsRepeater v-model="additionalLocations" :errors="errors" :disabled="disabled" />
        </div>

        <div>
            <h2 class="text-base font-semibold leading-7 mb-4">Dealership Billing Address</h2>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                <Field class="sm:col-span-6">
                    <FieldLabel for="dealer_billing_address">Address</FieldLabel>
                    <Input id="dealer_billing_address" name="dealer_billing_address" :default-value="initial.dealer_billing_address ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_billing_address">{{ errors.dealer_billing_address }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel for="dealer_billing_city">City</FieldLabel>
                    <Input id="dealer_billing_city" name="dealer_billing_city" :default-value="initial.dealer_billing_city ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_billing_city">{{ errors.dealer_billing_city }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel for="dealer_billing_state">State</FieldLabel>
                    <Input id="dealer_billing_state" name="dealer_billing_state" :default-value="initial.dealer_billing_state ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_billing_state">{{ errors.dealer_billing_state }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel for="dealer_billing_zip">Zip Code</FieldLabel>
                    <Input id="dealer_billing_zip" name="dealer_billing_zip" :default-value="initial.dealer_billing_zip ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_billing_zip">{{ errors.dealer_billing_zip }}</FieldError>
                </Field>
                <Field class="sm:col-span-6">
                    <FieldLabel for="dealer_billing_fax">Fax Number</FieldLabel>
                    <Input id="dealer_billing_fax" name="dealer_billing_fax" :default-value="initial.dealer_billing_fax ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_billing_fax">{{ errors.dealer_billing_fax }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel for="dealer_billing_contact_name">Other Contact Name</FieldLabel>
                    <Input id="dealer_billing_contact_name" name="dealer_billing_contact_name" :default-value="initial.dealer_billing_contact_name ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_billing_contact_name">{{ errors.dealer_billing_contact_name }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel for="dealer_billing_contact_title">Other Contact Title</FieldLabel>
                    <Input id="dealer_billing_contact_title" name="dealer_billing_contact_title" :default-value="initial.dealer_billing_contact_title ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_billing_contact_title">{{ errors.dealer_billing_contact_title }}</FieldError>
                </Field>
                <Field class="sm:col-span-2">
                    <FieldLabel for="dealer_billing_contact_email">Other Contact Email</FieldLabel>
                    <Input id="dealer_billing_contact_email" name="dealer_billing_contact_email" type="email" :default-value="initial.dealer_billing_contact_email ?? ''" :disabled="disabled" />
                    <FieldError v-if="errors?.dealer_billing_contact_email">{{ errors.dealer_billing_contact_email }}</FieldError>
                </Field>
            </div>
        </div>
    </div>
</template>
