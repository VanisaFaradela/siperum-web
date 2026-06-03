<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontak', function (Blueprint $table) {
            $table->id('id_kontak');
            $table->string('nama_pengunjung', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('nomor_hp', 20)->nullable();
            $table->text('pesan')->nullable();
            $table->date('tanggal_kirim')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontak');
    }
};