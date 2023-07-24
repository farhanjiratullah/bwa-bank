<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'name' => 'Bank BWA',
                'code' => 'bwa',
                'status' => 'active',
                'thumbnail' => 'assets/payment-methods/bwa.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bank BNI',
                'code' => 'bni_va',
                'status' => 'active',
                'thumbnail' => 'assets/payment-methods/bni.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bank BCA',
                'code' => 'bca_va',
                'status' => 'active',
                'thumbnail' => 'assets/payment-methods/bca.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bank BRI',
                'code' => 'bri_va',
                'status' => 'active',
                'thumbnail' => 'assets/payment-methods/bri.png',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        PaymentMethod::insert($paymentMethods);
    }
}
