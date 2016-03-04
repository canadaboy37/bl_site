@include('includes.header');

<body class="login-page">
<!-- main container of all the page elements -->
<div id="wrapper"> <!-- table -->
    <div class="w1">
        <div class="login-block">
            <div class="container small-container">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- page logo -->
                        <div class="logo"><a href="#"><img src="images/logo.png" height="163" width="635" alt="franklin building supply service is our specialty"></a></div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-info">
                        <h2>REGISTER NOW</h2>
                        <span class="asterisk_label col-md-4">These fields are required.</span><br />
                    </div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Display Name" name="name" value="{{ old('name') }}">
                                    <span class="asterisk_input"></span>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="Email Address" name="email" value="{{ old('email') }}">
                                    <span class="asterisk_input"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Phone" name="phone" value="{{ old('phone')  }}">
                                    <span class="asterisk_input"></span>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}">
                                    <span class="asterisk_input"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <input type="password" placeholder="Password" class="form-control" name="password">
                                    <span class="asterisk_input"></span>
                                </div>
                                <div class="col-md-6">
                                    <input type="password" placeholder="Verify Password" class="form-control" name="password_confirmation">
                                    <span class="asterisk_input"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-1 control-label">iNet Pro</label>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <input type="text" placeholder="Username" class="form-control" name="inetpro_username">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" placeholder="Account Number" class="form-control" name="inetpro_account">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-1">
                                    <div class="g-recaptcha" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-1">
                                    <input type="submit" class="btn btn-default" value="register">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

                        <!-- login footer -->
                        <footer class="login-footer">
                            <strong class="tilte">POWERED BY</strong>
                            <!-- footer logo -->
                            <strong class="logo"><a href="#"><img src="images/logo01.png" height="47" width="259" alt="builder link"></a></strong>
                        </footer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('includes.footer');


