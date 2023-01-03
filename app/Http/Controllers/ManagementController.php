<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManagementRequest;
use App\Http\Requests\UpdateManagementRequest;
use App\Models\Management;
use App\Services\App\Management\ManagementServiceInterface;
use App\Services\App\Wallet\WalletService;
use Illuminate\Http\Request;

class ManagementController extends Controller
{

    public function __construct(
        protected ManagementServiceInterface $managementService,
        protected WalletService $walletService
    )
    {
    }

    public function index()
    {
        return $this->managementService->findAll();
    }

    public function book(int $id)
    {
        $wallet = $this->walletService->getWalletsByUserWhere($id);

        dd($wallet->managements);
    }

    public function create()
    {
        //
    }

    public function store(StoreManagementRequest $request)
    {
        //
    }

    public function show(Management $management)
    {
        //
    }

    public function edit(Management $management)
    {
        //
    }

    public function update(UpdateManagementRequest $request, Management $management)
    {
        //
    }

    public function destroy(Management $management)
    {
        //
    }
}
