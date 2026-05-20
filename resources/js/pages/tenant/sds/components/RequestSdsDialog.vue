<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Loader2 } from 'lucide-vue-next';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { Field, FieldError, FieldLabel } from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import sds from '@/routes/dealer/sds';

const open = ref(false);

const form = useForm({
    name: '',
    manufacturer: '',
});

const submit = (): void => {
    form.post(sds.request.url(), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            open.value = false;
        },
    });
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button size="sm" class="w-full sm:w-auto">Request SDS Sheet</Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-md">
            <DialogHeader>
                <DialogTitle>Request SDS Sheet</DialogTitle>
                <DialogDescription>
                    Send a request for a missing SDS sheet to be added to the library.
                </DialogDescription>
            </DialogHeader>

            <form class="space-y-5" @submit.prevent="submit">
                <Field>
                    <FieldLabel for="request-name">Chemical Name *</FieldLabel>
                    <Input
                        id="request-name"
                        v-model="form.name"
                        placeholder="Enter the chemical or product name"
                        autofocus
                        required
                    />
                    <FieldError v-if="form.errors.name">{{ form.errors.name }}</FieldError>
                </Field>

                <Field>
                    <FieldLabel for="request-manufacturer">Manufacturer</FieldLabel>
                    <Input
                        id="request-manufacturer"
                        v-model="form.manufacturer"
                        placeholder="Enter manufacturer name"
                    />
                    <FieldError v-if="form.errors.manufacturer">{{ form.errors.manufacturer }}</FieldError>
                </Field>

                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button type="submit" :disabled="form.processing">
                        <Loader2 v-if="form.processing" class="animate-spin" />
                        Submit Request
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
