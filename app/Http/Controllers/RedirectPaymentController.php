<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RedirectPaymentController extends Controller
{
    public function finish(Request $request): View
    {
        $transaction = Transaction::whereCode($request->order_id)->first();

        return view('payment.finish', [
            'transaction' => $transaction
        ]);
    }
}
