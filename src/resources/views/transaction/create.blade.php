@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ __('Add new transaction') }}</h2>

        <div class="row justify-content-center my-5">
            <div class="col-md-6">

                <form action="{{ route('transaction.store') }}" method="POST">

                    @csrf

                    <div class="form-group">

                        <label for="recipient">{{ __('Select recipient') }}</label>

                        <select class="form-control @error('recipient') is-invalid @enderror" id="recipient"
                                name="recipient" required="required">
                            <option hidden="hidden" value="">{{ __('Select recipient') }}</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @if(old('recipient') == $user->id) selected @endif>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('recipient')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                    </div>


                    <div class="form-group">

                        <label for="amount">{{ __('Amount') }}</label>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">₽</span>
                            </div>
                            <input class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount"
                                   type="number" step="0.01" min="0.01" max="{{auth()->user()->account->balance}}"
                                   placeholder="Available balance: {{auth()->user()->account->balance}}"
                                   value="{{ old('amount') }}" required="required">
                        </div>

                        @error('amount')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror

                    </div>


                    <div class="form-group row">

                        <div class="col-md-6">

                            <label for="date">{{ __('Scheduled date') }}</label>

                            <input class="form-control @error('date') is-invalid @enderror" id="date" name="date"
                                   type="date" min="{{ now()->format('Y-m-d') }}" required="required"
                                   value="{{ old('date') }}">

                            @error('date')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror

                        </div>

                        <div class="col-md-6">

                            <label for="time">{{ __('Scheduled time') }} ({{ config('app.timezone') }})</label>

                            <select
                                class="form-control @if($errors->has('date') || $errors->has('time')) is-invalid @endif"
                                id="time" name="time" required="required">
                                @for($i = 0; $i < 24; $i++)
                                    <option value="{{ $i }}">{{ ($i<10) ? '0'.$i : $i }}:00</option>
                                @endfor
                            </select>

                            @error('time')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror

                        </div>

                    </div>


                    <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>

                </form>

            </div>
        </div>
    </div>

@endsection
