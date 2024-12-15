@extends('front.layout.pages-layout')
@section('pageTitle', 'Deposite')
@section('content')
<div class="container my-5">
    <h3>Deposit to Wallet</h3>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('wallet.deposit') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" name="amount" id="amount" class="form-control" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Deposit</button>
    </form>
</div>
@endsection
