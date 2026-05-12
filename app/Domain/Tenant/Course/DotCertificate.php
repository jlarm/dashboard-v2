<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course;

/**
 * Canonical references for the DOT Hazardous Materials Transportation
 * certificate — shared across the dispatch action, sync generator, eligibility
 * query, and rendering job so they cannot drift.
 */
final class DotCertificate
{
    public const string COURSE_NAME = 'DOT Hazardous Materials Transportation';

    public const string COURSE_SLUG = 'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding';

    public const string STORAGE_DISK = 'armp-certs';

    public const int DEFAULT_YEARS_EXPIRES = 3;

    /**
     * IDs of the four DOT Hazardous Materials Transportation courses. The
     * series carries a 3-year expiration window (longer than the default
     * 1-year refresh used for other courses) and is referenced when
     * computing course-completion counts.
     *
     * @var list<int>
     */
    public const array HAZMAT_COURSE_IDS = [9, 10, 11, 12];
}
