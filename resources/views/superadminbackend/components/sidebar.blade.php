<aside class="main-sidebar sidebar-dark-primary elevation-4">
  {{-- Brand Logo --}}
  <a href="{{ route('superadmin.home') }}" class="brand-link">

    @php
      $auth_name = config('app.name', 'Laravel');
      preg_match_all('/(?<=\s|^)[a-z]/i', $auth_name, $matches);
    @endphp
    <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
  </a>
  {{-- Sidebar --}}
  <div class="sidebar ">
    <div class="form-inline mt-2">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li @class([
                'nav-item',
                'menu-open' => request()->is('*manage/*'),
              ])>
          <a href="#"
              @class([
               'nav-link',
               'active' => request()->is('*/manage/*'),
               ])
          >
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
             {{ __('language.User Management') }}
             <i class="right fas fa-angle-left"></i>
           </p>
         </a>
         <ul class="nav nav-treeview">
          {{-- <li class="nav-item">
            <a href="{{ route('superadmin.role.index') }}"
                @class([
                 'nav-link',
                 'active' => request()->is('*/manage/role*'),
                 ])>
              <i class="fab fa-empire nav-icon"></i>
              <p>{{ __('language.Roles') }}</p>
            </a>
          </li> --}}
          <li class="nav-item">
            <a href="{{ route('superadmin.users.index') }}"
                @class([
                 'nav-link',
                 'active' => request()->is('*/manage/users*'),
                 ])>
              <i class="fas fa-user-cog nav-icon"></i>
              <p>Admin User </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superadmin.active_gymer.index') }}"
                @class([
                 'nav-link',
                 'active' => request()->is('*/manage/active_gymer*'),
                 ])>
              <i class="fas fa-users nav-icon "></i>
              <p>{{ __('language.Active_gymer') }}  </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superadmin.inactive_gymer.index') }}"
                @class([
                 'nav-link',
                 'active' => request()->is('*/manage/inactive_gymer*'),
                 ])>
              <i class="fas fa-users-slash nav-icon"></i>
              <p>{{ __('language.Inactive_gymer') }}  </p>
            </a>
          </li>
        </ul>
      </li>
      <li @class([
                'nav-item',
                'menu-open' => request()->is('*setup/*'),
              ])>
        <a href="#"
            @class([
             'nav-link',
             'active' => request()->is('*/setup/*'),
             ])
         >
          <i class="nav-icon fas fa-map"></i>
          <p>
            Setup
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('superadmin.shift.index') }}"
              @class([
                'nav-link',
                'active' => request()->is('*/setup/shift*'),
                ])>
              <i class="fab fa-usps nav-icon"></i>
              <p>{{ __('language.Shift') }}</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superadmin.gender.index') }}"
              @class([
                'nav-link',
                'active' => request()->is('*/setup/gender*'),
                ])>
              <i class="fa fa-transgender-alt nav-icon"></i>
              <p>{{ __('language.Gender') }}</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superadmin.blood_type.index') }}"
              @class([
                'nav-link',
                'active' => request()->is('*/setup/blood_type*'),
                ])>
              <i class="fa fa-heartbeat nav-icon"></i>
              <p>{{ __('language.Bloodtype') }}</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superadmin.offer.index') }}"
              @class([
                'nav-link',
                'active' => request()->is('*/setup/offer*'),
                ])>
              <i class="fas fa-gift nav-icon"></i>
              <p>{{ __('language.offer') }}</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superadmin.groupdiscount.index') }}"
              @class([
                'nav-link',
                'active' => request()->is('*/setup/groupdiscount*'),
                ])>
              <i class="fas fa-shapes nav-icon"></i>
              <p>{{ __('language.gdiscount') }}</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('superadmin.annual_payment.index') }}"
              @class([
                'nav-link',
                'active' => request()->is('*/setup/annual_payment*'),
                ])>
              <i class="fas fa-piggy-bank nav-icon"></i>
              <p>{{ __('language.annual_payment') }}</p>
            </a>
          </li>
        </ul>

      </li>
      <li class="nav-item">
            <a href="{{ route('superadmin.change_password.edit',Auth::user()->id) }}"
              @class([
                'nav-link',
                'active' => request()->is('*/change_password*'),
                ])>
              <i class="fa fa-key nav-icon"></i>
              <p>Change SuperAdmin Password</p>
            </a>
          </li>
    </ul>
  </nav>
</div>
</aside>
