        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo d-flex justify-content-center align-items-center">
              <a href="{{ route('home') }}" class="app-brand-link">
                <span class="app-brand-logo demo">
                  <img src="{{ asset('assets/landing/images/logo.png') }}" style="max-width: 200px; height: auto;" alt="Logo">
                </span>
              </a>
  
              <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none position-absolute" style="top: 1rem; right: 1rem;">
                <i class="bx bx-chevron-left bx-sm align-middle"></i>
              </a>
            </div>
  
            <div class="menu-inner-shadow"></div>
  
            <ul class="menu-inner py-1 mt-3">
              {{-- Dashboard --}}
              <li class="menu-item {{ Route::is('dashboard.dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard.dashboard') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-home"></i>
                  <div data-i18n="Analytics">Dashboard</div>
                </a>
              </li>
              {{-- Users --}}
              <li class="menu-item {{ Route::is('dashboard.user*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.user.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-user"></i>
                  <div data-i18n="Analytics">Users</div>
                </a>
              </li>
              {{-- TPS Election --}}
              <li class="menu-item {{ Route::is('dashboard.tps*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.tps.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-home"></i>
                  <div data-i18n="Analytics">TPS</div>
                </a>
              </li>
              {{-- Kelurahan Election --}}
              <li class="menu-item {{ Route::is('dashboard.kelurahan*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.kelurahan.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-home"></i>
                  <div data-i18n="Analytics">Kelurahan</div>
                </a>
              </li>
              {{-- Kecamatan Election --}}
              <li class="menu-item {{ Route::is('dashboard.kecamatan*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.kecamatan.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-home"></i>
                  <div data-i18n="Analytics">Kecamatan</div>
                </a>
              </li>
              {{-- Participant --}}
              <li class="menu-item {{ Route::is('dashboard.participant*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.participant.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bxs-data"></i>
                  <div data-i18n="Analytics">Participant</div>
                </a>
              </li>
            </ul>
          </aside>
          <!-- / Menu -->

@push('styles')
<style>
  .app-brand.demo {
    height: 80px; /* Sesuaikan dengan kebutuhan */
    overflow: hidden;
  }
  .app-brand-logo.demo img {
    object-fit: contain;
    max-height: 100%;
  }
</style>
@endpush