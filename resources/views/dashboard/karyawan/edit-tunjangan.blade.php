@extends('dashboard.layouts.main')

@section('isi')

<div class="row">
   <div class="col">
      <div class="card mb-3 border-0 rounded-4 shadow-sm">
         <div class="row mx-auto my-3">
            <h3>Tunjangan</h3>
         </div>
         <div class="row mx-auto px-5 w-100 py-5">
            <form action="{{ route('tunjangan.update', $tunjangan->kode) }}" method="post"  enctype="multipart/form-data">
               @csrf
               @method('put')
               <input type="hidden" class="form-control" name="kode" value="{{ $tunjangan->kode }}" id="floatingInput" placeholder="nik.com" />
               <input type="hidden" class="form-control" id="karyawan_nik" name="karyawan_nik" value="{{ $tunjangan->karyawan->nik }}" id="floatingInput" placeholder="nik.com" />
               <input type="hidden" class="form-control" name="status" value="belum" id="floatingInput" placeholder="belum" />
               <div class="form-floating mb-3">
                  <select class="form-select @error('jenis_tunjangan') is-invalid @enderror" name="jenis_tunjangan" id="jenis_tunjangan" aria-label="Floating label select example" required>
                     <option selected disabled>Pilih Jenis Tunjangan</option>
                     <option {{ old('jenis_tunjangan', $tunjangan->jenis_tunjangan) == 'tunjangan_kesehatan' ? 'selected' : '' }} value="tunjangan_kesehatan">Kesehatan</option>
                     <option {{ old('jenis_tunjangan', $tunjangan->jenis_tunjangan) == 'tunjangan_pernikahan' ? 'selected' : '' }} value="tunjangan_pernikahan">Pernikahan</option>
                     <option {{ old('jenis_tunjangan', $tunjangan->jenis_tunjangan) == 'tunjangan_bencana' ? 'selected' : '' }} value="tunjangan_bencana">Bencana</option>
                     <option {{ old('jenis_tunjangan', $tunjangan->jenis_tunjangan) == 'tunjangan_kematian' ? 'selected' : '' }} value="tunjangan_kematian">Kematian</option>
                  </select>
                  <label for="jenis_tunjangan">Jenis Tunjangan</label>
                  @error('jenis_tunjangan')
                  <div class="invalid-feedback mt-2">
                     {{ $message }}
                  </div>
                  @enderror
               </div>
               <div class="form-floating mb-3">
                  <input required type="number" onkeyup="$('#peringatanAwal').addClass('d-none')" value="{{ old('besar_tunjangan', $tunjangan->besar_tunjangan) }}" class="form-control {{ $sisaTunjangan < $tunjangan->besar_tunjangan ? 'is-invalid' : ''}} @error('besar_tunjangan') is-invalid @enderror" name="besar_tunjangan" id="besar_tunjangan" placeholder="name@example.com"/>
                  <label for="floatingInput">Besar Tunjangan</label>
                  @error('besar_tunjangan')
                  <div class="invalid-feedback mt-2">
                     {{ $message }}
                  </div>
                  @enderror
               </div>

               @if ($sisaTunjangan < $tunjangan->besar_tunjangan)
               <div class="my-2 mb-3 text-danger {{ old('besar_tunjangan') ?  'd-none' : ''}}" id="peringatanAwal">Permintaanmu Melebihi Tunjangan yang Tersedia</div>
               @endif
               <div class="my-2 mb-3" id="wadah"></div>
               <div class="my-2 mb-3" id="peringatan"></div>

               <div class="form-floating mb-3">
                  <textarea required class="form-control h-25 @error('pesan') is-invalid @enderror" name="pesan" placeholder="Leave a comment here" id="floatingTextarea">{{ old('pesan', $tunjangan->pesan) }}</textarea>
                  <label for="floatingTextarea">Pesan</label>
                  @error('pesan')
                  <div class="invalid-feedback mt-2">
                     {{ $message }}
                  </div>
                  @enderror
               </div>
               <div class="mb-3">
                  <img class="img-preview img-fluid rounded mb-3 col-md-8 col-lg-5" src="{{ asset("images/$tunjangan->bukti") }}">
                  <input class="form-control @error('bukti') is-invalid @enderror" name="bukti" type="file" id="bukti" onchange="previewImage()">
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

<script>
   function previewImage () { 
      const image = document.querySelector("#bukti")
      const imgPreview = document.querySelector(".img-preview")

      const blob = URL.createObjectURL(image.files[0])
      imgPreview.src = blob 
   }

   $(document).ready(function() {
      let data = ""
      data = $("#jenis_tunjangan").val()

      tampilkanSisaTunjangan(data);
      
      $("#jenis_tunjangan").on('change', function() {
         data = $(this).val()
         tampilkanSisaTunjangan(data);
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
