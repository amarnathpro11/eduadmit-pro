<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FollowUp;
use App\Models\User;

class FollowUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FollowUp::factory()->count(10)->create([
            'user_id' => User::first()->id ?? 1
        ]);
    }
}
