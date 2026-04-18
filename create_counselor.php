<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$role = Role::firstOrCreate(['name' => 'counselor'], ['display_name' => 'Counselor']);
$user = User::firstOrCreate(['email' => 'counselor@example.com'], [
    'name' => 'Sarah Counselor',
    'password' => Hash::make('password'),
    'role_id' => $role->id,
    'department_id' => null,
    'is_active' => true
]);

echo "Success! Email: counselor@example.com | Password: password\n";
