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

        return Inertia::render('App/Wallet', [
            'wallets' => $wallets
        ]);
    }

    public function store(StoreWalletRequest $request)
    {


        return $this->walletService->create($request->all());
    }

    public function show($id)
    {
        //
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
