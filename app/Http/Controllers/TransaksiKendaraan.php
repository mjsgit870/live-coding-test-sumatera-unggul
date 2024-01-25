<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TransaksiKendaraan extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $transaksi = \App\Models\TransaksiKendaraan::query();

      return DataTables::eloquent($transaksi)
        ->addColumn('plat', function($row) {
          return $row->kendaraan->plat_nomor;
        })
        ->addColumn('created_at', function($row) {
          return $row->created_at->format('d-m-Y');
        })
        ->addColumn('updated_at', function($row) {
          return $row->updated_at->format('d-m-Y');
        })
        ->addColumn('action', function($row) {
          return '
            <a href="'.route('transaksi.edit', $row).'" class="btn btn-sm btn-success">Edit</a>
            <a href="'.route('transaksi.destroy', $row).'" class="btn btn-sm btn-danger hapusTransaksi">Hapus</a>
          ';
        })
        ->make(true);
    }

    $kendaraan = \App\Models\Kendaraan::all();
    
    return view('transaksi_kendaraan.index', compact('kendaraan'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'nama_customer' => 'required',
      'tanggal_mulai_sewa' => 'required|date',
      'tanggal_selesai_sewa' => 'required|date',
      'harga_sewa' => 'required|numeric',
      'id_kendaraan' => 'required',
    ], [], [
      'nama_customer' => 'Nama Customer',
      'tanggal_mulai_sewa' => 'Tanggal Mulai Sewa',
      'tanggal_selesai_sewa' => 'Tanggal Selesai Sewa',
      'harga_sewa' => 'harga Sewa',
      'id_kendaraan' => 'Kendaraan',
    ]);

    if ($validator->fails()) { // jika validasi gagal
      return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
    }

    $transaksi = new \App\Models\TransaksiKendaraan; // inisiasi model class transaksikendaraan
    $transaksi->nama_customer = $request->nama_customer;
    $transaksi->tanggal_mulai_sewa = $request->tanggal_mulai_sewa;
    $transaksi->tanggal_selesai_sewa = $request->tanggal_selesai_sewa;
    $transaksi->harga_sewa = $request->harga_sewa;
    $transaksi->id_kendaraan = $request->id_kendaraan;

    if (!$transaksi->save()) { // simpan transaksi / jika gagal
      return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat melakukan transaksi, silahkan refresh halaman']);
    }

    return response()->json(['success' => true, 'message' => 'Berhasil menambahkan transaksi baru']);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(\App\Models\TransaksiKendaraan $transaksi)
  {
    $kendaraan = \App\Models\Kendaraan::all();

    return view('transaksi_kendaraan.edit', compact('transaksi', 'kendaraan'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, \App\Models\TransaksiKendaraan $transaksi)
  {
    $validator = Validator::make($request->all(), [
      'nama_customer' => 'required',
      'tanggal_mulai_sewa' => 'required|date',
      'tanggal_selesai_sewa' => 'required|date',
      'harga_sewa' => 'required|numeric',
      'id_kendaraan' => 'required',
    ], [], [
      'nama_customer' => 'Nama Customer',
      'tanggal_mulai_sewa' => 'Tanggal Mulai Sewa',
      'tanggal_selesai_sewa' => 'Tanggal Selesai Sewa',
      'harga_sewa' => 'harga Sewa',
      'id_kendaraan' => 'Kendaraan',
    ]);

    if ($validator->fails()) { // jika validasi gagal
      return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
    }

    $transaksi->nama_customer = $request->nama_customer;
    $transaksi->tanggal_mulai_sewa = $request->tanggal_mulai_sewa;
    $transaksi->tanggal_selesai_sewa = $request->tanggal_selesai_sewa;
    $transaksi->harga_sewa = $request->harga_sewa;
    $transaksi->id_kendaraan = $request->id_kendaraan;

    if (!$transaksi->save()) { // simpan transaksi / jika gagal
      return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat melakukan update transaksi, silahkan refresh halaman']);
    }

    return response()->json(['success' => true, 'message' => 'Berhasil merubah transaksi']);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(\App\Models\TransaksiKendaraan $transaksi)
  {
    if (!$transaksi->delete()) {
      return response()->json(['success' => false, 'message' => 'Gagal menghapus transaksi, silahkan refresh halaman']);
    }

    return response()->json(['success' => true, 'message' => 'Berhasil menghapus transaksi']);
  }
}
