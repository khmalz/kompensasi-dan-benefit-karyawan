@extends('dashboard.layouts.main')

@section('isi')

<div class="d-md-flex justify-content-between align-items-center flex-wrap flex-md-nowrap pb-2 mb-4">
   <form class="d-flex col-md-7 col-lg-5 pb-2 mb-2 mb-md-0" role="search" method="get">
      <input id="tanggal" class="form-control form-control-sm me-2" type="date" name="tanggal" value="{{ request()->tanggal ?? "" }}" placeholder="Masukkan Tanggal" aria-label="Pencarian">
      <button id="submit" class="btn btn-outline-success btn-sm w-25" disabled type="submit">Cari</button>
      <a href="/riwayat-tunjangan" class="btn btn-outline-danger btn-sm w-25 ms-2 {{ request()->tanggal ? "" : "disabled"}}">Reset</a>
   </form>
   @can('karyawan')
   <a href="/riwayat-tunjangan?{{ request()->cari || request()->tanggal ? "cari=" . request()->cari . "&tanggal=" . request()->tanggal : "" }}" class="btn btn-info text-light btn-sm">Proses</a>
   @endcan
</div>

@if ($tunjangans->isNotEmpty())

<div class="row">
   <div class="col">
      @if ($tunjangans->where('status', 'tolak')->isNotEmpty())
          
      <div class="card mb-4 border-0 rounded-4 shadow-sm">
         <div class="container">
            <div class="row mx-1 my-3 mb-2">
               <h5>Permintaan Ditolak</h5>
            </div>
            <div class="row mx-2 table-responsive-md">
               <table class="table text-center">
                  <thead>
                    <tr>
                      <th scope="col">Tanggal</th>
                      <th scope="col">Kode</th>
                      <th scope="col">Jenis Tunjangan</th>
                      <th scope="col">Besar Tunjangan</th>
                      <th scope="col">Status</th>
                      <th scope="col">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach ($tunjangans->where('status', 'tolak') as $tunjangan)
                     <tr>
                        <td>{{ $tunjangan->created_at->isoFormat('D MMM Y') }}</td>
                        <td >{{ $tunjangan->kode }}</td>
                        <td class="text-capitalize">{{ str_replace("_", " ", $tunjangan->jenis_tunjangan) }}</td>
                        <td>{{ number_format($tunjangan->besar_tunjangan, 0, '', '.') }}</td>
                        <td class="text-capitalize"><span class="badge text-bg-danger text-danger" style="--bs-bg-opacity: .3;">{{ $tunjangan->status }}</span></td>
                        <td><a href="/tunjangan/{{ $tunjangan->kode }}" class="badge text-bg-primary border-0"><span data-feather="file-text"></span></a></td>
                     </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
         </div>
      </div>
      @endif
   </div>
</div>
@else

   <div class="row justify-content-center mt-5 pt-5">
      <div class="col-md-7">
         <div class="card border-0 shadow-sm rounded-3">
            <div class="row ms-0 ms-md-2 justify-content-center mt-3">
               <div class="col text-center py-4">
                  <h1 class="display-2 fw-semibold">404</h1>
                  <p class="fs-5">Permintaan Tunjangan <span class="text-danger">Tidak Ditemukan</span></p>
               </div>
            </div>
         </div>
      </div>
   </div>
    
@endif

<script>
   $(document).on('change', function() {
      $("#submit").removeAttr('disabled');
   })
</script>
@endsection
