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
        Schema::create('customer_layanan', function (Blueprint $table) {
            $table->id();
            $table->integer('no_langganan')->unique();
            $table->foreignId('id_customer')->constrained('customers')->cascadeOnDelete();
            $table->string('nama_layanan');
            $table->bigInteger('tagihan');
            $table->enum('is_active', ['aktif', 'tidak aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
