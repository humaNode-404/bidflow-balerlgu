<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('prdoc_id'); // Ensure only one definition
            $table->foreign('prdoc_id')->references('id')->on('prdocs')->onDelete('cascade');
            $table->string('status');
            $table->unsignedBigInteger('user_id'); // Ensure only one definition
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('main_proc');
            $table->string('proc');
            $table->string('desc');
            $table->timestamp('received_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
