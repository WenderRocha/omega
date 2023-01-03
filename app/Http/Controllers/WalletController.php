<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWalletRequest;
use App\Models\Management;
use App\Models\Wallet;
use App\Repositories\App\Wallet\WalletRepositoryInterface;
use App\Services\App\Management\ManagementService;
use App\Services\App\Wallet\WalletServiceInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WalletController extends Controller
{

    public function __construct(
        protected WalletServiceInterface $walletService,
        protected ManagementService $managementService
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

    public function show(Request $request, int $id)
    {
        $wallet = $this->walletService->getWalletsByUserWhere($id);


        if(is_null($wallet)) {
            return redirect()->route('wallet.index');
        }

        $date = (is_null($request->get('date'))) ? now()->format('d/m/Y') : $date = str_replace('-', '/', $request->get('date'));

        $management = $wallet->managements->where('date', $date)->first();

        //se o gerenciamento for nulo, e data informada for igua a hoje, cria um novo gerenciamento
        if(is_null($management) && $date == now()->format('d/m/Y')) {
           $management = $this->managementService->createDefaultManagement($wallet->id);
        }

        //dd($management);

       if(!is_null($management)) {
           $trades = $management->trades;
       }else{
           return redirect()->back();
       }

        return Inertia::render('App/Wallet/Show', [
            'wallet' => $wallet,
            'management' => $management,
            'date' => $date,
            'trades' => $trades

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
