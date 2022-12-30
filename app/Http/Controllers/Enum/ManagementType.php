<?php

namespace App\Http\Controllers\App\Enum;

enum ManagementType: int
{
    case FIXED = 1;
    case COMPOUND = 2;
    case TWOXONE = 3;
}
