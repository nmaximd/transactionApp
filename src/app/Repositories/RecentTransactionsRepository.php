<?php


namespace App\Repositories;


use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Interfaces\RecentTransactionsRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class RecentTransactionsRepository implements RecentTransactionsRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getPaginatedData(int $perPage = 15): Paginator
    {
        $usersTable = with(new User)->getTable();
        $transactionTable = with(new Transaction)->getTable();

        $recentTransactionsBySender = DB::table($transactionTable)
            ->select("sender_id", DB::raw("MAX(sent_date) as sent_date"))
            ->where("status", Transaction::STATUS_PROCESSED)
            ->groupBy("sender_id");

        $recentTransactionsFull = DB::table($transactionTable)
            ->select(
                "$transactionTable.sender_id",
                "$transactionTable.amount",
                "$transactionTable.sent_date as date",
                "$usersTable.name as to"
            )
            ->joinSub($recentTransactionsBySender, "ltbs", function ($join) use ($transactionTable) {
                $join
                    ->on("$transactionTable.sender_id", "=", "ltbs.sender_id")
                    ->on("$transactionTable.sent_date", "=", "ltbs.sent_date");
            })
            ->leftJoin($usersTable, "$transactionTable.recipient_id", "=", "$usersTable.id");

        return DB::table($usersTable)
            ->select(
                "$usersTable.name as from",
                "$transactionTable.to",
                "$transactionTable.amount",
                "$transactionTable.date"
            )
            ->leftJoinSub($recentTransactionsFull, $transactionTable,
                "$usersTable.id", "=", "$transactionTable.sender_id"
            )
            ->orderBy("$usersTable.id")
            ->paginate($perPage);
    }
}
