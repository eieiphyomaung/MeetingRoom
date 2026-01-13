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
    Schema::table('departments', function ($table) {
        if (!Schema::hasColumn('departments', 'head_of_department')) {
            $table->string('head_of_department')->nullable()->after('depart_name');
        }
        if (!Schema::hasColumn('departments', 'badge_color')) {
            $table->string('badge_color', 30)->nullable()->after('head_of_department'); // e.g. teal, sky, pink
        }
        if (!Schema::hasColumn('departments', 'badge_text')) {
            $table->string('badge_text', 5)->nullable()->after('badge_color'); // e.g. HR, IT, M
        }
    });
}

public function down(): void
{
    Schema::table('departments', function ($table) {
        $table->dropColumn(['head_of_department','badge_color','badge_text']);
    });
}
};
