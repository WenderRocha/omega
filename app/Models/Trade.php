<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'management_id',
        'date',
        'assets',
        'payout',
        'value',
        'income',
        'orderType',
        'operational',
        'observation',
        'tradeResult',
    ];

    public function management()
    {
        return $this->belongsTo(Management::class);
    }
}
