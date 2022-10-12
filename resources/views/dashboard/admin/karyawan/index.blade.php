@extends('dashboard.layouts.main')

@section('isi')
<div class="d-md-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
   <a href="{{ route('dashboardAdmin.create') }}" class="btn btn-success order-last"><small>Tambah Data</small></a>
   <form class="d-flex col-md-5 mt-md-0 mt-3" role="search" method="get">
      <input class="form-control form-control-sm me-2" type="search" name="cari" value="{{ request()->cari ?? "" }}" placeholder="Ketikkan Nama" aria-label="Pencarian">
      <button id="submit" class="btn btn-outline-success btn-sm w-25" disabled type="submit">Cari</button>
      <a href="/dashboardAdmin" class="btn btn-outline-danger btn-sm w-25 ms-2 {{ request()->cari ? "" : "disabled"}}">Reset</a>
      </form>
</div>

@if (session()->has('added'))
   <div class="row g-0 pb-2">
      <div class="alert alert-success" role="alert">
         {{ session('added') }}
      </div>
   </div>
@endif

@if (session()->has('updated'))
   <div class="row g-0 pb-2">
      <div class="alert alert-success" role="alert">
         {{ session('updated') }}
      </div>
   </div>
@endif

@if (session()->has('deleted'))
   <div class="row g-0 pb-2">
      <div class="alert alert-primary" role="alert">
         {{ session('deleted') }}
      </div>
   </div>
@endif

@if ($karyawans->isNotEmpty())
<div class="row">
   <div class="col">
      <div class="card mb-3 border-0 p-2 table-responsive-lg rounded-3 shadow-sm">
         <table class="table table-striped text-center">
            <thead>
               <tr>
                  <th scope="col">No</th>
                  <th scope="col">Nama</th>
                  <th scope="col">NIK</th>
                  <th scope="col">Status</th>
                  <th scope="col">Tunjangan Kesehatan</th>
                  <th scope="col">Tunjangan Pernikahan</th>
                  <th scope="col">Tunjangan Bencana</th>
                  <th scope="col">Tunjangan Kematian</th>
                  <th scope="col">Aksi</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($karyawans as $karyawan)
               <tr>
                  <th>{{ $loop->iteration }}</th>
                  <td>{{ $karyawan->nama }}</td>
                  <td>{{ $karyawan->nik }}</td>
                  <td class="text-capitalize">{{ $karyawan->status }}</td>
                  <td>{{ number_format($karyawan->tunjangan_kesehatan, 0, '', '.') }}</td>
                  <td>{{ number_format($karyawan->tunjangan_pernikahan, 0, '', '.') }}</td>
                  <td>{{ number_format($karyawan->tunjangan_bencana, 0, '', '.') }}</td>
                  <td>{{ number_format($karyawan->tunjangan_kematian, 0, '', '.') }}</td>
                  <td class="d-flex gap-1">
                  <a href="/dashboardAdmin/{{ $karyawan->nik }}" class="badge text-bg-primary border-0"><span data-feather="file-text"></span></a>
                  {{-- <a href="{{ route('dashboardAdmin.destroy', $karyawan->nik) }}" class="badge text-bg-danger border-0"><span data-feather="trash"></span></a> --}}
                  <form action="/dashboardAdmin/{{ $karyawan->user_id }}" method="post" class="d-inline">
                     @method('delete')
                     @csrf
                     <button onclick="return confirm('Apakah Yakin?')" type="submit" class="badge text-bg-danger border-0"><span data-feather="trash"></span></button>
                  </form>
                  <a href="/dashboardAdmin/{{ $karyawan->nik }}/edit" class="badge text-bg-info text-light border-0"><span data-feather="edit"></span></a>
                  </td>
               </tr>
               @endforeach
            </tbody>
            </table>
      </div>
   </div>
</div>

@else

<div class="row justify-content-center mt-5 pt-5">
   <div class="col-md-7">
      <div class="card border-0 shadow-sm rounded-3">
         <div class="row ms-0 ms-md-2 justify-content-center mt-3">
            <div class="col text-center py-4">
               <h1 class="display-2 fw-semibold">404</h1>
               <p class="fs-5">Data Karyawan <span class="text-danger">Tidak Ditemukan</span></p>
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