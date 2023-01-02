<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWalletRequest;
use App\Repositories\App\Wallet\WalletRepositoryInterface;
use App\Services\App\Wallet\WalletServiceInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WalletController extends Controller
{

    public function __construct(
        protected WalletServiceInterface $walletService
    )
    {
    }

    public function index(){

        $wallets = $this->walletService->getWalletsByUser();

        return Inertia::render('App/Wallet/Index', [
            'wallets' => $wallets
        ]);
    }

    public function store(StoreWalletRequest $request)
    {


        return $this->walletService->create($request->all());
    }

    public function show(int $id)
    {
        $wallet = $this->walletService->getWalletsByUserWhere($id);

        if(is_null($wallet)) {
            return redirect()->route('wallet.index');
        }

        return Inertia::render('App/Wallet/Show', [
            'wallet' => $wallet
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }


}
