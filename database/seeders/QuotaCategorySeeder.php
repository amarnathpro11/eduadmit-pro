<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QuotaCategory;

class QuotaCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        QuotaCategory::insert([
            ['name' => 'General', 'code' => 'GEN', 'percentage' => 50],
            ['name' => 'OBC', 'code' => 'OBC', 'percentage' => 27],
            ['name' => 'SC', 'code' => 'SC', 'percentage' => 15],
            ['name' => 'ST', 'code' => 'ST', 'percentage' => 8],
        ]);
    }
}
