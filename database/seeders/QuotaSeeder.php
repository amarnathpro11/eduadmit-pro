<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('quota_categories')->insert([
            ['name' => 'General', 'code' => 'GEN', 'percentage' => 50.00],
            ['name' => 'SC/ST', 'code' => 'SCST', 'percentage' => 22.50],
            ['name' => 'OBC', 'code' => 'OBC', 'percentage' => 27.00],
            ['name' => 'Sports', 'code' => 'SP', 'percentage' => 0.50],
        ]);
    }
}
