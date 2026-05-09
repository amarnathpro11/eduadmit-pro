<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('departments')) {
            Schema::create('departments', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('code')->unique();
                $table->string('hod_name')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('courses')) {
            Schema::create('courses', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->unique();
                $table->integer('duration_years');
                $table->integer('total_seats');
                $table->decimal('application_fee', 10, 2);
                $table->decimal('admission_fee', 10, 2);
                $table->decimal('lab_fee', 10, 2)->nullable();
                $table->decimal('library_fee', 10, 2)->nullable();
                $table->boolean('is_active')->default(true);
                $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
