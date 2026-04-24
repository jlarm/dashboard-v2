import type { Employee } from '@/pages/tenant/user/components/columns';

export type EmployeeShowPermissions = {
    update: boolean;
    delete: boolean;
    impersonate: boolean;
    manage_courses: boolean;
};

export type EmployeeEditOptions = {
    departments: Array<{ id: number; name: string }>;
    roles: Array<{ id: number; name: string }>;
    stores: Array<{ id: number; name: string }> | null;
    audit_types: Array<{ value: string; label: string }>;
};

export type EmployeeShowProps = {
    employee: Employee;
    permissions: EmployeeShowPermissions;
    editOptions: EmployeeEditOptions | null;
    remediationReminders: string[];
};
