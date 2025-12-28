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
             $table->id('reserve_id');

        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('room_id');
        $table->unsignedBigInteger('depart_id');

        $table->date('reserve_date');
        $table->time('start_time');
        $table->time('end_time');

        // pending, approved, rejected
        $table->enum('status', ['pending', 'approved', 'rejected']);

        $table->timestamps();

        $table->foreign('user_id')->references('user_id')->on('users');
        $table->foreign('room_id')->references('room_id')->on('rooms');
        $table->foreign('depart_id')->references('depart_id')->on('departments');
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
