<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap5.css', true) }}">
    <link href="{{ asset('frontend/css/select2.min.css', true) }}" rel="stylesheet">
    <link  type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link  href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="{{ asset('admin/css/nucleo-icons.css', true) }}" rel="stylesheet" />
    <link href="{{ asset('admin/css/nucleo-svg.css', true) }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('admin/css/material-dashboard.css', true) }}">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css', true) }}">
</head>
<body>
    <div class="wrapper">
        @include('layouts.inc.sidebar')
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
            @include('layouts.inc.adminnav')
            @yield('content')
            @include('layouts.inc.adminfooter')
        </main>
    </div>

    @yield('modals')

    <!-- Scripts -->
    <script src="{{ asset('frontend/js/jquery-3.6.4.min.js', true) }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js', true) }}"></script>
    <script src="{{ asset('frontend/js/select2.min.js', true) }}"></script>
    <script src="{{ asset('frontend/js/jquery.mask.min.js', true) }}"></script>

    <script src="{{ asset('admin/js/core/popper.min.js', true) }}"></script>
    <script src="{{ asset('admin/js/core/bootstrap.min.js', true) }}"></script>
    <script src="{{ asset('admin/js/plugins/perfect-scrollbar.min.js', true) }}"></script>
    <script src="{{ asset('admin/js/plugins/smooth-scrollbar.min.js', true) }}"></script>
    <script src="{{ asset('admin/js/plugins/chartjs.min.js', true) }}"></script>

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session("status"))
        <script>
            Swal.fire({
                title: "{{ session("message") }}",
                icon: "{{ session("status") }}",
                showConfirmButton: false,
                timer: 2500
            });
        </script>
    @endif

    @yield('scripts')
</body>
</html>
