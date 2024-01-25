@extends('layout')

@section('content')
  <div class="card">
    <card class="card-body">
      <form action="{{ route('transaksi.update', $transaksi) }}" method="POST" id="editTransaksi">
        @method('PUT')
        <div class="mb-3">
          <label for="nama_customer" class="form-label">Nama Customer</label>
          <input type="text" class="form-control" id="nama_customer" name="nama_customer" value="{{ $transaksi->nama_customer }}">
        </div>
        <div class="mb-3">
          <label for="tanggal_mulai_sewa" class="form-label">Tanggal Mulai Sewa</label>
          <input type="date" class="form-control" id="tanggal_mulai_sewa" name="tanggal_mulai_sewa" value="{{ $transaksi->tanggal_mulai_sewa }}">
        </div>
        <div class="mb-3">
          <label for="tanggal_selesai_sewa" class="form-label">Tanggal Selesai Sewa</label>
          <input type="date" class="form-control" id="tanggal_selesai_sewa" name="tanggal_selesai_sewa" value="{{ $transaksi->tanggal_selesai_sewa }}">
        </div>
        <div class="mb-3">
          <label for="harga_sewa" class="form-label">Harga Sewa</label>
          <input type="text" class="form-control" id="harga_sewa" name="harga_sewa" value="{{ $transaksi->harga_sewa }}">
        </div>
        <div class="mb-3">
          <label for="id_kendaraan" class="form-label">Kendaraan</label>
          <select class="form-select" name="id_kendaraan">
            <option selected value="">Pilih Kendaraan</option>
            @foreach ($kendaraan as $k)
              <option value="{{ $k->id }}" @selected($transaksi->id_kendaraan == $k->id)>{{ $k->plat_nomor }}</option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Edit transaksi</button>
      </form>
    </card>
  </div>

  @push('script')
  <script>
    $(document).ready(function() {
      $('#editTransaksi').submit(function(e) { // Edit transaksi
        e.preventDefault()

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          url: $(this).attr('action'),
          type: $(this).attr('method'),
          data: new FormData(this),
          processData: false,
          contentType: false,
          success: function(res) {
            if (res.success) {
              Swal.fire({
                title: res.message,
                icon: "success",
                toast: true,
                position: 'top',
                showConfirmButton: false
              });

              $(this).trigger("reset")
            } else if(!res.success) {
              Swal.fire({
                title: res.message,
                icon: "error",
                toast: true,
                position: 'top',
                showConfirmButton: false
              });
            }
          },
          error: function(err) {
            console.log(err)
          }
        })
      })
    })
  </script>
  @endpush
@endsection