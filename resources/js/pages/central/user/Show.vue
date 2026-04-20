<script setup lang="ts">
import {User} from "@/types/user";

const { user } = defineProps<{
    user: User;
}>();
</script>

<template>
    <div>
        Name: {{ user.name }}
    </div>
</template>
