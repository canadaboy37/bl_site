@extends('app')

@section('content')

<main id="main" role="main">
    <section class="maincontent">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- setting-block -->
                    <section class="setting-block">
                        <h1 class="hidden-xs">settings </h1>
                        <div class="holder">
                            <div class="twocolumns">
                                <div class="col">
                                    <div class="account">
                                        <h2>account</h2>
                                        <div class="personal-details">
                                            <div class="wrap">
                                                <div class="output">{{ strtoupper($account->name) }}</div>
                                                <input type="text" value="{{ strtoupper($account->name) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="personal-info">
                                        <h2>Personal</h2>
                                        <div class="personal-details">
                                            <div class="wrap">
                                                <div class="output">{{ $user->name }}</div>
                                                <input type="text" value="Name">
                                            </div>
                                            <div class="wrap">
                                                <div class="output">{{ $user->email }}</div>
                                                <input type="text" value="Email">
                                            </div>
                                            <div class="wrap">
                                                <div class="output">{{ $user->phone }}</div>
                                                <input type="text" value="Phone">
                                            </div>
                                        </div>
                                        <a href="#" class="btn btn-default" id="personalEdit">edit info</a>
                                        <a href="#" class="btn btn-default" id="passwordChange">change password</a>
                                    </div>
                                </div>
                                <div class="col">
                                    <h2>Company</h2>
                                    <div class="wrap">
                                        <div class="output">Franklin Building Supply</div>
                                        <input type="text" value="Franklin Building Supply">
                                    </div>
                                    <div class="wrap">
                                        <div class="output">5024 Silver Feather Way</div>
                                        <input type="text" value="5024 Silver Feather Way">
                                    </div>
                                    <div class="wrap">
                                        <div class="output">Broomfield, CO</div>
                                        <input type="text" value="Broomfield, CO">
                                    </div>
                                    <div class="wrap">
                                        <div class="output">80023</div>
                                        <input type="text" value="80023">
                                    </div>
                                    <div class="wrap">
                                        <div class="output">(000) 000-0000</div>
                                        <input type="text" value="(000) 000-0000">
                                    </div>
                                    <div class="wrap">
                                        <div class="output">Franklinbuilding.com</div>
                                        <input type="text" value="Franklinbuilding.com">
                                    </div>
                                    <a href="#" class="btn btn-default">edit</a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</main>

@stop

@section('modals')

    <div class="modal fade" id="personalModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post" action="#" class="create-section-form" id="updateForm">
                        <fieldset>
                            {{ csrf_field() }}
                            <h2>EDIT PERSONAL INFO</h2>
                            <div class="has-error" id="errorMsg" style="display: none"></div>
                            <div class="form-group">
                                <span class="modal-title">Name:</span>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                                <span class="modal-title">Email:</span>
                                <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                <span class="modal-title">Phone:</span>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                            </div>
                            <button type="submit" class="btn btn-default" data-toggle="modal" id="personalSave" data-target="#myModal3">save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"> CANCEL </button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body" id="showForm">
                    <form method="post" action="#" class="create-section-form" id="passwordForm">
                        <fieldset>
                            {{ csrf_field() }}
                            <h2>Change Password</h2>
                            <div class="has-error" id="pwdError" style="display: none"></div>
                            <div class="form-group">
                                <span class="modal-title">Current Password:</span>
                                <input type="password" class="form-control" id="currentPassword" name="currentPassword">
                                <span class="modal-title">New Password:</span>
                                <input type="password" class="form-control" id="newPassword" name="newPassword">
                                <span class="modal-title">Confirm New Password:</span>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                            </div>
                            <button type="submit" class="btn btn-default" data-toggle="modal" id="passwordSave" data-target="#myModal3">save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"> CANCEL </button>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-body" id="success" style="display:none">
                    <h2>Change Password</h2>
                    <span class="modal-title">Your password has been successfully changed.</span>
                    <button type="button" class="btn btn-default" data-dismiss="modal"> close </button>
                </div>
            </div>
        </div>
    </div>
@stop


@section('scripts')

    <script type="text/javascript">
        $("#personalEdit").click(function(e){
            e.preventDefault();
            $('#personalModal').modal('toggle');
        });

        $("#passwordChange").click(function(e){
            e.preventDefault();
            $('#passwordModal').modal('toggle');
        });

        $("#personalSave").click(function(e){
            e.preventDefault();
            var form = $('updateForm');
            var dataString = form.serialize();
            $.ajax({
                type: "POST",
                url: "/settings/update",
                data: dataString,
                success: function(data) {
                    if(data.status == 'error'){
                        $("#errorMsg").text("Email address is already in use.").toggle();
                    } else {
                        $("#personalModal").modal('toggle');
                        location.reload();
                    }
                }
            });

        });

        $("#passwordSave").click(function(e){
            e.preventDefault();
            var form = $('#passwordForm');
            var dataString = form.serialize();
            $.ajax({
                type: "POST",
                url: "/settings/password",
                data: dataString,
                success: function(data) {
                    if(data.status == 'error') {
                        $("#pwdError").text("Current password is incorrect.").toggle();
                    } else if(data.status == 'validation') {
                        $("#pwdError").text("Your password must contain at least one number and one special character.").toggle();
                    } else {
                        $("#passwordForm").toggle();
                        $('#success').toggle();
                    }
                }
            });

        });

    </script>


@stop