<?php


namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * Should return all users except current
     * @return Collection
     */
    public function getAllExceptAuth(): Collection;
}
