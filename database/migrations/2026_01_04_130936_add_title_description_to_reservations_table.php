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
         Schema::table('reservations', function (Blueprint $table) {
        $table->string('title', 120)->nullable()->after('end_time');
        $table->string('description', 255)->nullable()->after('title');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('reservations', function (Blueprint $table) {
        $table->dropColumn(['title', 'description']);
        });
    }
};
