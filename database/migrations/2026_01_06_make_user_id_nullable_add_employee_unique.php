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
        if (Schema::hasTable('attendances')) {
            // Make user_id nullable so employee-only records can exist
            Schema::table('attendances', function (Blueprint $table) {
                try {
                    $table->unsignedBigInteger('user_id')->nullable()->change();
                } catch (\Exception $e) {
                    // If change() requires doctrine/dbal and it's not available,
                    // try raw SQL as a fallback.
                    try {
                        \DB::statement('ALTER TABLE `attendances` MODIFY `user_id` bigint unsigned NULL');
                    } catch (\Exception $ex) {
                        // ignore if even raw fails
                    }
                }

                // Add unique index for employee_id + date to prevent duplicate employee presensi.
                // We don't rely on Doctrine here; just attempt to create the index and ignore errors if it exists.
                if (Schema::hasColumn('attendances', 'employee_id')) {
                    try {
                        $table->unique(['employee_id', 'date'], 'attendances_employee_date_unique');
                    } catch (\Exception $e) {
                        // Index may already exist or DB driver doesn't allow listing indexes here — ignore.
                    }
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('attendances')) {
            Schema::table('attendances', function (Blueprint $table) {
                // Attempt to drop the employee unique index if it exists — ignore errors if not present
                try {
                    $table->dropUnique('attendances_employee_date_unique');
                } catch (\Exception $e) {
                    // ignore
                }

                try {
                    $table->unsignedBigInteger('user_id')->nullable(false)->change();
                } catch (\Exception $e) {
                    try {
                        \DB::statement('ALTER TABLE `attendances` MODIFY `user_id` bigint unsigned NOT NULL');
                    } catch (\Exception $ex) {
                        // ignore
                    }
                }
            });
        }
    }
};
