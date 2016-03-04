<?php

use Illuminate\Support\Facades\Session;
use App\Models\Dealer;

$dealerId = Session::get('dealerId');
$dealer = Dealer::findOrFail($dealerId);

?>

@include('includes.header')

<body>
<!-- main container of all the page elements -->
<div id="wrapper"> <!-- table -->
    <div class="w1">

        @include('includes.nav')
                <!-- contain main informative part of the site -->

        @yield('content')

    </div>
    <!-- footer of the page -->
    <footer id="footer">
        <div class="container f1">
            <div class="row">
                <div class="col-sm-12">
                    <span class="powered-by">POWERED BY</span>
                    <!-- footer logo -->
                    <a href="#"><img class="logo" src="/images/logo03.png" height="30" width="163" alt="builder link"></a>
                </div>
            </div>
        </div>
    </footer>
</div>

@yield('modals')

@include('includes.footer')
