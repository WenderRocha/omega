<?php

namespace App\Repositories\App\Management;

interface ManagementRepositoryInterface
{
    public function getByDate(string $date);
    public function getTotalValueByColumn(string $column);
}
