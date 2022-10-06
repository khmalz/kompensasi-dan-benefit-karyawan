@extends('dashboard.layouts.main')

@section('isi')

<div class="row">
   <div class="col">
      <div class="card mb-3 border-0">
         <div class="row mx-auto my-3">
            <h3>Tambah Data</h3>
         </div>
         <div class="row mx-auto px-5 w-100 py-5">
            <form action="{{ route('dashboardAdmin.store') }}" method="post">
               @csrf
               <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="name" id="floatingInput" placeholder="name@example.com" />
                  <label for="floatingInput">Nama</label>
               </div>
               <div class="form-floating mb-3">
                  <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com" />
                  <label for="floatingInput">Email</label>
               </div>
               <div class="form-floating mb-3">
                  <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password" />
                  <label for="floatingPassword">Password</label>
               </div>
               <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="nik" id="floatingInput" placeholder="name@example.com" />
                  <label for="floatingInput">NIK</label>
               </div>
               <div class="form-floating mb-3">
                  <select class="form-select" name="status" id="floatingSelect" aria-label="Floating label select example">
                    <option value="permanen">Permanen</option>
                    <option value="kontrak">Kontrak</option>
                  </select>
                  <label for="floatingSelect">Status</label>
                </div>
               <div class="form-floating mb-3">
                  <input type="text" class="form-control" name="lokasi" id="floatingInput" placeholder="name@example.com" />
                  <label for="floatingInput">Lokasi</label>
               </div>
               <div class="form-floating mb-3">
                  <input type="date" class="form-control" name="tanggal_masuk" id="floatingInput" placeholder="name@example.com" />
                  <label for="floatingInput">Tanggal Masuk</label>
               </div>
               <button type="submit" class="btn btn-success mt-3">Kirim</button>
            </form>
         </div>
      </div>
   </div>
</div>

@endsection
