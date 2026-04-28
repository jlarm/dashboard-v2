/**
 * Mirrors App\Enums\Role on the backend. Keep in sync with that enum.
 *
 * Used for nav-item visibility, conditional UI gates, and any other
 * frontend role checks. Do not introduce new role strings ad hoc — add
 * them here so a single grep finds every usage.
 */
export const Role = {
    SuperAdmin: 'super-admin',
    Admin: 'Admin',
    Consultant: 'Consultant',
    Owner: 'Owner',
    CFO: 'CFO',
    GM: 'GM',
    GSM: 'GSM',
    QualifiedIndividual: 'Qualified Individual',
    Manager: 'Manager',
    Employee: 'Employee',
    PorterDriver: 'Porter/Driver',
} as const;

export type RoleName = (typeof Role)[keyof typeof Role];

/**
 * Roles allowed to view the Employees section in the main nav and
 * access the index, invite, courses, etc. Mirrors
 * App\Enums\Role::employeeSectionViewers().
 */
export const EMPLOYEE_SECTION_VIEWERS: RoleName[] = [
    Role.SuperAdmin,
    Role.Consultant,
    Role.Owner,
    Role.CFO,
    Role.GM,
    Role.GSM,
    Role.QualifiedIndividual,
    Role.Manager,
];

/**
 * Roles allowed to view the Documents section. Employees and
 * Porter/Drivers are excluded.
 */
export const DOCUMENT_VIEWERS: RoleName[] = [
    Role.SuperAdmin,
    Role.Consultant,
    Role.Owner,
    Role.CFO,
    Role.GM,
    Role.GSM,
    Role.QualifiedIndividual,
    Role.Manager,
];

/**
 * Roles allowed to view and manage the Automated Reports page.
 * Mirrors App\Enums\Role::automatedReportRoles() — every role except
 * Manager, Employee, and Porter/Driver.
 */
export const AUTOMATED_REPORT_VIEWERS: RoleName[] = [
    Role.SuperAdmin,
    Role.Admin,
    Role.Consultant,
    Role.Owner,
    Role.CFO,
    Role.GM,
    Role.GSM,
    Role.QualifiedIndividual,
];
