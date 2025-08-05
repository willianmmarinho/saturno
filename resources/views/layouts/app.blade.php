<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://kit.fontawesome.com/a944918be8.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        function Atualizar() {
            window.location.reload();
        }
    </script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- Link ke jQuery dari CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- Import CSS --}}
    <link href="{{ asset('css/tooltips.css') }}" rel="stylesheet">
    {{-- <script src="{{ asset('js/jquery.js') }}"></script> --}}
    <!-- Font Awesome manualmente -->
    <link rel="stylesheet" href="{{ asset('fontsawesome/css/all.min.css') }}">

    <!-- Estilo para o dropdown-->
    <style>
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>

<body>

    @include('layouts/sidebar')

    @yield('content')

    <!-- footerScript -->
    @yield('footerScript')


    <!-- App js-->


</body>

<script>
    $("body").on("submit", "form", function() {
        $(this).submit(function() {
            return false;
        });
        $(':submit').html(
            '<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Carregando...')
        return true;
    });
</script>

</html>
