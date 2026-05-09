<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

$studentRole = Role::where('name', 'student')->first();

if (!$studentRole) {
    echo "Student role not found!\n";
    exit(1);
}

$students = ['akarsh', 'adhi', 'abhi'];

foreach ($students as $name) {
    $user = User::updateOrCreate(
        ['email' => $name . '@example.com'],
        [
            'name' => ucfirst($name),
            'password' => Hash::make('password123'),
            'role_id' => $studentRole->id,
        ]
    );
    echo "Student created: " . $name . "@example.com / password123\n";
}
