<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { AlertTriangle } from 'lucide-vue-next';
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
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

type StoreOption = { id: number; name: string };

const props = defineProps<{
    stores: StoreOption[];
    multipleStoresExist: boolean;
    hasQualifiedIndividual: boolean;
}>();

const open = defineModel<boolean>('open', { default: false });

const form = useForm({
    name: '',
    contact_name: '',
    contact_email: '',
    store_id: null as number | null,
});

const submit = (): void => {
    form.post(VendorController.store.url(), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            open.value = false;
        },
    });
};

const cancel = (): void => {
    form.reset();
    form.clearErrors();
    open.value = false;
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogContent class="sm:max-w-lg">
            <DialogHeader>
                <DialogTitle>Add Vendor</DialogTitle>
                <DialogDescription>
                    Send a Risk Assessment form to a third-party vendor for sign-off.
                </DialogDescription>
            </DialogHeader>

            <div
                v-if="!props.hasQualifiedIndividual"
                class="flex items-start gap-2 rounded-md border border-amber-200 bg-amber-50 p-3 text-sm text-amber-800"
            >
                <AlertTriangle class="mt-0.5 size-4 shrink-0" />
                <p>A Qualified Individual must be set before adding a vendor.</p>
            </div>

            <form class="grid gap-4" @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="name">Company Name</Label>
                    <Input id="name" v-model="form.name" type="text" required autofocus />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="contact_name">Contact Name</Label>
                    <Input id="contact_name" v-model="form.contact_name" type="text" required />
                    <InputError :message="form.errors.contact_name" />
                </div>

                <div class="grid gap-2">
                    <Label for="contact_email">Contact Email</Label>
                    <Input id="contact_email" v-model="form.contact_email" type="email" required />
                    <InputError :message="form.errors.contact_email" />
                </div>

                <div v-if="props.multipleStoresExist" class="grid gap-2">
                    <Label for="store_id">Location (optional)</Label>
                    <Select
                        :model-value="form.store_id ? String(form.store_id) : ''"
                        @update:model-value="(value) => (form.store_id = value ? Number(value) : null)"
                    >
                        <SelectTrigger id="store_id" class="w-full">
                            <SelectValue placeholder="All Locations" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem
                                v-for="store in props.stores"
                                :key="store.id"
                                :value="String(store.id)"
                            >
                                {{ store.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError :message="form.errors.store_id" />
                </div>

                <DialogFooter class="gap-2">
                    <Button type="button" variant="outline" @click="cancel">Cancel</Button>
                    <Button
                        type="submit"
                        :disabled="form.processing || !props.hasQualifiedIndividual"
                    >
                        {{ form.processing ? 'Creating...' : 'Create' }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
