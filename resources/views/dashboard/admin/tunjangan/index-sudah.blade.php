@extends('dashboard.layouts.main')

@section('isi')
<div class="d-flex justify-content-end flex-wrap flex-md-nowrap pb-2 mb-3">
   <a href="{{ route('tunjangan.index') }}" class="btn btn-info text-light btn-sm">Belum / Sedang Diproses</a>
</div>

@if ($tunjangans->where('status', 'sudah')->isNotEmpty())
<div class="row">
   <div class="col">
      <div class="card mb-3 border-0 rounded-4 shadow-sm">
         <div class="container">
            <div class="row mx-1 my-3">
               <h4>Sudah Diproses</h4>
            </div>
            <div class="row mx-2 table-responsive-md">
               <table class="table text-center">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Date</th>
                      <th scope="col">Kode</th>
                      <th scope="col">Jenis Tunjangan</th>
                      <th scope="col">Besar Tunjangan</th>
                      <th scope="col">Status</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach ($tunjangans->where('status', 'sudah') as $tunjangan)
                     <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tunjangan->created_at->isoFormat('D MMM Y') }}</td>
                        <td >{{ $tunjangan->kode }}</td>
                        <td class="text-capitalize">Tunjangan {{ $tunjangan->jenis_tunjangan }}</td>
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
@else
   <div class="row justify-content-center mt-5 pt-5">
      <div class="col-md-7">
         <div class="card border-0">
            <div class="row ms-0 ms-md-2 justify-content-center mt-3">
               <div class="col text-center py-4">
                  <h1 class="display-2 fw-semibold">404</h1>
                  <p class="fs-5">Tunjangan <span class="text-danger">Belum Tersedia</span></p>
               </div>
            </div>
         </div>
      </div>
   </div>
@endif

@endsection
