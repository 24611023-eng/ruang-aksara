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
        if (Schema::hasTable('attendances') && !Schema::hasColumn('attendances', 'employee_id')) {
            Schema::table('attendances', function (Blueprint $table) {
                $table->foreignId('employee_id')->nullable()->after('user_id')->constrained('employees')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('attendances') && Schema::hasColumn('attendances', 'employee_id')) {
            Schema::table('attendances', function (Blueprint $table) {
                $table->dropForeign([ 'employee_id' ]);
                $table->dropColumn('employee_id');
            });
        }
    }
};
