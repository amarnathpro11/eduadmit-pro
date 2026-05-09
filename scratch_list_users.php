<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

$users = User::all();

foreach ($users as $user) {
    echo "User: " . $user->name . " | Email: " . $user->email . " | Role ID: " . $user->role_id . "\n";
}
