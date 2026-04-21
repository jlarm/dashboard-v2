<script setup lang="ts">
import { ref } from "vue";
import ViolationStatementController from "@/actions/App/Http/Controllers/Central/ViolationStatementController";
import { router } from "@inertiajs/vue3";
import { Loader2 } from "lucide-vue-next";
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import { Button } from "@/components/ui/button";

const props = defineProps<{
    statement: {
        id: number;
        statement: string;
    };
}>();

const open = ref(false);
const processing = ref(false);

const handleDelete = (): void => {
    processing.value = true;
    router.delete(
        ViolationStatementController.destroy({ violationStatement: props.statement.id }).url,
        {
            onFinish: () => {
                processing.value = false;
            },
            onSuccess: () => {
                open.value = false;
            },
        },
    );
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <slot />
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>Delete Violation Statement</DialogTitle>
            </DialogHeader>
            <p class="text-sm text-muted-foreground">
                Are you sure you want to delete <strong>{{ statement.statement }}</strong>? This action cannot be undone.
            </p>
            <DialogFooter>
                <DialogClose as-child>
                    <Button type="button" variant="outline">Cancel</Button>
                </DialogClose>
                <Button variant="destructive" :disabled="processing" @click="handleDelete">
                    <Loader2 v-if="processing" class="animate-spin" />
                    Delete
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
