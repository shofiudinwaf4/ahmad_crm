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
        Schema::create('proyek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lead')->constrained('leads')->cascadeOnDelete();
            $table->foreignId('id_produk')->constrained('produks')->cascadeOnDelete();
            $table->foreignId('id_user')->constrained('users')->cascadeOnDelete();
            $table->bigInteger('harga_jual');
            $table->bigInteger('permintaan_harga');
            $table->enum('status', [
                'waiting approval',
                'approved',
                'rejected'
            ])->default('waiting approval');
            $table->enum('status_project', ['proses', 'selesai'])->default('proses');
            $table->timestamps();
            $table->unique(['id_lead', 'id_produk', 'id_user']);
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
