<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function show(Request $request)
    {
        $wallet = Wallet::select('pin', 'card_number', 'balance')->whereUserId(auth()->id())->first();

        return response()->json($wallet);
    }
}
