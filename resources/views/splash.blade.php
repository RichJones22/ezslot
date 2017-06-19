@extends('layout.master')

@section('content')
    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-text brand-color">
                        <span class="name">Swing low option trading</span>
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
                    <welcome-leads-email></welcome-leads-email>
                </div>
            </div>
        </div>
    </section>
@endsection