@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>From</th>
            <th>To</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($users) && $users->count())
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->from }}</td>
                    <td>{{ $user->to ?? 'N/A' }}</td>
                    <td>{{ $user->amount ?? 'N/A' }}</td>
                    <td>{{ $user->date ?? 'N/A' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="10">No transaction found.</td>
            </tr>
        @endif
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection
