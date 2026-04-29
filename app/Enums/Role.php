<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Tenant-side role names. Mirrors RoleAndPermissionSeeder.
 *
 * Spatie reads role data from the database; this enum is a typed reference
 * for code so role strings are validated by the type system instead of
 * silently failing on typo.
 */
enum Role: string
{
    case SuperAdmin = 'super-admin';
    case Admin = 'Admin';
    case Consultant = 'Consultant';
    case Owner = 'Owner';
    case CFO = 'CFO';
    case GM = 'GM';
    case GSM = 'GSM';
    case QualifiedIndividual = 'Qualified Individual';
    case Manager = 'Manager';
    case Employee = 'Employee';
    case PorterDriver = 'Porter/Driver';

    /**
     * Roles allowed to access the employee section index, invite, courses,
     * dot-certificates, and per-employee show pages.
     *
     * @return list<self>
     */
    public static function employeeSectionViewers(): array
    {
        return [
            self::SuperAdmin,
            self::Consultant,
            self::Owner,
            self::CFO,
            self::GM,
            self::GSM,
            self::QualifiedIndividual,
            self::Manager,
        ];
    }

    /**
     * Roles allowed to access the deleted employees page and restore.
     *
     * @return list<self>
     */
    public static function employeeAdminRoles(): array
    {
        return [
            self::SuperAdmin,
            self::Consultant,
            self::Owner,
            self::CFO,
            self::GM,
            self::GSM,
            self::QualifiedIndividual,
        ];
    }

    /**
     * Roles allowed to send custom messages to employees.
     *
     * @return list<self>
     */
    public static function sendMessageRoles(): array
    {
        return self::employeeAdminRoles();
    }

    /**
     * Roles a Manager-only viewer may invite a new employee as.
     *
     * @return list<self>
     */
    public static function managerInvitableRoles(): array
    {
        return [self::Manager, self::Employee, self::PorterDriver];
    }

    /**
     * Roles allowed to view and manage the automated compliance reports
     * (every role except Manager, Employee, and Porter/Driver).
     *
     * @return list<self>
     */
    public static function automatedReportRoles(): array
    {
        return [
            self::SuperAdmin,
            self::Admin,
            self::Consultant,
            self::Owner,
            self::CFO,
            self::GM,
            self::GSM,
            self::QualifiedIndividual,
        ];
    }

    /**
     * Roles allowed to access the IT Scans dashboard and report archive.
     * Every role except Employee and Porter/Driver.
     *
     * @return list<self>
     */
    public static function scanViewers(): array
    {
        return [
            self::SuperAdmin,
            self::Admin,
            self::Consultant,
            self::Owner,
            self::CFO,
            self::GM,
            self::GSM,
            self::QualifiedIndividual,
            self::Manager,
        ];
    }

    /**
     * @param  list<self>  $roles
     * @return list<string>
     */
    public static function values(array $roles): array
    {
        return array_map(static fn (self $role): string => $role->value, $roles);
    }
}
