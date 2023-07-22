<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreTopUpRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TopUpController extends Controller
{
    public function store(StoreTopUpRequest $request)
    {
        $data = $request->validated();
        $pinChecker = pinChecker($data['pin']);

        if (!$pinChecker) {
            return response()->json(['message' => 'Your pin is wrong'], 422);
        }

        try {
            $transaction = Transaction::create($data);
            $transaction->load('paymentMethod');


            $params = $this->buildMidtransParameters([
                'code' => $transaction->code,
                'amount' => $transaction->amount,
                'payment_method' => $transaction->paymentMethod->code,
            ]);

            $midtrans = $this->callMidtrans($params);

            return response()->json($midtrans);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    private function callMidtrans(array $params): array
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.midtrans_server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.midtrans_is_production');
        \Midtrans\Config::$isSanitized = config('services.midtrans.midtrans_is_sanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.midtrans_is_3ds');

        $paymentUrl = \Midtrans\Snap::createTransaction($params);

        return [
            'redirect_url' => $paymentUrl->redirect_url,
            'token' => $paymentUrl->token
        ];
    }

    private function buildMidtransParameters(array $params): array
    {
        $transactionDetails = [
            'order_id' => $params['code'],
            'gross_amount' => $params['amount']
        ];

        $splitName = $this->splitName(auth()->user()->name);

        $customerDetails = [
            'first_name' => $splitName['first_name'],
            'last_name' => $splitName['last_name'],
            'email' => auth()->user()->email
        ];
        $enabledPayment = [$params['payment_method']];

        return [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'enabled_payments' => $enabledPayment,
        ];
    }

    private function splitName(string $fullName): array
    {
        $name = explode(' ', $fullName);
        $countName = count($name);

        $lastName = $name[$countName - 1];
        $firstName = $name[0];

        return [
            'first_name' => $firstName,
            'last_name' => $lastName
        ];
    }
}
