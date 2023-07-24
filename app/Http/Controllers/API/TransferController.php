<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreTransferRequest;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\TransferHistory;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function store(StoreTransferRequest $request)
    {
        $data = $request->validated();

        $sender = auth()->user()->with('wallet')->first();
        $receiver = User::with('wallet')
            ->whereUsername($data['send_to'])
            ->orWhereHas('wallet', function ($query) use ($data) {
                return $query->whereCardNumber($data['send_to']);
            })
            ->first();

        // dd($receiver);
        $pinChecker = pinChecker($data['pin']);

        if (!$pinChecker) {
            return response()->json(['message' => 'Your pin is wrong'], 422);
        }

        if (!$receiver) {
            return response()->json(['message' => 'User receiver not found'], 404);
        }

        if ($sender->id == $receiver->id) {
            return response()->json(['message' => 'Your can\'t transfer to yourself'], 422);
        }

        if ($sender->wallet->balance < $data['amount']) {
            return response()->json(['message' => 'Your balance is not enough'], 422);
        }

        DB::beginTransaction();
        try {
            [$transferTransactionType, $receiveTransactionType] = TransactionType::whereIn('code', ['transfer', 'receive'])->get();

            $code = Str::upper(str()->random(10));

            $paymentMethod = PaymentMethod::whereCode('bwa')->first();

            $senderTransaction = Transaction::create([
                'user_id' => $sender->id,
                'transaction_type_id' => $transferTransactionType->id,
                'payment_method_id' => $paymentMethod->id,
                'description' => "Transfer funds to {$receiver->username}",
                'amount' => $data['amount'],
                'code' => $code,
                'status' => 'success'
            ]);

            Wallet::whereUserId($sender->id)->decrement('balance', $data['amount']);

            $receiverTransaction = Transaction::create([
                'user_id' => $receiver->id,
                'transaction_type_id' => $receiveTransactionType->id,
                'payment_method_id' => $paymentMethod->id,
                'description' => "Receive funds from {$sender->username}",
                'amount' => $data['amount'],
                'code' => $code,
                'status' => 'success'
            ]);

            Wallet::whereUserId($receiver->id)->increment('balance', $data['amount']);

            TransferHistory::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'code' => $code
            ]);

            DB::commit();

            return response()->json(['message' => 'Transfer success']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
