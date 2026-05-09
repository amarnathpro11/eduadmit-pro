<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('parent_student')) {
            Schema::create('parent_student', function (Blueprint $table) {
                $table->id();
                $table->foreignId('parent_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
                $table->timestamps();
            });
        }

        // Insert Parent role if it doesn't exist
        DB::table('roles')->updateOrInsert(
            ['name' => 'parent'],
            ['display_name' => 'Parent']
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_student');
    }
};
