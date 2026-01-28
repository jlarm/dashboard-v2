<?php

declare(strict_types=1);

namespace App\Enums;

enum ContractStatus: string
{
    case CREATED = 'created';
    case SENT = 'sent';
    case SIGNED = 'signed';
    case COMPLETED = 'completed';
}
