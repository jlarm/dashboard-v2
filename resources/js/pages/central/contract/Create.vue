<script setup lang="ts">
import { Head, Form } from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import type { BreadcrumbItem } from "@/types";
import contractRoutes from "@/routes/contracts";
import ContractController from "@/actions/App/Http/Controllers/Central/ContractController";
import ContractForm from "@/pages/central/contract/components/ContractForm.vue";
import type { AdditionalLocation } from "@/pages/central/contract/components/AdditionalLocationsRepeater.vue";
import { Button } from "@/components/ui/button";
import { Loader2 } from "lucide-vue-next";

type ServiceOption = { value: string; label: string };

defineProps<{ services: ServiceOption[] }>();

const initial = {
    user_id: null,
    contract_type: "",
    dealer_name: "",
    agreement_date: "",
    commence_date: "",
    yearly_inspection_total: "",
    initial_fee: "",
    monthly_fee: "",
    services: [],
    dealer_physical_address: "",
    dealer_physical_city: "",
    dealer_physical_state: "",
    dealer_physical_zip: "",
    dealer_phone: "",
    dealer_qi_name: "",
    dealer_qi_email: "",
    dealer_billing_address: "",
    dealer_billing_city: "",
    dealer_billing_state: "",
    dealer_billing_zip: "",
    dealer_billing_fax: "",
    dealer_billing_contact_name: "",
    dealer_billing_contact_title: "",
    dealer_billing_contact_email: "",
    additional_locations: [] as AdditionalLocation[],
};

const breadcrumbItems: BreadcrumbItem[] = [
    { title: "Contracts", href: contractRoutes.index().url },
    { title: "New", href: contractRoutes.create().url },
];
</script>

<template>
    <Head title="Create Contract" />
    <AppLayout :breadcrumbs="breadcrumbItems">
        <div class="w-full max-w-3xl mx-auto">
            <Form
                v-slot="{ errors, processing }"
                :action="ContractController.store()"
                class="space-y-10"
            >
                <ContractForm
                    :initial="initial"
                    :services="services"
                    :errors="errors"
                    :processing="processing"
                />
                <div class="flex justify-end">
                    <Button type="submit" :disabled="processing">
                        <Loader2 v-if="processing" class="animate-spin" />
                        Create Contract
                    </Button>
                </div>
            </Form>
        </div>
    </AppLayout>
</template>
