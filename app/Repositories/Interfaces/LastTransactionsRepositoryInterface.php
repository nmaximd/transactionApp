<?php


namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\Paginator;

interface LastTransactionsRepositoryInterface
{
    /**
     * Should return all users with their one
     * (or null) last successful transaction
     * @param int|null $perPage
     * @return Paginator
     */
    public function getPaginatedData(int $perPage = 15): Paginator;
}
