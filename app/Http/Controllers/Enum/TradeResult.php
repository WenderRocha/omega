<?php

namespace App\Http\Controllers\Enum;

enum TradeResult: string
{
    case WIN = 'win';
    case LOSS = 'loss';
    case DRAW = 'draw';
}
