<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run()
    {
        Department::insert([
            ['name' => 'Computer Science', 'code' => 'CS', 'hod_name' => 'Dr. Sarah Jenkins'],
            ['name' => 'Business Administration', 'code' => 'BUS', 'hod_name' => 'Dr. Michael Carter'],
            ['name' => 'Science', 'code' => 'SCI', 'hod_name' => 'Dr. Robert Williams'],
            ['name' => 'Arts & Humanities', 'code' => 'ART', 'hod_name' => 'Dr. Emma Watson'],
            ['name' => 'Engineering', 'code' => 'ENG', 'hod_name' => 'Dr. Daniel Smith'],
        ]);
    }
}
