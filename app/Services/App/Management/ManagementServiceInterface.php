<?php

namespace App\Services\App\Management;

interface ManagementServiceInterface
{
    public function find(int $id);

    public function findAll();

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function getByDate(string $date);

    public function createDefaultManagement(string $date, int $walletId);

    public function getTotalValueByColumn(string $column);
}
