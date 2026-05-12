<script setup lang="ts">
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/tenant/NavUser.vue';
import StoreSwitcher from '@/components/tenant/StoreSwitcher.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
} from '@/components/ui/sidebar';
import { AUDIT_VIEWERS, AUTOMATED_REPORT_VIEWERS, DOCUMENT_VIEWERS, EMPLOYEE_SECTION_VIEWERS, MANUAL_EDITORS, Role, SCAN_VIEWERS, VENDOR_VIEWERS } from '@/constants/roles';
import bodyShopAudit from '@/routes/dealer/audit/body-shop';
import dealJacketsAudit from '@/routes/dealer/audit/deal-jackets';
import financeAudit from '@/routes/dealer/audit/finance';
import individualAudit from '@/routes/dealer/audit/individual';
import oshaAudit from '@/routes/dealer/audit/osha';
import doc from '@/routes/dealer/doc';
import employees from '@/routes/dealer/employees';
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
import { Building2, ClipboardCheck, FileSignature, FileText, FileBarChart2, FlaskConical, GraduationCap, Handshake, HardHat, LayoutGrid, ScrollText, Settings, ShieldCheck, Users } from 'lucide-vue-next';

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
                { title: 'Deal Jackets Archived', href: individualAudit.index.url() },
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
