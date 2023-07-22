<?php

namespace App\Http\Requests\API;

use App\Models\PaymentMethod;
use App\Models\TransactionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreTopUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'transaction_type_id' => 'required|integer|exists:transaction_types,id',
            'amount' => 'required|integer|min:10000',
            'code' => 'required|string|size:10|uppercase',
            'description' => 'required|string|max:255',
            'status' => 'required|string',
            'pin' => 'required|digits:6',
            'payment_method_code' => 'required|string|in:bca_va,bni_va,bri_va'
        ];
    }

    protected function prepareForValidation(): void
    {
        $transactionType = TransactionType::whereCode('top_up')->first();
        $paymentMethod = PaymentMethod::whereCode($this->payment_method_code)->first();

        $this->merge([
            'user_id' => auth()->id(),
            'transaction_type_id' => $transactionType->id,
            'payment_method_id' => $paymentMethod->id,
            'code' => Str::upper(str()->random(10)),
            'description' => "Top up via {$paymentMethod->name}",
            'status' => "pending",
        ]);
    }
}
