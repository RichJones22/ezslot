<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ezSlot</title>

    <link href="{{mix('css/ezSlot.css')}}" rel="stylesheet">

</head>

<body id="page-top" class="index">

<!-- Navigation -->
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="#page-top">slot</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse"  id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="hidden">
                    <a href="#page-top"></a>
                </li>
                <li class="page-scroll">
                    <a href="#portfolio">Results</a>
                </li>
                <li class="page-scroll">
                    <a href="#contact">Alerts</a>
                </li>
                <li class="page-scroll">
                    <a href="{{ url('/login') }}">Login</a>
                </li>
                <li class="page-scroll">
                    <a href="{{ url('/register') }}">Register</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<!-- Header -->
<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-text brand-color">
                    <span class="name">Swing low options trading</span>
                    <hr class="style17-1">
                    <p style="color: #a2a2a2;">Insights into how option selling works.&nbsp;&nbsp;Sign-up for email alerts below, and observe first hand the trials and tribulations of an options put seller.&nbsp;&nbsp;Find out if this kind of trading is right for you, by observing the risks and rewards taken by someone else.<br><br></p>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Portfolio Grid Section -->
<section id="portfolio">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center brand-color">
                <h2>Results</h2>
                <hr class="style17-1">
            </div>
        </div>
        <div class="row">
            <vue-closed-trades></vue-closed-trades>
            {{--<div class="container">--}}
                {{--<h2>Basic Table</h2>--}}
                {{--<p>The .table class adds basic styling (light padding and only horizontal dividers) to a table:</p>--}}
                {{--<table class="table">--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                        {{--<th>Firstname</th>--}}
                        {{--<th>Lastname</th>--}}
                        {{--<th>Email</th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                    {{--<tr>--}}
                        {{--<td>John</td>--}}
                        {{--<td>Doe</td>--}}
                        {{--<td>john@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Mary</td>--}}
                        {{--<td>Moe</td>--}}
                        {{--<td>mary@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>July</td>--}}
                        {{--<td>Dooley</td>--}}
                        {{--<td>july@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>John</td>--}}
                        {{--<td>Doe</td>--}}
                        {{--<td>john@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Mary</td>--}}
                        {{--<td>Moe</td>--}}
                        {{--<td>mary@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>July</td>--}}
                        {{--<td>Dooley</td>--}}
                        {{--<td>july@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>John</td>--}}
                        {{--<td>Doe</td>--}}
                        {{--<td>john@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Mary</td>--}}
                        {{--<td>Moe</td>--}}
                        {{--<td>mary@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>July</td>--}}
                        {{--<td>Dooley</td>--}}
                        {{--<td>july@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>John</td>--}}
                        {{--<td>Doe</td>--}}
                        {{--<td>john@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Mary</td>--}}
                        {{--<td>Moe</td>--}}
                        {{--<td>mary@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>July</td>--}}
                        {{--<td>Dooley</td>--}}
                        {{--<td>july@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>John</td>--}}
                        {{--<td>Doe</td>--}}
                        {{--<td>john@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Mary</td>--}}
                        {{--<td>Moe</td>--}}
                        {{--<td>mary@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>July</td>--}}
                        {{--<td>Dooley</td>--}}
                        {{--<td>july@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>John</td>--}}
                        {{--<td>Doe</td>--}}
                        {{--<td>john@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Mary</td>--}}
                        {{--<td>Moe</td>--}}
                        {{--<td>mary@example.com</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>July</td>--}}
                        {{--<td>Dooley</td>--}}
                        {{--<td>july@example.com</td>--}}
                    {{--</tr>--}}
                    {{--</tbody>--}}
                {{--</table>--}}
            {{--</div>--}}
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center brand-color">
                <h2>Alerts</h2>
                <br>
                <!--<hr class="style17-1">-->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                <form name="sentMessage" id="contactForm" novalidate>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>Email Address</label>
                            <input type="email" class="form-control" placeholder="Email Address" id="email" required data-validation-required-message="Please enter your email address.">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <br>
                    <div id="success"></div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-success btn-lg">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="text-center">
    <div class="footer-below">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    &copy; Copyright 2008-
                    <script language="JavaScript" type="text/javascript">
                        let now = new Date;
                        theYear=now.getYear();
                        if (theYear < 1900) {
                            theYear=theYear+1900;
                        }
                        document.write(theYear)
                    </script>
                    Premise Software Solutions. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
<div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
    <a class="btn btn-primary" href="#page-top">
        <i class="fa fa-chevron-up"></i>
    </a>
</div>

<script src="{{mix('js/ezSlot.js')}}"></script>
</body>

</html>
