<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('supplier_bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('track_id')->nullable()->after('event_id');
            $table->foreign('track_id')->references('track_id')->on('tracks')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('supplier_bookings', function (Blueprint $table) {
            $table->dropForeign(['track_id']);
            $table->dropColumn('track_id');
        });
    }
};