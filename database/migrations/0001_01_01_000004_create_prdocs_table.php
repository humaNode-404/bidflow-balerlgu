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
            $table->uuid('uuid')->unique();
            $table->string('number')->unique();
            $table->string('mode');
            $table->string('desc');
            $table->decimal('value', 11, 2);
            $table->string('purpose');
            $table->date('event_start')->nullable();
            $table->date('event_need')->nullable();
            $table->date('event_end')->nullable();
            $table->string('event_loc')->default("Baler, Aurora");
            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->softDeletes();
            $table->timestamp('failed_at')->nullable();
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
