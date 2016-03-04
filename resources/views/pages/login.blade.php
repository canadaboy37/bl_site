@include('includes.header')

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
                        <!-- login form -->
                        <form action="/login" method="post" class="login-form">
                            @if(session()->has('message'))
                                <div class="error">{{ session('message') }}</div>
                            @endif
                            <fieldset>
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="text" name="email" placeholder="Username" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" placeholder="Password" class="form-control">
                                </div>
                                <input type="submit" value="login">
                                @if($errors->any())
                                    <div class="wrap">
                                        {{$errors->first()}}
                                    </div>
                                @endif
                                <div class="wrap">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> <span class="text">Remember Me</span>
                                        </label>
                                    </div>
                                    <ul class="links">
                                        <li><a href="#" data-toggle="modal" data-target="#usernameModal">Forgot Username</a></li>
                                        <li><a href="#" data-toggle="modal" data-target="#passwordModal">Forgot Password</a></li>
                                    </ul>
                                </div>
                            </fieldset>
                        </form>
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

<!-- modal of forgot username -->
<div class="modal fade" id="usernameModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" action="/username" id="forgotUsername" class="create-section-form">
                    <fieldset>
                        {{ csrf_field() }}
                        <h2>Forgot Username?</h2>
                        <span class="job-title">Enter the E-mail address associated with your account.</span>
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" placeholder="E-mail address">
                        </div>
                        <button class="btn btn-default" id="usernameSubmit" data-target="#myModal3"> SUBMIT </button>
                        <button class="btn btn-default" data-dismiss="modal"> CANCEL </button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modal of forgot password  -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" action="/password/email" id="passwordReset" class="create-section-form">
                    <fieldset>
                        {!! csrf_field() !!}
                        <input type="hidden" name="token" value="{{ csrf_token() }}" />
                        <h2>Password Reset?</h2>
                        <span class="job-title">E-Mail Address</span>
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" placeholder="E-mail address">
                        </div>
                        <button class="btn btn-default"> SUBMIT </button>
                        <button class="btn btn-default" data-dismiss="modal"> CANCEL </button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')

<script type="text/javascript">

$('#usernameSubmit').click(function(event) {
    event.preventDefault();
    var form = $('#forgotUsername');
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function(data){
            $('.modal-body').html('<p>' + data.status + '</p><button class="btn btn-default" data-dismiss="modal"> CLOSE </button>');
        }
    });
});

$('#passwordReset').submit(function(event) {
    event.preventDefault();
    var form = $(this);
    var newHTML = "<p>Your password reset link has been emailed to you.</p><button type='button' class='btn btn-default' data-dismiss='modal'> CLOSE </button>"
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function(data){
            $('.modal-body').html(newHTML);
        }
    })
});

</script>
@stop


@include('includes.footer')