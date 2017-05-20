@extends('layout.master')

@section('content')
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
                <vue-closed-trades2></vue-closed-trades2>
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
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
                    <!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
                    <form action="{{url('welcomeEmail')}}" method="POST" name="sentMessage" id="contactForm" novalidate>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                {{ csrf_field() }}
                                <label>Email Address</label>
                                <input name="email" type="email" class="form-control" placeholder="Email Address" id="email" required data-validation-required-message="Please enter your email address."/>

                                @if($errors->first('email'))
                                    <div class="alert alert-danger">
                                        <ul>
                                            <li>{{$errors->first('email')}}</li>
                                            {{--<p class="help-block text-danger">{{$errors->first('email')}}</p>--}}
                                        </ul>
                                    </div>
                                @endif
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
@endsection