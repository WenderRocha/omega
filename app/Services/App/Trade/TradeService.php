<?php

namespace App\Services\App\Trade;

use App\Repositories\App\Trade\TradeRepositoryInterface;
use App\Services\App\Management\ManagementService;
use App\Services\App\Wallet\WalletService;


class TradeService implements TradeServiceInterface
{
    public function __construct(
        protected TradeRepositoryInterface $tradeRepository,
        protected ManagementService $managementService,
        protected WalletService $walletService
    ){}

    public function find(int $id)
    {
        return $this->tradeRepository->find($id);
    }

    public function findAll()
    {
       return $this->tradeRepository->findAll();
    }

    public function create(array $data)
    {

      $trade = $this->tradeRepository->create($data);

      $management = $this->managementService->find($trade->management_id);

      $balance = $management->wallet->initialBalance;

      $managementId = $trade->management_id;

      $valueTotalWin = $this->getTotalValueByResult($managementId, 'win');
      $valueTotalLoss = $this->getTotalValueByResult($managementId, 'loss');
      $profit = $this->managementService->getTotalValueByColumn('profit');

        $this->walletService->update($management->wallet->id, [
            'result' => $profit,
            'qtdWin' => $this->getTotalByResult($managementId, 'win')->count(),
            'qtdLoss' => $this->getTotalByResult($managementId, 'loss')->count(),
            'balance' => $balance + $profit,

        ]);

        $this->managementService->update($managementId, [
          'qtdTrades' => $this->getTotalTrades($managementId),
          'qtdWin' => $this->getTotalByResult($managementId, 'win')->count(),
          'qtdLoss' => $this->getTotalByResult($managementId, 'loss')->count(),
          'qtdDraw' => $this->getTotalByResult($managementId, 'draw')->count(),
          'totalInvestment' => $this->getTotalValueByColumn($managementId, 'value'),
          'valueWin' => $valueTotalWin,
          'valueLoss' =>  $valueTotalLoss,
          'profit' => $profit

      ]);


    }

    public function update(int $id, array $data)
    {
         $this->tradeRepository->update($id, $data);

    }

    public function delete(int $id)
    {
        return $this->tradeRepository->delete($id);
    }

    public function getTotalByResult(int $management_id, string $result)
    {
        return $this->tradeRepository->getTotalByResult($management_id, $result);

    }

    public function getTotalTrades(int $management_id)
    {
        return $this->tradeRepository->getTotalTrades($management_id);
    }

    public function getTotalValueByColumn(int $management_id, string $column)
    {
        return  $this->tradeRepository->getTotalValueByColumn($management_id, $column );
    }

    public function getTotalValueByResult(int $management_id, string $result)
    {
        return $this->tradeRepository->getTotalValueByResult($management_id, $result);
    }
}
