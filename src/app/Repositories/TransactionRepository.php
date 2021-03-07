<?php


namespace App\Repositories;


use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getUserSentTransactionsPaginated(int $perPage = 15): Paginator
    {
        return $this->getUserTransactionsPaginated($perPage, true);
    }

    /**
     * @inheritDoc
     */
    public function getUserReceivedTransactionsPaginated(int $perPage = 15): Paginator
    {
        return $this->getUserTransactionsPaginated($perPage, false);
    }

    /**
     * Get data from database and paginate it
     * @param int $perPage
     * @param bool $asSender
     * @return Paginator
     */
    private function getUserTransactionsPaginated(int $perPage, bool $asSender): Paginator
    {
        $lookFor = $asSender ? 'recipient_id' : 'sender_id';
        $filterBy = $asSender ? 'sender_id' : 'recipient_id';

        $usersTable = with(new User)->getTable();
        $transactionTable = with(new Transaction)->getTable();

        $query = DB::table($transactionTable)
            ->select(
                "$usersTable.name",
                "$transactionTable.$lookFor",
                "$transactionTable.amount",
                "$transactionTable.sent_date"
            )
            ->leftJoin($usersTable, "$usersTable.id", "=", "$transactionTable.$lookFor")
            ->where("$transactionTable.$filterBy", "=", auth()->id());

        if ($asSender) {
            return $query
                ->addSelect(
                    "$transactionTable.sending_date",
                    "$transactionTable.status"
                )
                ->paginate($perPage);
        } else {
            return $query
                ->where("$transactionTable.status", "=", Transaction::STATUS_PROCESSED)
                ->paginate($perPage);
        }
    }
}
