<?php

namespace App\Services;

use App\Exceptions\TransactionProcessedException;
use App\Models\Transaction;

class TransactionProcessingService
{
    /**
     * Increase transaction's recipient balance
     * and update it's status and sent timestamp
     * @param Transaction $transaction
     * @return void
     * @throws TransactionProcessedException
     */
    public static function process(Transaction $transaction): void
    {
        if ($transaction->status == Transaction::STATUS_PROCESSED){
            throw new TransactionProcessedException("Transaction [$transaction->id] has been already processed");
        }

        $account = $transaction->recipient->account;
        $account->increaseBalance($transaction->amount);

        $transaction->update([
            'status' => Transaction::STATUS_PROCESSED,
            'sent_date' => now(),
        ]);
    }
}
