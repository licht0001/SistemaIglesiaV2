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
        Schema::create('prayer_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('request');
            $table->boolean('is_anonymous')->default(false);
            $table->string('contact_info')->nullable();
            $table->string('status', 20)->default('pendiente'); // pendiente, mensionado, completado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prayer_requests');
    }
};
