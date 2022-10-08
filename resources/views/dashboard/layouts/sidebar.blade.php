<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse collapse-horizontal">
   <div class="position-sticky d-md-flex pt-3 sidebar-sticky">
      <ul class="nav flex-column fs-6 ms-2">
         @can('admin')
         <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboardAdmin*') ? 'active' : '' }}" aria-current="page" href="/dashboardAdmin">
               <i class="bi bi-card-text"></i>
               Data Karyawan
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link w-100 d-flex align-items-center gap-2 justify-content-between {{ Request::is('tunjangan*') ? "active" : '' }}" href="/tunjangan">
               <div>
                  <i class="bi bi-clock-history"></i>
                  List Tunjangan
               </div>
               @if ($total_tunjangan > 0)
                  <span class="badge text-bg-primary rounded-pill me-3 me-md-0" style="font-size: .68rem !important">{{ $total_tunjangan }}</span>
               @endif
            </a>
         </li>
         @else
         <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboardKaryawan*') ? 'active' : '' }}" href="/dashboardKaryawan">
               <i class="bi bi-cash-stack"></i>
               Permintaan Tunjangan
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link {{ Request::is('riwayat-tunjangan*', 'tunjangan*') ? 'active' : '' }}" href="/riwayat-tunjangan">
               <i class="bi bi-clock-history"></i>
               Riwayat Tunjangan
            </a>
         </li>
         <li class="nav-item mt-auto mb-2">
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
         @endcan
      </ul>
   </div>
</nav>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content">
       <div class="modal-header justify-content-center">
         <h1 class="modal-title fs-5" id="exampleModalLabel">Notifikasi</h1>
       </div>
       <div class="modal-body">
         @if (auth()->user()->notifications->isNotEmpty())
            @foreach (auth()->user()->notifications as $notification)
            <div class="row g-0 mb-4">
               <div class="alert alert-success d-flex align-items-center justify-content-between" role="alert">
                  <div>
                     @if ($notification->data['status'] == 'sedang')
                     <span>Tunjangan dengan kode <span class="fw-semibold">{{ $notification->data['kode'] }}</span> sedang dalam proses</span>
                     @else
                     <span>Tunjangan dengan kode <span class="fw-semibold">{{ $notification->data['kode'] }}</span> sudah selesai diproses</span>
                     @endif
                     <a href="/tunjangan/{{ $notification->data['kode'] }}" class="text-dark text-decoration-none fw-semibold">Lihat Selengkapnya</a> 
                     <small><span class="text-secondary d-block mb-1">{{ $notification->created_at->isoFormat('D MMMM, Y') }} pada {{ $notification->created_at->format('H:i') }} | {{ $notification->created_at->diffForHumans() }}</span></small>
                  </div>
               </div>
            </div>
            @endforeach
         @else
         <div class="d-flex justify-content-center"><span class="text-secondary">Tidak Ada Notifikasi</span></div>
         @endif
       </div>
     </div>
   </div>
 </div>