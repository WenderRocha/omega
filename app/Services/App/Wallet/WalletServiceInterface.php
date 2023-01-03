<?php

namespace App\Services\App\Wallet;

interface WalletServiceInterface
{
    public function find(int $id);

    public function findAll();

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function getWalletsByUser();

}
