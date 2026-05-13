<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Data;

final readonly class ManualsSummaryData
{
    public function __construct(
        public bool $isp,
        public bool $osha,
        public bool $red_flag,
        public bool $cms,
    ) {}

    /**
     * @return array{isp:bool, osha:bool, red_flag:bool, cms:bool}
     */
    public function toArray(): array
    {
        return [
            'isp' => $this->isp,
            'osha' => $this->osha,
            'red_flag' => $this->red_flag,
            'cms' => $this->cms,
        ];
    }
}
