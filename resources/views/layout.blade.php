<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Creative Tim">
    <title>Hymn Dashboard - Free Dashboard for the Hymn App</title>
    <!-- Favicon -->
    <link href="{{asset('img/brand/favicon.png')}}" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{asset('vendor/nucleo/css/nucleo.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{asset('css/argon.min.css?v=1.0.0')}}" rel="stylesheet">
</head>
<body class="@yield('section-class')">

@yield('content')
@yield('footer')
</body>
<!--   Core JS Files   -->
<script src="{{asset('vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<!-- Optional JS -->
<script src="{{asset('vendor/chart.js/dist/Chart.min.js')}}"></script>
<script src="{{asset('vendor/chart.js/dist/Chart.extension.js')}}"></script>
<!-- Argon JS -->
<script src="{{asset('js/argon.js?v=1.0.0')}}"></script>
@yield('scripts')
@stack('scripts')
<script type="text/javascript">
    $(document).ready(function() {

        //init wizard

        // demo.initMaterialWizard();

        // Javascript method's body can be found in assets/js/demos.js
        // demo.initDashboardPageCharts();

        // demo.initCharts();

    });
</script>
</html>
