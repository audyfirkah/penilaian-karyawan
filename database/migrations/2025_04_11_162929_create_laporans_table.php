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
        Schema::create('laporans', function (Blueprint $table) {
             $table->id('id_laporan');
            $table->unsignedBigInteger('id_karyawan');
            $table->enum('periode', ['bulanan', 'semester', 'tahunan']);
            $table->string('jenis');
            $table->timestamps();

            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawans')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
