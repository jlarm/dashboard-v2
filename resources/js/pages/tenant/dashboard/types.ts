export type PillTone = 'positive' | 'negative' | 'warning' | 'neutral';

export type Kpi = {
    label: string;
    value: string;
    delta: string;
    tone: PillTone;
    caption: string;
    info: {
        title: string;
        description: string;
    };
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
    grade: string | null;
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

export type DepartmentCompletion = {
    label: string;
    value: number;
    headcount: number;
};

export type LocationGradeRow = {
    store_id: number;
    store_name: string;
    overall: string | null;
    deal_jacket: string | null;
    osha: string | null;
    glba: string | null;
    body_shop: string | null;
};

export type TrainingComplianceStatus = 'overdue' | 'at_risk' | 'compliant' | 'unassigned';

export type TrainingComplianceAlert = {
    user_slug: string;
    name: string;
    valid_completed: number;
    total_required: number;
    status: TrainingComplianceStatus;
};

export type TrainingComplianceSnapshot = {
    overdue: number;
    at_risk: number;
    compliant: number;
    unassigned: number;
    employees: number;
    priority_alerts: TrainingComplianceAlert[];
};

export type ConsultantNote = {
    note: string | null;
};

export type ManualsSummary = {
    isp: boolean;
    osha: boolean;
    red_flag: boolean;
    cms: boolean;
};
