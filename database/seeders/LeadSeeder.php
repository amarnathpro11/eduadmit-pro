<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;
use App\Models\Course;
use App\Models\User;

class LeadSeeder extends Seeder
{
    public function run()
    {
        $course = Course::first();
        $admin = User::whereHas('role', function($q) { $q->where('name', 'admin'); })->first();

        $leads = [
            [
                'name' => 'Johnathan Doe',
                'email' => 'j.doe@university.com',
                'phone' => '(555) 123-4567',
                'source' => 'Website',
                'course_interested' => $course->id ?? 1,
                'assigned_to' => $admin ? $admin->id : null,
                'status' => 'New',
                'lead_score' => 45,
            ],
            [
                'name' => 'Alice Stevenson',
                'email' => 'alice.s@gmail.com',
                'phone' => '(555) 987-6543',
                'source' => 'Referral',
                'course_interested' => $course->id ?? 1,
                'assigned_to' => $admin ? $admin->id : null,
                'status' => 'Interested',
                'lead_score' => 92,
            ],
            [
                'name' => 'Robert Brown',
                'email' => 'rbrown@outlook.com',
                'phone' => '(555) 444-5555',
                'source' => 'Facebook Ad',
                'course_interested' => $course->id ?? 1,
                'assigned_to' => $admin ? $admin->id : null,
                'status' => 'Converted',
                'lead_score' => 100,
            ],
            [
                'name' => 'Emily White',
                'email' => 'ewhite@edu.com',
                'phone' => '(555) 222-3333',
                'source' => 'Walk-in',
                'course_interested' => $course->id ?? 1,
                'assigned_to' => null,
                'status' => 'Lost',
                'lead_score' => 12,
            ],
        ];

        foreach($leads as $lead) {
            Lead::create($lead);
        }
    }
}
