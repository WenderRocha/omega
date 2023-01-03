<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTradeRequest;
use App\Http\Requests\UpdateTradeRequest;
use App\Models\Trade;
use App\Services\App\Management\ManagementService;
use App\Services\App\Trade\TradeServiceInterface;
use Illuminate\Http\Request;


class TradeController extends Controller
{

    public function __construct(
        protected TradeServiceInterface $tradeService,
        protected ManagementService $managementService
    )
    {
    }

    public function index(Request $request)
    {

    }

    public function create(Request $request)
    {
        return $this->tradeService->create($request->all());


    }

    public function store(StoreTradeRequest $request)
    {
        //dd($request->all());
       if($this->create($request)) {
           return redirect()->back();
       }
    }

    public function show(Trade $trade)
    {
        //
    }

    public function edit(Trade $trade)
    {
        //
    }

    public function update(UpdateTradeRequest $request, Trade $trade)
    {
        //
    }

    public function destroy(Trade $trade)
    {
        //
    }
}
