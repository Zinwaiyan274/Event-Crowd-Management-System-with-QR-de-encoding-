<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR Generator</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .nav{
            background-color: #b6abee;
        }
    </style>
</head>
<body>
    <nav class="nav navbar navbar-lg navbar-expand-lg">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <div class="navbar-brand d-flex align-item-center" style="margin-left: 150px">
                <img src="{{ asset("storage/Logo.svg") }}" alt="" width="70px">
            </div>
            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse justify-content-end d-flex align-item-center" id="navbarCenteredExample" style="margin-right: 150px;">
            <!-- Left links -->
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fs-3 " aria-current="page" href="{{ route('generatePage') }}">Generate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-3 " aria-current="page" href="{{ route('scannerPage') }}">Scan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-3 " aria-current="page" href="{{ route('detail') }}">Detail</a>
                    </li>
                </ul>
            <!-- Left links -->
            </div>
            <!-- Collapsible wrapper -->
        </div>
        <!-- Container wrapper -->
    </nav>

      @yield('content')
</body>


</html>
