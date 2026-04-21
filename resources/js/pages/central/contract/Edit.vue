<script setup lang="ts">
import { computed, ref } from "vue";
import { Head, Form, Link } from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import type { BreadcrumbItem } from "@/types";
import contractRoutes from "@/routes/contracts";
import ContractController from "@/actions/App/Http/Controllers/Central/ContractController";
import ContractPdfController from "@/actions/App/Http/Controllers/Central/ContractPdfController";
import ContractForm from "@/pages/central/contract/components/ContractForm.vue";
import ContractActivity from "@/pages/central/contract/components/ContractActivity.vue";
import ContractChecklist from "@/pages/central/contract/components/ContractChecklist.vue";
import SignaturePad from "@/pages/central/contract/components/SignaturePad.vue";
import SendContractDialog from "@/pages/central/contract/components/SendContractDialog.vue";
import SendContractPdfDialog from "@/pages/central/contract/components/SendContractPdfDialog.vue";
import type { AdditionalLocation } from "@/pages/central/contract/components/AdditionalLocationsRepeater.vue";
import { Button } from "@/components/ui/button";
import { Field, FieldError, FieldLabel } from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import { Loader2, Download } from "lucide-vue-next";

type ServiceOption = { value: string; label: string };
type Consultant = { id: number; name: string };

type ContractStatusEntry = {
    id: number;
    name: string;
    status: string;
    step: number | null;
    created_at_for_humans?: string;
};

type Contract = {
    id: number;
    uuid: string;
    user_id: number | null;
    contract_type: string;
    agreement_date: string | null;
    commence_date: string | null;
    dealer_name: string;
    services: string[];
    yearly_inspection_total: number | string;
    initial_fee: number | string;
    monthly_fee: number | string;
    armp_signature: string | null;
    armp_printed_name: string | null;
    armp_date_signed: string | null;
    dealer_signature: string | null;
    dealer_printed_name: string | null;
    dealer_date_signed: string | null;
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
    pdf_path: string | null;
    progress_steps: number[];
    status: ContractStatusEntry[];
};

const props = defineProps<{
    contract: Contract;
    consultants: Consultant[];
    services: ServiceOption[];
    armp_signature_url: string | null;
    can: {
        update: boolean;
        delete: boolean;
        sendForReview: boolean;
        generatePdf: boolean;
        sendPdf: boolean;
        downloadPdf: boolean;
    };
}>();

const armpSignatureDataUri = ref("");

const initial = computed(() => ({
    user_id: props.contract.user_id,
    contract_type: props.contract.contract_type,
    dealer_name: props.contract.dealer_name,
    agreement_date: props.contract.agreement_date ?? "",
    commence_date: props.contract.commence_date ?? "",
    yearly_inspection_total: props.contract.yearly_inspection_total,
    initial_fee: props.contract.initial_fee,
    monthly_fee: props.contract.monthly_fee,
    services: props.contract.services,
    dealer_physical_address: props.contract.dealer_physical_address,
    dealer_physical_city: props.contract.dealer_physical_city,
    dealer_physical_state: props.contract.dealer_physical_state,
    dealer_physical_zip: props.contract.dealer_physical_zip,
    dealer_phone: props.contract.dealer_phone,
    dealer_qi_name: props.contract.dealer_qi_name,
    dealer_qi_email: props.contract.dealer_qi_email,
    dealer_billing_address: props.contract.dealer_billing_address,
    dealer_billing_city: props.contract.dealer_billing_city,
    dealer_billing_state: props.contract.dealer_billing_state,
    dealer_billing_zip: props.contract.dealer_billing_zip,
    dealer_billing_fax: props.contract.dealer_billing_fax,
    dealer_billing_contact_name: props.contract.dealer_billing_contact_name,
    dealer_billing_contact_title: props.contract.dealer_billing_contact_title,
    dealer_billing_contact_email: props.contract.dealer_billing_contact_email,
    additional_locations: props.contract.additional_locations,
}));

const formDisabled = computed(() => !props.can.update);
const contractFullySigned = computed(() =>
    props.contract.armp_signature !== null && props.contract.dealer_signature !== null,
);

const breadcrumbItems = computed<BreadcrumbItem[]>(() => [
    { title: "Contracts", href: contractRoutes.index().url },
    { title: props.contract.dealer_name, href: contractRoutes.edit(props.contract.uuid).url },
]);
</script>

<template>
    <Head :title="contract.dealer_name" />
    <AppLayout :breadcrumbs="breadcrumbItems">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="col-span-2 border rounded-md p-5">
                <Form
                    v-slot="{ errors, processing }"
                    :action="ContractController.update(contract.uuid)"
                    class="space-y-10"
                >
                    <ContractForm
                        :initial="initial"
                        :services="services"
                        :consultants="consultants"
                        :errors="errors"
                        :processing="processing"
                        :disabled="formDisabled"
                        show-consultant
                    />

                    <div v-if="contract.dealer_signature" class="border-t pt-8">
                        <h2 class="text-base font-semibold leading-7 mb-4">ARMP Signature</h2>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                            <Field class="sm:col-span-3">
                                <FieldLabel for="armp_printed_name">Name</FieldLabel>
                                <Input
                                    id="armp_printed_name"
                                    name="armp_printed_name"
                                    :default-value="contract.armp_printed_name ?? ''"
                                    :disabled="contract.armp_signature !== null"
                                />
                                <FieldError v-if="errors.armp_printed_name">{{ errors.armp_printed_name }}</FieldError>
                            </Field>
                            <div class="sm:col-span-6">
                                <img
                                    v-if="contract.armp_signature && armp_signature_url"
                                    :src="armp_signature_url"
                                    alt="ARMP signature"
                                    class="border rounded-md w-auto h-32 bg-white"
                                />
                                <SignaturePad
                                    v-else
                                    v-model="armpSignatureDataUri"
                                    name="armp_signature"
                                />
                                <FieldError v-if="errors.armp_signature">{{ errors.armp_signature }}</FieldError>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <Button v-if="!contractFullySigned" type="submit" :disabled="processing || formDisabled">
                            <Loader2 v-if="processing" class="animate-spin" />
                            Update
                        </Button>
                        <p v-else class="text-sm text-muted-foreground italic">
                            * The contract cannot be updated after both parties have signed.
                        </p>
                    </div>
                </Form>
            </div>

            <aside class="space-y-5">
                <ContractActivity :entries="contract.status" />
                <ContractChecklist :steps="contract.progress_steps" />

                <SendContractDialog
                    v-if="can.sendForReview && !contract.dealer_signature"
                    :contract="contract"
                />

                <Form
                    v-if="can.generatePdf && contract.armp_signature && !contract.pdf_path"
                    v-slot="{ processing }"
                    :action="ContractPdfController.generate(contract.uuid)"
                >
                    <Button type="submit" variant="outline" class="w-full" :disabled="processing">
                        <Loader2 v-if="processing" class="animate-spin" />
                        Generate PDF
                    </Button>
                </Form>

                <template v-if="contract.pdf_path">
                    <SendContractPdfDialog v-if="can.sendPdf" :contract="contract" />
                    <Button v-if="can.downloadPdf" variant="outline" class="w-full" as-child>
                        <Link :href="ContractPdfController.download(contract.uuid).url">
                            <Download class="mr-2 h-4 w-4" />
                            Download PDF
                        </Link>
                    </Button>
                </template>
            </aside>
        </div>
    </AppLayout>
</template>
