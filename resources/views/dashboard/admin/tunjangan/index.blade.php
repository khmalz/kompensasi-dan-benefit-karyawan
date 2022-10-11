@extends('dashboard.layouts.main')

@section('isi')
<div class="d-md-flex justify-content-between align-items-center flex-wrap flex-md-nowrap pb-2 mb-3">
   <form class="d-flex col-md-7" role="search" method="get">
      <input id="cari" class="form-control form-control-sm me-2" type="search" name="cari" value="{{ request()->cari ?? "" }}" placeholder="Ketikkan Nama" aria-label="Pencarian">
      <input id="tanggal" class="form-control form-control-sm me-2" type="date" name="tanggal" value="{{ request()->tanggal ?? "" }}" placeholder="Masukkan Tanggal" aria-label="Pencarian">
      <button id="submit" class="btn btn-outline-success btn-sm w-25" disabled type="submit">Cari</button>
      <a href="/tunjangan" class="btn btn-outline-danger btn-sm w-25 ms-2 {{ request()->cari || request()->tanggal ? "" : "disabled"}}">Reset</a>
    </form>
   <a href="/tunjangan/sudah?{{ request()->cari || request()->tanggal ? "cari=" . request()->cari . "&tanggal=" . request()->tanggal : "" }}" class="btn btn-info text-light btn-sm mt-md-0 mt-3">Sudah Diproses</a>
</div>

@if (session()->has('success'))
   <div class="row g-0">
      <div class="alert alert-success" role="alert">
         {{ session('success') }}
      </div>
   </div>
@endif

@if (session()->has('tolak'))
   <div class="row g-0">
      <div class="alert alert-warning" role="alert">
         {{ session('tolak') }}
      </div>
   </div>
@endif

@if ($tunjangans->isNotEmpty())

   @if ($tunjangans->where('status', 'belum')->isNotEmpty())
   <div class="row">
      <div class="col">
         <div class="card mb-4 border-0 rounded-4 shadow-sm">
            <div class="container">
               <div class="row mx-1 my-3 mb-2">
                  <h5>Belum Diproses</h5>
               </div>
               <div class="row mx-2 table-responsive-lg">
                  <table class="table text-center">
                     <thead>
                       <tr>
                         <th scope="col">No</th>
                         <th scope="col">Nama</th>
                         <th scope="col">Tanggal</th>
                         <th scope="col">Kode</th>
                         <th scope="col">Jenis Tunjangan</th>
                         <th scope="col">Besar Tunjangan</th>
                         <th scope="col">Status</th>
                         <th scope="col">Aksi</th>
                       </tr>
                     </thead>
                     <tbody>
                        @foreach ($tunjangans->where('status', 'belum') as $tunjangan)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $tunjangan->karyawan->nama }}</td>
                           <td>{{ $tunjangan->created_at->isoFormat('D MMM Y') }}</td>
                           <td >{{ $tunjangan->kode }}</td>
                           <td class="text-capitalize">{{ str_replace("_", " ", $tunjangan->jenis_tunjangan) }}</td>
                           <td class="{{ ($tunjangan->karyawan[$tunjangan->jenis_tunjangan] < $tunjangan->besar_tunjangan) ? 'text-danger' : '' }}">{{ number_format($tunjangan->besar_tunjangan, 0, '', '.') }}</td>
                        @if ($tunjangan->status == 'sudah')
                           <td class="text-capitalize"><span class="badge text-bg-primary text-primary" style="--bs-bg-opacity: .3;">{{ $tunjangan->status }}</span></td>
                        @elseif($tunjangan->status == 'sedang')
                           <td class="text-capitalize"><span class="badge text-bg-warning text-warning" style="--bs-bg-opacity: .2;">{{ $tunjangan->status }}</span></td>
                        @else
                           <td class="text-capitalize"><span class="badge text-bg-danger text-danger" style="--bs-bg-opacity: .3;">{{ $tunjangan->status }}</span></td>
                        @endif
                           <td><a href="/tunjangan/{{ $tunjangan->kode }}" class="badge text-bg-primary border-0"><span data-feather="file-text"></span></a></td>
                        </tr>
                       @endforeach
                     </tbody>
                   </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   @endif

   @if ($tunjangans->where('status', 'sedang')->isNotEmpty())
   <div class="row">
      <div class="col">
         <div class="card mb-4 border-0 rounded-4 shadow-sm">
            <div class="container">
               <div class="row mx-1 my-3 mb-2">
                  <h5>Sedang Diproses</h5>
               </div>
               <div class="row mx-2 table-responsive-lg">
                  <table class="table text-center">
                     <thead>
                       <tr>
                         <th scope="col">No</th>
                         <th scope="col">Nama</th>
                         <th scope="col">Tanggal</th>
                         <th scope="col">Kode</th>
                         <th scope="col">Jenis Tunjangan</th>
                         <th scope="col">Besar Tunjangan</th>
                         <th scope="col">Status</th>
                         <th scope="col">Aksi</th>
                       </tr>
                     </thead>
                     <tbody>
                        @foreach ($tunjangans->where('status', 'sedang') as $tunjangan)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ $tunjangan->karyawan->nama }}</td>
                           <td>{{ $tunjangan->created_at->isoFormat('D MMM Y') }}</td>
                           <td >{{ $tunjangan->kode }}</td>
                           <td class="text-capitalize">{{ str_replace("_", " ", $tunjangan->jenis_tunjangan) }}</td>
                           <td>{{ number_format($tunjangan->besar_tunjangan, 0, '', '.') }}</td>
                        @if ($tunjangan->status == 'sudah')
                           <td class="text-capitalize"><span class="badge text-bg-primary text-primary" style="--bs-bg-opacity: .3;">{{ $tunjangan->status }}</span></td>
                        @elseif($tunjangan->status == 'sedang')
                           <td class="text-capitalize"><span class="badge text-bg-warning text-warning" style="--bs-bg-opacity: .2;">{{ $tunjangan->status }}</span></td>
                        @else
                           <td class="text-capitalize"><span class="badge text-bg-danger text-danger" style="--bs-bg-opacity: .3;">{{ $tunjangan->status }}</span></td>
                        @endif
                           <td><a href="/tunjangan/{{ $tunjangan->kode }}" class="badge text-bg-primary border-0"><span data-feather="file-text"></span></a></td>
                        </tr>
                       @endforeach
                     </tbody>
                   </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   @endif
   
@else
   <div class="row justify-content-center mt-5 pt-5">
      <div class="col-md-7">
         <div class="card border-0 shadow-sm rounded-3">
            <div class="row ms-0 ms-md-2 justify-content-center mt-3">
               <div class="col text-center py-4">
                  <h1 class="display-2 fw-semibold">404</h1>
                  <p class="fs-5">Permintaan Tunjangan <span class="text-danger">Tidak Ditemukan</span></p>
                  @if (request('cari'))
                  <p class="fs-6">Mungkin Tunjangan Sudah Diproses &raquo;  <a href="/tunjangan/sudah?{{ request()->cari || request()->tanggal ? "cari=" . request()->cari . "&tanggal=" . request()->tanggal : "" }}" class="text-dark">Klik Untuk Melihat</a></p>
                  @endif
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