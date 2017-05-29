<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ezSlot</title>
    <link href="{{mix('css/ezSlot.css')}}" rel="stylesheet">

    <!-- Global csrfToken -->
    <script>
        let tmpToken = <?php echo json_encode([
            'csrfToken' => csrf_token(),
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

</body>

</html>
