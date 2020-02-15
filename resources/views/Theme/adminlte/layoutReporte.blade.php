<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('titulo','Recetario Insuval') | Insuval</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{public_path("assets/$theme/dist/css/adminlte.min.css")}}">

    <link rel="stylesheet" href="{{public_path("assets/css/custom.css")}}">
    <link rel="stylesheet" href="{{public_path("assets/css/font.css")}}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!--Miga de pan-->

            <section class="content">
                @yield('contenido')
            </section>
            <!-- /.content -->
        </div>

    </div>
    <!-- ./wrapper -->

</body>

</html>