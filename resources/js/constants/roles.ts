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

/**
 * Roles allowed to view the Vendors section. Excludes Employees and
 * Porter/Drivers — every other role can manage vendors.
 */
export const VENDOR_VIEWERS: RoleName[] = [
    Role.SuperAdmin,
    Role.Admin,
    Role.Consultant,
    Role.Owner,
    Role.CFO,
    Role.GM,
    Role.GSM,
    Role.QualifiedIndividual,
    Role.Manager,
];

/**
 * Roles allowed to view, sign, and delete compliance manuals.
 * Mirrors App\Enums\Role::manualEditors() — every role except
 * Manager, Employee, and Porter/Driver.
 */
export const MANUAL_EDITORS: RoleName[] = [
    Role.SuperAdmin,
    Role.Admin,
    Role.Consultant,
    Role.Owner,
    Role.CFO,
    Role.GM,
    Role.GSM,
    Role.QualifiedIndividual,
];

/**
 * Roles that see the "Courses" entry in the main sidebar.
 *
 * super-admins and Consultants don't take training courses themselves
 * (they administer the system), and Employees / Porter/Drivers consume
 * their courses inline on the Dashboard instead. Everyone in between
 * gets the dedicated sidebar shortcut.
 */
export const COURSES_NAV_VIEWERS: RoleName[] = [
    Role.Admin,
    Role.Owner,
    Role.CFO,
    Role.GM,
    Role.GSM,
    Role.QualifiedIndividual,
    Role.Manager,
];

/**
 * Roles allowed to view OSHA / Body Shop / GLBA audits.
 * Mirrors App\Enums\Role::auditViewers() — broader role group on the
 * audit read routes.
 */
export const AUDIT_VIEWERS: RoleName[] = [
    Role.SuperAdmin,
    Role.Consultant,
    Role.Owner,
    Role.CFO,
    Role.GM,
    Role.GSM,
    Role.QualifiedIndividual,
];

/**
 * Roles allowed to view the IT Scans dashboard and report archive.
 * Mirrors App\Enums\Role::scanViewers() — every role except Employee
 * and Porter/Driver.
 */
export const SCAN_VIEWERS: RoleName[] = [
    Role.SuperAdmin,
    Role.Admin,
    Role.Consultant,
    Role.Owner,
    Role.CFO,
    Role.GM,
    Role.GSM,
    Role.QualifiedIndividual,
    Role.Manager,
];
