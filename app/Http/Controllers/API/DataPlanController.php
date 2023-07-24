<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\StoreDataPlanRequest;
use App\Models\DataPlan;
use App\Models\DataPlanHistory;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataPlanController extends Controller
{
    public function store(StoreDataPlanRequest $request)
    {
        $data = $request->validated();

        $transactionType = TransactionType::whereCode('internet')->first();
        $paymentMethod = PaymentMethod::whereCode('bwa')->first();
        $wallet = Wallet::whereUserId(auth()->id())->first();
        $dataPlan = DataPlan::find($data['data_plan_id']);

        $pinChecker = pinChecker($data['pin']);

        if (!$pinChecker) {
            return response()->json(['message' => 'Your pin is wrong'], 422);
        }

        if ($wallet->balance < $dataPlan->price) {
            return response()->json(['message' => 'Your balance is not enough'], 422);
        }

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'transaction_type_id' => $transactionType->id,
                'payment_method_id' => $paymentMethod->id,
                'amount' => $dataPlan->price,
                'description' => "Internet data plan {$dataPlan->name}",
                'code' => Str::upper(str()->random(10)),
                'status' => 'success'
            ]);

            DataPlanHistory::create([
                'data_plan_id' => $data['data_plan_id'],
                'transaction_id' => $transaction->id,
                'phone_number' => $data['phone_number']
            ]);

            $wallet->decrement('balance', $dataPlan->price);

            DB::commit();

            return response()->json(['message' => 'Buy data plan success']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
