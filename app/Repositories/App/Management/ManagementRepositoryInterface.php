<?php

namespace App\Repositories\App\Management;

interface ManagementRepositoryInterface
{
    public function getByDate(string $date);
}
