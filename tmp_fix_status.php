<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Application;
use App\Models\Payment;

$apps = Application::whereIn('status', ['pending', 'submitted_documents', 'verified'])->get();
foreach($apps as $app) {
    if (Payment::where('user_id', $app->user_id)->where('status', 'success')->exists()) {
        $app->update(['status' => 'confirmed']);
        echo "Restored: " . $app->first_name . "\n";
    }
}
