<?php

namespace App\Repositories\App\Trade;

use App\Models\Trade;
use App\Repositories\App\Trade\TradeRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class TradeRepository extends BaseRepository implements TradeRepositoryInterface
{
    public function __construct(
        protected Trade $trade
    )
    {
        parent::__construct($trade);
    }

    public function getTotalByResult(int $management_id, string $result)
    {
       return  $this->trade->where('management_id', $management_id)
            ->where('tradeResult', $result)->get();
    }

    public function getTotalTrades(int $management_id)
    {
        return $this->trade->where('management_id', $management_id)->count();
    }

    public function getTotalValueByColumn(int $management_id, string $column)
    {
        return $this->trade->where('management_id', $management_id)->sum($column);
    }

    public function getTotalValueByResult(int $management_id, string $result)
    {
        return  $this->trade->where('management_id', $management_id)
            ->where('tradeResult', $result)->sum('income');
    }
}
