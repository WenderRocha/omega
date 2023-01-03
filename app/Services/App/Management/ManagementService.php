<?php

namespace App\Services\App\Management;

use App\Models\Management;
use App\Repositories\App\Management\ManagementRepositoryInterface;

class ManagementService implements ManagementServiceInterface
{

    public function __construct(
        protected ManagementRepositoryInterface $managementRepository
    )
    {
    }

    public function find(int $id)
    {
        return $this->managementRepository->find($id);
    }

    public function findAll()
    {
        return $this->managementRepository->findAll();
    }

    public function create(array $data)
    {
        return $this->managementRepository->create($data);
    }

    public function update(int $id, array $data)
    {
       return $this->managementRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    public function getByDate(string $date)
    {
       return $this->managementRepository->getByDate($date);
    }

    public function createDefaultManagement(int $walletId)
    {
        return $this->create([
            'wallet_id' => $walletId,
            'date' => now()->format('d/m/Y'),
            'dates' => now()->format('Y/m/d')
        ]);
    }

    public function getTotalWin(string $result)
    {
        return Match($result) {
            'win', 'draw', 'loss' => 1,
        };
    }
}
