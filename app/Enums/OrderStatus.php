<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\Enum;

enum OrderStatus: int
{
    use Enum;

    case New = 1;
    case Canceled = 2;
    case Paid = 3;
    case Send = 4;
    case Delivered = 5;
}
