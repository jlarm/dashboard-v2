export type AuditTypeSlug = 'osha' | 'body-shop' | 'finance';

export const AUDIT_LABELS: Record<AuditTypeSlug, string> = {
    osha: 'OSHA',
    'body-shop': 'Body Shop',
    finance: 'GLBA',
};

export const auditLabel = (slug: AuditTypeSlug): string => AUDIT_LABELS[slug];
