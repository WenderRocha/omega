<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'name',
      'initialBalance',
      'balance',
       'result',
      'take',
      'takePercentage',
      'stop',
      'stopPercentage',
      'qtdWin',
      'qtdLoss',
      'currency',
      'managementType',
      'addToTotals',
      'isBinary',
      'isMain',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function managements()
    {
        return $this->hasMany(Management::class);
    }


}
