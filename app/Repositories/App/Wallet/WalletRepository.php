<?php

declare(strict_types=1);

namespace App\Repositories\App\Wallet;

use App\Models\Wallet;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class WalletRepository extends BaseRepository implements WalletRepositoryInterface
{
        public function __construct(Wallet $wallet)
        {
            parent::__construct($wallet);
        }
}
