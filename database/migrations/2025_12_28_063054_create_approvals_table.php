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
        Schema::create('approvals', function (Blueprint $table) {
        $table->bigIncrements('approval_id');

    $table->unsignedBigInteger('reserve_id');
    $table->unsignedBigInteger('admin_user_id');

    $table->enum('decision_status', ['approved','rejected']);
    $table->string('decision_note')->nullable();
    $table->timestamp('decided_at')->useCurrent();

    $table->timestamps();

    $table->foreign('reserve_id')->references('reserve_id')->on('reservations')->cascadeOnDelete();
    $table->foreign('admin_user_id')->references('user_id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
