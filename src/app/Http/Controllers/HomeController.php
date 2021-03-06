<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\LastTransactionsRepositoryInterface;

class HomeController extends Controller
{
    /**
     * Show last users' transaction.
     *
     * @param LastTransactionsRepositoryInterface $repository
     * @return \Illuminate\View\View
     */
    public function index(LastTransactionsRepositoryInterface $repository)
    {
        return view('home')->with('users', $repository->getPaginatedData());
    }
}
