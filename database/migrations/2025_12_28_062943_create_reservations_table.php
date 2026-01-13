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
        Schema::create('reservations', function (Blueprint $table) {
    $table->bigIncrements('reserve_id');

    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('room_id');
    $table->unsignedBigInteger('depart_id')->nullable();

    $table->date('reserve_date');
    $table->time('start_time');
    $table->time('end_time');

    $table->string('purpose')->nullable();
    $table->enum('status', ['pending','approved','rejected','cancelled'])->default('pending');

    $table->timestamps();

    $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
    $table->foreign('room_id')->references('room_id')->on('rooms')->cascadeOnDelete();
    $table->foreign('depart_id')->references('depart_id')->on('departments')->nullOnDelete();

    $table->index(['room_id', 'reserve_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
