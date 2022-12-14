@extends('dashboard.layouts.main')

@section('isi')

<div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap pb-2 mb-3">
   <button type="button" class="btn btn-primary btn-sm rounded-4 d-flex gap-2 align-items-center" data-bs-toggle="modal" data-bs-target="#searchModal">
      <i class="bi bi-search"></i>
      Pencarian
   </button>
   
   <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title fs-5" id="searchModalLabel">Pencarian</h1>
         </div>
         <form method="get">
            <div class="modal-body d-flex flex-column gap-3">
               <input id="tanggal" class="form-control form-control-sm me-2" type="date" name="tanggal" value="{{ request()->tanggal ?? "" }}" placeholder="Masukkan Tanggal" aria-label="Pencarian">
               <select class="form-select" name="jenis" id="select-tunjangan" aria-label=".form-select-sm example">
                  <option value="" selected>Pilih Jenis Tunjangan | Semua</option>
                  <option {{ request()->jenis == "tunjangan_kesehatan" ? "selected" : "" }} value="tunjangan_kesehatan">Tunjangan Kesehatan</option>
                  <option {{ request()->jenis == "tunjangan_pernikahan" ? "selected" : "" }} value="tunjangan_pernikahan">Tunjangan Pernikahan</option>
                  <option {{ request()->jenis == "tunjangan_bencana" ? "selected" : "" }} value="tunjangan_bencana">Tunjangan Bencana</option>
                  <option {{ request()->jenis == "tunjangan_kematian" ? "selected" : "" }} value="tunjangan_kematian">Tunjangan Kematian</option>
               </select>
            </div>
            <div class="modal-footer justify-content-between">
               <a id="reset" href="/riwayat-tunjangan" class="btn btn-danger ms-2 {{ request()->cari || request()->tanggal || request()->jenis ? "" : "disabled"}}">Reset</a>
               <button id="submit" type="submit" class="btn btn-primary" disabled>Cari</button>
            </div>
         </form>
      </div>
      </div>
   </div>
   <a href="/riwayat-tunjangan/ditolak?{{ request()->cari || request()->tanggal || request()->jenis ? "cari=" . request()->cari . "&tanggal=" . request()->tanggal . "&jenis=" . request()->jenis : "" }}" class="btn btn-danger btn-sm">Di Tolak</a>
</div>

@if (session()->has('success'))
   <div class="row g-0 pb-2">
      <div class="alert alert-success" role="alert">
         {{ session('success') }}
      </div>
   </div>
@endif

@foreach (auth()->user()->unreadnotifications as $notification)
<div class="row g-0 mb-4">
   <div class="alert {{ $notification->data['status'] == 'sedang' || $notification->data['status'] == 'sudah' ? "alert-success" : "alert-danger" }} d-md-flex align-items-center justify-content-between" role="alert">
      <div>
         @if ($notification->data['status'] == 'sedang')
         <span>Permintaan Tunjangan dengan kode <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-dark">{{ $notification->data['kode'] }}</a> <strong>Sedang</strong> dalam proses</span>
         @elseif ($notification->data['status'] == 'sudah')
         <span>Permintaan Tunjangan dengan kode <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-dark">{{ $notification->data['kode'] }}</a> <strong>Sudah</strong> selesai diproses</span>
         @else
         <span>Permintaan Tunjangan dengan kode <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-danger">{{ $notification->data['kode'] }}</a> <strong>Ditolak</strong> oleh Admin</span>
         @endif
         <span class="{{ $notification->data['status'] == 'sedang' || $notification->data['status'] == 'sudah' ? "text-secondary" : "text-danger" }} d-block mb-1 mb-md-0">{{ $notification->created_at->translatedFormat('d F Y') }} pada {{ $notification->created_at->format('H:i') }} | {{ $notification->created_at->diffForHumans() }}</span>
      </div>
      <a class="{{ $notification->data['status'] == 'sedang' || $notification->data['status'] == 'sudah' ? "text-success" : "text-danger" }}" href="/dibaca/{{ $notification->id }}">Tandai Dibaca</a>
    </div>
</div>
@endforeach

@if ($tunjangans->isNotEmpty())

<div class="row">
   <div class="col">
      @if ($tunjangans->where('status', 'belum')->isNotEmpty())
          
      <div class="card mb-4 border-0 rounded-4 shadow-sm">
         <div class="container">
            <div class="row mx-1 my-3 mb-2">
               <h5>Belum Diproses</h5>
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
                     @foreach ($tunjangans->where('status', 'belum') as $tunjangan)
                     <tr>
                        <td>{{ $tunjangan->created_at->translatedFormat('d M Y') }}</td>
                        <td >{{ $tunjangan->kode }}</td>
                        <td class="text-capitalize">{{ str_replace("_", " ", $tunjangan->jenis_tunjangan) }}</td>
                        <td class="{{ ($tunjangan->karyawan[$tunjangan->jenis_tunjangan] < $tunjangan->besar_tunjangan) ? 'text-danger' : '' }}">{{ number_format($tunjangan->besar_tunjangan, 0, '', '.') }}</td>
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

      @if ($tunjangans->where('status', 'sedang')->isNotEmpty())

      <div class="card mb-4 border-0 rounded-4 shadow-sm">
         <div class="container">
            <div class="row mx-1 my-3 mb-2">
               <h5>Sedang Diproses</h5>
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
                     @foreach ($tunjangans->where('status', 'sedang') as $tunjangan)
                     <tr>
                        <td>{{ $tunjangan->created_at->translatedFormat('d M Y') }}</td>
                        <td >{{ $tunjangan->kode }}</td>
                        <td class="text-capitalize">{{ str_replace("_", " ", $tunjangan->jenis_tunjangan) }}</td>
                        <td>{{ number_format($tunjangan->besar_tunjangan, 0, '', '.') }}</td>
                        <td class="text-capitalize"><span class="badge text-bg-warning text-warning" style="--bs-bg-opacity: .2;">{{ $tunjangan->status }}</span></td>
                        <td><a href="/tunjangan/{{ $tunjangan->kode }}" class="badge text-bg-primary border-0"><span data-feather="file-text"></span></a></td>
                     </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
         </div>
      </div>

      @endif
      
      @if ($tunjangans->where('status', 'sudah')->isNotEmpty())

      <div class="card mb-4 border-0 rounded-4 shadow-sm">
         <div class="container">
            <div class="row mx-1 my-3 mb-2">
               <h5>Sudah Diproses</h5>
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
                     @foreach ($tunjangans->where('status', 'sudah') as $tunjangan)
                     <tr>
                        <td>{{ $tunjangan->created_at->translatedFormat('d M Y') }}</td>
                        <td >{{ $tunjangan->kode }}</td>
                        <td class="text-capitalize">{{ str_replace("_", " ", $tunjangan->jenis_tunjangan) }}</td>
                        <td>{{ number_format($tunjangan->besar_tunjangan, 0, '', '.') }}</td>
                        <td class="text-capitalize"><span class="badge text-bg-primary text-primary" style="--bs-bg-opacity: .3;">{{ $tunjangan->status }}</span></td>
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

   $(window).on('load resize', function() {
      var width = $(window).width();

      if(width <= 750) {
         $("#submit")[0].classList.add('btn-sm')
         $("#reset")[0].classList.add('btn-sm')
         $("#select-tunjangan")[0].classList.add('form-select-sm')
      } else if(width > 750) {
         $("#submit")[0].classList.remove('btn-sm')
         $("#reset")[0].classList.remove('btn-sm')
         $("#select-tunjangan")[0].classList.remove('form-select-sm')
      }
   })
</script>
@endsection
