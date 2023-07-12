<?php

namespace Database\Seeders;

use App\Models\DataPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataPlans = [
            [
                'operator_card_id' => 1,
                'name' => '10 GB',
                'price' => 100000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 1,
                'name' => '25 GB',
                'price' => 200000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 1,
                'name' => '40 GB',
                'price' => 300000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 1,
                'name' => '60 GB',
                'price' => 400000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 2,
                'name' => '10 GB',
                'price' => 100000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 2,
                'name' => '25 GB',
                'price' => 200000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 2,
                'name' => '40 GB',
                'price' => 300000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 2,
                'name' => '60 GB',
                'price' => 400000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 3,
                'name' => '10 GB',
                'price' => 100000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 3,
                'name' => '25 GB',
                'price' => 200000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 3,
                'name' => '40 GB',
                'price' => 300000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'operator_card_id' => 3,
                'name' => '60 GB',
                'price' => 400000,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DataPlan::insert($dataPlans);
    }
}
