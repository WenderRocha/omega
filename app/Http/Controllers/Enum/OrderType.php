<?php

namespace App\Http\Controllers\Enum;

enum OrderType: string
{
    case CALL = 'call';
    case PUT = 'put';
}
