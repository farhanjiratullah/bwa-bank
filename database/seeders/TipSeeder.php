<?php

namespace Database\Seeders;

use App\Models\Tip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tips = [
            [
                'title' => 'Cara menyimpan uang yang baik',
                "thumbnail" => 'assets/tips/nabung.jpg',
                "url" => 'https://www.ocbcnisp.com/id/article/2023/02/08/cara-menabung-yang-benar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Cara berinvestasi emas',
                "thumbnail" => 'assets/tips/emas.jpg',
                "url" => 'https://www.cimbniaga.co.id/id/inspirasi/perencanaan/5-cara-investasi-emas-yang-mudah-bagi-pemula',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Cara bermain saham',
                "thumbnail" => 'assets/tips/saham.jpg',
                "url" => 'https://bmoney.id/blog/cara-main-saham-pemula-117204',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        Tip::insert($tips);
    }
}
