<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komentar', function (Blueprint $table) {
            $table->id('id_komentar');
            $table->unsignedBigInteger('id_berita');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('nama', 100);
            $table->string('email', 100);
            $table->text('komentar');
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
            
            $table->foreign('id_berita')
                  ->references('id_berita')
                  ->on('berita')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komentar');
    }
};