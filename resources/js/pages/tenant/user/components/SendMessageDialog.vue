<script setup lang="ts">
import UserController from '@/actions/App/Http/Controllers/Tenant/UserController';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, watch } from 'vue';

type Filters = {
    search: string;
    department_ids: number[];
    role_ids: number[];
    only_incomplete: boolean;
    only_expired: boolean;
    only_expiring_soon: boolean;
    sort_field: 'name' | 'department' | 'role';
    sort_direction: 'asc' | 'desc';
};

const props = defineProps<{
    selectedUserIds: number[];
    selectAllAcrossPages: boolean;
    selectionCount: number;
    filters: Filters;
}>();

const open = defineModel<boolean>('open', { required: true });

const page = usePage<{ auth: { user: { name: string } } }>();
const senderName = computed(() => page.props.auth?.user?.name ?? '');

const defaultSubject = computed(() => `Message from ${senderName.value}`);
const defaultMessage = "This is a friendly reminder that you have outstanding compliance training courses that need to be completed. Please log in and complete your assigned courses at your earliest convenience. If you have any questions, please don't hesitate to reach out.";

const form = useForm({
    subject: defaultSubject.value,
    message_body: defaultMessage,
    select_all: false,
    user_ids: [] as number[],
    search: '',
    department_ids: [] as number[],
    role_ids: [] as number[],
    only_incomplete: false,
    only_expired: false,
    only_expiring_soon: false,
    sort_field: 'name' as Filters['sort_field'],
    sort_direction: 'asc' as Filters['sort_direction'],
});

watch(open, (isOpen) => {
    if (!isOpen) {
        return;
    }

    form.clearErrors();
    form.subject = defaultSubject.value;
    form.message_body = defaultMessage;
    form.select_all = props.selectAllAcrossPages;
    form.user_ids = props.selectAllAcrossPages ? [] : [...props.selectedUserIds];
    form.search = props.filters.search;
    form.department_ids = [...props.filters.department_ids];
    form.role_ids = [...props.filters.role_ids];
    form.only_incomplete = props.filters.only_incomplete;
    form.only_expired = props.filters.only_expired;
    form.only_expiring_soon = props.filters.only_expiring_soon;
    form.sort_field = props.filters.sort_field;
    form.sort_direction = props.filters.sort_direction;
});

const submit = () => {
    form.post(UserController.sendMessage.url(), {
        preserveScroll: true,
        onSuccess: () => {
            open.value = false;
        },
    });
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogContent class="sm:max-w-2xl">
            <DialogHeader>
                <DialogTitle>Send Custom Message</DialogTitle>
            </DialogHeader>

            <form class="space-y-4" @submit.prevent="submit">
                <div class="rounded-md border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-900">
                    Sending to <span class="font-semibold">{{ selectionCount }} {{ selectionCount === 1 ? 'employee' : 'employees' }}</span>. The subject and message below have been pre-filled for you — feel free to customize them before sending.
                </div>

                <div class="space-y-2">
                    <Label for="send-message-subject">Subject</Label>
                    <Input
                        id="send-message-subject"
                        v-model="form.subject"
                        type="text"
                        maxlength="255"
                        required
                    />
                    <p v-if="form.errors.subject" class="text-sm text-red-600">
                        {{ form.errors.subject }}
                    </p>
                </div>

                <div class="space-y-2">
                    <Label for="send-message-body">Message</Label>
                    <Textarea
                        id="send-message-body"
                        v-model="form.message_body"
                        rows="8"
                        maxlength="10000"
                        required
                    />
                    <p v-if="form.errors.message_body" class="text-sm text-red-600">
                        {{ form.errors.message_body }}
                    </p>
                </div>

                <DialogFooter>
                    <Button type="button" variant="outline" :disabled="form.processing" @click="open = false">
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing || selectionCount === 0">
                        {{ form.processing ? 'Sending...' : 'Send Message' }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
