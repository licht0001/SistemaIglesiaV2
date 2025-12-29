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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            $table->dateTime('start_at');
            $table->dateTime('end_at')->nullable();

            $table->string('location')->nullable();
            $table->string('type')->nullable(); // culto, vigilia, reunión de líderes, retiro, etc.

            $table->boolean('is_public')->default(true);

            $table->string('status', 20)->default('programado'); // programado, en curso, finalizado, cancelado

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
