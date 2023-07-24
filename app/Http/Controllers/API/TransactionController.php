<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);

        $transactions = Transaction::with([
            'paymentMethod:id,name,code,thumbnail',
            'transactionType:id,name,code,action,thumbnail'
        ])
            ->whereUserId(auth()->id())
            ->whereStatus('success')
            ->paginate($limit);

        return response()->json($transactions);
    }
}
