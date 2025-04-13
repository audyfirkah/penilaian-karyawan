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
        Schema::create('detail_penilaians', function (Blueprint $table) {
           $table->id('id_detail');
            $table->unsignedBigInteger('id_penilaian');
            $table->unsignedBigInteger('id_kategori');
            $table->decimal('skor', 5, 2);
            $table->timestamps();

            $table->foreign('id_penilaian')->references('id_penilaian')->on('penilaians')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_penilaians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penilaians');
    }
};
