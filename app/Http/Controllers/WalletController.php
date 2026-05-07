<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\WalletTransaction;

class WalletController extends Controller
{
    public function index()
    {
        $wallet = Wallet::firstOrCreate(
            ['user_id' => auth()->id()],
            ['balance' => 0, 'currency' => 'USD']
        );

        $transactions = WalletTransaction::where('wallet_id', $wallet->id)
            ->latest()
            ->paginate(20);

        return view('wallet.index', compact('wallet', 'transactions'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'method' => 'required|in:stripe,paypal,bank_transfer',
        ]);

        $wallet = Wallet::firstOrCreate(
            ['user_id' => auth()->id()],
            ['balance' => 0, 'currency' => 'USD']
        );

        $wallet->credit(
            (float) $request->amount,
            'Wallet deposit via ' . $request->method,
            $wallet
        );

        return back()->with('success', 'Deposit successful.');
    }
}
