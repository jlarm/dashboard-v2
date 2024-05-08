<?php

namespace App\Enums;

enum ContractStatus: string
{
    case CREATED = 'created';
    case SENT = 'sent';
    case SIGNED = 'signed';
    case COMPLETED = 'completed';
}
