<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Download PDF Tunjangan</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
</head>
<body>
   <div class="container">
      <p>Tunjangan / Kode : #{{ $tunjangan->kode }}</p>

       <div class="row justify-content-between">
         <div class="col">
            <ul class="list-group tunjangan-details">
               <li class="list-group-item border-0 border-bottom"><p class="h5">Tunjangan Detail</p></li>
               <li class="list-group-item border-0 border-bottom mt-3">
                  <div class="d-sm-flex justify-content-between">
                     <p class="m-0 mb-1 mb-md-0 fw-bold">Jenis Tunjangan</p>
                     <p class="m-0 text-capitalize">{{ str_replace("_", " ", $tunjangan->jenis_tunjangan) }}</p>
                  </div>
               </li>
               <li class="list-group-item border-0 border-bottom mt-2">
                  <div class="d-sm-flex justify-content-between">
                     <p class="m-0 mb-1 mb-md-0 fw-bold">Status</p>
                     @if ($tunjangan->status == 'sudah')
                     <p class="m-0 text-capitalize text-primary" style="color: #0d6efd">{{ $tunjangan->status }} Diproses</p>
                     @elseif($tunjangan->status == 'sedang')
                     <p class="m-0 text-capitalize text-warning" style="color: #ffc107">{{ $tunjangan->status }} Diproses</p>
                     @else
                     <p class="m-0 text-capitalize text-danger" style="color: #dc3545">{{ $tunjangan->status }} Diproses</p>
                     @endif
                  </div>
               </li>
               <li class="list-group-item border-0 border-bottom mt-2">
                  <div class="d-sm-flex justify-content-between">
                     <p class="m-0 mb-1 mb-md-0 fw-bold">Tanggal</p>
                     <p class="m-0 text-capitalize">{{ $tunjangan->created_at->translatedFormat('d F Y')}}</p>
                  </div>
               </li>
               <li class="list-group-item border-0 border-bottom mt-2">
                  <div class="d-sm-flex justify-content-between">
                     <p class="m-0 mb-1 mb-md-0 fw-bold">Besar Tunjangan</p>
                     <p class="m-0 text-capitalize">Rp {{ number_format($tunjangan->besar_tunjangan, 0, '', '.') }}</p>
                  </div>
               </li>
               <li class="list-group-item border-0 border-bottom mt-2">
                  <p class="m-0 mb-1 fw-bold">Pesan</p>
                  <p class="m-0 text-capitalize">{{ $tunjangan->pesan }}</p>
               </li>
            </ul>
         </div>
         <div class="col">
            <div class="card border-0">
               <img src="{{ asset("images/$tunjangan->bukti") }}" class="card-img-top p-2 mt-2 rounded-4" style="border-radius: 10px; width: 500px">
            </div>
         </div>
       </div>

   </div>


</body>
</html>