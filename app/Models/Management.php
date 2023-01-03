<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'date',
        'qtdTrades',
        'totalInvestment',
        'qtdWin',
        'qtdLoss',
        'qtdDraw',
        'totalInvestment',
        'valueWin',
        'valueLoss',
        'profit',
        'resultPercentage',
        'dayBalance',
        'resultDay',
        'key',
        'highlight',
        'dates'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }
}
