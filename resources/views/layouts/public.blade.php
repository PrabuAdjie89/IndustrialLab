<!DOCTYPE html>
<html lang="en">
<style>
    .main-header,
    .navbar-header,
    .navbar {
        width: 100% !important;
    }

    .main-panel {
        margin-left: 0 !important;
    }
</style>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ env('APP_NAME') }}</title>

    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport"
    />

    <link
        rel="icon"
        href="{{ asset('template') }}/assets/img/kaiadmin/lab.svg"
        type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="{{ asset('template') }}/assets/js/plugin/webfont/webfont.min.js"></script>

    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },

            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],

                urls: [
                    "{{ asset('template') }}/assets/css/fonts.min.css"
                ],
            },

            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('template') }}/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('template') }}/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="{{ asset('template') }}/assets/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="{{ asset('template') }}/assets/css/demo.css" />
</head>

<body>

@include('sweetalert::alert')

<div class="wrapper">

    <div class="main-panel w-100" style="width: 100vw;">

        <!-- Header -->
        <div class="main-header">

            <div class="main-header-logo">

                <div class="logo-header" data-background-color="dark">

                    <a href="/" class="logo">
                        <img
                            src="{{ asset('template') }}/assets/img/kaiadmin/lab.svg"
                            alt="navbar brand"
                            class="navbar-brand"
                            height="20"
                        />
                    </a>

                </div>

            </div>

            <!-- Navbar -->
            <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                <div class="container-fluid">

                    <h4 class="mb-0 fw-bold">
                        @yield('page_title', 'Lab Inventory')
                    </h4>

                </div>
            </nav>

        </div>

        <!-- Content -->
        <div class="container">

            <div class="page-inner">

                @yield('content')

            </div>

        </div>

        <!-- Footer -->
        <footer class="footer">

            <div class="container-fluid d-flex justify-content-between">

                <div class="copyright">
                    2024, made with
                    <i class="fa fa-heart heart text-danger"></i>
                    by Industrial Laboratory
                </div>

                <div>
                    Distributed by
                    <a target="_blank" href="https://themewagon.com/">
                        ThemeWagon
                    </a>
                </div>

            </div>

        </footer>

    </div>

</div>

<!-- Core JS Files -->
<script src="{{ asset('template') }}/assets/js/core/jquery-3.7.1.min.js"></script>
<script src="{{ asset('template') }}/assets/js/core/popper.min.js"></script>
<script src="{{ asset('template') }}/assets/js/core/bootstrap.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('template') }}/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Chart JS -->
<script src="{{ asset('template') }}/assets/js/plugin/chart.js/chart.min.js"></script>

<!-- Datatables -->
<script src="{{ asset('template') }}/assets/js/plugin/datatables/datatables.min.js"></script>

<!-- Sweet Alert -->
<script src="{{ asset('template') }}/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

<!-- Kaiadmin JS -->
<script src="{{ asset('template') }}/assets/js/kaiadmin.min.js"></script>

</body>
</html>