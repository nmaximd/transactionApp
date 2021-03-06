<?php

namespace App\Observers;

use App\Exceptions\AccountBalanceNotEnough;
use App\Models\Account;
use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle transaction "creating" event.
     *
     * @param Transaction $transaction
     * @return void
     */
    public function creating(Transaction $transaction)
    {
        if (is_null($transaction->status)) {
            $transaction->status = Transaction::STATUS_PLANNED;
        }
        if (is_null($transaction->sender)) {
            $transaction->sender()->associate(auth()->user());
        }
    }

    /**
     * Handle transaction "created" event.
     *
     * @param Transaction $transaction
     * @return void|bool
     */
    public function created(Transaction $transaction)
    {
        try {
            /** @var Account $account */
            $account = $transaction->sender->account;
            $account->decreaseBalance($transaction->amount);
        } catch (AccountBalanceNotEnough $exception) {
            report($exception);
            return false;
        }
    }
}
