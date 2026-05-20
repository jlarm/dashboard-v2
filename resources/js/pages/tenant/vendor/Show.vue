<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import {
    ArrowLeft,
    ChevronRight,
    Clock,
    Download,
    Loader2,
    Send,
    Trash2,
} from 'lucide-vue-next';
import AppLayout from '@/layouts/tenant/AppLayout.vue';
import VendorController from '@/actions/App/Http/Controllers/Dealer/VendorController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import vendor from '@/routes/dealer/vendor';
import type { BreadcrumbItem } from '@/types';

type EmailLog = {
    id: number;
    event_type: string | null;
    delivery_message: string | null;
    sent_at: string | null;
};

type VendorFormRow = {
    id: number;
    name: string;
    email: string;
    created_at: string | null;
    is_completed: boolean;
    email_logs: EmailLog[];
};

type VendorDetail = {
    id: number;
    name: string;
    contact_name: string;
    contact_email: string;
    store: { id: number; name: string } | null;
    created_at: string | null;
    has_legacy_signature: boolean;
    is_legacy: boolean;
};

const props = defineProps<{
    vendor: VendorDetail;
    forms: VendorFormRow[];
    multipleStoresExist: boolean;
    can: { update: boolean; delete: boolean };
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Vendors', href: vendor.index.url() },
    { title: props.vendor.name, href: vendor.show.url({ vendor: props.vendor.id }) },
];

const sendOpen = ref(false);

const sendForm = useForm({
    name: '',
    email: '',
});

const submitSend = (): void => {
    sendForm.post(VendorController.sendForm.url({ vendor: props.vendor.id }), {
        preserveScroll: true,
        onSuccess: () => {
            sendForm.reset();
            sendOpen.value = false;
        },
    });
};

const cancelSend = (): void => {
    sendForm.reset();
    sendForm.clearErrors();
    sendOpen.value = false;
};

const expandedFormId = ref<number | null>(null);

const toggleForm = (id: number): void => {
    expandedFormId.value = expandedFormId.value === id ? null : id;
};

const deleteOpen = ref(false);
const deleting = ref(false);

const confirmDelete = (): void => {
    deleting.value = true;
    router.delete(VendorController.destroy.url({ vendor: props.vendor.id }), {
        preserveScroll: false,
        onFinish: () => {
            deleting.value = false;
            deleteOpen.value = false;
        },
    });
};

const downloadUrl = (formId: number): string =>
    VendorController.downloadForm.url({ vendorForm: formId });

const formatDate = (iso: string | null): string => {
    if (!iso) {
        return '';
    }
    const d = new Date(iso);
    return d.toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: '2-digit' });
};

const eventBadgeClass = (type: string | null): string => {
    switch (type) {
        case 'accepted':
            return 'bg-emerald-100 text-emerald-700';
        case 'delivered':
            return 'bg-sky-100 text-sky-700';
        case 'opened':
            return 'bg-indigo-100 text-indigo-700';
        case 'clicked':
            return 'bg-violet-100 text-violet-700';
        case 'complained':
        case 'permanent_fail':
            return 'bg-red-100 text-red-700';
        default:
            return 'bg-muted text-muted-foreground';
    }
};

const sortedForms = computed<VendorFormRow[]>(() => props.forms);
</script>

<template>
    <Head :title="props.vendor.name" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 px-4 py-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <Link
                        :href="vendor.index.url()"
                        class="inline-flex size-8 items-center justify-center rounded-md border text-muted-foreground hover:bg-muted hover:text-foreground"
                        aria-label="Back to vendors"
                    >
                        <ArrowLeft class="size-4" />
                    </Link>
                    <div>
                        <h1 class="text-xl font-semibold capitalize tracking-tight">
                            {{ props.vendor.name.toLowerCase() }}
                        </h1>
                        <p v-if="props.multipleStoresExist" class="text-sm text-muted-foreground">
                            {{ props.vendor.store ? props.vendor.store.name : 'All Locations' }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <Button
                        v-if="props.can.update"
                        size="sm"
                        @click="sendOpen = true"
                    >
                        <Send class="size-3.5" />
                        Send a new request
                    </Button>
                    <Button
                        v-if="props.can.delete"
                        variant="outline"
                        size="sm"
                        class="text-red-600 hover:bg-red-50 hover:text-red-700"
                        @click="deleteOpen = true"
                    >
                        <Trash2 class="size-3.5" />
                        Delete
                    </Button>
                </div>
            </div>

            <div class="space-y-6">
                <section class="rounded-lg border bg-card">
                        <header class="flex items-center justify-between border-b px-5 py-3">
                            <h2 class="text-sm font-semibold">Activity</h2>
                            <span class="text-xs text-muted-foreground">{{ sortedForms.length }} requests</span>
                        </header>

                        <div v-if="sortedForms.length === 0" class="px-5 py-12 text-center text-sm text-muted-foreground">
                            No form requests have been sent yet.
                        </div>

                        <ul v-else class="divide-y">
                            <li v-for="form in sortedForms" :key="form.id">
                                <button
                                    type="button"
                                    class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left transition hover:bg-muted/40"
                                    @click="toggleForm(form.id)"
                                >
                                    <div class="flex items-start gap-3">
                                        <ChevronRight
                                            class="mt-0.5 size-4 text-muted-foreground transition"
                                            :class="expandedFormId === form.id ? 'rotate-90 text-foreground' : ''"
                                        />
                                        <div>
                                            <p class="text-sm font-medium text-foreground">{{ form.name }}</p>
                                            <p class="text-xs text-muted-foreground">{{ form.email.toLowerCase() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-1">
                                        <span class="text-xs text-muted-foreground tabular-nums">
                                            {{ formatDate(form.created_at) }}
                                        </span>
                                        <span
                                            :class="[
                                                'inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase',
                                                form.is_completed
                                                    ? 'bg-emerald-100 text-emerald-700'
                                                    : 'bg-muted text-muted-foreground',
                                            ]"
                                        >
                                            {{ form.is_completed ? 'Completed' : 'Pending' }}
                                        </span>
                                    </div>
                                </button>

                                <div v-if="expandedFormId === form.id" class="border-t bg-muted/20 px-5 py-4">
                                    <div v-if="form.is_completed" class="mb-3">
                                        <Button as-child size="sm" variant="outline">
                                            <a :href="downloadUrl(form.id)">
                                                <Download class="size-3.5" />
                                                Download response
                                            </a>
                                        </Button>
                                    </div>

                                    <p class="mb-2 text-[10px] font-semibold uppercase tracking-wide text-muted-foreground">
                                        Communication history
                                    </p>

                                    <div v-if="form.email_logs.length === 0" class="rounded-md border border-dashed bg-background px-4 py-6 text-center">
                                        <p class="text-xs font-semibold text-foreground">No history</p>
                                        <p class="mt-1 text-[11px] text-muted-foreground">
                                            No automated reminders have been sent to this contact yet. The system sends
                                            a reminder every 30 days until the form is completed.
                                        </p>
                                    </div>

                                    <ul v-else class="space-y-2">
                                        <li
                                            v-for="log in form.email_logs"
                                            :key="log.id"
                                            class="rounded-md border bg-background p-3"
                                        >
                                            <div class="flex items-center justify-between gap-2">
                                                <div class="flex items-center gap-2 text-xs text-muted-foreground">
                                                    <Clock class="size-3.5" />
                                                    Reminder sent
                                                </div>
                                                <span class="text-[11px] tabular-nums text-muted-foreground">
                                                    {{ formatDate(log.sent_at) }}
                                                </span>
                                            </div>
                                            <div class="mt-2 flex items-center justify-between gap-2">
                                                <span
                                                    :class="['inline-flex items-center rounded px-1.5 py-0.5 text-[10px] font-semibold uppercase', eventBadgeClass(log.event_type)]"
                                                >
                                                    {{ log.event_type ?? 'unknown' }}
                                                </span>
                                                <span v-if="log.delivery_message" class="text-[11px] italic text-muted-foreground">
                                                    {{ log.delivery_message }}
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </section>
            </div>
        </div>

        <Dialog v-model:open="sendOpen">
            <DialogContent class="sm:max-w-lg">
                <DialogHeader>
                    <DialogTitle>Send a new request</DialogTitle>
                    <DialogDescription>
                        Email the Risk Assessment form to a new contact at this vendor.
                    </DialogDescription>
                </DialogHeader>
                <form class="grid gap-4" @submit.prevent="submitSend">
                    <div class="grid gap-2">
                        <Label for="send-name">Name</Label>
                        <Input id="send-name" v-model="sendForm.name" type="text" required autofocus />
                        <InputError :message="sendForm.errors.name" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="send-email">Email</Label>
                        <Input id="send-email" v-model="sendForm.email" type="email" required />
                        <InputError :message="sendForm.errors.email" />
                    </div>
                    <DialogFooter class="gap-2">
                        <Button type="button" variant="outline" :disabled="sendForm.processing" @click="cancelSend">
                            Cancel
                        </Button>
                        <Button type="submit" :disabled="sendForm.processing">
                            <Loader2 v-if="sendForm.processing" class="size-3.5 animate-spin" />
                            <Send v-else class="size-3.5" />
                            Send
                        </Button>
                    </DialogFooter>
                </form>
            </DialogContent>
        </Dialog>

        <Dialog v-model:open="deleteOpen">
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Delete vendor</DialogTitle>
                    <DialogDescription>
                        Are you sure you want to delete <span class="font-semibold">{{ props.vendor.name }}</span>?
                        Submitted forms will be archived.
                    </DialogDescription>
                </DialogHeader>
                <DialogFooter>
                    <Button type="button" variant="outline" :disabled="deleting" @click="deleteOpen = false">
                        Cancel
                    </Button>
                    <Button variant="destructive" :disabled="deleting" @click="confirmDelete">
                        <Loader2 v-if="deleting" class="size-3.5 animate-spin" />
                        Delete
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>
