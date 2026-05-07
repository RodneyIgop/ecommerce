@extends('layouts.app')

@section('title', 'Wallet')

@section('content')
<section class="bg-[#f5f3ef] min-h-screen py-10">
    <div class="max-w-[800px] mx-auto px-6 lg:px-10">
        <h1 class="font-serif-display text-[32px] text-gray-900 mb-8">Wallet</h1>

        <div class="bg-white border border-[#e8e5e0] p-8 mb-8">
            <p class="text-[10px] font-semibold tracking-[0.15em] uppercase text-gray-500 mb-2">Current Balance</p>
            <p class="text-[36px] font-semibold text-gray-900">${{ number_format($wallet->balance, 2) }}</p>
            <p class="text-[11px] text-gray-500 mt-1">{{ $wallet->currency }}</p>
        </div>

        <div class="bg-white border border-[#e8e5e0] p-6 mb-8">
            <h3 class="text-[11px] font-semibold tracking-[0.15em] uppercase text-gray-900 mb-4">Deposit Funds</h3>
            <form action="{{ route('wallet.deposit') }}" method="post" class="flex gap-3">
                @csrf
                <input type="number" name="amount" placeholder="Amount" min="1" step="0.01" required class="flex-1 bg-transparent border border-[#e8e5e0] text-[13px] py-2 px-3 focus:outline-none focus:border-black">
                <select name="method" class="bg-transparent border border-[#e8e5e0] text-[12px] py-2 px-3 focus:outline-none focus:border-black">
                    <option value="stripe">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
                <button type="submit" class="bg-[#111] text-white text-[11px] font-semibold tracking-[0.12em] uppercase px-6 py-2 hover:bg-gray-800 transition-colors">Deposit</button>
            </form>
        </div>

        <h2 class="text-[11px] font-semibold tracking-[0.15em] uppercase text-gray-900 mb-4">Transaction History</h2>
        @if($transactions->count())
        <div class="bg-white border border-[#e8e5e0]">
            @foreach($transactions as $txn)
            <div class="flex justify-between items-center p-4 border-b border-[#e8e5e0] last:border-b-0">
                <div>
                    <p class="text-[13px] font-medium">{{ $txn->description }}</p>
                    <p class="text-[11px] text-gray-500">{{ $txn->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[14px] font-semibold {{ $txn->type === 'credit' ? 'text-green-700' : 'text-gray-900' }}">
                        {{ $txn->type === 'credit' ? '+' : '-' }}${{ number_format($txn->amount, 2) }}
                    </p>
                    <p class="text-[11px] text-gray-500">${{ number_format($txn->balance_after, 2) }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $transactions->links() }}</div>
        @else
        <div class="bg-white border border-[#e8e5e0] p-12 text-center">
            <p class="text-[13px] text-gray-600">No transactions yet.</p>
        </div>
        @endif
    </div>
</section>
@endsection
