<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\RecentTransactionsRepositoryInterface;

class HomeController extends Controller
{
    /**
     * Show recent users' transaction.
     *
     * @param RecentTransactionsRepositoryInterface $repository
     * @return \Illuminate\View\View
     */
    public function index(RecentTransactionsRepositoryInterface $repository)
    {
        return view('home')->with('users', $repository->getPaginatedData());
    }
}
