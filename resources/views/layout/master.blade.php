<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ezSlot</title>
    <link href="{{mix('css/ezSlot.css')}}" rel="stylesheet">
</head>
<body id="page-top" class="index">

<!-- site navigation -->
@include('nav.topNav')

<!-- page content -->
@yield('content')

<!-- site Footer -->
@include('footer.appFooter')

<script src="{{mix('js/ezSlot.js')}}"></script>

</body>

</html>
