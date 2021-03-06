<?php


namespace App\Repositories;


use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getAllExceptAuth(): Collection
    {
        return User::where('id', '!=', auth()->id())
            ->select('id', 'name')
            ->get();
    }
}
