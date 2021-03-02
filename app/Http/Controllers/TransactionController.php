<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

class TransactionController extends Controller
{
    /**
     * Display all user's sent transactions.
     *
     * @return \Illuminate\View\View
     */
    public function index(TransactionRepositoryInterface $transactionRepository)
    {
        return view('transaction.index')
            ->with('transactions', $transactionRepository->getUserTransactionsPaginated());
    }

    /**
     * Show the form for creating a new transaction if user has money.
     *
     * @param UserRepositoryInterface $userRepository
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create(UserRepositoryInterface $userRepository)
    {
        if (auth()->user()->account->balance <= 0) {
            return back();
        }

        return view('transaction.create')
            ->with('users', $userRepository->getAllExceptAuth());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Transaction $transaction
     * @param TransactionStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(Transaction $transaction, TransactionStoreRequest $request)
    {
        $transaction->fill([
            'recipient_id' => $request->input('recipient'),
            'amount' => $request->input('amount'),
            'sending_date' => \Carbon\Carbon::parse(
                $request->input('date') . ' ' . $request->input('time') . ':00'
            ),
        ]);
        $transaction->saveOrFail();

        return redirect()
            ->route('transaction.index')
            ->with('success', __('Transaction added successfully!'));
    }
}
