<?php

namespace Database\Seeders;

use App\Models\TransaksiKendaraan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiKendaraanSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    TransaksiKendaraan::create([
      'nama_customer' => 'Yunus',
      'tanggal_mulai_sewa' => date('Y-m-d'),
      'tanggal_selesai_sewa' => '2025-01-25',
      'harga_sewa' => 35000000,
      'id_kendaraan' => 1
    ]);
  }
}
