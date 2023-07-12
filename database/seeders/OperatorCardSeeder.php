<?php

namespace Database\Seeders;

use App\Models\OperatorCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperatorCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $operatorCards = [
            [
                'name' => 'Telkomsel',
                'status' => 'active',
                'thumbnail' => 'assets/operator-cards/telkomsel.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Indosat',
                'status' => 'active',
                'thumbnail' => 'assets/operator-cards/indosat.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Singtel',
                'status' => 'active',
                'thumbnail' => 'assets/operator-cards/singtel.png',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        OperatorCard::insert($operatorCards);
    }
}
