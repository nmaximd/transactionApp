@extends('layouts.app')

@section('content')



    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('My transactions') }}</h2>
            @if(auth()->user()->balance > 0)
                <a href="{{ route('transaction.create') }}" type="button" class="btn btn-outline-primary">
                    {{ __('Add new') }}
                </a>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <table class="table table-bordered table-striped">

            <thead>
            <tr>
                <th>{{ __('Recipient') }}</th>
                <th>{{ __('Amount') }}</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Status') }}</th>
            </tr>
            </thead>

            <tbody>
            @if(!empty($transactions) && $transactions->count())
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->name }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>
                            {{ Carbon\Carbon::parse(($transaction->status == \App\Models\Transaction::STATUS_PROCESSED)
                                ? $transaction->sent_date : $transaction->sending_date)->format('Y-m-d H:i') }}
                        </td>
                        <td>{{ __(\App\Models\Transaction::getStatusLabel($transaction->status)) }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10">{{ __('No transaction found') }}</td>
                </tr>
            @endif
            </tbody>

        </table>

        @if(!empty($transactions))
            {{ $transactions->links() }}
        @endif

    </div>
@endsection
