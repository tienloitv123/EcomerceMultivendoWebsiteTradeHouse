@extends('front.layout.pages-layout')
@section('pageTitle', 'Balance')
@section('content')
<div class="container my-5">
    <h3>My Wallet</h3>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Wallet Balance</h5>
            <p class="card-text">Your current balance is:</p>
            <h2 class="text-success">{{ number_format($wallet->balance, 2) }} USD</h2>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('wallet.deposit.form') }}" class="btn btn-primary">Deposit Money</a>
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#withdrawModal">Withdraw Money</button>
    </div>
</div>

<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('wallet.withdraw') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="withdrawModalLabel">Withdraw Money</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Your current balance: <strong>{{ number_format($wallet->balance, 2) }} USD</strong></p>
                    <div class="mb-3">
                        <label for="withdrawAmount" class="form-label">Enter amount to withdraw:</label>
                        <input type="number" class="form-control" id="withdrawAmount" name="amount" min="1" max="{{ $wallet->balance }}" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Withdraw</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
