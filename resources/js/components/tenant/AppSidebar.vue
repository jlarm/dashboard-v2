<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import GlobalSearch from '@/components/GlobalSearch.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/tenant/NavUser.vue';
import StoreSwitcher from '@/components/tenant/StoreSwitcher.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
} from '@/components/ui/sidebar';
import { AUDIT_VIEWERS, AUTOMATED_REPORT_VIEWERS, COURSES_NAV_VIEWERS, DOCUMENT_VIEWERS, EMPLOYEE_SECTION_VIEWERS, MANUAL_EDITORS, Role, SCAN_VIEWERS, VENDOR_VIEWERS } from '@/constants/roles';
import bodyShopAudit from '@/routes/dealer/audit/body-shop';
import dealJacketsAudit from '@/routes/dealer/audit/deal-jackets';
import financeAudit from '@/routes/dealer/audit/finance';
import oshaAudit from '@/routes/dealer/audit/osha';
import doc from '@/routes/dealer/doc';
import employees from '@/routes/dealer/employees';
import fitTests from '@/routes/dealer/fit-tests';
import locations from '@/routes/dealer/locations';
import logs from '@/routes/dealer/logs';
import isp from '@/routes/dealer/manual/isp';
import osha from '@/routes/dealer/manual/osha';
import redFlag from '@/routes/dealer/manual/red-flag';
import cms from '@/routes/dealer/manual/cms';
import scan from '@/routes/dealer/scan';
import sds from '@/routes/dealer/sds';
import vendor from '@/routes/dealer/vendor';
import settings from '@/routes/dealer/settings';
import dealer from '@/routes/dealer/dealer';
import automatedReports from '@/routes/dealer/settings/automated-reports';
import courses from '@/routes/dealer/courses';
import { dashboard } from '@/routes/dealer';
import type { NavItem } from '@/types';
import { Building2, ClipboardCheck, FileSignature, FileText, FileBarChart2, FlaskConical, GraduationCap, Handshake, HardHat, LayoutGrid, ScrollText, Search, Settings, ShieldCheck, Users } from 'lucide-vue-next';

const page = usePage<{ auth: { current_store_id: number | null } }>();

const hasCurrentStore = computed<boolean>(() => page.props.auth?.current_store_id !== null);
const showGlobalSettings = computed<boolean>(() => page.props.auth?.current_store_id === null);

const mainNavItems = computed<NavItem[]>(() => {
    const items: NavItem[] = [
        {
            title: 'Dashboard',
            href: dashboard(),
            icon: LayoutGrid,
        },
        {
            title: 'Courses',
            href: courses.index.url(),
            icon: GraduationCap,
            roles: COURSES_NAV_VIEWERS,
        },
        {
            title: 'Employees',
            href: employees.index.url(),
            icon: Users,
            roles: EMPLOYEE_SECTION_VIEWERS,
        },
        {
            title: 'Documents',
            href: doc.index.url(),
            icon: FileText,
            roles: DOCUMENT_VIEWERS,
        },
        {
            title: 'SDS Sheets',
            href: sds.index.url(),
            icon: FlaskConical,
        },
        {
            title: 'Vendors',
            href: vendor.index.url(),
            icon: Handshake,
            roles: VENDOR_VIEWERS,
        },
    ];

    if (hasCurrentStore.value) {
        items.splice(3, 0, {
            title: 'Manuals',
            href: isp.index.url(),
            icon: FileSignature,
            roles: MANUAL_EDITORS,
            children: [
                { title: 'ISP', href: isp.index.url() },
                { title: 'OSHA', href: osha.index.url() },
                { title: 'Red Flag', href: redFlag.index.url() },
                { title: 'CMS', href: cms.index.url() },
            ],
        });

        items.splice(4, 0, {
            title: 'Audits',
            href: oshaAudit.index.url(),
            icon: ClipboardCheck,
            roles: AUDIT_VIEWERS,
            children: [
                { title: 'OSHA', href: oshaAudit.index.url() },
                { title: 'Body Shop', href: bodyShopAudit.index.url() },
                { title: 'GLBA', href: financeAudit.index.url() },
                { title: 'Deal Jackets', href: dealJacketsAudit.index.url() },
                { title: 'Fit Tests', href: fitTests.index.url() },
            ],
        });

        items.push({
            title: 'IT Scans',
            href: scan.index.url(),
            icon: ShieldCheck,
            roles: SCAN_VIEWERS,
        });
    }

    items.push({
        title: 'OSHA 300 Form',
        href: '/docs/osha-300.pdf',
        icon: HardHat,
        external: true,
    });

    return items;
});

const footerNavItems = computed<NavItem[]>(() => {
    const items: NavItem[] = [];

    if (showGlobalSettings.value) {
        items.push({
            title: 'Global Settings',
            href: settings.global.url(),
            icon: Settings,
            roles: [Role.SuperAdmin, Role.Consultant],
        });
    } else {
        items.push({
            title: 'Settings',
            href: dealer.settings.url(),
            icon: Settings,
            roles: [Role.SuperAdmin, Role.Consultant],
        });
    }

    items.push(
        {
            title: 'Automated Reports',
            href: automatedReports.index.url(),
            icon: FileBarChart2,
            roles: AUTOMATED_REPORT_VIEWERS,
        },
        {
            title: 'Locations',
            href: locations.index.url(),
            icon: Building2,
            roles: [Role.SuperAdmin, Role.Consultant],
        },
        {
            title: 'Activity Logs',
            href: logs.index.url(),
            icon: ScrollText,
            roles: [Role.SuperAdmin, Role.Consultant],
        },
    );

    return items;
});
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <StoreSwitcher />

            <GlobalSearch>
                <template #trigger="{ open, shortcut }">
                    <div
                        class="px-1 pt-2 pb-3 group-data-[collapsible=icon]:px-0 group-data-[collapsible=icon]:py-1.5"
                    >
                        <button
                            type="button"
                            aria-label="Search"
                            class="flex h-9 w-full cursor-pointer items-center gap-2 rounded-md border border-sidebar-border bg-background px-2.5 text-sm text-muted-foreground shadow-xs transition-colors hover:bg-sidebar-accent hover:text-sidebar-accent-foreground group-data-[collapsible=icon]:size-8 group-data-[collapsible=icon]:justify-center group-data-[collapsible=icon]:p-0"
                            @click="open"
                        >
                            <Search class="size-4 shrink-0" />
                            <span
                                class="flex-1 text-left group-data-[collapsible=icon]:hidden"
                            >
                                Search
                            </span>
                            <kbd
                                class="rounded border border-sidebar-border bg-sidebar px-1.5 py-0.5 font-mono text-[10px] font-medium group-data-[collapsible=icon]:hidden"
                            >
                                {{ shortcut }}
                            </kbd>
                        </button>
                    </div>
                </template>
            </GlobalSearch>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavMain :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
