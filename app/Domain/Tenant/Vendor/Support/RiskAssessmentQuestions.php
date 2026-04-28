<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Support;

/**
 * The 22 GLBA / Safeguards Rule risk assessment questions, in 1-indexed
 * legacy order. Stored on VendorForm->data alongside vendor responses.
 */
final class RiskAssessmentQuestions
{
    public const int COUNT = 22;

    /**
     * @return array<int, string>
     */
    public static function all(): array
    {
        return [
            1 => 'Are you an employee or authorized representative of this vendor/company? Indicate the Person’s Name in the comments.',
            2 => 'Does your company offer software applications as part of its services?',
            3 => 'Is client data encrypted at rest and in transit? If not, why not?',
            4 => 'Has your company experienced a data breach in the past 12 months that affected customers’ personal information?',
            5 => 'Does your company have insurance coverage for a data breach that may involve our customers’ information that your company acquires while doing business with us?',
            6 => 'Does your company require security awareness training for all employees? If so, please answer how often it is provided in the comments section.',
            7 => 'Does your company monitor for the effectiveness of employee security training by testing your users with simulated attacks?',
            8 => 'Does your company have a process for restricting access to customer files on a need-to-know basis?',
            9 => 'Do you have a written information security program?',
            10 => 'Does your company conduct annual risk assessments that assess electronic, physical, and administrative information safeguards?',
            11 => 'Does your company have systems in place to securely dispose of documents that have personal identifiable information on them?',
            12 => 'Does your company have systems in place to restrict access to files/documents containing customers personal information to those with proper authorization?',
            13 => 'Does your company have due diligence processes and procedures for vetting subcontractors, including having them sign processing agreements that are compliant with applicable federal and state laws?',
            14 => 'Has your company performed penetration testing of its systems within the past 12 months?',
            15 => 'Has your company conducted a vulnerability assessment of your systems within the past 6 months?',
            16 => 'Does your company maintain end-of-life or unsupported operating systems or software? If so, are these systems used to manage or maintain customer data?',
            17 => 'Does your company regularly patch or update systems and third-party software and monitor for noncompliance?',
            18 => 'Does your company have a written incident response plan in the event of a security breach?',
            19 => 'Does your company require users to create complex passwords with 9 characters or greater?',
            20 => 'Does your company prohibit shared logins?',
            21 => 'Does your company require multi-factor authentication to log into your company’s systems?',
            22 => 'Do you have an account lockout policy?',
        ];
    }
}
