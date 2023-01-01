<?php

namespace App\Http\Controllers\Enum;

enum TransactionType
{
    case DEPOSIT;
    case WITHDRAW;
    case TRANSFER;
}
