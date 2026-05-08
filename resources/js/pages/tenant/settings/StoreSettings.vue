<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { Loader2, Search } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import StoreSettingsController from '@/actions/App/Http/Controllers/Tenant/Settings/StoreSettingsController';
import dealer from '@/routes/dealer/dealer';

const settings = dealer.settings;
import type { BreadcrumbItem } from '@/types';

type Section = 'general' | 'managers' | 'compliance' | 'reset-courses';

type StoreSummary = {
    id: number;
    name: string;
};

type StoreDetails = {
    id: number;
    name: string;
    address: string | null;
    city: string | null;
    state: string | null;
    postal_code: string | null;
    phone: string | null;
    website: string | null;
    active_monitoring: boolean;
    monitoring_start_date: string | null;
    courses_not_taken_notification: boolean;
    videos: boolean;
};

type RemediationSettings = {
    active: boolean;
    notifications: boolean;
    frequency: string | null;
};

type PhishingSettings = {
    active: boolean;
    token: string | null;
    ip: string | null;
};

type Frequency = { value: string; label: string };

type GeneralPayload = {
    store: StoreDetails;
    remediation: RemediationSettings;
    phishing: PhishingSettings;
    frequencies: Frequency[];
};

type ManagersPayload = {
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

type CompliancePayload = {
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
    antivirus_minutes: string | null;
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
    standard_dpp_rate: number | null;
};

type ResettableUser = {
    id: number;
    name: string;
    email: string;
    stores: string[];
    status: 'completed' | 'in-progress' | 'not-started';
};

const props = defineProps<{
    section: Section;
    store: StoreSummary;
    can: { update: boolean; manage_dealerships: boolean };
    search: string;
    general?: GeneralPayload | null;
    managers?: ManagersPayload | null;
    compliance?: CompliancePayload | null;
    resettableUsers?: ResettableUser[] | null;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Settings', href: settings.url() },
];

const sections: { key: Section; label: string; href: string; gated?: boolean }[] = [
    { key: 'general', label: 'General', href: settings.url() },
    { key: 'managers', label: 'Managers', href: settings.managers.url() },
    { key: 'compliance', label: 'Compliance', href: settings.compliance.url() },
    { key: 'reset-courses', label: 'Reset Courses', href: settings.resetCourses.url(), gated: true },
];

const visibleSections = sections.filter((item) => !item.gated || props.can.manage_dealerships);

// ---------- Phone formatting ----------

const formatPhoneNumber = (value: string | null | undefined): string => {
    if (value === null || value === undefined) {
        return '';
    }

    const digits = value.replace(/\D/g, '').slice(0, 10);

    if (digits.length <= 3) {
        return digits;
    }
    if (digits.length <= 6) {
        return `${digits.slice(0, 3)}-${digits.slice(3)}`;
    }
    return `${digits.slice(0, 3)}-${digits.slice(3, 6)}-${digits.slice(6, 10)}`;
};

// ---------- General section ----------

const form = useForm({
    name: '',
    address: '',
    city: '',
    state: '',
    postal_code: '',
    phone: '',
    website: '',
    active_monitoring: false,
    monitoring_start_date: '',
    courses_not_taken_notification: false,
    videos: false,
    remediations_active: false,
    remediation_notifications: false,
    remediation_frequency: '' as string,
    phishing_active: false,
    phishing_token: '',
    phishing_ip: '',
});

const hydrateGeneralForm = (payload: GeneralPayload): void => {
    form.name = payload.store.name;
    form.address = payload.store.address ?? '';
    form.city = payload.store.city ?? '';
    form.state = payload.store.state ?? '';
    form.postal_code = payload.store.postal_code ?? '';
    form.phone = formatPhoneNumber(payload.store.phone);
    form.website = payload.store.website ?? '';
    form.active_monitoring = payload.store.active_monitoring;
    form.monitoring_start_date = payload.store.monitoring_start_date ?? '';
    form.courses_not_taken_notification = payload.store.courses_not_taken_notification;
    form.videos = payload.store.videos;
    form.remediations_active = payload.remediation.active;
    form.remediation_notifications = payload.remediation.notifications;
    form.remediation_frequency = payload.remediation.frequency ?? '';
    form.phishing_active = payload.phishing.active;
    form.phishing_token = payload.phishing.token ?? '';
    form.phishing_ip = payload.phishing.ip ?? '';
};

watch(
    () => props.general,
    (next) => {
        if (next) {
            hydrateGeneralForm(next);
        }
    },
    { immediate: true },
);

const submitGeneral = (): void => {
    form
        .transform((data) => ({
            ...data,
            remediation_frequency: data.remediation_frequency === '' ? null : data.remediation_frequency,
        }))
        .patch(StoreSettingsController.updateGeneral.url({ store: props.store.id }), {
            preserveScroll: true,
        });
};

// ---------- Managers section ----------

const managersForm = useForm({
    qualified_individual_name: '',
    qualified_individual_phone: '',
    service_manager_name: '',
    service_manager_phone: '',
    parts_manager_name: '',
    parts_manager_phone: '',
    body_shop_manager_name: '',
    body_shop_manager_phone: '',
    general_manager_name: '',
    general_manager_phone: '',
    owner_name: '',
    owner_phone: '',
});

const hydrateManagersForm = (payload: ManagersPayload): void => {
    managersForm.qualified_individual_name = payload.qualified_individual_name ?? '';
    managersForm.qualified_individual_phone = formatPhoneNumber(payload.qualified_individual_phone);
    managersForm.service_manager_name = payload.service_manager_name ?? '';
    managersForm.service_manager_phone = formatPhoneNumber(payload.service_manager_phone);
    managersForm.parts_manager_name = payload.parts_manager_name ?? '';
    managersForm.parts_manager_phone = formatPhoneNumber(payload.parts_manager_phone);
    managersForm.body_shop_manager_name = payload.body_shop_manager_name ?? '';
    managersForm.body_shop_manager_phone = formatPhoneNumber(payload.body_shop_manager_phone);
    managersForm.general_manager_name = payload.general_manager_name ?? '';
    managersForm.general_manager_phone = formatPhoneNumber(payload.general_manager_phone);
    managersForm.owner_name = payload.owner_name ?? '';
    managersForm.owner_phone = formatPhoneNumber(payload.owner_phone);
};

watch(
    () => props.managers,
    (next) => {
        if (next) {
            hydrateManagersForm(next);
        }
    },
    { immediate: true },
);

const managerRoles: { key: keyof ManagersPayload; phoneKey: keyof ManagersPayload; label: string }[] = [
    { key: 'qualified_individual_name', phoneKey: 'qualified_individual_phone', label: 'Qualified Individual' },
    { key: 'owner_name', phoneKey: 'owner_phone', label: 'Owner' },
    { key: 'general_manager_name', phoneKey: 'general_manager_phone', label: 'General Manager' },
    { key: 'service_manager_name', phoneKey: 'service_manager_phone', label: 'Service Manager' },
    { key: 'parts_manager_name', phoneKey: 'parts_manager_phone', label: 'Parts Manager' },
    { key: 'body_shop_manager_name', phoneKey: 'body_shop_manager_phone', label: 'Body Shop Manager' },
];

const submitManagers = (): void => {
    managersForm.patch(StoreSettingsController.updateManagers.url({ store: props.store.id }), {
        preserveScroll: true,
    });
};

// ---------- Compliance section ----------

type ComplianceFormShape = Omit<CompliancePayload, 'standard_dpp_rate'> & { standard_dpp_rate: string };

const blankCompliance = (): ComplianceFormShape => ({
    police_emergency_phone: '',
    police_non_emergency_phone: '',
    fire_emergency_phone: '',
    fire_non_emergency_phone: '',
    fire_alarm_type: '',
    burglar_alarm_type: '',
    firewall_company: '',
    ip_addresses: [],
    mfa: '',
    vulnerability: '',
    currently_monitoring: '',
    antivirus_software: '',
    antivirus_computers: '',
    antivirus_minutes: '',
    screensaver_minutes: '',
    dms_provider: '',
    backups: '',
    website_urls: [],
    designated_red_flag_coordinator: '',
    document_shredding: '',
    service_provider_agreements: '',
    offsite_storage: '',
    other_business: '',
    vendor_access: '',
    personal_devices: '',
    compliance_issues: '',
    fi_products_sold: '',
    service_contracts: [],
    tire_wheel: [],
    other_fi: [],
    fi_system: '',
    appearance_protection_sold: '',
    reinsurance: false,
    admin_name: '',
    fi_username: '',
    fi_password: '',
    standard_dpp_rate: '',
});

const complianceForm = useForm<ComplianceFormShape>(blankCompliance());

const hydrateComplianceForm = (payload: CompliancePayload): void => {
    complianceForm.police_emergency_phone = formatPhoneNumber(payload.police_emergency_phone);
    complianceForm.police_non_emergency_phone = formatPhoneNumber(payload.police_non_emergency_phone);
    complianceForm.fire_emergency_phone = formatPhoneNumber(payload.fire_emergency_phone);
    complianceForm.fire_non_emergency_phone = formatPhoneNumber(payload.fire_non_emergency_phone);
    complianceForm.fire_alarm_type = payload.fire_alarm_type ?? '';
    complianceForm.burglar_alarm_type = payload.burglar_alarm_type ?? '';
    complianceForm.firewall_company = payload.firewall_company ?? '';
    complianceForm.ip_addresses = [...payload.ip_addresses];
    complianceForm.mfa = payload.mfa ?? '';
    complianceForm.vulnerability = payload.vulnerability ?? '';
    complianceForm.currently_monitoring = payload.currently_monitoring ?? '';
    complianceForm.antivirus_software = payload.antivirus_software ?? '';
    complianceForm.antivirus_computers = payload.antivirus_computers ?? '';
    complianceForm.antivirus_minutes = payload.antivirus_minutes ?? '';
    complianceForm.screensaver_minutes = payload.screensaver_minutes ?? '';
    complianceForm.dms_provider = payload.dms_provider ?? '';
    complianceForm.backups = payload.backups ?? '';
    complianceForm.website_urls = [...payload.website_urls];
    complianceForm.designated_red_flag_coordinator = payload.designated_red_flag_coordinator ?? '';
    complianceForm.document_shredding = payload.document_shredding ?? '';
    complianceForm.service_provider_agreements = payload.service_provider_agreements ?? '';
    complianceForm.offsite_storage = payload.offsite_storage ?? '';
    complianceForm.other_business = payload.other_business ?? '';
    complianceForm.vendor_access = payload.vendor_access ?? '';
    complianceForm.personal_devices = payload.personal_devices ?? '';
    complianceForm.compliance_issues = payload.compliance_issues ?? '';
    complianceForm.fi_products_sold = payload.fi_products_sold ?? '';
    complianceForm.service_contracts = [...payload.service_contracts];
    complianceForm.tire_wheel = [...payload.tire_wheel];
    complianceForm.other_fi = [...payload.other_fi];
    complianceForm.fi_system = payload.fi_system ?? '';
    complianceForm.appearance_protection_sold = payload.appearance_protection_sold ?? '';
    complianceForm.reinsurance = payload.reinsurance;
    complianceForm.admin_name = payload.admin_name ?? '';
    complianceForm.fi_username = payload.fi_username ?? '';
    complianceForm.fi_password = payload.fi_password ?? '';
    complianceForm.standard_dpp_rate = payload.standard_dpp_rate === null ? '' : String(payload.standard_dpp_rate);
};

watch(
    () => props.compliance,
    (next) => {
        if (next) {
            hydrateComplianceForm(next);
        }
    },
    { immediate: true },
);

type ComplianceListKey = 'ip_addresses' | 'website_urls' | 'service_contracts' | 'tire_wheel' | 'other_fi';

const addComplianceRow = (key: ComplianceListKey): void => {
    complianceForm[key] = [...complianceForm[key], ''];
};

const removeComplianceRow = (key: ComplianceListKey, index: number): void => {
    complianceForm[key] = complianceForm[key].filter((_, i) => i !== index);
};

const submitCompliance = (): void => {
    complianceForm
        .transform((data) => ({
            ...data,
            standard_dpp_rate: data.standard_dpp_rate === '' ? null : data.standard_dpp_rate,
        }))
        .patch(StoreSettingsController.updateCompliance.url({ store: props.store.id }), {
            preserveScroll: true,
        });
};

const downloadComplianceUrl = (): string =>
    StoreSettingsController.downloadCompliance.url({ store: props.store.id });

// ---------- Reset Courses section ----------

const resetMode = ref<'everyone' | 'selected-users'>('everyone');
const search = ref(props.search ?? '');
const selectedUserIds = ref<number[]>([]);
const confirmOpen = ref(false);
const resetting = ref(false);

const reloadResettableUsers = (): void => {
    router.get(
        settings.resetCourses.url(),
        search.value.trim() === '' ? {} : { search: search.value.trim() },
        {
            preserveScroll: true,
            preserveState: true,
            replace: true,
            only: ['resettableUsers', 'search'],
        },
    );
};

const debouncedReload = useDebounceFn(reloadResettableUsers, 300);
watch(search, debouncedReload);

watch(
    () => props.search,
    (next) => {
        search.value = next ?? '';
    },
);

const resettableUsersList = computed<ResettableUser[]>(() => props.resettableUsers ?? []);

const visibleUserIds = computed<number[]>(() => resettableUsersList.value.map((user) => user.id));

const allVisibleSelected = computed<boolean>(
    () => visibleUserIds.value.length > 0 && visibleUserIds.value.every((id) => selectedUserIds.value.includes(id)),
);

const isUserSelected = (id: number): boolean => selectedUserIds.value.includes(id);

const toggleUser = (id: number): void => {
    selectedUserIds.value = isUserSelected(id)
        ? selectedUserIds.value.filter((existing) => existing !== id)
        : [...selectedUserIds.value, id];
};

const toggleSelectAllVisible = (checked: boolean): void => {
    if (checked) {
        const merged = new Set([...selectedUserIds.value, ...visibleUserIds.value]);
        selectedUserIds.value = [...merged];
        return;
    }
    selectedUserIds.value = selectedUserIds.value.filter((id) => !visibleUserIds.value.includes(id));
};

const requestReset = (): void => {
    if (resetMode.value === 'selected-users' && selectedUserIds.value.length === 0) {
        return;
    }
    confirmOpen.value = true;
};

const cancelReset = (): void => {
    confirmOpen.value = false;
};

const confirmReset = (): void => {
    resetting.value = true;
    router.post(
        StoreSettingsController.resetCourses.url({ store: props.store.id }),
        {
            mode: resetMode.value,
            user_ids: resetMode.value === 'selected-users' ? selectedUserIds.value : [],
        },
        {
            preserveScroll: true,
            onFinish: () => {
                resetting.value = false;
                confirmOpen.value = false;
                if (resetMode.value === 'selected-users') {
                    selectedUserIds.value = [];
                }
            },
        },
    );
};

const statusLabel: Record<ResettableUser['status'], string> = {
    completed: 'Completed',
    'in-progress': 'In Progress',
    'not-started': 'Not Started',
};

const statusClass: Record<ResettableUser['status'], string> = {
    completed: 'bg-green-100 text-green-700',
    'in-progress': 'bg-amber-100 text-amber-700',
    'not-started': 'bg-muted text-muted-foreground',
};

const confirmMessage = computed<string>(() =>
    resetMode.value === 'selected-users'
        ? 'Are you sure you want to reset courses for the selected users?'
        : `Are you sure you want to reset all course results for ${props.store.name}?`,
);
</script>

<template>
    <Head title="Settings" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 px-4 py-6">
            <Heading
                title="Settings"
                :description="`Configure settings for ${store.name}.`"
            />

            <div class="flex justify-center">
                <nav class="inline-flex flex-wrap rounded-md border bg-muted/40 p-1" aria-label="Settings sections">
                    <Link
                        v-for="item in visibleSections"
                        :key="item.key"
                        :href="item.href"
                        :class="[
                            'flex whitespace-nowrap items-center justify-center rounded-md px-4 py-1.5 text-sm transition-colors',
                            section === item.key ? 'bg-background text-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground',
                        ]"
                        :aria-current="section === item.key ? 'page' : undefined"
                    >
                        {{ item.label }}
                    </Link>
                </nav>
            </div>

            <!-- General -->
            <div v-if="section === 'general'" class="mx-auto max-w-4xl space-y-6">
                <div v-if="!general" class="flex h-32 items-center justify-center rounded-md border bg-card text-sm text-muted-foreground">
                    <Loader2 class="mr-2 size-4 animate-spin" />
                    Loading settings...
                </div>

                <form v-else class="space-y-6" @submit.prevent="submitGeneral">
                    <Card>
                        <CardHeader>
                            <CardTitle>Dealership Details</CardTitle>
                            <CardDescription>Update the basic information for this location.</CardDescription>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div class="space-y-2">
                                    <Label for="name">Dealership Name</Label>
                                    <Input id="name" v-model="form.name" required />
                                    <InputError :message="form.errors.name" />
                                </div>
                                <div class="space-y-2">
                                    <Label for="phone">Phone</Label>
                                    <Input id="phone" v-model="form.phone" @input="form.phone = formatPhoneNumber(form.phone)" />
                                    <InputError :message="form.errors.phone" />
                                </div>
                                <div class="md:col-span-2 space-y-2">
                                    <Label for="address">Address</Label>
                                    <Input id="address" v-model="form.address" />
                                    <InputError :message="form.errors.address" />
                                </div>
                                <div class="space-y-2">
                                    <Label for="city">City</Label>
                                    <Input id="city" v-model="form.city" />
                                    <InputError :message="form.errors.city" />
                                </div>
                                <div class="space-y-2">
                                    <Label for="state">State</Label>
                                    <Input id="state" v-model="form.state" />
                                    <InputError :message="form.errors.state" />
                                </div>
                                <div class="space-y-2">
                                    <Label for="postal_code">Postal Code</Label>
                                    <Input id="postal_code" v-model="form.postal_code" />
                                    <InputError :message="form.errors.postal_code" />
                                </div>
                                <div class="space-y-2">
                                    <Label for="website">Website</Label>
                                    <Input id="website" v-model="form.website" />
                                    <InputError :message="form.errors.website" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Monitoring</CardTitle>
                            <CardDescription>Active monitoring tracks security activity for this dealership.</CardDescription>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="flex items-center justify-between">
                                <Label for="active_monitoring" class="cursor-pointer">Active monitoring</Label>
                                <Checkbox id="active_monitoring" v-model="form.active_monitoring" />
                            </div>
                            <div class="space-y-2">
                                <Label for="monitoring_start_date">Monitoring start date</Label>
                                <Input id="monitoring_start_date" v-model="form.monitoring_start_date" type="date" />
                                <InputError :message="form.errors.monitoring_start_date" />
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Audit Remediations</CardTitle>
                            <CardDescription>Allow this store to remediate audits and optionally notify managers.</CardDescription>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="flex items-center justify-between">
                                <Label for="remediations_active" class="cursor-pointer">Remediations enabled</Label>
                                <Checkbox id="remediations_active" v-model="form.remediations_active" />
                            </div>
                            <div class="flex items-center justify-between">
                                <Label for="remediation_notifications" class="cursor-pointer">Send remediation reminders</Label>
                                <Checkbox id="remediation_notifications" v-model="form.remediation_notifications" />
                            </div>
                            <div class="space-y-2">
                                <Label for="remediation_frequency">Reminder frequency</Label>
                                <Select v-model="form.remediation_frequency">
                                    <SelectTrigger id="remediation_frequency">
                                        <SelectValue placeholder="Choose a frequency" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="frequency in general.frequencies" :key="frequency.value" :value="frequency.value">
                                            {{ frequency.label }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                                <InputError :message="form.errors.remediation_frequency" />
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Phishing Simulations</CardTitle>
                            <CardDescription>These settings apply across the whole tenant.</CardDescription>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="flex items-center justify-between">
                                <Label for="phishing_active" class="cursor-pointer">Phishing active</Label>
                                <Checkbox id="phishing_active" v-model="form.phishing_active" />
                            </div>
                            <div class="space-y-2">
                                <Label for="phishing_token">Phishing token</Label>
                                <Input id="phishing_token" v-model="form.phishing_token" />
                                <InputError :message="form.errors.phishing_token" />
                            </div>
                            <div class="space-y-2">
                                <Label for="phishing_ip">Phishing IP</Label>
                                <Input id="phishing_ip" v-model="form.phishing_ip" />
                                <InputError :message="form.errors.phishing_ip" />
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Other</CardTitle>
                        </CardHeader>
                        <CardContent class="space-y-4">
                            <div class="flex items-center justify-between">
                                <Label for="courses_not_taken_notification" class="cursor-pointer">Send "courses not taken" notifications</Label>
                                <Checkbox id="courses_not_taken_notification" v-model="form.courses_not_taken_notification" />
                            </div>
                            <div class="flex items-center justify-between">
                                <Label for="videos" class="cursor-pointer">Allow course videos</Label>
                                <Checkbox id="videos" v-model="form.videos" />
                            </div>
                        </CardContent>
                    </Card>

                    <div v-if="can.update" class="flex justify-end">
                        <Button type="submit" :disabled="form.processing">
                            <Loader2 v-if="form.processing" class="mr-2 size-4 animate-spin" />
                            Save Settings
                        </Button>
                    </div>
                </form>
            </div>

            <!-- Managers -->
            <div v-else-if="section === 'managers'" class="mx-auto max-w-4xl space-y-6">
                <div v-if="!managers" class="flex h-32 items-center justify-center rounded-md border bg-card text-sm text-muted-foreground">
                    <Loader2 class="mr-2 size-4 animate-spin" />
                    Loading managers...
                </div>

                <form v-else class="space-y-6" @submit.prevent="submitManagers">
                    <Card>
                        <CardHeader>
                            <CardTitle>Manager Contacts</CardTitle>
                            <CardDescription>Names and phone numbers for the people responsible for each role.</CardDescription>
                        </CardHeader>
                        <CardContent class="space-y-6">
                            <div
                                v-for="role in managerRoles"
                                :key="role.key"
                                class="grid grid-cols-1 gap-4 md:grid-cols-2"
                            >
                                <div class="space-y-2">
                                    <Label :for="role.key">{{ role.label }}</Label>
                                    <Input :id="role.key" v-model="managersForm[role.key] as string" />
                                    <InputError :message="managersForm.errors[role.key]" />
                                </div>
                                <div class="space-y-2">
                                    <Label :for="role.phoneKey">{{ role.label }} Phone</Label>
                                    <Input
                                        :id="role.phoneKey"
                                        :model-value="managersForm[role.phoneKey] as string"
                                        @update:model-value="(value) => (managersForm[role.phoneKey] = formatPhoneNumber(value as string))"
                                    />
                                    <InputError :message="managersForm.errors[role.phoneKey]" />
                                </div>
                            </div>
                        </CardContent>
                    </Card>

                    <div v-if="can.update" class="flex justify-end">
                        <Button type="submit" :disabled="managersForm.processing">
                            <Loader2 v-if="managersForm.processing" class="mr-2 size-4 animate-spin" />
                            Save Managers
                        </Button>
                    </div>
                </form>
            </div>

            <!-- Compliance -->
            <div v-else-if="section === 'compliance'" class="mx-auto max-w-5xl space-y-6">
                <div v-if="!compliance" class="flex h-32 items-center justify-center rounded-md border bg-card text-sm text-muted-foreground">
                    <Loader2 class="mr-2 size-4 animate-spin" />
                    Loading compliance information...
                </div>

                <form v-else class="space-y-6" @submit.prevent="submitCompliance">
                    <div class="flex justify-end">
                        <Button as="a" :href="downloadComplianceUrl()" target="_blank" variant="outline">
                            Download PDF
                        </Button>
                    </div>

                    <Card>
                        <CardHeader>
                            <CardTitle>Emergency Contacts</CardTitle>
                        </CardHeader>
                        <CardContent class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="police_emergency_phone">Police Emergency Phone Number</Label>
                                <Input id="police_emergency_phone" v-model="complianceForm.police_emergency_phone" @input="complianceForm.police_emergency_phone = formatPhoneNumber(complianceForm.police_emergency_phone)" />
                            </div>
                            <div class="space-y-2">
                                <Label for="police_non_emergency_phone">Police Non-Emergency Phone Number</Label>
                                <Input id="police_non_emergency_phone" v-model="complianceForm.police_non_emergency_phone" @input="complianceForm.police_non_emergency_phone = formatPhoneNumber(complianceForm.police_non_emergency_phone)" />
                            </div>
                            <div class="space-y-2">
                                <Label for="fire_emergency_phone">Fire Emergency Phone Number</Label>
                                <Input id="fire_emergency_phone" v-model="complianceForm.fire_emergency_phone" @input="complianceForm.fire_emergency_phone = formatPhoneNumber(complianceForm.fire_emergency_phone)" />
                            </div>
                            <div class="space-y-2">
                                <Label for="fire_non_emergency_phone">Fire Non-Emergency Phone Number</Label>
                                <Input id="fire_non_emergency_phone" v-model="complianceForm.fire_non_emergency_phone" @input="complianceForm.fire_non_emergency_phone = formatPhoneNumber(complianceForm.fire_non_emergency_phone)" />
                            </div>
                            <div class="space-y-2">
                                <Label for="fire_alarm_type">Fire Alarm Type</Label>
                                <Input id="fire_alarm_type" v-model="complianceForm.fire_alarm_type" />
                            </div>
                            <div class="space-y-2">
                                <Label for="burglar_alarm_type">Burglar Alarm Type</Label>
                                <Input id="burglar_alarm_type" v-model="complianceForm.burglar_alarm_type" />
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>IT &amp; Security</CardTitle>
                        </CardHeader>
                        <CardContent class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="firewall_company">Firewall Company</Label>
                                <Input id="firewall_company" v-model="complianceForm.firewall_company" />
                            </div>
                            <div class="space-y-2">
                                <Label for="mfa">Multi-Factor Authentication</Label>
                                <Input id="mfa" v-model="complianceForm.mfa" />
                            </div>
                            <div class="space-y-2">
                                <Label for="vulnerability">Vulnerability</Label>
                                <Input id="vulnerability" v-model="complianceForm.vulnerability" />
                            </div>
                            <div class="space-y-2">
                                <Label for="currently_monitoring">Currently Monitoring</Label>
                                <Input id="currently_monitoring" v-model="complianceForm.currently_monitoring" />
                            </div>
                            <div class="space-y-2">
                                <Label for="antivirus_software">Antivirus Software</Label>
                                <Input id="antivirus_software" v-model="complianceForm.antivirus_software" />
                            </div>
                            <div class="space-y-2">
                                <Label for="antivirus_computers">Antivirus Computers</Label>
                                <Input id="antivirus_computers" v-model="complianceForm.antivirus_computers" />
                            </div>
                            <div class="space-y-2">
                                <Label for="antivirus_minutes">Antivirus Lock Minutes</Label>
                                <Input id="antivirus_minutes" v-model="complianceForm.antivirus_minutes" />
                            </div>
                            <div class="space-y-2">
                                <Label for="screensaver_minutes">Screensaver Minutes</Label>
                                <Input id="screensaver_minutes" v-model="complianceForm.screensaver_minutes" />
                            </div>
                            <div class="space-y-2">
                                <Label for="dms_provider">DMS Provider</Label>
                                <Input id="dms_provider" v-model="complianceForm.dms_provider" />
                            </div>
                            <div class="space-y-2">
                                <Label for="backups">Backups</Label>
                                <Input id="backups" v-model="complianceForm.backups" />
                            </div>

                            <div class="md:col-span-2 space-y-2">
                                <Label>IP Addresses</Label>
                                <div v-for="(_, index) in complianceForm.ip_addresses" :key="`ip-${index}`" class="flex gap-2">
                                    <Input v-model="complianceForm.ip_addresses[index]" />
                                    <Button type="button" variant="outline" size="sm" @click="removeComplianceRow('ip_addresses', index)">Remove</Button>
                                </div>
                                <Button type="button" variant="outline" size="sm" @click="addComplianceRow('ip_addresses')">Add IP Address</Button>
                            </div>

                            <div class="md:col-span-2 space-y-2">
                                <Label>Website URLs</Label>
                                <div v-for="(_, index) in complianceForm.website_urls" :key="`url-${index}`" class="flex gap-2">
                                    <Input v-model="complianceForm.website_urls[index]" />
                                    <Button type="button" variant="outline" size="sm" @click="removeComplianceRow('website_urls', index)">Remove</Button>
                                </div>
                                <Button type="button" variant="outline" size="sm" @click="addComplianceRow('website_urls')">Add URL</Button>
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Compliance &amp; Operations</CardTitle>
                        </CardHeader>
                        <CardContent class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="designated_red_flag_coordinator">Designated Red Flag Coordinator</Label>
                                <Input id="designated_red_flag_coordinator" v-model="complianceForm.designated_red_flag_coordinator" />
                            </div>
                            <div class="space-y-2">
                                <Label for="document_shredding">Document Shredding</Label>
                                <Input id="document_shredding" v-model="complianceForm.document_shredding" />
                            </div>
                            <div class="space-y-2">
                                <Label for="service_provider_agreements">Service Provider Agreements</Label>
                                <Input id="service_provider_agreements" v-model="complianceForm.service_provider_agreements" />
                            </div>
                            <div class="space-y-2">
                                <Label for="offsite_storage">Offsite Storage</Label>
                                <Input id="offsite_storage" v-model="complianceForm.offsite_storage" />
                            </div>
                            <div class="space-y-2">
                                <Label for="other_business">Other Business</Label>
                                <Input id="other_business" v-model="complianceForm.other_business" />
                            </div>
                            <div class="space-y-2">
                                <Label for="vendor_access">Vendor Access</Label>
                                <Input id="vendor_access" v-model="complianceForm.vendor_access" />
                            </div>
                            <div class="space-y-2">
                                <Label for="personal_devices">Personal Devices</Label>
                                <Input id="personal_devices" v-model="complianceForm.personal_devices" />
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <Label for="compliance_issues">Compliance Issues</Label>
                                <Input id="compliance_issues" v-model="complianceForm.compliance_issues" />
                            </div>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Finance &amp; Insurance</CardTitle>
                        </CardHeader>
                        <CardContent class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="fi_products_sold">F&amp;I Products Sold</Label>
                                <Input id="fi_products_sold" v-model="complianceForm.fi_products_sold" />
                            </div>
                            <div class="space-y-2">
                                <Label for="fi_system">F&amp;I System</Label>
                                <Input id="fi_system" v-model="complianceForm.fi_system" />
                            </div>
                            <div class="space-y-2">
                                <Label for="appearance_protection_sold">Appearance Protection Sold</Label>
                                <Input id="appearance_protection_sold" v-model="complianceForm.appearance_protection_sold" />
                            </div>
                            <div class="space-y-2">
                                <Label for="admin_name">Admin Name</Label>
                                <Input id="admin_name" v-model="complianceForm.admin_name" />
                            </div>
                            <div class="space-y-2">
                                <Label for="fi_username">F&amp;I Username</Label>
                                <Input id="fi_username" v-model="complianceForm.fi_username" />
                            </div>
                            <div class="space-y-2">
                                <Label for="fi_password">F&amp;I Password</Label>
                                <Input id="fi_password" v-model="complianceForm.fi_password" type="password" />
                            </div>
                            <div class="space-y-2">
                                <Label for="standard_dpp_rate">Standard DPP Rate (%)</Label>
                                <Input id="standard_dpp_rate" v-model="complianceForm.standard_dpp_rate" type="number" step="0.01" min="0" max="100" />
                                <InputError :message="complianceForm.errors.standard_dpp_rate" />
                            </div>
                            <div class="flex items-center justify-between md:col-span-2 pt-2">
                                <Label for="reinsurance" class="cursor-pointer">Reinsurance</Label>
                                <Checkbox id="reinsurance" v-model="complianceForm.reinsurance" />
                            </div>

                            <div class="md:col-span-2 space-y-2">
                                <Label>Service Contracts</Label>
                                <div v-for="(_, index) in complianceForm.service_contracts" :key="`sc-${index}`" class="flex gap-2">
                                    <Input v-model="complianceForm.service_contracts[index]" />
                                    <Button type="button" variant="outline" size="sm" @click="removeComplianceRow('service_contracts', index)">Remove</Button>
                                </div>
                                <Button type="button" variant="outline" size="sm" @click="addComplianceRow('service_contracts')">Add Service Contract</Button>
                            </div>

                            <div class="md:col-span-2 space-y-2">
                                <Label>Tire &amp; Wheel</Label>
                                <div v-for="(_, index) in complianceForm.tire_wheel" :key="`tw-${index}`" class="flex gap-2">
                                    <Input v-model="complianceForm.tire_wheel[index]" />
                                    <Button type="button" variant="outline" size="sm" @click="removeComplianceRow('tire_wheel', index)">Remove</Button>
                                </div>
                                <Button type="button" variant="outline" size="sm" @click="addComplianceRow('tire_wheel')">Add Tire &amp; Wheel</Button>
                            </div>

                            <div class="md:col-span-2 space-y-2">
                                <Label>Other F&amp;I</Label>
                                <div v-for="(_, index) in complianceForm.other_fi" :key="`ofi-${index}`" class="flex gap-2">
                                    <Input v-model="complianceForm.other_fi[index]" />
                                    <Button type="button" variant="outline" size="sm" @click="removeComplianceRow('other_fi', index)">Remove</Button>
                                </div>
                                <Button type="button" variant="outline" size="sm" @click="addComplianceRow('other_fi')">Add Other F&amp;I</Button>
                            </div>
                        </CardContent>
                    </Card>

                    <div v-if="can.update" class="flex justify-end">
                        <Button type="submit" :disabled="complianceForm.processing">
                            <Loader2 v-if="complianceForm.processing" class="mr-2 size-4 animate-spin" />
                            Save Compliance Info
                        </Button>
                    </div>
                </form>
            </div>

            <!-- Reset Courses -->
            <div v-else-if="section === 'reset-courses'" class="mx-auto max-w-5xl space-y-6">
                <Card>
                    <CardHeader>
                        <CardTitle>Reset Courses</CardTitle>
                        <CardDescription>
                            Clear course results for {{ store.name }}. Choose to reset everyone at this location or pick individual users.
                        </CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-6">
                        <div class="flex flex-wrap gap-2">
                            <Button
                                type="button"
                                :variant="resetMode === 'everyone' ? 'default' : 'outline'"
                                size="sm"
                                @click="resetMode = 'everyone'"
                            >
                                Everyone at this location
                            </Button>
                            <Button
                                type="button"
                                :variant="resetMode === 'selected-users' ? 'default' : 'outline'"
                                size="sm"
                                @click="resetMode = 'selected-users'"
                            >
                                Selected users
                            </Button>
                        </div>

                        <div v-if="resetMode === 'selected-users'" class="space-y-4">
                            <div class="relative">
                                <Search class="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-muted-foreground" />
                                <Input v-model="search" placeholder="Search by name or email" class="pl-9" />
                            </div>

                            <div class="overflow-hidden rounded-md border">
                                <Table>
                                    <TableHeader>
                                        <TableRow>
                                            <TableHead class="w-12">
                                                <Checkbox
                                                    :model-value="allVisibleSelected"
                                                    @update:model-value="(value) => toggleSelectAllVisible(Boolean(value))"
                                                />
                                            </TableHead>
                                            <TableHead>Name</TableHead>
                                            <TableHead>Email</TableHead>
                                            <TableHead>Status</TableHead>
                                        </TableRow>
                                    </TableHeader>
                                    <TableBody>
                                        <TableRow v-if="resettableUsers === undefined || resettableUsers === null">
                                            <TableCell colspan="4" class="py-6 text-center text-sm text-muted-foreground">
                                                <Loader2 class="mr-2 inline-block size-4 animate-spin" />
                                                Loading users...
                                            </TableCell>
                                        </TableRow>
                                        <TableRow v-else-if="resettableUsersList.length === 0">
                                            <TableCell colspan="4" class="py-6 text-center text-sm text-muted-foreground">
                                                No users at this location have course results yet.
                                            </TableCell>
                                        </TableRow>
                                        <TableRow v-for="user in resettableUsersList" :key="user.id">
                                            <TableCell>
                                                <Checkbox
                                                    :model-value="isUserSelected(user.id)"
                                                    @update:model-value="() => toggleUser(user.id)"
                                                />
                                            </TableCell>
                                            <TableCell class="font-medium">{{ user.name }}</TableCell>
                                            <TableCell class="text-sm text-muted-foreground">{{ user.email }}</TableCell>
                                            <TableCell>
                                                <span
                                                    class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium"
                                                    :class="statusClass[user.status]"
                                                >
                                                    {{ statusLabel[user.status] }}
                                                </span>
                                            </TableCell>
                                        </TableRow>
                                    </TableBody>
                                </Table>
                            </div>

                            <p class="text-xs text-muted-foreground">
                                {{ selectedUserIds.length }} user(s) selected.
                            </p>
                        </div>

                        <Separator />

                        <div class="flex justify-end">
                            <Button
                                type="button"
                                variant="destructive"
                                :disabled="resetMode === 'selected-users' && selectedUserIds.length === 0"
                                @click="requestReset"
                            >
                                Reset Courses
                            </Button>
                        </div>
                    </CardContent>
                </Card>

                <Dialog v-model:open="confirmOpen">
                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>Reset courses</DialogTitle>
                            <DialogDescription>{{ confirmMessage }}</DialogDescription>
                        </DialogHeader>
                        <DialogFooter>
                            <Button variant="outline" :disabled="resetting" @click="cancelReset">Cancel</Button>
                            <Button variant="destructive" :disabled="resetting" @click="confirmReset">
                                <Loader2 v-if="resetting" class="mr-2 size-4 animate-spin" />
                                Confirm Reset
                            </Button>
                        </DialogFooter>
                    </DialogContent>
                </Dialog>
            </div>

            <!-- Fallback (unexpected section) -->
            <div v-else class="mx-auto max-w-4xl">
                <Card>
                    <CardHeader>
                        <CardTitle class="capitalize">{{ section.replace('-', ' ') }}</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <p class="text-sm text-muted-foreground">Unknown section.</p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
