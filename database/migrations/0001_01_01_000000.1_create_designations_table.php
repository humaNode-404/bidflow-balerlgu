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
        Schema::create('designations', function (Blueprint $table) {
            $table->id(); // auto-incrementing primary key
            $table->string('title'); // designation title
            $table->string('category')->nullable(); // category based on role/environment
            $table->string('suffix')->nullable(); // suffix like I, II, III
            $table->timestamps(); // created_at, updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designations');
    }
};
