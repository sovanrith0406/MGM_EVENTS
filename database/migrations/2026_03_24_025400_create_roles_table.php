<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // public function up(): void
    // {
    //     Schema::table('users', function (Blueprint $table) {
    //         if (!Schema::hasColumn('users', 'role_id')) {
    //             $table->unsignedBigInteger('role_id')->default(2)->after('email');
    //             $table->foreign('role_id')->references('role_id')->on('roles')->onDelete('restrict');
    //         }
    //     });
    // }

    // public function down(): void
    // {
    //     Schema::table('users', function (Blueprint $table) {
    //         if (Schema::hasColumn('users', 'role_id')) {
    //             $table->dropForeign(['role_id']);
    //             $table->dropColumn('role_id');
    //         }
    //     });
    // }
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->integer('role_id')->primary();
            $table->string('role_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};