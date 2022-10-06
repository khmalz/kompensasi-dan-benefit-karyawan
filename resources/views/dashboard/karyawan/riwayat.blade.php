@extends('dashboard.layouts.main')

@section('isi')

@foreach (auth()->user()->readnotifications as $notification)
<div class="row g-0 mb-4">
   <div class="alert alert-success d-flex align-items-center justify-content-between" role="alert">
      <div>
         @if ($notification->data['status'] == 'sedang')
         <span>Tunjangan dengan kode <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-dark">{{ $notification->data['kode'] }}</a> sedang dalam proses</span>
         @else
         <span>Tunjangan dengan kode <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-dark">{{ $notification->data['kode'] }}</a> sudah selesai diproses</span>
         @endif
         <span class="text-secondary d-block">{{ $notification->created_at->isoFormat('D MMMM, Y') }} pada {{ $notification->created_at->format('H:i') }} | {{ $notification->created_at->diffForHumans() }}</span>
      </div>
      <a class="text-success" href="/dibaca/{{ $notification->id }}">Tandai Dibaca</a>
    </div>
</div>
@endforeach
{{-- @if (!empty(auth()->user()->notifications))
@endif --}}

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
                        <td>{{ $tunjangan->created_at->isoFormat('D MMM Y') }}</td>
                        <td >{{ $tunjangan->kode }}</td>
                        <td class="text-capitalize">Tunjangan {{ $tunjangan->jenis_tunjangan }}</td>
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
                        <td>{{ $tunjangan->created_at->isoFormat('D MMM Y') }}</td>
                        <td >{{ $tunjangan->kode }}</td>
                        <td class="text-capitalize">Tunjangan {{ $tunjangan->jenis_tunjangan }}</td>
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
                        <td>{{ $tunjangan->created_at->isoFormat('D MMM Y') }}</td>
                        <td >{{ $tunjangan->kode }}</td>
                        <td class="text-capitalize">Tunjangan {{ $tunjangan->jenis_tunjangan }}</td>
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
      <div class="card border-0">
         <div class="row ms-0 ms-md-2 justify-content-center mt-3">
            <div class="col text-center py-4">
               <h1 class="display-2 fw-semibold">404</h1>
               <p class="fs-5">Permintaan Tunjangan <span class="text-danger">Belum Tersedia</span></p>
            </div>
         </div>
      </div>
   </div>
</div>
    
@endif


@endsection
