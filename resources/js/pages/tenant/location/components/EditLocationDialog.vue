<script setup lang="ts">
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Loader2 } from 'lucide-vue-next';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import LocationController from '@/actions/App/Http/Controllers/Tenant/Store/LocationController';
import { STATE_OPTIONS } from '@/lib/states';
import type { Location } from '@/pages/tenant/location/Index.vue';

const props = defineProps<{
    location: Location | null;
}>();

const open = defineModel<boolean>('open', { required: true });

const form = useForm({
    name: '',
    address: '',
    city: '',
    state: '',
    postal_code: '',
    phone: '',
    website: '',
});

watch(
    () => props.location,
    (next) => {
        if (!next) {
            return;
        }

        form.defaults({
            name: next.name ?? '',
            address: next.address ?? '',
            city: next.city ?? '',
            state: next.state ?? '',
            postal_code: next.postal_code ?? '',
            phone: next.phone ?? '',
            website: next.website ?? '',
        });
        form.reset();
        form.clearErrors();
    },
    { immediate: true },
);

const submit = (): void => {
    if (!props.location) {
        return;
    }

    form.patch(LocationController.update.url({ store: props.location.id }), {
        preserveScroll: true,
        onSuccess: () => {
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
        <DialogContent class="sm:max-w-2xl">
            <DialogHeader>
                <DialogTitle>Edit Location</DialogTitle>
            </DialogHeader>
            <form class="grid gap-4" @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="edit_name">Name</Label>
                    <Input id="edit_name" v-model="form.name" type="text" required autofocus />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="edit_address">Address</Label>
                    <Input id="edit_address" v-model="form.address" type="text" required />
                    <InputError :message="form.errors.address" />
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="grid gap-2">
                        <Label for="edit_city">City</Label>
                        <Input id="edit_city" v-model="form.city" type="text" required />
                        <InputError :message="form.errors.city" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="edit_state">State</Label>
                        <Select v-model="form.state">
                            <SelectTrigger id="edit_state" class="w-full">
                                <SelectValue placeholder="Select" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="option in STATE_OPTIONS"
                                    :key="option.value"
                                    :value="option.value"
                                >
                                    {{ option.label }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <InputError :message="form.errors.state" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="edit_postal_code">Postal Code</Label>
                        <Input id="edit_postal_code" v-model="form.postal_code" type="text" required />
                        <InputError :message="form.errors.postal_code" />
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="edit_phone">Phone</Label>
                        <Input id="edit_phone" v-model="form.phone" type="tel" required />
                        <InputError :message="form.errors.phone" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="edit_website">Website</Label>
                        <Input id="edit_website" v-model="form.website" type="text" required />
                        <InputError :message="form.errors.website" />
                    </div>
                </div>

                <DialogFooter class="gap-2">
                    <Button type="button" variant="outline" @click="cancel">Cancel</Button>
                    <Button type="submit" :disabled="form.processing">
                        <Loader2 v-if="form.processing" class="animate-spin" />
                        Save
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
