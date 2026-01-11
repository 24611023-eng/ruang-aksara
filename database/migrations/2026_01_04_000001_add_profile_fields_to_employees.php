<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            if (! Schema::hasColumn('employees', 'nik')) {
                $table->string('nik')->nullable()->after('email');
            }
            if (! Schema::hasColumn('employees', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('nik');
            }
            if (! Schema::hasColumn('employees', 'foto_profil')) {
                $table->string('foto_profil')->nullable()->after('tanggal_lahir');
            }
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'foto_profil')) {
                $table->dropColumn('foto_profil');
            }
            if (Schema::hasColumn('employees', 'tanggal_lahir')) {
                $table->dropColumn('tanggal_lahir');
            }
            if (Schema::hasColumn('employees', 'nik')) {
                $table->dropColumn('nik');
            }
        });
    }
};
