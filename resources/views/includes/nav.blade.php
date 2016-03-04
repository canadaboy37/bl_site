
    <!-- header of the page -->
    <header id="header">
        <div class="header-top hidden-xs">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- page logo -->
                        <div class="logo"><a href="/"><img src="/images/logo02.png" height="49" width="191" alt="franklin building supply service is our specialty"></a></div>
                    </div>
                    <div class="col-sm-6">
                        <!-- add nav -->
                        <ul class="nav navbar-nav navbar-right">
                            @if (Session::has('whoAmI'))
                                <li><a href="/logInAsMe">LOG IN AS ME</a></li>
                            @endif
                            <li><a href="/account">MY ACCOUNT</a></li>
                            <li><a href="/settings">SETTINGS</a></li>
                            <li><a href="/logout">LOGOUT</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">

                        @include('includes.subnav')

                    </div>
                </div>
            </div>
        </div>
    </header>
