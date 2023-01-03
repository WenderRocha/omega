<?php

namespace App\Repositories\App\Trade;

interface TradeRepositoryInterface
{
    public function getTotalByResult(int $management_id, string $result);
    public function getTotalTrades(int $management_id);
    public function getTotalValueByColumn(int $management_id, string $column);
    public function getTotalValueByResult(int $management_id, string $result);
}
