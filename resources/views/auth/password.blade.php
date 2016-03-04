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
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Reset Password</div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

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

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Send Password Reset Link
                                    </button>
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