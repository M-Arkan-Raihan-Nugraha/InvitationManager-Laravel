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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')
                  ->constrained('invitations')
                  ->onDelete('cascade');
            $table->foreignId('guest_id')
                  ->constrained('guests')
                  ->onDelete('cascade');
            $table->enum('status', ['pending','present','not_present'])
                  ->default('pending');
            $table->timestamp('response_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
