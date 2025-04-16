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
        Schema::create('jurnals', function (Blueprint $table) {
             $table->id('id_jurnal');
            $table->unsignedBigInteger('id_karyawan');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->date('tanggal');
            $table->text('aktivitas');
            $table->string('lampiran')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'revisi']);
            $table->timestamps();

            $table->foreign('approved_by')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnals');
    }
};
