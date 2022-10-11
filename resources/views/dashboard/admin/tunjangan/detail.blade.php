@extends('dashboard.layouts.main') 
@section('isi')
<div class="d-md-flex justify-content-sm-between flex-wrap pb-2 mb-3">
   <h1 class="h4 detail-judul">Tunjangan Informasi <span class="fw-lighter">|</span> <span class="text-primary">#{{ $tunjangan->kode }}</span></h1>
   @can('admin')
      @if ($tunjangan->status == 'tolak' || $tunjangan->status == 'sudah')
      <form action="/tunjangan/pdf/{{ $tunjangan->kode }}" method="post">
         @csrf
         <a class="btn btn-info text-light btn-sm pdf-button" href="#">Ekspor Data ke PDF</a>
      </form>
      @else
      <div class="btn-group">
         <button type="button" class="btn btn-info btn-sm text-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Aksi</button>
         <ul class="dropdown-menu">
            <li>
               <form action="/tunjangan/pdf/{{ $tunjangan->kode }}" method="post">
                  @csrf
                  <a class="dropdown-item pdf-button" href="#">Ekspor Data ke PDF</a>
               </form>
            </li>
            <li><hr class="dropdown-divider" /></li>
            <li><a class="dropdown-item" href="#" role="button" data-bs-toggle="modal" data-bs-target="#tanggapan">Tanggapan</a></li>
         </ul>
      </div>

      <div class="modal fade" id="tanggapan" tabindex="-1" aria-labelledby="tanggapanLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
               <div class="modal-header justify-content-center">
                  <h1 class="modal-title fs-5" id="tanggapanLabel">Tanggapan</h1>
               </div>
               <form action="/tanggapan" method="post">
                  @csrf
                  <div class="modal-body">
                     <input type="hidden" name="kode" value="{{ $tunjangan->kode }}" />
                     <input type="hidden" name="id" value="{{ $tunjangan->karyawan->user_id }}" />
                     <input type="hidden" name="jenis_tunjangan" value="{{ $tunjangan->jenis_tunjangan  }}" />
                     <input type="hidden" name="besar_tunjangan" value="{{ $tunjangan->besar_tunjangan  }}" />
                     <div class="mb-3">
                        <label for="select" class="form-label">Status</label>
                        <select class="form-select" name="status" id="select" aria-label="Floating label select example" required>
                           <option value="tolak">Menolak Permintaan</option>
                           @if ($tunjangan->karyawan[$tunjangan->jenis_tunjangan] >= $tunjangan->besar_tunjangan)
                           <option value="sedang" selected>Sedang Diproses</option>
                           <option value="sudah">Sudah Diproses</option>
                           @endif
                        </select>
                     </div>
                     <div class="mb-3">
                        <label for="pesan" class="form-label">Pesan</label>
                        <textarea class="form-control" name="pesan" id="pesan" rows="2" required></textarea>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      @endif
   @else
   <div class="d-flex align-items-center gap-3">
      <form action="/tunjangan/pdf/{{ $tunjangan->kode }}" method="post">
         @csrf
         <a class="btn btn-info text-light btn-sm pdf-button" href="#">Ekspor Data ke PDF</a>
      </form>
         @if ($tunjangan->status == 'tolak')
         <form action="{{ route('tunjangan.destroy', $tunjangan->kode) }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <a href="#" id="hapusPermintaan" class="btn btn-danger btn-sm">Hapus Permintaan</a>
         </form>
         @elseif ($tunjangan->karyawan[$tunjangan->jenis_tunjangan] < $tunjangan->besar_tunjangan)
         <a href="{{ route('tunjangan.edit', $tunjangan->kode) }}" id="editPermintaan" class="btn btn-primary btn-sm">Edit Permintaan</a>
         @endif
   </div>
   @endcan
</div>


<div class="card mb-3 border-0 shadow-sm rounded-3">
   <div class="row ms-0 ms-md-2 align-items-center justify-content-center justify-content-md-between">
      <div class="col-6 col-md-2">
         <img src="{{ asset('images/Anon Bussines.png') }}" class="img-fluid rounded-pill mb-2" alt="Bussines Man" />
         <h4 class="text-center fw-bold mb-0">{{ $tunjangan->karyawan->nama }}</h4>
         <small>
            <p class="text-center text-secondary mb-1">{{ $tunjangan->karyawan->user->email }}</p>
         </small>
         <p class="text-center">{{ $tunjangan->karyawan->nik }}</p>
      </div>
      <div class="col-md-1 d-none d-md-flex">
         <div class="d-flex" style="height: 250px">
            <div class="vr"></div>
         </div>
      </div>
      <div class="col-md-9 ps-0 py-3">
         <ul class="list-group me-4 tunjangan-details">
            <li class="list-group-item border-0 border-bottom"><p class="h5">Tunjangan Details</p></li>
            <li class="list-group-item border-0 border-bottom">
               <div class="d-sm-flex justify-content-between">
                  <p class="m-0 mb-1 mb-md-0 fw-bold">Jenis Tunjangan</p>
                  <p class="m-0 text-capitalize">{{ str_replace("_", " ", $tunjangan->jenis_tunjangan) }}</p>
               </div>
            </li>
            <li class="list-group-item border-0 border-bottom">
               <div class="d-sm-flex justify-content-between">
                  <p class="m-0 mb-1 mb-md-0 fw-bold">Status</p>
                  @if ($tunjangan->status == 'sudah')
                  <p class="m-0 text-capitalize text-primary">{{ $tunjangan->status }} Diproses</p>
                  @elseif($tunjangan->status == 'sedang')
                  <p class="m-0 text-capitalize text-warning">{{ $tunjangan->status }} Diproses</p>
                  @elseif($tunjangan->status == 'belum')
                  <p class="m-0 text-capitalize text-danger">{{ $tunjangan->status }} Diproses</p>
                  @else
                  <p class="m-0 text-capitalize text-danger">Permintaan di{{ $tunjangan->status }}</p>
                  @endif
               </div>
            </li>
            <li class="list-group-item border-0 border-bottom">
               <div class="d-sm-flex justify-content-between">
                  <p class="m-0 mb-1 mb-md-0 fw-bold">Tanggal</p>
                  <p class="m-0 text-capitalize">{{ $tunjangan->created_at->isoFormat('DD-MM-Y')}}</p>
               </div>
            </li>
            <li class="list-group-item border-0 border-bottom">
               <div class="d-sm-flex justify-content-between">
                  <p class="m-0 mb-1 mb-md-0 fw-bold">Besar Tunjangan</p>
               @if ($tunjangan->karyawan[$tunjangan->jenis_tunjangan] < $tunjangan->besar_tunjangan)
                  <p class="m-0 text-capitalize text-danger">Rp {{ number_format($tunjangan->besar_tunjangan, 0, '', '.') }}</p>
               </div>
               <small><span class="d-md-flex justify-content-end text-danger">Permintaan Tunjangan Lebih Besar dari Yang Tersedia</span></small>
               @else
                  <p class="m-0 text-capitalize">Rp {{ number_format($tunjangan->besar_tunjangan, 0, '', '.') }}</p>
               </div>
               @endif
            </li>
            <li class="list-group-item border-0 border-bottom">
               <p class="m-0 mb-1 fw-bold">Pesan</p>
               <p class="m-0 text-capitalize">{{ $tunjangan->pesan }}</p>
            </li>
            @if (!empty($tunjangan->tanggapan))
            <li class="list-group-item border-0 border-bottom">
               <p class="m-0 mb-1 fw-bold">Pesan dari Admin</p>
               <p class="m-0 text-capitalize">{{ $tunjangan->tanggapan->pesan }}</p>
            </li>
            @endif
         </ul>
      </div>
   </div>
</div>

<div class="row mt-4">
   <div class="col-md-4">
      <div class="card border-0 shadow-sm">
         <img src="{{ asset("images/$tunjangan->bukti") }}" class="card-img-top p-2 rounded-4" alt="..." role="button" data-bs-toggle="modal" data-bs-target="#buktiFoto">
         <div class="card-body">
            <h5 class="card-title">Bukti</h5>
            <p class="card-text text-capitalize">{{ $tunjangan->pesan }}</p>
         </div>
         <div class="modal fade" id="buktiFoto" tabindex="-1" aria-labelledby="buktiFotoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title" id="buktiFotoLabel">Foto Bukti</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body"><img src="{{ asset("images/$tunjangan->bukti") }}" class="img-fluid rounded-1" alt="..."></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   $("#hapusPermintaan").on('click', function() {
      let tanya = confirm("Apakah Yakin ?")
      if (tanya) {
         $(this).closest('form').submit()
      }
   })
   
   $(".pdf-button").on("click", function () {
      var form = $(this).closest("form");
      Swal.fire({
         title: "Apakah Yakin Mau Download?",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Yes, download it!",
      }).then((result) => {
         if (result.isConfirmed) {
            Swal.fire({
               text: "Wait...",
               timer: 3000,
               allowEscapeKey: false,
               allowOutsideClick: false,
               timerProgressBar: true,
               didOpen: () => {
                  Swal.showLoading();
               },
            });
            form.submit();
         }
      });
   });
</script>
@endsection
