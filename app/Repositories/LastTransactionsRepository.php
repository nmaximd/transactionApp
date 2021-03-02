<?php


namespace App\Repositories;


use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Interfaces\LastTransactionsRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class LastTransactionsRepository implements LastTransactionsRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getPaginatedData(int $perPage = 15): Paginator
    {
        $usersTable = with(new User)->getTable();
        $transactionTable = with(new Transaction)->getTable();

        $latestTransactionsBySender = DB::table($transactionTable)
            ->select("sender_id", DB::raw("MAX(sent_date) as sent_date"))
            ->where("status", Transaction::STATUS_PROCESSED)
            ->groupBy("sender_id");

        $latestTransactionsFull = DB::table($transactionTable)
            ->select(
                "$transactionTable.sender_id",
                "$transactionTable.amount",
                "$transactionTable.sent_date as date",
                "$usersTable.name as to"
            )
            ->joinSub($latestTransactionsBySender, "ltbs", function ($join) use ($transactionTable) {
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
            ->leftJoinSub($latestTransactionsFull, $transactionTable,
                "$usersTable.id", "=", "$transactionTable.sender_id"
            )
            ->orderBy("$usersTable.id")
            ->paginate($perPage);
    }
}
