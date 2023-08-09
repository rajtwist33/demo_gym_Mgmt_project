<aside class="main-sidebar sidebar-dark-primary elevation-4">
  {{-- Brand Logo --}}
  <a href="{{ route('admin.home') }}" class="brand-link">
    {{-- <img src="{{ asset('icon-image/a.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
    @php
      $auth_name = config('app.name', 'Laravel');
      preg_match_all('/(?<=\s|^)[a-z]/i', $auth_name, $matches);
    @endphp
    <span class="brand-text font-weight-light text-center">{{ config('app.name') }}</span>
  </a>
  {{-- Sidebar --}}
  <div class="sidebar ">


    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li @class([
                'nav-item',
                'menu-open' => request()->is('*manage/*'),
              ])>

         <ul class="nav ">
          <li class="nav-item">
            <a href="{{ route('admin.gymer.index') }}"
                @class([
                 'nav-link',
                 'active' => request()->is(['*/manage/gymer*',
          '*/users_profile*','*/payment_history*']),
                 ])>
              <i class="fas fa-users nav-icon"></i>
              <p>{{ __('language.Gymer') }}</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.trainer.index') }}"
                @class([
                 'nav-link',
                 'active' => request()->is('*/manage/trainer*','*/trainerpayment/*','*/trainershift/*'),
                 ])>
              <i class="fas fa-user nav-icon"></i>
              <p>{{ __('language.Trainer') }}  </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.payment.index') }}"
                @class([
                 'nav-link',
          'active' => request()->is('*/payment'),
                 ])>
              <i class="far fa-money-bill-alt nav-icon"></i>
              <p>{{ __('language.Payment') }}  </p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="{{ route('admin.advancelist.index') }}"
                @class([
                 'nav-link',
                 'active' => request()->is('*/advancelist*'),
                 ])>
              <i class="fab fa-bitcoin nav-icon"></i>
              <p>{{ __('language.Advance') }}  </p>
            </a>
          </li> -->
          <li class="nav-item">
            <a href="{{ route('admin.offers.index') }}"
                @class([
                 'nav-link',
                 'active' => request()->is('*/offers*'),
                 ])>
              <i class="fas fa-gift nav-icon"></i>
              <p>{{ __('language.Offer') }}  </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.anual_paymenttype.index') }}"
                @class([
                 'nav-link',
                 'active' => request()->is('*/anual_paymenttype*'),
                 ])>
                 <i class="fas fa-money-check-alt nav-icon"></i>
              <p>{{ __('language.anual_paymenttype') }}  </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.pdf.index') }}"
                @class([
                 'nav-link',
                 'active' => request()->is('*/pdf*'),
                 ])>
                 <i class="bi bi-printer nav-icon"></i>
              <p>{{ __('language.pdf') }}  </p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="{{ route('admin.attendance.index') }}"
                @class([
                 'nav-link',
                 'active' => request()->is('*/attendance*'),
                 ])>
              <i class="fab fa-blackberry nav-icon"></i>
              <p>{{ __('language.Attendance') }}  </p>
            </a>
          </li> -->
          <!-- <li class="nav-item">
            <a href="{{ route('admin.attendancereport.index') }}"
                @class([
                 'nav-link',
                 'active' => request()->is('*/attendancereport*'),
                 ])>
              <i class="fab fa-blackberry nav-icon"></i>
              <p>{{ __('language.attendancereport') }}  </p>
            </a>
          </li> -->
        </ul>
      </li>


       <!-- <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-th"></i>
          <p>
            Simple Link
            <span class="right badge badge-danger">New</span>
          </p>
        </a>
      </li>  -->
    </ul>
  </nav>
</div>
</aside>
