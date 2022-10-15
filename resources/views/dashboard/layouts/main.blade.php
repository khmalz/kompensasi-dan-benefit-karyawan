<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <title>Dashboard</title>

      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
      <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <style>
         body {
            font-size: 0.85rem;
            font-family: 'Poppins', sans-serif;
         }

         .feather {
            width: 16px;
            height: 16px;
            vertical-align: text-bottom;
         }

         .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100; /* Behind the navbar */
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, 0.1);
         }

         .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            overflow-x: hidden;
            overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
         }

         .sidebar .nav-link {
            font-weight: 500;
            color: #333;
         }

         .sidebar .nav-link .feather {
            margin-right: 4px;
            color: #727272;
         }

         .sidebar .nav-link.active {
            color: #2470dc;
         }

         .sidebar .nav-link:hover .feather,
         .sidebar .nav-link.active .feather {
            color: inherit;
         }

         .navbar-brand {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            font-size: 1rem;
            background-color: rgba(0, 0, 0, 0.25);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, 0.25);
         }

         .navbar .navbar-toggler {
            top: 0.25rem;
            right: 1rem;
         }

         .logout:hover {
            color: #0d6efd !important;
         }

         @media (max-width: 992px) {
            .detail-judul {
               font-size: 1.3rem
            }
         }

         @media (max-width: 767.98px) {
            .sidebar {
               top: 5rem;
            }

            .sidebar-sticky {
               width: 100vw;
            }
            
            .w-100 > .row > .fs-6 {
               font-size: 0.8rem !important;
            }
         }

         @media (max-width: 576px) {
            .detail-judul {
               font-size: 1rem
            }

            .tunjangan-details,
            .card > .card-body > .card-text {
               font-size: 0.8rem !important;
            }

            .tunjangan-details > .list-group-item > .h5,
            .card > .card-body > .card-title {
               font-size: 1.1rem !important;
            }
         }

         input::-webkit-outer-spin-button,
         input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
         }

         input[type=number] {
            -moz-appearance: textfield;
         }
      </style>
   </head>
   <body style="background-color: #ECECEC">
      <header class="navbar navbar-dark sticky-top flex-md-nowrap p-0 shadow" style="background-color: #BABBBB;">
         <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 text-center bg-transparent shadow-none" href="#">
            <img src="{{ asset('images/RTS-Lite.png') }}" width="100" alt="Logo RTS">
         </a>
         <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-expanded="false" aria-controls="sidebarMenu">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="navbar-nav w-100">
            <div class="nav-item text-nowrap d-md-flex justify-content-between align-items-center">
               @can('admin')
               <a class="nav-link px-3 text-dark fs-5">Selamat Datang, Admin</a>
               @else
               <a class="nav-link px-3 text-dark fs-5">Selamat Datang, {{ auth()->user()->name }}</a>
               @endcan
               <form action="{{ route('logout') }}" method="post" id="logout">
                  @csrf
                  <a onclick='$("#logout").submit()' href="#" class="nav-link px-3 text-dark logout">Logout <i class="bi bi-box-arrow-right"></i></a>
               </form>
            </div>
      </header>

      <div class="container">
         <div class="row">
            @include('dashboard.layouts.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-0 pt-3 mt-4">
               @can('karyawan')
               <button class="position-fixed border-0 d-md-none bottom-0 end-0 bg-success text-success fs-5 me-3 mb-3 p-1 px-2 rounded-circle" style="--bs-bg-opacity: .3;z-index: 100" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  @if (auth()->user()->unreadnotifications->isNotEmpty())
                  <span class="position-absolute top-0 end-0 p-1 bg-success border border-light rounded-circle">
                     <span class="visually-hidden"></span>
                  </span>
                  @endif
                  <i class="bi bi-bell"></i>
               </button>
               @endcan
               
               @yield('isi')
            </main>
         </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>

      <script>
         feather.replace({ "aria-hidden": "true" });

         function convertRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
            ribuan 	= reverse.match(/\d{1,3}/g);
            ribuan	= ribuan.join('.').split('').reverse().join('');
            return ribuan;
         }
      </script>
   </body>
</html>
