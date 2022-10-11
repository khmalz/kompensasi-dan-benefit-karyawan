<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse collapse-horizontal">
   <div class="position-sticky d-md-flex pt-3 sidebar-sticky">
      <ul class="nav flex-column fs-6 ms-2 w-100">
         @can('admin')
         <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboardAdmin*') ? 'active' : '' }}" aria-current="page" href="/dashboardAdmin">
               <i class="bi bi-card-text"></i>
               Data Karyawan
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link w-100 d-flex align-items-center gap-2 justify-content-between {{ Request::is('tunjangan*') ? (Request::is('tunjangan/tolak*') ? "" : "active") : '' }}" href="/tunjangan">
               <div>
                  <i class="bi bi-clock-history"></i>
                  List Tunjangan
               </div>
               @if ($total_tunjangan > 0)
                  <span class="badge text-bg-primary rounded-pill me-3 me-md-0" style="font-size: .68rem !important">{{ $total_tunjangan }}</span>
               @endif
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link w-100 d-flex align-items-center gap-2 justify-content-between {{ Request::is('tunjangan/tolak*') ? "active" : '' }}" href="/tunjangan/tolak">
               <div>
                  <i class="bi bi-clock-history"></i>
                  List Tunjangan Ditolak
               </div>
            </a>
         </li>
         @else
         <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboardKaryawan*') ? 'active' : '' }}" href="/dashboardKaryawan">
               <i class="bi bi-cash-stack"></i>
               Permintaan Tunjangan
            </a>
         </li>
         @if (!Hash::check('password', auth()->user()->password))
         <li class="nav-item">
            <a class="nav-link {{ Request::is('riwayat-tunjangan*', 'tunjangan*') ? 'active' : '' }}" href="/riwayat-tunjangan">
               <i class="bi bi-clock-history"></i>
               Riwayat Tunjangan
            </a>
         </li>
         <li class="nav-item mt-md-auto mb-3 me-3 me-md-2 mt-2">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="nav-link w-100 bg-success d-flex align-items-center justify-content-between border-0 text-success py-1 px-3 rounded-3"  style="--bs-bg-opacity: .3;" >
               <div>
                  <i class="bi bi-bell"></i>
                  Notifikasi
               </div>
               @if (auth()->user()->unreadnotifications->isNotEmpty())
                  <span class="badge text-bg-success rounded-pill me-3 me-md-0" style="--bs-bg-opacity: 1; font-size: .68rem !important">{{ auth()->user()->unreadnotifications->count() }}</span>
               @endif
            </button>
         </li>
         @endif
         @endcan
      </ul>
   </div>
</nav>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content">
       <div class="modal-header">
         <h1 class="modal-title fs-5" id="exampleModalLabel">Notifikasi</h1>
         @if (auth()->user()->notifications->isNotEmpty())
         <a href="/dibaca" class="modal-title text-decoration-none">Tandai semua sudah dibaca</a>
         @endif
       </div>
       <div class="modal-body">
         @if (auth()->user()->notifications->isNotEmpty())
            @foreach (auth()->user()->notifications as $notification)
               @if (is_null($notification->read_at))
               <div class="row g-0 mb-0 my-1">
                  <div class="alert {{ $notification->data['status'] == 'sedang' || $notification->data['status'] == 'sudah' ? "bg-success" : "bg-danger" }} border-bottom mb-0 border-2 d-flex align-items-center justify-content-between" style="--bs-bg-opacity: 0.12;" role="alert">
                     <div>
                        @if ($notification->data['status'] == 'sedang')
                        <span class="d-block">Tunjangan dengan kode <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-dark">{{ $notification->data['kode'] }}</a> sedang dalam proses</span>
                        <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-dark text-decoration-none fw-semibold">Lihat Selengkapnya</a> 
                        @elseif ($notification->data['status'] == 'sudah')
                        <span class="d-block">Tunjangan dengan kode <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-dark">{{ $notification->data['kode'] }}</a> sudah selesai diproses</span>
                        <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-dark text-decoration-none fw-semibold">Lihat Selengkapnya</a> 
                        @else
                        <span class="d-block">Permintaan Tunjangan dengan kode <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-dark">{{ $notification->data['kode'] }}</a> ditolak oleh Admin</span>
                        <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-dark text-decoration-none fw-semibold">Lihat Selengkapnya</a> 
                        @endif

                        @if ($notification->created_at > now()->subHours(24))  {{-- sehari yang lalu --}}
                        <small><span class="text-secondary d-block mb-1">Hari ini pada {{ $notification->created_at->format('H:i') }} | {{ $notification->created_at->diffForHumans() }}</span></small>
                        @else
                        <small><span class="text-secondary d-block mb-1">{{ $notification->created_at->isoFormat('D MMMM, Y') }} pada {{ $notification->created_at->format('H:i') }}</span></small>
                        @endif
                     </div>
                  </div>
               </div>
               @else
               <div class="row g-0 mb-0">
                  <div class="alert border-bottom mb-0 border-2 d-flex align-items-center justify-content-between" role="alert">
                     <div>
                        @if ($notification->data['status'] == 'sedang')
                        <span class="d-block">Permintaan Tunjangan dengan kode <span class="fw-semibold">{{ $notification->data['kode'] }}</span> sedang dalam proses</span>
                        <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-dark text-decoration-none fw-semibold">Lihat Selengkapnya</a> 
                        @elseif ($notification->data['status'] == 'sudah')
                        <span class="d-block">Permintaan Tunjangan dengan kode <span class="fw-semibold">{{ $notification->data['kode'] }}</span> sudah selesai diproses</span>
                        <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-dark text-decoration-none fw-semibold">Lihat Selengkapnya</a> 
                        @else
                        <span class="d-block">Permintaan Tunjangan dengan kode <span class="fw-semibold">{{ $notification->data['kode'] }}</span> ditolak oleh Admin</span>
                        <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-dark text-decoration-none fw-semibold">Lihat Selengkapnya</a> 
                        @endif
                        @if ($notification->created_at > now()->subHours(24))  {{-- sehari yang lalu --}}
                        <small><span class="text-secondary d-block mb-1">Hari ini pada {{ $notification->created_at->format('H:i') }} | {{ $notification->created_at->diffForHumans() }}</span></small>
                        @else
                        <small><span class="text-secondary d-block mb-1">{{ $notification->created_at->isoFormat('D MMMM, Y') }} pada {{ $notification->created_at->format('H:i') }}</span></small>
                        @endif
                     </div>
                  </div>
               </div>
               @endif
            @endforeach
         @else
         <div class="d-flex justify-content-center"><span class="text-secondary">Tidak Ada Notifikasi</span></div>
         @endif
       </div>
     </div>
   </div>
 </div>