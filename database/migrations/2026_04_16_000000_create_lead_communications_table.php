<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('lead_communications')) {
            Schema::create('lead_communications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('lead_id')->constrained()->onDelete('cascade');
                $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
                $table->string('type')->default('system');
                $table->text('message');
                $table->timestamp('communicated_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_communications');
    }
};
