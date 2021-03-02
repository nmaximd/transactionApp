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
    public function getUserTransactionsPaginated(int $perPage = 15): Paginator
    {
        $usersTable = with(new User)->getTable();
        $transactionTable = with(new Transaction)->getTable();

        return DB::table($transactionTable)
            ->select(
                "$usersTable.name",
                "$transactionTable.recipient_id",
                "$transactionTable.amount",
                "$transactionTable.sending_date",
                "$transactionTable.sent_date",
                "$transactionTable.status"
            )
            ->leftJoin($usersTable, "$usersTable.id", "=", "$transactionTable.recipient_id")
            ->where("$transactionTable.sender_id", "=", auth()->id())
            ->paginate($perPage);
    }
}
