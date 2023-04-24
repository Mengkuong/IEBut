<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $wallet = auth()->user()->wallet;
        $wallet->balance += $request->amount;
        $wallet->save();

        return response()->json([$wallet]);
    }
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . auth()->user()->wallet->balance,
        ]);

        $wallet = auth()->user()->wallet;
        $wallet->balance -= $request->amount;
        $wallet->save();

        return response()->json([$wallet]);
    }
}
