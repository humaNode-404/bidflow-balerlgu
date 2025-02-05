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
        Schema::create('stage_actions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('prdoc_id')->constrained('prdocs')->onDelete('cascade');
            $table->string('user_group')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('incharge');
            $table->string('proc_no');
            $table->string('main_proc');
            $table->string('proc');
            $table->string('desc')->nullable();
            $table->string('notes')->nullable();
            $table->string('attachment')->nullable();
            $table->string('status')->default('pending');
            $table->timestamp('received_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // Optional migration for storing multiple files per stage
        Schema::create('stage_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stage_action_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stage_actions');
        Schema::dropIfExists('stage_files');
    }
};
