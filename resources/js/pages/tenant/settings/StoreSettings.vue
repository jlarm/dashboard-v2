<script setup lang="ts">
import { watch } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Loader2 } from 'lucide-vue-next';
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

const props = defineProps<{
    section: Section;
    store: StoreSummary;
    can: { update: boolean; manage_dealerships: boolean };
    general?: GeneralPayload | null;
    managers?: ManagersPayload | null;
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
    form.phone = payload.store.phone ?? '';
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
    managersForm.qualified_individual_phone = payload.qualified_individual_phone ?? '';
    managersForm.service_manager_name = payload.service_manager_name ?? '';
    managersForm.service_manager_phone = payload.service_manager_phone ?? '';
    managersForm.parts_manager_name = payload.parts_manager_name ?? '';
    managersForm.parts_manager_phone = payload.parts_manager_phone ?? '';
    managersForm.body_shop_manager_name = payload.body_shop_manager_name ?? '';
    managersForm.body_shop_manager_phone = payload.body_shop_manager_phone ?? '';
    managersForm.general_manager_name = payload.general_manager_name ?? '';
    managersForm.general_manager_phone = payload.general_manager_phone ?? '';
    managersForm.owner_name = payload.owner_name ?? '';
    managersForm.owner_phone = payload.owner_phone ?? '';
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
                                    <Input id="phone" v-model="form.phone" />
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
                                    <Input :id="role.phoneKey" v-model="managersForm[role.phoneKey] as string" />
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

            <!-- Compliance / Reset / Ridgeback placeholders -->
            <div v-else class="mx-auto max-w-4xl">
                <Card>
                    <CardHeader>
                        <CardTitle class="capitalize">{{ section.replace('-', ' ') }}</CardTitle>
                        <CardDescription>This section is being rebuilt.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Separator class="mb-4" />
                        <p class="text-sm text-muted-foreground">
                            The {{ section.replace('-', ' ') }} settings will move here in a follow-up commit.
                        </p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
