<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        $paymentMethod = PaymentMethod::whereStatus('active')
            ->whereNot('code', 'bwa')
            ->get();

        return response()->json($paymentMethod);
    }
}
