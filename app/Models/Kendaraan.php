<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kendaraan extends Model
{
  use HasFactory;

  protected $table = 'kendaraan';

  protected $fillable = [
    'plat_nomor'
  ];

  public function transaksi(): HasMany {
    return $this->hasMany(TransaksiKendaraan::class, 'id_kendaraan');
  }
}
