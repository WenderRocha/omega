<?php

namespace App\Services\App\Trade;

interface TradeServiceInterface
{
    public function find(int $id);

    public function findAll();

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function getTotalByResult(int $management_id, string $result);

    public function getTotalTrades(int $management_id);

    public function getTotalValueByColumn(int $management_id, string $column);

    public function getTotalValueByResult(int $management_id, string $result);
}
