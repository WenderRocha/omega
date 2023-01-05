<?php

namespace App\Repositories\App\Management;

use App\Models\Management;
use App\Repositories\Eloquent\BaseRepository;

class ManagementRepository extends BaseRepository implements ManagementRepositoryInterface
{
    public function __construct(protected Management $management)
    {
        parent::__construct($management);
    }

    public function getByDate(string $date)
    {
        return $this->management->where('date', $date)->first();
    }

    public function getTotalValueByColumn(string $column)
    {
        return $this->management->sum($column);
    }
}
