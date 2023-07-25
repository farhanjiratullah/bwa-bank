<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UpdateWalletRequest;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function show(Request $request)
    {
        $wallet = Wallet::select('pin', 'card_number', 'balance')->whereUserId(auth()->id())->first();

        return response()->json($wallet);
    }

    public function update(UpdateWalletRequest $request)
    {
        $data = $request->validated();

        $pinChecker = pinChecker($data['previous_pin']);

        if (!$pinChecker) {
            return response()->json(['message' => 'Your old pin is wrong'], 422);
        }

        $wallet = Wallet::whereUserId(auth()->id())->update(['pin' => $data['new_pin']]);

        return response()->json(['message' => 'Pin updated']);
    }
}
