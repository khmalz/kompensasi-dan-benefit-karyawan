@extends('dashboard.layouts.main')

@section('isi')

@if (session()->has('added'))
   <div class="row g-0 pb-2">
      <div class="alert alert-success" role="alert">
         {{ session('added') }}
      </div>
   </div>
@endif

@if (session()->has('gagal'))
   <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>{{ session('gagal') }}</strong>, Harap Ulangi Dengan Benar
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
@endif

@if (session()->has('berhasil'))
   <div class="alert alert-success" id="password_berhasil" role="alert">
      {{ session('berhasil') }}
   </div>
@endif

@if (Hash::check('password', auth()->user()->password))
<div class="row">
   <div class="col">
      <div class="card mb-3 border-0 rounded-4 shadow-sm">
         <div class="row mx-auto my-4">
            <h3>Ganti Password</h3>
         </div>
         <div class="row mx-auto px-5 w-100 py-4">
            <form action="{{ route('ganti-password') }}" method="post">
               @csrf
               @method('PATCH')
               <div class="form-floating @error('old_password') is-invalid @enderror">
                  <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" id="floatingInput" placeholder="password" required/>
                  <label for="floatingInput">Password Lama</label>
               </div>
               @error('old_password')
               <div class="invalid-feedback mt-2">
                  {{ $message }}
               </div>
               @enderror
               <div class="form-floating mt-3 @error('password') is-invalid @enderror">
                  <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="floatingInput" placeholder="password" required/>
                  <label for="floatingInput">Password</label>
               </div>
               @error('password')
               <div class="invalid-feedback mt-2">
                  {{ $message }}
               </div>
               @enderror
               <div class="form-floating mt-3">
                  <input type="password" class="form-control" name="password_confirmation" id="floatingInput" placeholder="password" required/>
                  <label for="floatingInput">Konfirmasi Password</label>
               </div>
               <button type="submit" class="btn btn-success mt-3">Kirim</button>
            </form>
         </div>
      </div>
   </div>
</div>
@else
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
                  <input type="hidden" class="form-control" id="karyawan_nik" name="karyawan_nik" value="{{ auth()->user()->karyawan->nik }}" id="floatingInput" placeholder="nik.com" />
                  <input type="hidden" class="form-control" name="status" value="belum" id="floatingInput" placeholder="belum" />
                  <div class="form-floating mb-3">
                     <select class="form-select @error('jenis_tunjangan') is-invalid @enderror" name="jenis_tunjangan" id="jenis_tunjangan" aria-label="Floating label select example" required>
                        <option selected disabled>Pilih Jenis Tunjangan</option>
                        <option {{ old('jenis_tunjangan') == 'tunjangan_kesehatan' ? 'selected' : '' }} value="tunjangan_kesehatan">Kesehatan</option>
                        <option {{ old('jenis_tunjangan') == 'tunjangan_pernikahan' ? 'selected' : '' }} value="tunjangan_pernikahan">Pernikahan</option>
                        <option {{ old('jenis_tunjangan') == 'tunjangan_bencana' ? 'selected' : '' }} value="tunjangan_bencana">Bencana</option>
                        <option {{ old('jenis_tunjangan') == 'tunjangan_kematian' ? 'selected' : '' }} value="tunjangan_kematian">Kematian</option>
                     </select>
                     <label for="jenis_tunjangan">Jenis Tunjangan</label>
                     @error('jenis_tunjangan')
                     <div class="invalid-feedback mt-2">
                        {{ $message }}
                     </div>
                     @enderror
                  </div>
                  <div class="form-floating mb-3">
                     <input required type="number" value="{{ old('besar_tunjangan') }}" class="form-control @error('besar_tunjangan') is-invalid @enderror" name="besar_tunjangan" id="besar_tunjangan" placeholder="name@example.com"/>
                     <label for="floatingInput">Besar Tunjangan</label>
                     @error('besar_tunjangan')
                     <div class="invalid-feedback mt-2">
                        {{ $message }}
                     </div>
                     @enderror
                  </div>

                  <div class="my-2 mb-3" id="wadah"></div>
                  <div class="my-2 mb-3" id="peringatan"></div>

                  <div class="form-floating mb-3">
                     <textarea required class="form-control h-25 @error('pesan') is-invalid @enderror" name="pesan" placeholder="Leave a comment here" id="floatingTextarea">{{ old('pesan') }}</textarea>
                     <label for="floatingTextarea">Pesan</label>
                     @error('pesan')
                     <div class="invalid-feedback mt-2">
                        {{ $message }}
                     </div>
                     @enderror
                  </div>
                  <div class="mb-3">
                     <img class="img-preview img-fluid d-none rounded col-md-8 col-lg-5">
                     <input required class="form-control @error('bukti') is-invalid @enderror" name="bukti" type="file" id="bukti" onchange="previewImage()">
                     @error('bukti')
                     <div class="invalid-feedback mt-2">
                        {{ $message }}
                     </div>
                     @enderror
                  </div>
                  <button type="submit" class="btn btn-success mt-2" id="kirim_tunjangan">Kirim</button>
               </form>
            </div>
         </div>
      </div>
   </div>
@endif

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

   if ( $("#password_berhasil").length) {
      setTimeout(() => {
         $("#password_berhasil").attr('hidden', true);
      }, 3000);
   }

   $(document).ready(function() {
      let data = ""
      $("#jenis_tunjangan").on('change', function () {
         data = $(this).val()
         tampilkanSisaTunjangan(data)
      })
   })

   function tampilkanSisaTunjangan(jenis) {
      $.ajax({
         type: "GET",
         url: "/karyawan/" + $("#karyawan_nik").val(),
         dataType: "json",
         success: function (res) {
            $("#wadah, #peringatan").html("")
            $("#besar_tunjangan, #kirim_tunjangan").removeAttr('disabled')
            var isi = 'Sisa Tunjangan Kamu <span class="text-primary" id="pemberitahuan"></span>'
            $("#wadah").html(isi)
            $("#pemberitahuan").html("")
            $("#pemberitahuan").text("Rp. " + convertRupiah(res[jenis]))
            if (res[jenis] <= 0) {
               var info = 'Jatah Tunjangan Kamu <span class="text-danger">Sudah Habis, Tidak Bisa Pilih Tunjangan Tersebut</span>'
               $("#peringatan").html(info)
               $("#besar_tunjangan").attr('disabled', 'true')
               $("#kirim_tunjangan").attr('disabled', 'true')
            }
         },
         error: function (err) {
            console.log(err);
         },
      });
   }

</script>

@endsection
