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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->string('nama');
            $table->string('kontak');
            $table->string('alamat');
            $table->enum('status', ['baru', 'proses', 'deal', 'gagal', 'done'])->default('baru');
            $table->text('kebutuhan');
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('no_pelanggan')->unique();
            $table->string('nama');
            $table->string('kontak');
            $table->string('alamat');
            $table->enum('is_active', ['aktif', 'tidak aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
