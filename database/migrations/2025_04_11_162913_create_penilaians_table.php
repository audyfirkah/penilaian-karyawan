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
        Schema::create('penilaians', function (Blueprint $table) {
             $table->id('id_penilaian');
            $table->unsignedBigInteger('id_karyawan');
            $table->unsignedBigInteger('id_penilai'); // user
            $table->date('tanggal_penilaian');
            $table->enum('periode', ['bulanan', 'semester', 'tahunan']);
            $table->decimal('total_skor', 10, 2)->nullable();
            $table->string('keterangan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawans')->onDelete('cascade');
            $table->foreign('id_penilai')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
