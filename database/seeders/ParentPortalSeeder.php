<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ParentPortalSeeder extends Seeder
{
    public function run()
    {
        // 1. Ensure Parent Role exists
        $parentRole = Role::where('name', 'parent')->first();
        if (!$parentRole) {
            $parentRole = Role::create(['name' => 'parent', 'display_name' => 'Parent']);
        }

        // 2. Find or Create a Student
        $studentRole = Role::where('name', 'student')->first();
        $student = User::where('role_id', $studentRole->id ?? 3)->first();
        
        if (!$student) {
            $student = User::create([
                'name' => 'John Doe Jr.',
                'email' => 'student@example.com',
                'password' => Hash::make('password'),
                'role_id' => $studentRole->id ?? 3,
                'is_active' => true,
            ]);
            
            // Find first course
            $course = DB::table('courses')->first();
            $courseId = $course ? $course->id : 1;
            
            // Create a mock application for this student
            DB::table('applications')->insert([
                'user_id' => $student->id,
                'course_id' => $courseId,
                'application_no' => 'APP' . str_pad($student->id, 5, '0', STR_PAD_LEFT),
                'status' => 'enrolled',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Create a Parent
        $parent = User::where('email', 'parent@example.com')->first();
        if (!$parent) {
            $parent = User::create([
                'name' => 'John Doe Sr.',
                'email' => 'parent@example.com',
                'password' => Hash::make('password'),
                'role_id' => $parentRole->id,
                'is_active' => true,
            ]);
        }

        // 4. Map Parent to Student
        DB::table('parent_student')->updateOrInsert(
            ['parent_id' => $parent->id, 'student_id' => $student->id],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // 5. Seed LMS Records
        DB::table('lms_student_records')->updateOrInsert(
            ['user_id' => $student->id, 'subject' => 'Introduction to Programming'],
            ['grade' => 'A', 'attendance' => 95, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()]
        );
        DB::table('lms_student_records')->updateOrInsert(
            ['user_id' => $student->id, 'subject' => 'Data Structures'],
            ['grade' => 'B+', 'attendance' => 88, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()]
        );
        DB::table('lms_student_records')->updateOrInsert(
            ['user_id' => $student->id, 'subject' => 'Discrete Mathematics'],
            ['grade' => 'A-', 'attendance' => 90, 'status' => 'active', 'created_at' => now(), 'updated_at' => now()]
        );
    }
}
