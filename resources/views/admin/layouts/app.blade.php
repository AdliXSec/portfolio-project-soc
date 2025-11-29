<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>

    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl-carousel-2/owl.theme.default.min.css') }}">
    @stack('plugin-css') {{-- Untuk CSS Chart atau Plugin Khusus per halaman --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @php
        $header = \App\Models\Home::first();
    @endphp
    <link rel="shortcut icon" href="{{ asset('img/home/'.$header->foto) }}" />
  </head>
  <body>
    <div class="container-scroller">

      @include('admin.layouts.sidebar')

      <div class="container-fluid page-body-wrapper">

        @include('admin.layouts.navbar')

        <div class="main-panel">
          <div class="content-wrapper">

            @yield('content')

          </div>
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © {{ date('Y') }} <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved.</span>
              <span class="text-muted float-none float-sm-end d-block mt-1 mt-sm-0 text-center"> <span class="text-muted float-none float-sm-end d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span></span>
            </div>
          </footer>
          </div>
        </div>
      </div>
        @if(isset($chartData) && count($chartData) > 0)
            <script>
                var monthlyLabels = {!! json_encode($chartData->pluck('label')->toArray()) !!};
                var monthlyVisits = {!! json_encode($chartData->pluck('visits')->toArray()) !!};
            </script>
            <script src="{{ asset('assets/js/dashboard.js') }}"></script>
        @endif
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jvectormap/jquery-jvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/vendors/owl-carousel-2/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    @stack('plugin-js') {{-- Untuk JS Chart atau Plugin Khusus per halaman --}}
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/proBanner.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    {{-- Scripts halaman khusus bisa ditaruh di @stack('custom-js') jika tidak bentrok --}}
    </body>
</html>
