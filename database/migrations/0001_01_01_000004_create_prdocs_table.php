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
        Schema::create('prdocs', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('mode');
            $table->string('desc');
            $table->string('purpose');
            $table->date('event_need')->nullable();
            $table->date('event_start')->nullable();
            $table->date('event_end')->nullable();
            $table->string('event_loc')->default("Baler, Aurora");
            $table->unsignedBigInteger('end_office'); // Ensure only one definition
            $table->foreign('end_office')->references('id')->on('offices')->onDelete('cascade');
            $table->unsignedBigInteger('end_user'); // Ensure only one definition
            $table->foreign('end_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('status');
            $table->decimal('value', 15, 2);
            $table->boolean('archived')->default(false);
            $table->boolean('starred')->default(false);
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prdocs');
    }
};
