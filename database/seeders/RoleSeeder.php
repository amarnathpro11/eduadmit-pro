<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Role::insert([
            ['name' => 'admin', 'display_name' => 'Administrator'],
            ['name' => 'accountant', 'display_name' => 'Accountant'],
            ['name' => 'student', 'display_name' => 'Student'],
            ['name' => 'counselor', 'display_name' => 'Counselor'],
        ]);
    }
}
