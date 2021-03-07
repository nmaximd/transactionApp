<?php

namespace App\Jobs;

use App\Exceptions\TransactionProcessedException;
use App\Models\Transaction;
use App\Services\TransactionProcessingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTransactionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @param Transaction $transaction
     * @return void
     * @throws TransactionProcessedException
     */
    public function handle(Transaction $transaction)
    {
        $foundTransactions = $transaction
            ->where('status', Transaction::STATUS_PLANNED)
            ->where('sending_date', '<=', now())
            ->get();
        foreach ($foundTransactions as $transaction) {
            TransactionProcessingService::process($transaction);
        }
    }
}
