<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebhookController extends Controller
{
    public function update(Request $request)
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.midtrans_server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.midtrans_is_production');

        DB::beginTransaction();
        try {
            $notif = new \Midtrans\Notification();

            $transactionStatus = $notif->transaction_status;
            $type = $notif->payment_type;
            $order_id = $notif->order_id;
            $fraud = $notif->fraud_status;

            $status = null;

            if ($transactionStatus == 'capture') {
                if ($fraud == 'accept') {
                    // TODO set transaction status on your database to 'success'
                    // and response with 200 OK
                    $status = 'success';
                }
            } else if ($transactionStatus == 'settlement') {
                // TODO set transaction status on your database to 'success'
                // and response with 200 OK
                $status = 'success';
            } else if (
                $transactionStatus == 'cancel' ||
                $transactionStatus == 'deny' ||
                $transactionStatus == 'expire'
            ) {
                // TODO set transaction status on your database to 'failure'
                // and response with 200 OK
                $status = 'failure';
            } else if ($transactionStatus == 'pending') {
                // TODO set transaction status on your database to 'pending' / waiting payment
                // and response with 200 OK
                $status = 'pending';
            }

            $transaction = Transaction::whereCode($order_id)->first();

            if ($transaction->status != 'success') {
                $transaction->update(['status' => $status]);

                if ($status == 'success') {
                    Wallet::whereUserId($transaction->user_id)->increment('balance', $transaction->amount);
                }
            }

            DB::commit();

            return response()->json();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
