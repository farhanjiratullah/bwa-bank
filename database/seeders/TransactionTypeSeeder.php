<?php

namespace Database\Seeders;

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
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Internet',
                'code' => 'internet',
                'action' => 'dr',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Top Up',
                'code' => 'top_up',
                'action' => 'cr',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Receive',
                'code' => 'receive',
                'action' => 'cr',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        OperatorCard::insert($transactionTypes);
    }
}
