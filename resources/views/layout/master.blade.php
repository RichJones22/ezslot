<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ezSlot</title>
    <link href="{{mix('css/ezSlot.css')}}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css" rel="stylesheet">
    {{--<link href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css" rel="stylesheet">--}}

    <!-- Global csrfToken -->
    <script>
        let tmpToken = <?php echo json_encode([
            '_token' => csrf_token(),
        ]); ?>

        window.Laravel = tmpToken;
    </script>
</head>
<body id="page-top" class="index">

<!-- site navigation -->
@include('nav.topNav')

<!-- page content -->
<div id="vueAppScope">
    @yield('content')
</div>

<!-- site footer -->
@include('footer.appFooter')

<script src="{{mix('js/ezSlot.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>

</body>

</html>
