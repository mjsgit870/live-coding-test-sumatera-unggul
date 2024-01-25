<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiKendaraan extends Model
{
  use HasFactory;

  protected $table = 'transaksi_kendaraan';

  protected $fillable = [
    'nama_customer',
    'tanggal_mulai_sewa',
    'tanggal_selesai_sewa',
    'harga_sewa',
    'id_kendaraan'
  ];

  public function kendaraan(): BelongsTo {
    return $this->belongsTo(Kendaraan::class, 'id_kendaraan');
  }
}
