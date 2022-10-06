<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse collapse-horizontal">
   <div class="position-sticky pt-3 sidebar-sticky">
      <ul class="nav flex-column fs-6">
         @can('admin')
         <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboardAdmin*') ? 'active' : '' }}" aria-current="page" href="/dashboardAdmin">
               <i class="bi bi-card-text"></i>
               Data Karyawan
            </a>
         </li>
         <li class="nav-item">
            <a class="nav-link {{ Request::is('tunjangan*') ? "active" : '' }}" href="/tunjangan">
               <i class="bi bi-clock-history"></i>
               List Tunjangan
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
         @endcan
      </ul>
   </div>
</nav>