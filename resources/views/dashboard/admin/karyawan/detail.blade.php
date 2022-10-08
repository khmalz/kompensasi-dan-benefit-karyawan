@extends('dashboard.layouts.main')

@section('isi')
   <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
      <h1 class="h2">Informasi Personal</h1>
   </div>

   <div class="card mb-3 border-0">
      <div class="row ms-0 ms-md-2 align-items-center justify-content-center">
         <div class="col-5 col-xl-2">
            <img src="{{ asset('images/Anon Bussines.png') }}" class="img-fluid rounded-pill mb-2" alt="Bussines Man" />
            <p class="text-center fw-bold">{{ $karyawan->nama }}</p>
         </div>
         <div class="col-xl-10 col-12 mt-2 mt-lg-0">
            <div class="d-xl-flex ms-5">
               <div class="w-100">
                  <div class="d-flex">
                     <div class="col fs-6 fw-semibold">NIK</div>
                     <div class="col fs-6 fw-semibold">: {{ $karyawan->nik }}</div>
                  </div>
                  <div class="d-flex">
                     <div class="col fs-6 fw-semibold">Lokasi</div>
                     <div class="col fs-6 fw-semibold">: {{ $karyawan->lokasi }}</div>
                  </div>
                  <div class="d-flex">
                     <div class="col fs-6 fw-semibold">Tanggal Masuk</div>
                     <div class="col fs-6 fw-semibold">: {{ $karyawan->tanggal_masuk }}</div>
                  </div>
                  <div class="d-flex">
                     <div class="col fs-6 fw-semibold">Status</div>
                     <div class="col fs-6 fw-semibold text-capitalize">: {{ $karyawan->status }}</div>
                  </div>
               </div>
               <div class="w-100">
                  <div class="d-flex">
                     <div class="col fs-6 fw-semibold">Tunjangan Kesehatan</div>
                     <div class="col fs-6 fw-semibold">: {{ number_format($karyawan->tunjangan_kesehatan, 0, '', '.') }}</div>
                  </div>
                  <div class="d-flex">
                     <div class="col fs-6 fw-semibold">Tunjangan Pernikahan</div>
                     <div class="col fs-6 fw-semibold">: {{ number_format($karyawan->tunjangan_pernikahan, 0, '', '.') }}</div>
                  </div>
                  <div class="d-flex">
                     <div class="col fs-6 fw-semibold">Tunjangan Bencana</div>
                     <div class="col fs-6 fw-semibold">: {{ number_format($karyawan->tunjangan_bencana, 0, '', '.') }}</div>
                  </div>
                  <div class="d-flex">
                     <div class="col fs-6 fw-semibold">Tunjangan Kematian</div>
                     <div class="col fs-6 fw-semibold">: {{ number_format($karyawan->tunjangan_kematian, 0, '', '.') }}</div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      <div class="row ms-0 ms-md-2 mb-3 mt-3 mt-x;-0">
         <div class="col-xl-2 text-center">
            <a href="/tunjangan?cari={{ $karyawan->nama }}" class="btn btn-primary btn-sm">Riwayat Tunjangan</a>
         </div>
      </div>
   </div>
@endsection