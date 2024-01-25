@extends('layout')

@section('content')
  <div class="accordion mb-3" id="accordionExample">
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
          Tambah Transaksi
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <form action="{{ route('transaksi.store') }}" method="POST" id="tambahTransaksi">
            <div class="mb-3">
              <label for="nama_customer" class="form-label">Nama Customer</label>
              <input type="text" class="form-control" id="nama_customer" name="nama_customer">
            </div>
            <div class="mb-3">
              <label for="tanggal_mulai_sewa" class="form-label">Tanggal Mulai Sewa</label>
              <input type="date" class="form-control" id="tanggal_mulai_sewa" name="tanggal_mulai_sewa">
            </div>
            <div class="mb-3">
              <label for="tanggal_selesai_sewa" class="form-label">Tanggal Selesai Sewa</label>
              <input type="date" class="form-control" id="tanggal_selesai_sewa" name="tanggal_selesai_sewa">
            </div>
            <div class="mb-3">
              <label for="harga_sewa" class="form-label">Harga Sewa</label>
              <input type="text" class="form-control" id="harga_sewa" name="harga_sewa">
            </div>
            <div class="mb-3">
              <label for="id_kendaraan" class="form-label">Kendaraan</label>
              <select class="form-select" name="id_kendaraan">
                <option selected value="">Pilih Kendaraan</option>
                @foreach ($kendaraan as $k)
                  <option value="{{ $k->id }}">{{ $k->plat_nomor }}</option>
                @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah transaksi</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <table class="table" id="tableTransaksi">
        <thead>
          <tr>
            <th scope="col">Nama Customer</th>
            <th scope="col">Plat Kendaraan</th>
            <th scope="col">Tanggal Mulai Sewa</th>
            <th scope="col">Tanggal Selesai Sewa</th>
            <th scope="col">Tanggal Buat Order</th>
            <th scope="col">Tanggal Update Order</th>
            <th scope="col"></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  @push('script')
    <script>
      $(document).ready(function() {
        var tableTransaksi = new DataTable('#tableTransaksi', {
          ajax: "{{ route('transaksi.index') }}",
          processing: true,
          serverSide: true,
          columns: [
            { name: 'nama_customer', data: 'nama_customer', orderable: false },
            { name: 'plat', data: 'plat', orderable: false },
            { name: 'tanggal_mulai_sewa', data: 'tanggal_mulai_sewa' },
            { name: 'tanggal_selesai_sewa', data: 'tanggal_selesai_sewa' },
            { name: 'created_at', data: 'created_at' },
            { name: 'updated_at', data: 'updated_at' },
            { name: 'action', data: 'action' },
          ]
        })

        $('#tambahTransaksi').submit(function(e) { // Tambah transaksi baru
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

                tableTransaksi.draw()
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

        $(document).on('click', '.hapusTransaksi', function(e) {
          e.preventDefault()

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          Swal.fire({
            title: "Apakah kamu yakin?",
            text: "Ingin menghapus transaksi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, hapus!"
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: $(this).attr('href'),
                type: 'DELETE',
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
    
                    tableTransaksi.draw()
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
            }
          });
        })
      })
    </script>
  @endpush
@endsection