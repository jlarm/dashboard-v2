import osha from '@/routes/dealer/audit/osha';
import bodyShop from '@/routes/dealer/audit/body-shop';
import finance from '@/routes/dealer/audit/finance';
import { generate as generateOshaRemediation } from '@/routes/dealer/audit/osha/remediation';
import { generate as generateBodyShopRemediation } from '@/routes/dealer/audit/body-shop/remediation';
import { generate as generateFinanceRemediation } from '@/routes/dealer/audit/finance/remediation';
import type { AuditTypeSlug } from '@/components/audits/audit-types';

type AuditRoutes = typeof osha;
type GenerateRemediationRoute = typeof generateOshaRemediation;

export function useAuditRoutes(type: AuditTypeSlug): AuditRoutes {
    switch (type) {
        case 'osha':
            return osha;
        case 'body-shop':
            return bodyShop as unknown as AuditRoutes;
        case 'finance':
            return finance as unknown as AuditRoutes;
    }
}

export function useGenerateRemediationRoute(type: AuditTypeSlug): GenerateRemediationRoute {
    switch (type) {
        case 'osha':
            return generateOshaRemediation;
        case 'body-shop':
            return generateBodyShopRemediation;
        case 'finance':
            return generateFinanceRemediation;
    }
}
