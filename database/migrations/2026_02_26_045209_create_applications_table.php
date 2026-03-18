<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('lead_id')->nullable()->constrained();
            $table->foreignId('course_id')->constrained();
            $table->string('application_no')->nullable()->unique();
            $table->string('status')->default('registered');
            $table->decimal('tenth_percentage', 5, 2)->nullable();
            $table->decimal('twelfth_percentage', 5, 2)->nullable();
            $table->decimal('merit_score', 5, 2)->nullable();
            $table->string('rejection_reason')->nullable();
            $table->date('applied_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
