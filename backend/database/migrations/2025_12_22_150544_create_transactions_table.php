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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();

            $table->enum('type', ['ingreso', 'egreso']);
            $table->string('category'); // diezmo, ofrenda, donación, gasto operativo, misión, etc.
            $table->string('sub_category')->nullable(); // fondo general, fondo de construcción, etc.
            $table->decimal('amount', 12, 2);

            $table->date('transaction_date');

            $table->string('payment_method')->nullable(); // efectivo, transferencia, tarjeta, etc.
            $table->string('reference')->nullable();

            $table->text('description')->nullable();

            // Para multi-iglesia en el futuro podríamos tener church_id

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
