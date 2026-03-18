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
        Schema::table('courses', function (Blueprint $table) {
            $table->string('level')->nullable(); // UG / PG / PhD
            $table->text('description')->nullable();
            $table->integer('credits')->nullable();
            $table->integer('semester_count')->nullable();
        });
    }

    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'level',
                'description',
                'credits',
                'semester_count'
            ]);
        });
    }
};
