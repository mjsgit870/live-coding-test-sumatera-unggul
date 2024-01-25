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
    Schema::create('transaksi_kendaraan', function (Blueprint $table) {
      $table->id();
      $table->string('nama_customer');
      $table->date('tanggal_mulai_sewa');
      $table->date('tanggal_selesai_sewa');
      $table->bigInteger('harga_sewa');
      $table->foreignId('id_kendaraan')->constrained('kendaraan')->cascadeOnDelete()->cascadeOnUpdate();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('transaksi_kendaraans');
  }
};
