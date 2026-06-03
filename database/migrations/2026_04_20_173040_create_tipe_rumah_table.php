<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipe_rumah', function (Blueprint $table) {
            $table->id('id_tipe');
            $table->unsignedBigInteger('id_perumahan');
            $table->string('nama_tipe', 100);
            $table->bigInteger('harga')->nullable();
            $table->integer('luas_tanah')->nullable();
            $table->integer('luas_bangunan')->nullable();
            $table->text('fasilitas')->nullable();
            $table->text('keunggulan')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('denah', 255)->nullable();
            $table->string('foto_tampak_depan', 255)->nullable();
            $table->string('video_preview', 255)->nullable();
            $table->timestamps();
            
            $table->foreign('id_perumahan')
                  ->references('id_perumahan')
                  ->on('perumahan')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipe_rumah');
    }
};