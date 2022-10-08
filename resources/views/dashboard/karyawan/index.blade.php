@extends('dashboard.layouts.main')

@section('isi')

@if (session()->has('added'))
      <div class="row g-0 pb-2">
         <div class="alert alert-success" role="alert">
            {{ session('added') }}
         </div>
      </div>
@endif

<div class="row">
   <div class="col">
      <div class="card mb-3 border-0 rounded-4 shadow-sm">
         <div class="row mx-auto my-3">
            <h3>Tunjangan</h3>
         </div>
         <div class="row mx-auto px-5 w-100 py-5">
            <form action="{{ route('dashboardKaryawan.store') }}" method="post"  enctype="multipart/form-data">
               @csrf
               <input type="hidden" class="form-control" name="kode" value="" id="floatingInput" placeholder="nik.com" />
               <input type="hidden" class="form-control" name="karyawan_nik" value="{{ auth()->user()->karyawan->nik }}" id="floatingInput" placeholder="nik.com" />
               <input type="hidden" class="form-control" name="status" value="belum" id="floatingInput" placeholder="belum" />
               <div class="form-floating mb-3">
                  <select class="form-select" name="jenis_tunjangan" id="floatingSelect" aria-label="Floating label select example">
                    <option value="tunjangan_kesehatan">Kesehatan</option>
                    <option value="tunjangan_pernikahan">Pernikahan</option>
                    <option value="tunjangan_bencana">Bencana</option>
                    <option value="tunjangan_kematian">Kematian</option>
                  </select>
                  <label for="floatingSelect">Jenis Tunjangan</label>
                </div>
               <div class="form-floating mb-3">
                  <input type="integer" class="form-control" name="besar_tunjangan" id="floatingInput" placeholder="name@example.com" />
                  <label for="floatingInput">Besar Tunjangan</label>
               </div>
               <div class="form-floating mb-3">
                  <textarea class="form-control h-25" name="pesan" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                  <label for="floatingTextarea">Pesan</label>
               </div>
               <div class="mb-3">
                  {{-- <small><label for="formFile" class="form-label">Bukti Foto</label></small> --}}
                  <img class="img-preview img-fluid d-none rounded col-sm-5">
                  <input class="form-control" name="bukti" type="file" id="bukti" onchange="previewImage()">
               </div>
               <button type="submit" class="btn btn-success mt-3">Submit</button>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   function previewImage () { 
      const image = document.querySelector("#bukti")
      const imgPreview = document.querySelector(".img-preview")

      imgPreview.classList.remove("d-none");
      imgPreview.classList.add("d-block");
      imgPreview.classList.add("mb-3");

      const blob = URL.createObjectURL(image.files[0])
      imgPreview.src = blob 
   }
</script>

@endsection
