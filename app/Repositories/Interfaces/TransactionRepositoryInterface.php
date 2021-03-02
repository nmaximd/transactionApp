<?php


namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\Paginator;

interface TransactionRepositoryInterface
{
    /**
     * Should return all transactions of current user
     * @param int|null $perPage
     * @return Paginator
     */
    public function getUserTransactionsPaginated(int $perPage = 15): Paginator;
}
