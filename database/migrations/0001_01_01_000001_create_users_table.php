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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('gender')->nullable();
            $table->string('avatar')->nullable();
            $table->enum('role', ['admin', 'bac', 'end-user'])->default('end-user');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

            // Adding new columns
            $table->unsignedBigInteger('office_id')->nullable();  // Only define it once
            $table->unsignedBigInteger('designation_id')->nullable();  // Only define it once
            $table->unsignedBigInteger('modify_by')->nullable();  // Only define it once

            // Foreign Key Reference for office_id
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('set null');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('set null');
            $table->foreign('modify_by')->references('id')->on('users')->onDelete('set null');

            $table->string('phone', 11)->unique()->nullable();
            $table->string('address')->nullable();

       
            $table->string('password');
            $table->rememberToken();
            
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
