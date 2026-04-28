<script setup lang="ts">
import { computed } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Loader2, Send } from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import AutomatedReportsController from '@/actions/App/Http/Controllers/Tenant/Settings/AutomatedReportsController';
import automatedReports from '@/routes/dealer/settings/automated-reports';
import type { BreadcrumbItem } from '@/types';

type Recipient = {
    id: number;
    name: string;
    email: string;
};

type FrequencyOption = {
    value: string;
    label: string;
};

type Settings = {
    compliance_summary_active: boolean;
    compliance_summary_frequency: string;
    compliance_summary_recipients: number[];
};

const props = defineProps<{
    settings: Settings;
    availableRecipients: Recipient[];
    frequencies: FrequencyOption[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Automated Reports', href: automatedReports.index.url() },
];

const form = useForm({
    compliance_summary_active: props.settings.compliance_summary_active,
    compliance_summary_frequency: props.settings.compliance_summary_frequency,
    compliance_summary_recipients: [...props.settings.compliance_summary_recipients],
});

const sending = computed(() => form.processing);

const isRecipientSelected = (id: number): boolean =>
    form.compliance_summary_recipients.includes(id);

const toggleRecipient = (id: number, checked: boolean): void => {
    if (checked) {
        if (!form.compliance_summary_recipients.includes(id)) {
            form.compliance_summary_recipients = [...form.compliance_summary_recipients, id];
        }
        return;
    }

    form.compliance_summary_recipients = form.compliance_summary_recipients.filter(
        (recipientId) => recipientId !== id,
    );
};

const submit = (): void => {
    form.patch(AutomatedReportsController.update.url(), {
        preserveScroll: true,
    });
};

const sendNow = (): void => {
    router.post(
        AutomatedReportsController.sendNow.url(),
        {
            compliance_summary_frequency: form.compliance_summary_frequency,
            compliance_summary_recipients: form.compliance_summary_recipients,
        },
        { preserveScroll: true },
    );
};
</script>

<template>
    <Head title="Automated Reports" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto w-full max-w-3xl space-y-6 px-4 py-6">
            <Heading
                title="Automated Reports"
                description="Configure the automated compliance summary email."
            />

            <form class="space-y-8 rounded-md border bg-card p-6" @submit.prevent="submit">
                <div class="space-y-1">
                    <h2 class="text-base font-medium">Automated Compliance Summary Email</h2>
                    <p class="text-sm text-muted-foreground">
                        When enabled, a PDF compliance summary report is automatically emailed to
                        the selected recipients on the chosen schedule.
                    </p>
                </div>

                <Separator />

                <div class="flex items-center justify-between gap-4">
                    <div class="space-y-1">
                        <Label for="compliance_summary_active" class="text-sm font-medium">
                            Enable compliance summary emails
                        </Label>
                        <p class="text-xs text-muted-foreground">
                            Toggle off to pause delivery without losing your recipient list.
                        </p>
                    </div>
                    <Checkbox
                        id="compliance_summary_active"
                        :model-value="form.compliance_summary_active"
                        @update:model-value="(value) => (form.compliance_summary_active = value === true)"
                    />
                </div>

                <Separator />

                <div class="space-y-3">
                    <div>
                        <h3 class="text-sm font-medium">Frequency</h3>
                        <p class="text-xs text-muted-foreground">
                            Reports send on the first day of the selected period.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-6">
                        <label
                            v-for="option in frequencies"
                            :key="option.value"
                            class="flex cursor-pointer items-center gap-2 text-sm"
                        >
                            <input
                                v-model="form.compliance_summary_frequency"
                                type="radio"
                                :value="option.value"
                                class="h-4 w-4 border-input text-primary focus:ring-ring"
                            />
                            <span>{{ option.label }}</span>
                        </label>
                    </div>
                    <InputError :message="form.errors.compliance_summary_frequency" />
                </div>

                <Separator />

                <div class="space-y-3">
                    <div>
                        <h3 class="text-sm font-medium">Recipients</h3>
                        <p class="text-xs text-muted-foreground">
                            Select the users who should receive the compliance summary. At least
                            one recipient is required when the feature is enabled.
                        </p>
                    </div>

                    <p
                        v-if="availableRecipients.length === 0"
                        class="text-sm italic text-muted-foreground"
                    >
                        No qualifying users found. Users with Owner, GM, CFO, GSM, or Qualified
                        Individual roles will appear here.
                    </p>

                    <div
                        v-else
                        class="divide-y divide-border overflow-hidden rounded-md border"
                    >
                        <label
                            v-for="recipient in availableRecipients"
                            :key="recipient.id"
                            class="flex cursor-pointer items-center gap-4 px-4 py-3 hover:bg-muted/50"
                        >
                            <Checkbox
                                :model-value="isRecipientSelected(recipient.id)"
                                @update:model-value="(value) => toggleRecipient(recipient.id, value === true)"
                            />
                            <div class="min-w-0">
                                <span class="block text-sm font-medium capitalize">{{ recipient.name }}</span>
                                <span class="block truncate text-xs text-muted-foreground">{{ recipient.email.toLowerCase() }}</span>
                            </div>
                        </label>
                    </div>

                    <InputError :message="form.errors.compliance_summary_recipients" />
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                    <Button
                        type="button"
                        variant="outline"
                        :disabled="sending"
                        @click="sendNow"
                    >
                        <Send class="size-3.5" />
                        Send Report Now
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        <Loader2 v-if="form.processing" class="size-3.5 animate-spin" />
                        Save Settings
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
