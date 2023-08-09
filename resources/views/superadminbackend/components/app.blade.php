<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }}</title>
  <link rel="icon" type="image/x-icon" href="{{asset('fav-image/b.png')}}">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('backend/darkmode/darkmode.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>

  {{-- External Slot For Style --}}
  @stack('style')
</head>

<body @class([
        'hold-transition sidebar-mini',
        'dark-mode' => Auth::user()->mode,
        'sidebar-collapse' => Auth::user()->collapse,
        'layout-fixed layout-navbar-fixed layout-footer-fixed',
        ])
  >

  <div class="wrapper">

        @include('sweetalert::alert')

        @include('superadminbackend.components.header')

        <div class="content-wrapper"  >
          <div class="content-header">
            @yield('content')
          </div>
        </div>
          @include('superadminbackend.components.sidebar')

        @include('superadminbackend.components.footer')

  </div>

  <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
  <script>
    let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function (html) {
        let switchery = new Switchery(html, {size: 'small'});
    });
</script>

<script>
    $(document).ready(function () {
      $('.js-switch').change(function () {
            let status = $(this).prop('checked') === true ? 1 : 0;
            let sliderId = $(this).data('id');
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('superadmin.modes.index') }}',
                data:
                {
                  'status': status,
                  'slider_id':sliderId,
                },
                success: function (data) {
                      location.reload();
                }
            })
        });

        $(".btn").click(function () {
          let status = {{ Auth::user()->collapse == 1 ? '1' : '0' }};
          let sliderId = $(this).data('id');
          $.ajax({
              type: "GET",
              dataType: "json",
              url: '{{ route('superadmin.modes.create') }}',
              data:
              {
                'status': status,
                'slider_id':sliderId,
              },
              success: function (data) {
                    location.reload();
              }
          })
      });
    });

</script>
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
<script type="text/javascript" src="{{asset ('backend/plugins/toastr/toastr.min.js') }}"></script>


  {{-- External Slots Javascript  --}}
  @stack('script')
</body>
</html>
