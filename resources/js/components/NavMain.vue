<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ChevronRight } from 'lucide-vue-next';
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible';
import {
    SidebarGroup,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import type { NavItem } from '@/types';
import { computed } from 'vue';

const props = defineProps<{
    items: NavItem[];
}>();

const { isCurrentOrParentUrl } = useCurrentUrl();

const page = usePage<{ auth: { roles: string[] } }>();
const viewerRoles = computed(() => page.props.auth?.roles ?? []);

const isVisible = (item: NavItem): boolean => {
    if (!item.roles || item.roles.length === 0) {
        return true;
    }

    return item.roles.some((role) => viewerRoles.value.includes(role));
};

const visibleChildren = (item: NavItem): NavItem[] => {
    if (!item.children) {
        return [];
    }
    return item.children.filter(isVisible);
};

type DisplayItem = NavItem & { visibleChildren: NavItem[]; hasChildren: boolean };

const visibleItems = computed<DisplayItem[]>(() =>
    props.items
        .filter(isVisible)
        .map((item) => {
            const children = visibleChildren(item);
            return {
                ...item,
                visibleChildren: children,
                hasChildren: children.length > 0,
            };
        })
        .filter((item) => !item.children || item.hasChildren),
);

const isGroupOpen = (item: DisplayItem): boolean =>
    item.visibleChildren.some((child) => !child.external && isCurrentOrParentUrl(child.href));
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarMenu>
            <template v-for="item in visibleItems" :key="item.title">
                <Collapsible
                    v-if="item.hasChildren"
                    as-child
                    :default-open="isGroupOpen(item)"
                    class="group/collapsible"
                >
                    <SidebarMenuItem>
                        <CollapsibleTrigger as-child>
                            <SidebarMenuButton :tooltip="item.title">
                                <component :is="item.icon" />
                                <span>{{ item.title }}</span>
                                <ChevronRight class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                            </SidebarMenuButton>
                        </CollapsibleTrigger>
                        <CollapsibleContent>
                            <SidebarMenuSub>
                                <SidebarMenuSubItem v-for="child in item.visibleChildren" :key="child.title">
                                    <SidebarMenuSubButton
                                        as-child
                                        :is-active="!child.external && isCurrentOrParentUrl(child.href)"
                                        class="data-[active=true]:bg-primary/10 data-[active=true]:font-normal data-[active=true]:text-primary"
                                    >
                                        <a
                                            v-if="child.external"
                                            :href="typeof child.href === 'string' ? child.href : child.href.url"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            <component v-if="child.icon" :is="child.icon" />
                                            <span>{{ child.title }}</span>
                                        </a>
                                        <Link v-else :href="child.href">
                                            <component v-if="child.icon" :is="child.icon" />
                                            <span>{{ child.title }}</span>
                                        </Link>
                                    </SidebarMenuSubButton>
                                </SidebarMenuSubItem>
                            </SidebarMenuSub>
                        </CollapsibleContent>
                    </SidebarMenuItem>
                </Collapsible>
                <SidebarMenuItem v-else>
                    <SidebarMenuButton
                        as-child
                        :is-active="!item.external && isCurrentOrParentUrl(item.href)"
                        :tooltip="item.title"
                        class="data-[active=true]:bg-primary/10 data-[active=true]:font-normal data-[active=true]:text-primary data-[active=true]:[&_svg]:text-primary"
                    >
                        <a
                            v-if="item.external"
                            :href="typeof item.href === 'string' ? item.href : item.href.url"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <component :is="item.icon" />
                            <span>{{ item.title }}</span>
                        </a>
                        <Link v-else :href="item.href">
                            <component :is="item.icon" />
                            <span>{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </template>
        </SidebarMenu>
    </SidebarGroup>
</template>
