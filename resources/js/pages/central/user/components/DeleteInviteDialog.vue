<script setup lang="ts">

import {Loader2, Trash2} from "lucide-vue-next";
import {Button} from "@/components/ui/button";
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from "@/components/ui/dialog";
import {Form} from "@inertiajs/vue3";
import {ref} from "vue";
import invites from "@/routes/employees/invites";

type Invite = {
    id: number;
    name: string;
}

defineProps<{
    invite: Invite
}>();

const open = ref(false);

const handleSuccess = (): void => {
    open.value = false;
}
</script>

<template>
    <Dialog v-model:open="open">
        <DialogTrigger as-child>
            <Button size="sm" variant="destructive">
                <Trash2 />
            </Button>
        </DialogTrigger>
        <DialogContent>
            <DialogHeader>
                <DialogTitle>
                    Delete Invite
                </DialogTitle>
                <DialogDescription>
                    Are you sure you want to delete {{ invite.name }}'s invite?
                </DialogDescription>
            </DialogHeader>
            <Form
                v-slot="{ processing }"
                :action="invites.destroy(invite)"
                reset-on-success
                @success="handleSuccess"
            >
                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline">Close</Button>
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
