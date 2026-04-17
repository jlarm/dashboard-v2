<?php

declare(strict_types=1);

namespace App\Models\Dealer;

use App\Enums\ComplianceSummaryFrequency;
use Illuminate\Database\Eloquent\Model;
use Override;

class GlobalSetting extends Model
{
    #[Override]
    protected $fillable = [
        'phishing_active',
        'phishing_token',
        'phishing_ip',
        'compliance_summary_active',
        'compliance_summary_frequency',
        'compliance_summary_recipients',
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'phishing_active' => 'boolean',
            'compliance_summary_active' => 'boolean',
            'compliance_summary_frequency' => ComplianceSummaryFrequency::class,
            'compliance_summary_recipients' => 'array',
        ];
    }
}
