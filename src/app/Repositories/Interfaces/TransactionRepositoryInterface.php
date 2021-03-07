<?php


namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\Paginator;

interface TransactionRepositoryInterface
{
    /**
     * Should return all sent transactions of current user
     * @param int|null $perPage
     * @return Paginator
     */
    public function getUserSentTransactionsPaginated(int $perPage = 15): Paginator;

    /**
     * Should return all received transactions of current user
     * @param int|null $perPage
     * @return Paginator
     */
    public function getUserReceivedTransactionsPaginated(int $perPage = 15): Paginator;
}
