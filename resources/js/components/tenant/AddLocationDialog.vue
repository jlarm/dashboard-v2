<script setup lang="ts">
import CreateStoreController from '@/actions/App/Http/Controllers/Tenant/Store/CreateStoreController';
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
import { STATE_OPTIONS } from '@/lib/states';
import { useForm } from '@inertiajs/vue3';

const open = defineModel<boolean>('open', { default: false });

const form = useForm({
    name: '',
    address: '',
    city: '',
    state: '',
    postal_code: '',
    phone: '',
    website: '',
});

function submit(): void {
    form.post(CreateStoreController.url(), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            open.value = false;
        },
    });
}

function cancel(): void {
    form.reset();
    form.clearErrors();
    open.value = false;
}
</script>

<template>
    <Dialog v-model:open="open">
        <DialogContent class="sm:max-w-2xl">
            <DialogHeader>
                <DialogTitle>Add Location</DialogTitle>
                <DialogDescription class="sr-only">
                    Create a new location.
                </DialogDescription>
            </DialogHeader>

            <form class="grid gap-4" @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input
                        id="name"
                        v-model="form.name"
                        type="text"
                        required
                        autofocus
                    />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="address">Address</Label>
                    <Input
                        id="address"
                        v-model="form.address"
                        type="text"
                        required
                    />
                    <InputError :message="form.errors.address" />
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="grid gap-2">
                        <Label for="city">City</Label>
                        <Input
                            id="city"
                            v-model="form.city"
                            type="text"
                            required
                        />
                        <InputError :message="form.errors.city" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="state">State</Label>
                        <Select v-model="form.state">
                            <SelectTrigger id="state" class="w-full">
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
                        <Label for="postal_code">Postal Code</Label>
                        <Input
                            id="postal_code"
                            v-model="form.postal_code"
                            type="text"
                            required
                        />
                        <InputError :message="form.errors.postal_code" />
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="phone">Phone</Label>
                        <Input
                            id="phone"
                            v-model="form.phone"
                            type="tel"
                            required
                        />
                        <InputError :message="form.errors.phone" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="website">Website</Label>
                        <Input
                            id="website"
                            v-model="form.website"
                            type="text"
                            required
                        />
                        <InputError :message="form.errors.website" />
                    </div>
                </div>

                <DialogFooter class="gap-2">
                    <Button type="button" variant="outline" @click="cancel">
                        Cancel
                    </Button>
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Creating...' : 'Create' }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
