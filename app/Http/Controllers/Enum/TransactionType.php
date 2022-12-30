<?php

namespace App\Http\Controllers\App\Enum;

enum TransactionType
{
    case DEPOSIT;
    case WITHDRAW;
    case TRANSFER;
}
