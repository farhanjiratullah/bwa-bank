<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with([
            'paymentMethod:id,name',
            'transactionType:id,code',
            'user:id,name'
        ])->latest()->get();

        return view('transactions.index', [
            'transactions' => $transactions
        ]);
    }
}
