<?php

namespace App\Services\App\Wallet;

use App\Repositories\App\Management\ManagementRepository;
use App\Repositories\App\Management\ManagementRepositoryInterface;
use App\Repositories\App\Wallet\WalletRepositoryInterface;
use Illuminate\Support\Facades\Auth;


class WalletService implements WalletServiceInterface
{

    public function __construct(
        protected WalletRepositoryInterface $walletRepository,
        protected ManagementRepositoryInterface $managementRepository
    ){}

    public function find(int $id)
    {
        return $this->walletRepository->find($id);
    }

    public function findAll()
    {
        return $this->walletRepository->findAll();
    }

    public function create(array $data)
    {

        $this->walletRepository->create($data);

    /*   try {


        } catch(\Exception) {

            return redirect()->back()->withErrors([
                'message' => 'Oops! tente novamente mais tarde'
            ]);
        }*/

    }

    public function update(int $id, array $data)
    {
        return $this->walletRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->walletRepository->delete($id);
    }

    public function getWalletsByUser()
    {
        return Auth::user()->wallets;
    }

    public function getWalletsByUserWhere(int $id)
    {
      return  Auth::user()->wallets->where('id', $id)->first();

    }

}
