import osha from '@/routes/dealer/audit/osha';
import bodyShop from '@/routes/dealer/audit/body-shop';
import { generate as generateOshaRemediation } from '@/routes/dealer/audit/osha/remediation';
import { generate as generateBodyShopRemediation } from '@/routes/dealer/audit/body-shop/remediation';
import type { AuditTypeSlug } from '@/components/audits/audit-types';

type AuditRoutes = typeof osha;
type GenerateRemediationRoute = typeof generateOshaRemediation;

/**
 * Finance is still served by Livewire and not exposed to these Vue pages.
 * When it is migrated, add the 'finance' branch + imports back here.
 */
export type SharedAuditType = Exclude<AuditTypeSlug, 'finance'>;

export function useAuditRoutes(type: SharedAuditType): AuditRoutes {
    switch (type) {
        case 'osha':
            return osha;
        case 'body-shop':
            return bodyShop as unknown as AuditRoutes;
    }
}

export function useGenerateRemediationRoute(type: SharedAuditType): GenerateRemediationRoute {
    switch (type) {
        case 'osha':
            return generateOshaRemediation;
        case 'body-shop':
            return generateBodyShopRemediation;
    }
}
