<script setup lang="ts">
import SwitchStoreController from '@/actions/App/Http/Controllers/Tenant/Store/SwitchStoreController';
import AddLocationDialog from '@/components/tenant/AddLocationDialog.vue';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar';
import type { StoreOption } from '@/types/global';
import { router, usePage } from '@inertiajs/vue3';
import { Check, ChevronsUpDown, Plus } from 'lucide-vue-next';
import { computed, ref } from 'vue';

const page = usePage();

const stores = computed<StoreOption[]>(() => page.props.stores ?? []);
const currentStoreId = computed(() => page.props.auth.current_store_id ?? null);
const roles = computed(() => page.props.auth.roles ?? []);

const isPrivilegedRole = computed(() =>
    roles.value.some((role) => role === 'super-admin' || role === 'Consultant'),
);

const canManageLocations = computed(() => isPrivilegedRole.value);

const canUseOverview = computed(
    () => stores.value.length > 1 || isPrivilegedRole.value,
);

const currentStore = computed<StoreOption | null>(() => {
    if (currentStoreId.value !== null) {
        const match = stores.value.find((store) => store.id === currentStoreId.value);
        if (match) {
            return match;
        }
    }

    return stores.value.length === 1 ? stores.value[0] : null;
});

const displayName = computed(() => {
    if (currentStore.value) {
        return currentStore.value.name;
    }

    return canUseOverview.value ? 'Overview' : page.props.name;
});

const { isMobile, state } = useSidebar();

const addLocationOpen = ref(false);

function switchStore(storeId: number | null): void {
    if (storeId === currentStoreId.value) {
        return;
    }

    router.post(
        SwitchStoreController.url(),
        { store_id: storeId },
        { preserveScroll: true },
    );
}
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton
                        size="lg"
                        class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                        data-test="store-switcher-trigger"
                    >
                        <div
                            class="flex aspect-square size-8 items-center justify-center rounded-md bg-white ring-1 ring-border dark:bg-neutral-900"
                        >
                            <img
                                src="/favicon.svg"
                                alt=""
                                class="size-5"
                            />
                        </div>
                        <div class="ml-1 grid flex-1 text-left text-sm leading-tight">
                            <span class="truncate font-semibold">
                                {{ displayName }}
                            </span>
                            <span class="truncate text-xs text-muted-foreground">
                                Location
                            </span>
                        </div>
                        <ChevronsUpDown class="ml-auto size-4" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent
                    class="w-(--reka-dropdown-menu-trigger-width) min-w-56 rounded-lg"
                    :side="isMobile ? 'bottom' : state === 'collapsed' ? 'right' : 'right'"
                    align="start"
                    :side-offset="4"
                >
                    <DropdownMenuLabel class="text-xs text-muted-foreground">
                        Locations
                    </DropdownMenuLabel>

                    <DropdownMenuItem
                        v-if="canUseOverview"
                        class="my-0.5 gap-2 p-2 data-[active=true]:bg-sidebar-accent data-[active=true]:text-sidebar-accent-foreground data-[active=true]:font-medium"
                        :data-active="currentStoreId === null"
                        @select="switchStore(null)"
                    >
                        <span class="truncate">Overview</span>
                        <Check
                            v-if="currentStoreId === null"
                            class="ml-auto size-4"
                        />
                    </DropdownMenuItem>

                    <DropdownMenuItem
                        v-for="store in stores"
                        :key="store.id"
                        class="my-0.5 gap-2 p-2 data-[active=true]:bg-sidebar-accent data-[active=true]:text-sidebar-accent-foreground data-[active=true]:font-medium"
                        :data-active="store.id === currentStoreId"
                        @select="switchStore(store.id)"
                    >
                        <span class="truncate">{{ store.name }}</span>
                        <Check
                            v-if="store.id === currentStoreId"
                            class="ml-auto size-4"
                        />
                    </DropdownMenuItem>

                    <template v-if="canManageLocations">
                        <DropdownMenuSeparator />
                        <DropdownMenuItem
                            class="gap-2 p-2"
                            @select="addLocationOpen = true"
                        >
                            <div
                                class="flex size-6 items-center justify-center rounded-sm border bg-background"
                            >
                                <Plus class="size-3.5" />
                            </div>
                            <span class="text-muted-foreground">Add location</span>
                        </DropdownMenuItem>
                    </template>
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>

        <AddLocationDialog v-if="canManageLocations" v-model:open="addLocationOpen" />
    </SidebarMenu>
</template>
