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
            if (!Schema::hasColumn('courses', 'level')) {
                $table->string('level')->nullable();
            }
            if (!Schema::hasColumn('courses', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('courses', 'credits')) {
                $table->integer('credits')->nullable();
            }
            if (!Schema::hasColumn('courses', 'semester_count')) {
                $table->integer('semester_count')->nullable();
            }
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
