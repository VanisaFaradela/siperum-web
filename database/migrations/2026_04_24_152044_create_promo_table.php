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
        Schema::create('promo', function (Blueprint $table) {
            $table->id('id_promo');
            $table->unsignedBigInteger('id_perumahan');
            $table->string('judul_promo', 200);
            $table->string('badge', 50)->nullable()->default('HOT DEAL');
            $table->text('deskripsi');
            $table->bigInteger('harga_awal')->nullable();
            $table->bigInteger('harga_promo');
            $table->integer('diskon_persen')->nullable();
            $table->string('gambar', 255)->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->enum('status', ['active', 'expired', 'coming_soon'])->default('active');
            $table->integer('stok')->default(0);
            $table->text('syarat_ketentuan')->nullable();
            $table->timestamps();
            
            // Foreign key ke tabel perumahan
            $table->foreign('id_perumahan')
                  ->references('id_perumahan')
                  ->on('perumahan')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
                  
            // Index untuk pencarian
            $table->index('status');
            $table->index('tanggal_mulai');
            $table->index('tanggal_berakhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo');
    }
};