@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('Recent user transactions') }}</h2>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>{{ __('From') }}</th>
            <th>{{ __('To') }}</th>
            <th>{{ __('Amount') }}</th>
            <th>{{ __('Date') }}</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($users) && $users->count())
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->from }}</td>
                    <td>{{ $user->to ?? __('N/A') }}</td>
                    <td>{{ $user->amount ?? __('N/A') }}</td>
                    <td>{{ $user->date ?? __('N/A') }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="10">{{ __('No transactions found') }}</td>
            </tr>
        @endif
        </tbody>
    </table>
    @if(!empty($users))
        {{ $users->links() }}
    @endif
</div>
@endsection
