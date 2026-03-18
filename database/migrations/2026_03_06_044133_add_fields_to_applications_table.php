<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            if (!Schema::hasColumn('applications', 'application_no')) {
                $table->string('application_no')->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('applications', 'tenth_percentage')) {
                $table->decimal('tenth_percentage', 5, 2)->nullable()->after('status');
            }
            if (!Schema::hasColumn('applications', 'twelfth_percentage')) {
                $table->decimal('twelfth_percentage', 5, 2)->nullable()->after('tenth_percentage');
            }
            if (!Schema::hasColumn('applications', 'applied_date')) {
                $table->date('applied_date')->nullable()->after('twelfth_percentage');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['application_no', 'tenth_percentage', 'twelfth_percentage']);
        });
    }
};
