<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <meta name="description" content="" />
      <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
      <meta name="generator" content="Hugo 0.88.1" />
      <title>Halaman Login</title>

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous" />

      <style>
         html,
         body {
            height: 100%;
            margin: 0;
            padding: 0;
         }

         body {
            display: flex;
            background-color: #f5f5f5;
         }

         .form-signin .checkbox {
            font-weight: 400;
         }

         .form-signin .form-floating:focus-within {
            z-index: 2;
         }

         .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
         }

         .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
         }
      </style>
   </head>
   <body class="position-relative" style="background-color: #e4e7ec">
      <div>
         <img src="images/RTS-Lite.png" class="position-absolute d-inline-block bottom-0 end-0" style="width: 40%; z-index: -10" alt="RTS" />
      </div>

      <main class="w-100 m-auto">
         <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-8 shadow-lg p-5 rounded-3 bg-white" style="z-index: 1">
               <h1 class="h3 mb-4 fw-normal text-center fw-bold fs-2">LOGIN</h1>
               @if (session()->has('fail'))
                  <div class="alert alert-danger" role="alert">
                     {{ session('fail') }}
                  </div>
               @endif
               <form action="/login" method="post">
                  @csrf
                  <div class="form-floating text-start rounded @error('email') is-invalid @enderror">
                     <input autofocus name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}"/>
                     <label for="floatingInput">Email</label>
                  </div>
                  @error('email')
                     <div class="invalid-feedback mt-2">
                        {{ $message }}
                     </div>
                  @enderror
                  <div class="form-floating text-start mt-4 rounded @error('password') is-invalid @enderror">
                     <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" placeholder="Password" />
                     <label for="floatingPassword">Password</label>
                  </div>
                  @error('password')
                     <div class="invalid-feedback mt-2">
                        {{ $message }}
                     </div>
                  @enderror
                  <button class="btn btn-primary mt-3 w-100" type="submit">Login</button>
               </form>
            </div>
         </div>
      </main>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
   </body>
</html>
