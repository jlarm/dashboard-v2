<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Loader2 } from 'lucide-vue-next';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Button } from '@/components/ui/button';
import TextField from '@/pages/tenant/settings/components/TextField.vue';
import YesNoField from '@/pages/tenant/settings/components/YesNoField.vue';
import RepeaterField from '@/pages/tenant/settings/components/RepeaterField.vue';

type Managers = {
    qualified_individual_name: string | null;
    qualified_individual_phone: string | null;
    service_manager_name: string | null;
    service_manager_phone: string | null;
    parts_manager_name: string | null;
    parts_manager_phone: string | null;
    body_shop_manager_name: string | null;
    body_shop_manager_phone: string | null;
    general_manager_name: string | null;
    general_manager_phone: string | null;
    owner_name: string | null;
    owner_phone: string | null;
};

type Compliance = {
    police_emergency_phone: string | null;
    police_non_emergency_phone: string | null;
    fire_emergency_phone: string | null;
    fire_non_emergency_phone: string | null;
    fire_alarm_type: string | null;
    burglar_alarm_type: string | null;
    firewall_company: string | null;
    ip_addresses: string[];
    mfa: string | null;
    vulnerability: string | null;
    currently_monitoring: string | null;
    antivirus_software: string | null;
    antivirus_computers: string | null;
    screensaver_minutes: string | null;
    dms_provider: string | null;
    backups: string | null;
    website_urls: string[];
    designated_red_flag_coordinator: string | null;
    document_shredding: string | null;
    service_provider_agreements: string | null;
    offsite_storage: string | null;
    other_business: string | null;
    vendor_access: string | null;
    personal_devices: string | null;
    compliance_issues: string | null;
    fi_products_sold: string | null;
    service_contracts: string[];
    tire_wheel: string[];
    other_fi: string[];
    fi_system: string | null;
    appearance_protection_sold: string | null;
    reinsurance: boolean;
    admin_name: string | null;
    fi_username: string | null;
    fi_password: string | null;
};

const props = defineProps<{
    store: { id: number; name: string };
    managers: Managers;
    compliance: Compliance;
    userSubmitted: boolean;
    submitUrl: string;
}>();

const form = useForm({
    qualified_individual_name: props.managers.qualified_individual_name ?? '',
    qualified_individual_phone: props.managers.qualified_individual_phone ?? '',
    service_manager_name: props.managers.service_manager_name ?? '',
    service_manager_phone: props.managers.service_manager_phone ?? '',
    parts_manager_name: props.managers.parts_manager_name ?? '',
    parts_manager_phone: props.managers.parts_manager_phone ?? '',
    body_shop_manager_name: props.managers.body_shop_manager_name ?? '',
    body_shop_manager_phone: props.managers.body_shop_manager_phone ?? '',
    general_manager_name: props.managers.general_manager_name ?? '',
    general_manager_phone: props.managers.general_manager_phone ?? '',
    owner_name: props.managers.owner_name ?? '',
    owner_phone: props.managers.owner_phone ?? '',

    police_emergency_phone: props.compliance.police_emergency_phone ?? '',
    police_non_emergency_phone: props.compliance.police_non_emergency_phone ?? '',
    fire_emergency_phone: props.compliance.fire_emergency_phone ?? '',
    fire_non_emergency_phone: props.compliance.fire_non_emergency_phone ?? '',
    fire_alarm_type: props.compliance.fire_alarm_type ?? '',
    burglar_alarm_type: props.compliance.burglar_alarm_type ?? '',
    firewall_company: props.compliance.firewall_company ?? '',
    ip_addresses: [...props.compliance.ip_addresses],
    mfa: props.compliance.mfa,
    vulnerability: props.compliance.vulnerability,
    currently_monitoring: props.compliance.currently_monitoring,
    antivirus_software: props.compliance.antivirus_software ?? '',
    antivirus_computers: props.compliance.antivirus_computers ?? '',
    screensaver_minutes: props.compliance.screensaver_minutes ?? '',
    dms_provider: props.compliance.dms_provider ?? '',
    backups: props.compliance.backups ?? '',
    website_urls: [...props.compliance.website_urls],
    designated_red_flag_coordinator: props.compliance.designated_red_flag_coordinator ?? '',
    document_shredding: props.compliance.document_shredding,
    service_provider_agreements: props.compliance.service_provider_agreements,
    offsite_storage: props.compliance.offsite_storage,
    other_business: props.compliance.other_business,
    vendor_access: props.compliance.vendor_access,
    personal_devices: props.compliance.personal_devices,
    compliance_issues: props.compliance.compliance_issues,
    fi_products_sold: props.compliance.fi_products_sold ?? '',
    service_contracts: [...props.compliance.service_contracts],
    tire_wheel: [...props.compliance.tire_wheel],
    other_fi: [...props.compliance.other_fi],
    fi_system: props.compliance.fi_system ?? '',
    appearance_protection_sold: props.compliance.appearance_protection_sold ?? '',
    reinsurance: props.compliance.reinsurance,
    admin_name: props.compliance.admin_name ?? '',
    fi_username: props.compliance.fi_username ?? '',
    fi_password: props.compliance.fi_password ?? '',
});

const submit = (): void => {
    form.post(props.submitUrl, { preserveScroll: true });
};
</script>

<template>
    <Head title="Compliance Settings" />

    <div class="min-h-screen bg-muted/30 py-10">
        <div v-if="userSubmitted" class="flex min-h-[60vh] flex-col items-center justify-center gap-4 px-4 text-center">
            <AppLogoIcon class="h-12 w-auto" />
            <p class="text-sm text-muted-foreground">
                Thank you for providing your dealership's information. You can now close this tab.
            </p>
        </div>

        <div v-else class="mx-auto max-w-3xl px-4">
            <header class="mb-6 flex flex-wrap items-center justify-between gap-4 border-b pb-5">
                <AppLogoIcon class="h-8 w-auto" />
                <div class="text-right">
                    <h1 class="text-base font-semibold">{{ store.name }}</h1>
                    <p class="mt-0.5 text-sm text-muted-foreground">
                        Manager and compliance settings for your dealership's dashboard
                    </p>
                </div>
            </header>

            <form class="space-y-6" @submit.prevent="submit">
                <section class="rounded-md border bg-card p-6">
                    <h2 class="text-base font-semibold">Manager Information</h2>
                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <TextField v-model="form.qualified_individual_name" label="Qualified Individual Name" :error="form.errors.qualified_individual_name" />
                        <TextField v-model="form.qualified_individual_phone" label="Phone Number" type="tel" placeholder="555-555-5555" :error="form.errors.qualified_individual_phone" />
                        <TextField v-model="form.service_manager_name" label="Service Manager" :error="form.errors.service_manager_name" />
                        <TextField v-model="form.service_manager_phone" label="Phone Number" type="tel" placeholder="555-555-5555" :error="form.errors.service_manager_phone" />
                        <TextField v-model="form.parts_manager_name" label="Parts Manager" :error="form.errors.parts_manager_name" />
                        <TextField v-model="form.parts_manager_phone" label="Phone Number" type="tel" placeholder="555-555-5555" :error="form.errors.parts_manager_phone" />
                        <TextField v-model="form.body_shop_manager_name" label="Body Shop Manager" :error="form.errors.body_shop_manager_name" />
                        <TextField v-model="form.body_shop_manager_phone" label="Phone Number" type="tel" placeholder="555-555-5555" :error="form.errors.body_shop_manager_phone" />
                        <TextField v-model="form.general_manager_name" label="General Manager" :error="form.errors.general_manager_name" />
                        <TextField v-model="form.general_manager_phone" label="Phone Number" type="tel" placeholder="555-555-5555" :error="form.errors.general_manager_phone" />
                        <TextField v-model="form.owner_name" label="Owner" :error="form.errors.owner_name" />
                        <TextField v-model="form.owner_phone" label="Phone Number" type="tel" placeholder="555-555-5555" :error="form.errors.owner_phone" />
                    </div>
                </section>

                <section class="space-y-5 rounded-md border bg-card p-6">
                    <h2 class="text-base font-semibold">Compliance Info</h2>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <TextField v-model="form.police_emergency_phone" label="Police Emergency Phone Number" type="tel" placeholder="555-555-5555" :error="form.errors.police_emergency_phone" />
                        <TextField v-model="form.police_non_emergency_phone" label="Police Non-Emergency Phone Number" type="tel" placeholder="555-555-5555" :error="form.errors.police_non_emergency_phone" />
                        <TextField v-model="form.fire_emergency_phone" label="Fire Emergency Phone Number" type="tel" placeholder="555-555-5555" :error="form.errors.fire_emergency_phone" />
                        <TextField v-model="form.fire_non_emergency_phone" label="Fire Non-Emergency Phone Number" type="tel" placeholder="555-555-5555" :error="form.errors.fire_non_emergency_phone" />
                        <TextField v-model="form.fire_alarm_type" label="What type of fire alarm system do you use?" :error="form.errors.fire_alarm_type" />
                        <TextField v-model="form.burglar_alarm_type" label="What type of burglar alarm system do you use?" :error="form.errors.burglar_alarm_type" />
                    </div>

                    <TextField v-model="form.firewall_company" label="Firewall Company" :error="form.errors.firewall_company" />

                    <RepeaterField v-model="form.ip_addresses" label="IP Addresses" add-label="Add IP Address" placeholder="IP Address" />

                    <YesNoField v-model="form.mfa" label="Multi-Factor Authentication (MFA) — do you have it installed and being utilized?" :error="form.errors.mfa" />
                    <YesNoField v-model="form.vulnerability" label="Are IT vulnerability scans currently being completed?" :error="form.errors.vulnerability" />
                    <YesNoField v-model="form.currently_monitoring" label="Are you currently monitoring & logging user activity at your dealership?" :error="form.errors.currently_monitoring" />

                    <TextField v-model="form.antivirus_software" label="Antivirus Software" :error="form.errors.antivirus_software" />
                    <TextField v-model="form.antivirus_computers" label="Anti-virus applied on individual computers or through server?" :error="form.errors.antivirus_computers" />
                    <TextField v-model="form.screensaver_minutes" label="How many minutes are the monitors set for screen saver activation?" type="number" :error="form.errors.screensaver_minutes" />
                    <TextField v-model="form.dms_provider" label="Who is your Dealership Management System (DMS) provider?" :error="form.errors.dms_provider" />
                    <TextField v-model="form.backups" label="Where and how are backups being stored?" :error="form.errors.backups" />

                    <RepeaterField v-model="form.website_urls" label="Website URLs" add-label="Add Website URL" type="url" placeholder="https://example.com" />

                    <TextField v-model="form.designated_red_flag_coordinator" label="Who is your designated Red Flag Coordinator?" :error="form.errors.designated_red_flag_coordinator" />

                    <YesNoField v-model="form.document_shredding" label="Do you use a document shredding company?" :error="form.errors.document_shredding" />
                    <YesNoField v-model="form.service_provider_agreements" label="Are Service Provider Agreements & Risk Assessments on file with your dealership?" :error="form.errors.service_provider_agreements" />
                    <YesNoField v-model="form.offsite_storage" label="Does your dealership store any customer information at offsite locations?" :error="form.errors.offsite_storage" />
                    <YesNoField v-model="form.other_business" label="Does your dealership have an affiliation with any other business where he/she has a financial interest of more than 25%?" :error="form.errors.other_business" />
                    <YesNoField v-model="form.vendor_access" label="Are there any vendors that have after-hour access to your dealership and other buildings storing customer information?" :error="form.errors.vendor_access" />
                    <YesNoField v-model="form.personal_devices" label="Are there any persons that have customer access on their personal PC, or that maintain a customer database on a personal device of any kind?" :error="form.errors.personal_devices" />
                    <YesNoField v-model="form.compliance_issues" label="Have there been any compliance-related issues we should be made aware of (information compromised, attempted fraud, etc.)?" :error="form.errors.compliance_issues" />

                    <TextField v-model="form.fi_products_sold" label="What F&I products are sold in the F&I department?" :error="form.errors.fi_products_sold" />

                    <RepeaterField v-model="form.service_contracts" label="Service Contracts: New and Used" add-label="Add Contract" />
                    <RepeaterField v-model="form.tire_wheel" label="Combo / Tire and Wheel" add-label="Add" />
                    <RepeaterField v-model="form.other_fi" label="Other (e.g. Etch, Security Systems, GPS)" add-label="Add" />

                    <TextField v-model="form.fi_system" label="What F&I system do you use? (e.g. Reynolds, Stone Eagle, Dealer Track)" :error="form.errors.fi_system" />
                    <TextField v-model="form.appearance_protection_sold" label="Where are appearance protection products sold? (Sales floor / Separate dept / F&I)" :error="form.errors.appearance_protection_sold" />

                    <YesNoField v-model="form.reinsurance" label="Does the dealer have a reinsurance company formed?" :yes-value="true" :no-value="false" :error="form.errors.reinsurance" />

                    <TextField v-model="form.admin_name" label="Who is the administrator?" :error="form.errors.admin_name" />

                    <div class="grid gap-4 sm:grid-cols-2">
                        <TextField v-model="form.fi_username" label="F&I Logs Username" :error="form.errors.fi_username" />
                        <TextField v-model="form.fi_password" label="F&I Logs Password" :error="form.errors.fi_password" />
                    </div>
                </section>

                <div class="flex justify-end">
                    <Button type="submit" :disabled="form.processing">
                        <Loader2 v-if="form.processing" class="animate-spin" />
                        Update
                    </Button>
                </div>
            </form>
        </div>
    </div>
</template>
