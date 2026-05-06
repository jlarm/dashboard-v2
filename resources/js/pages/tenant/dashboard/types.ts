export type PillTone = 'positive' | 'negative' | 'warning' | 'neutral';

export type Kpi = {
    label: string;
    value: string;
    delta: string;
    tone: PillTone;
    caption: string;
};

export type CompliancePillar = {
    key: string;
    label: string;
    applicable: boolean;
    score: number | null;
    applicable_stores: number;
    inapplicable_stores: number;
};

export type ComplianceProps = {
    score: number | null;
    previous_score: number | null;
    delta: number | null;
    pillars: CompliancePillar[];
    computed_at: string | null;
    caption: string;
};

export type OverdueRemediationsProps = {
    count: number | null;
    high_severity_count: number | null;
    previous_count: number | null;
    delta_pct: number | null;
};

export type ExpiredTrainingProps = {
    count: number | null;
    expiring_soon_count: number | null;
    previous_count: number | null;
    delta_pct: number | null;
};

export type CriticalVulnerabilitiesProps = {
    critical_count: number;
    days_since_last_scan: number | null;
};

export type ViolationsBucket = { label: string; opened: number; closed: number };

export type ViolationsOverviewProps = {
    monthly: ViolationsBucket[];
    quarterly: ViolationsBucket[];
    yearly: ViolationsBucket[];
};

export type AuditStatus = 'passing' | 'action_required' | 'overdue';

export type AuditTrackerRow = {
    type_key: string;
    type_label: string;
    last_audit_date: string | null;
    grade: string | null;
    delta_label: string | null;
    status: AuditStatus;
    has_report: boolean;
};

export type ReminderItem = {
    title: string;
    assignee: string;
    due: string;
    tone: PillTone;
};

export type ExpiringCert = {
    name: string;
    type: string;
    expires: string;
};

export type OutstandingVendor = {
    name: string;
    lastContacted: string;
};

export type DepartmentCompletion = {
    label: string;
    value: number;
    headcount: number;
};
