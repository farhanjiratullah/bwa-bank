<?php

namespace Database\Seeders;

use App\Models\TransactionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactionTypes = [
            [
                'name' => 'Transfer',
                'code' => 'transfer',
                'action' => 'dr',
                'thumbnail' => 'assets/transaction-types/transfer.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Internet',
                'code' => 'internet',
                'action' => 'dr',
                'thumbnail' => 'assets/transaction-types/internet.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Top Up',
                'code' => 'top_up',
                'action' => 'cr',
                'thumbnail' => 'assets/transaction-types/top-up.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Receive',
                'code' => 'receive',
                'action' => 'cr',
                'thumbnail' => 'assets/transaction-types/receive.png',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        TransactionType::insert($transactionTypes);
    }
}
