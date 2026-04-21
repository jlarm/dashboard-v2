<script setup lang="ts">
import { ref } from "vue";
import { Form } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import ContractController from "@/actions/App/Http/Controllers/Central/ContractController";
import { Loader2, Trash2 } from "lucide-vue-next";

const props = defineProps<{
    contract: { uuid: string; dealer_name: string };
}>();

const open = ref(false);

const handleSuccess = (): void => {
    open.value = false;
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button size="sm" variant="outline" class="hover:text-red-500 hover:bg-red-50">
                <Trash2 class="h-4 w-4" />
            </Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Delete Contract</DialogTitle>
                <DialogDescription>
                    Are you sure you want to delete the contract for
                    <span class="font-semibold">{{ props.contract.dealer_name }}</span>? This cannot be undone.
                </DialogDescription>
            </DialogHeader>
            <Form
                v-slot="{ processing }"
                :action="ContractController.destroy(props.contract.uuid)"
                @success="handleSuccess"
            >
                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Cancel</Button>
                    </DialogClose>
                    <Button type="submit" variant="destructive" :disabled="processing">
                        <Loader2 v-if="processing" class="animate-spin" />
                        Delete
                    </Button>
                </DialogFooter>
            </Form>
        </DialogContent>
    </Dialog>
</template>
