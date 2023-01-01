<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Http\Request;

interface RepositoryInterface
{
    public function find(int $id);

    public function findAll();

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

}
