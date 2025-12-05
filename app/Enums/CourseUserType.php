<?php

declare(strict_types=1);

namespace App\Enums;

enum CourseUserType: string
{
    case ADD = 'add';
    case EXCLUDE = 'exclude';
}
