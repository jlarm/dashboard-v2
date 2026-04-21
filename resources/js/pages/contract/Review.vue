<script setup lang="ts">
import { ref } from "vue";
import { Head, Form } from "@inertiajs/vue3";
import AppLogo from "@/components/AppLogo.vue";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Field, FieldError, FieldLabel } from "@/components/ui/field";
import SignaturePad from "@/pages/central/contract/components/SignaturePad.vue";
import AdditionalLocationsRepeater, {
    type AdditionalLocation,
} from "@/pages/central/contract/components/AdditionalLocationsRepeater.vue";
import { Loader2 } from "lucide-vue-next";

type ServiceLabel = { value: string; label: string };

type ReviewContract = {
    uuid: string;
    dealer_name: string;
    contract_type: string;
    agreement_date: string | null;
    agreement_date_day: string | null;
    agreement_date_month: string | null;
    agreement_date_year: string | null;
    commence_date_formatted: string | null;
    yearly_inspection_total: number | string;
    initial_fee: number | string;
    monthly_fee: number | string;
    services: ServiceLabel[];
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
    contract: ReviewContract;
    signed_action_url: string;
}>();

const dealerSignature = ref("");
const additionalLocations = ref<AdditionalLocation[]>([...props.contract.additional_locations]);
</script>

<template>
    <Head title="Contract Review" />
    <div class="bg-background min-h-screen p-5">
        <div class="max-w-6xl mx-auto">
            <AppLogo class="h-10 w-auto my-10" />

            <article class="prose prose-sm max-w-none">
                <p>
                    This Agreement dated this <strong>{{ contract.agreement_date_day }}</strong> day of
                    <strong>{{ contract.agreement_date_month }}</strong>, <strong>{{ contract.agreement_date_year }}</strong>,
                    is entered into by and between AUTOMOTIVE RISK MANAGEMENT PARTNERS INC., 60-B Terra Cotta Avenue,
                    Suite 159, Crystal Lake, Illinois 60014 (hereinafter referred to as "ARMP"), and
                    <strong>{{ contract.dealer_name }}</strong> (hereinafter referred to as "DEALER").
                </p>
                <p>DEALER owns and operates an automobile dealership for the sale of new and used automobiles.</p>
                <p>
                    ARMP provides consulting services to assist automobile dealers in their compliance with
                    Gramm, Leach, Bliley Act ("GLB"), Patriot Act, Safeguards Rule, OSHA, Red Flags Rule,
                    F&amp;I Compliance, and related Federal and State Government regulations, contained in ARMP's
                    "Compliance Solved" program.
                </p>
                <p>DEALER has requested the following compliance services from ARMP:</p>
                <ul>
                    <li v-for="service in contract.services" :key="service.value">{{ service.label }}</li>
                </ul>
                <p>
                    The parties agree that ARMP will provide its services to DEALER commencing
                    <strong>{{ contract.commence_date_formatted }}</strong>, for a period of twelve (12) months from
                    the date of this contract.
                </p>
                <p>
                    During each 12-month period of the contract ARMP will conduct
                    <strong>{{ contract.yearly_inspection_total }}</strong> on-site inspections, audits, and review
                    sessions with management.
                </p>
                <p>
                    DEALER agrees to pay an initial fee of <strong>${{ contract.initial_fee }}</strong> upon execution
                    and a monthly fee of <strong>${{ contract.monthly_fee }}</strong> due on the first day of each
                    month that the Agreement is in effect.
                </p>
                <p>
                    The Agreement shall renew at the end of the initial term, and shall thereafter continue for
                    successive {{ contract.contract_type === 'yearly' ? 'annual periods' : 'month to month' }} until
                    terminated by either party upon not less than sixty days written notice.
                </p>
                <p>
                    By signing below, the DEALER and ARMP each accept and agree to the terms and conditions set forth
                    in this agreement.
                </p>
            </article>

            <Form
                v-slot="{ errors, processing }"
                :action="signed_action_url"
                method="post"
                class="mt-10 space-y-10"
            >
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div>
                        <h2 class="text-base font-semibold mb-4 text-primary">Dealership Physical Address</h2>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                            <Field class="sm:col-span-6">
                                <FieldLabel for="dealer_physical_address">Address *</FieldLabel>
                                <Input id="dealer_physical_address" name="dealer_physical_address" :default-value="contract.dealer_physical_address ?? ''" />
                                <FieldError v-if="errors.dealer_physical_address">{{ errors.dealer_physical_address }}</FieldError>
                            </Field>
                            <Field class="sm:col-span-2">
                                <FieldLabel for="dealer_physical_city">City *</FieldLabel>
                                <Input id="dealer_physical_city" name="dealer_physical_city" :default-value="contract.dealer_physical_city ?? ''" />
                                <FieldError v-if="errors.dealer_physical_city">{{ errors.dealer_physical_city }}</FieldError>
                            </Field>
                            <Field class="sm:col-span-2">
                                <FieldLabel for="dealer_physical_state">State *</FieldLabel>
                                <Input id="dealer_physical_state" name="dealer_physical_state" :default-value="contract.dealer_physical_state ?? ''" />
                                <FieldError v-if="errors.dealer_physical_state">{{ errors.dealer_physical_state }}</FieldError>
                            </Field>
                            <Field class="sm:col-span-2">
                                <FieldLabel for="dealer_physical_zip">Zip *</FieldLabel>
                                <Input id="dealer_physical_zip" name="dealer_physical_zip" :default-value="contract.dealer_physical_zip ?? ''" />
                                <FieldError v-if="errors.dealer_physical_zip">{{ errors.dealer_physical_zip }}</FieldError>
                            </Field>
                            <Field class="sm:col-span-6">
                                <FieldLabel for="dealer_phone">Phone Number *</FieldLabel>
                                <Input id="dealer_phone" name="dealer_phone" type="tel" :default-value="contract.dealer_phone ?? ''" />
                                <FieldError v-if="errors.dealer_phone">{{ errors.dealer_phone }}</FieldError>
                            </Field>
                            <Field class="sm:col-span-3">
                                <FieldLabel for="dealer_qi_name">Qualified Individual Name *</FieldLabel>
                                <Input id="dealer_qi_name" name="dealer_qi_name" :default-value="contract.dealer_qi_name ?? ''" />
                                <FieldError v-if="errors.dealer_qi_name">{{ errors.dealer_qi_name }}</FieldError>
                            </Field>
                            <Field class="sm:col-span-3">
                                <FieldLabel for="dealer_qi_email">Qualified Individual Email *</FieldLabel>
                                <Input id="dealer_qi_email" name="dealer_qi_email" type="email" :default-value="contract.dealer_qi_email ?? ''" />
                                <FieldError v-if="errors.dealer_qi_email">{{ errors.dealer_qi_email }}</FieldError>
                            </Field>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-base font-semibold mb-4 text-primary">Dealership Billing Address</h2>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                            <Field class="sm:col-span-6">
                                <FieldLabel for="dealer_billing_address">Address *</FieldLabel>
                                <Input id="dealer_billing_address" name="dealer_billing_address" :default-value="contract.dealer_billing_address ?? ''" />
                                <FieldError v-if="errors.dealer_billing_address">{{ errors.dealer_billing_address }}</FieldError>
                            </Field>
                            <Field class="sm:col-span-2">
                                <FieldLabel for="dealer_billing_city">City *</FieldLabel>
                                <Input id="dealer_billing_city" name="dealer_billing_city" :default-value="contract.dealer_billing_city ?? ''" />
                                <FieldError v-if="errors.dealer_billing_city">{{ errors.dealer_billing_city }}</FieldError>
                            </Field>
                            <Field class="sm:col-span-2">
                                <FieldLabel for="dealer_billing_state">State *</FieldLabel>
                                <Input id="dealer_billing_state" name="dealer_billing_state" :default-value="contract.dealer_billing_state ?? ''" />
                                <FieldError v-if="errors.dealer_billing_state">{{ errors.dealer_billing_state }}</FieldError>
                            </Field>
                            <Field class="sm:col-span-2">
                                <FieldLabel for="dealer_billing_zip">Zip *</FieldLabel>
                                <Input id="dealer_billing_zip" name="dealer_billing_zip" :default-value="contract.dealer_billing_zip ?? ''" />
                                <FieldError v-if="errors.dealer_billing_zip">{{ errors.dealer_billing_zip }}</FieldError>
                            </Field>
                            <Field class="sm:col-span-6">
                                <FieldLabel for="dealer_billing_fax">Fax Number</FieldLabel>
                                <Input id="dealer_billing_fax" name="dealer_billing_fax" :default-value="contract.dealer_billing_fax ?? ''" />
                                <FieldError v-if="errors.dealer_billing_fax">{{ errors.dealer_billing_fax }}</FieldError>
                            </Field>
                            <Field class="sm:col-span-2">
                                <FieldLabel for="dealer_billing_contact_name">Contact Name *</FieldLabel>
                                <Input id="dealer_billing_contact_name" name="dealer_billing_contact_name" :default-value="contract.dealer_billing_contact_name ?? ''" />
                                <FieldError v-if="errors.dealer_billing_contact_name">{{ errors.dealer_billing_contact_name }}</FieldError>
                            </Field>
                            <Field class="sm:col-span-2">
                                <FieldLabel for="dealer_billing_contact_title">Contact Title *</FieldLabel>
                                <Input id="dealer_billing_contact_title" name="dealer_billing_contact_title" :default-value="contract.dealer_billing_contact_title ?? ''" />
                                <FieldError v-if="errors.dealer_billing_contact_title">{{ errors.dealer_billing_contact_title }}</FieldError>
                            </Field>
                            <Field class="sm:col-span-2">
                                <FieldLabel for="dealer_billing_contact_email">Contact Email *</FieldLabel>
                                <Input id="dealer_billing_contact_email" name="dealer_billing_contact_email" type="email" :default-value="contract.dealer_billing_contact_email ?? ''" />
                                <FieldError v-if="errors.dealer_billing_contact_email">{{ errors.dealer_billing_contact_email }}</FieldError>
                            </Field>
                        </div>
                    </div>
                </div>

                <div v-if="additionalLocations.length > 0">
                    <h2 class="text-base font-semibold mb-4 text-primary">Additional Locations</h2>
                    <AdditionalLocationsRepeater v-model="additionalLocations" :errors="errors" />
                </div>

                <div class="max-w-lg space-y-6 pt-6 border-t">
                    <Field>
                        <FieldLabel for="dealer_printed_name">Name *</FieldLabel>
                        <Input id="dealer_printed_name" name="dealer_printed_name" />
                        <FieldError v-if="errors.dealer_printed_name">{{ errors.dealer_printed_name }}</FieldError>
                    </Field>
                    <div>
                        <p class="text-sm font-medium mb-2">Signature *</p>
                        <SignaturePad v-model="dealerSignature" name="dealer_signature" />
                        <FieldError v-if="errors.dealer_signature">{{ errors.dealer_signature }}</FieldError>
                    </div>
                    <p class="italic text-red-500 text-sm">
                        * Please make sure all information has been filled out and is correct prior to submitting.
                    </p>
                    <Button type="submit" :disabled="processing || !dealerSignature">
                        <Loader2 v-if="processing" class="animate-spin" />
                        Submit
                    </Button>
                </div>
            </Form>
        </div>
    </div>
</template>
