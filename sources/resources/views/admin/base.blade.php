<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Панель администратора</title>
    <link rel="stylesheet"
          crossorigin="anonymous"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH">
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        html,
        body,
        #wrapper,
        .row-wrapper{
            height: 100%;
        }
    </style>
</head>
<body>
    <div id="wrapper" class="container-fluid">
        <div class="row row-wrapper">
            {{-- Меню авминки --}}
            <div class="col-2 bg-dark position-fixed h-100">
                <div class="mt-5"></div>
                @include('admin.components.navbar')
            </div>
            {{-- Контентная чсть --}}
            <div class="col-10 d-flex justify-content-end" style="width: -webkit-fill-available;">
                @include('admin.components.alert')
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
            crossorigin="anonymous"></script>
</body>
</html>
