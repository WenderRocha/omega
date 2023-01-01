<?php

namespace App\Http\Controllers\Enum;

enum ManagementType: int
{
    case FIXED = 1;
    case COMPOUND = 2;
    case TWOXONE = 3;
}
