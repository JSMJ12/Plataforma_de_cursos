@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')
@inject('preloaderHelper', 'JeroenNoten\LaravelAdminLte\Helpers\PreloaderHelper')

@section('adminlte_css')
    @stack('css')
    @yield('css')
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <style>
        .card-header {
            background-color: #3b8b54;
            color: white;
        }

        .card-body {
            padding: 20px;
        }

        table {
            width: 100%;
        }

        .table th,
        .table td {
            text-align: center;
        }

        .btn-custom {
            background-color: #041c48;
            /* Color personalizado */
            border-color: #041c48;
            /* Color del borde */
            color: #fff;
            /* Color del texto */
        }

        .btn-custom:hover {
            background-color: #033a6d;
            /* Color del botón en estado hover */
            border-color: #033a6d;
            /* Color del borde en estado hover */
        }

        .btn-transparent {
            background-color: #3c8c54;
            border: 1px solid #041c48;
            /* Color del borde */
            color: #fff;
            /* Color del texto e ícono */
        }

        .btn-transparent:hover {
            background-color: #041c48;
            /* Fondo del botón al pasar el cursor */
            color: #fff;
            /* Color del texto e ícono al pasar el cursor */
        }

        .btn-transparent:hover i {
            color: #fff;
            /* Color del ícono al pasar el cursor */
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_scroll,
        .dataTables_wrapper .dataTables_empty,
        .dataTables_wrapper .dataTables_header,
        .dataTables_wrapper .dataTables_footer,
        table.dataTable {
            font-size: 14px;
            font-family: "Times New Roman", Times, serif;
        }
    </style>
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Preloader Animation (fullscreen mode) --}}
        @if ($preloaderHelper->isPreloaderEnabled())
            @include('adminlte::partials.common.preloader')
        @endif

        {{-- Top Navbar --}}
        @if ($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if (!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        @empty($iFrameEnabled)
            @include('adminlte::partials.cwrapper.cwrapper-default')
        @else
            @include('adminlte::partials.cwrapper.cwrapper-iframe')
        @endempty

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if (config('adminlte.right_sidebar'))
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Verificar si hay errores en la sesión
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: '{{ $error }}',
                        confirmButtonText: 'Aceptar'
                    });
                @endforeach
            @endif

            // Verificar si hay un mensaje de éxito en la sesión
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'Aceptar'
                });
            @endif
        });
    </script>
@stop
