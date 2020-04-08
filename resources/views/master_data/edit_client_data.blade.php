@extends('layouts.app')
@section('title', 'Edit Client')
@section('content')
<link rel="stylesheet" href="plugins/iCheck/square/blue.css">
<style>
    .error {
        color: red;
    }

    .has-feedback label~.form-control-feedback {
        top: 3px;
    }
</style>
<section class="content-header">
    <h1>
        Edit Client
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('client_data')}}"><i class="fa fa-dashboard"></i>Clients</a></li>
        <li class="active">Edit Client</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="box" style="border-top: 3px solid #ffffff;">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div>
                {!! Form::model($client_data,[
                'method' => 'PUT',
                'url' => ['update-client',$client_data->rid],
                'class'=> 'form-horizontal',
                'id'=>'update_client_form',
                'enctype'=>'multipart/form-data'
                ]) !!}
                {{ csrf_field() }}
                <!-- <form id="register_form" method="POST" action="{{ url('client-register') }}" aria-label="{{ __('Register') }}" enctype="multipart/form-data"> -->
                <div class="box-body">
                    <div class="form-group has-feedback">
                        <label for="reg_companyname" class="col-sm-4 control-label">Employee Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="reg_companyname" placeholder="Employee Name"
                                value="{{$client_data->reg_companyname}}" name="reg_companyname" required>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="reg_personname" class="col-sm-4 control-label">Contact Person Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="reg_personname"
                                placeholder="Contact Person Name" value="{{$client_data->reg_personname}}"
                                name="reg_personname" required>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="reg_mobileno" class="col-sm-4 control-label">Mobile</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="reg_mobileno" placeholder="Mobile"
                                value="{{$client_data->reg_mobileno}}" name="reg_mobileno" required>
                            <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="reg_emailid" class="col-sm-4 control-label">Email Address</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="reg_emailid" placeholder="Email Address"
                                value="{{$client_data->reg_emailid}}" name="reg_emailid">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="reg_address" class="col-sm-4 control-label">Address</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="reg_address" placeholder="Address"
                                value="{{$client_data->reg_address}}" name="reg_address" required>
                            <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="" class="col-sm-4 control-label"></label>
                        <div class="col-sm-8">
                            <label class="">

                                <div class="iradio_minimal-blue checked" aria-checked="true" aria-disabled="false"
                                    style="position: relative;"><input type="radio" name="location" class="minimal"
                                        value="single" style="position: absolute; opacity: 0;" required
                                        <?= ($client_data->location == "single") ? "checked" : "" ?>> Single Location
                                </div>
                            </label> <label class="">
                                <div class="iradio_minimal-blue" aria-checked="false" aria-disabled="false"
                                    style="position: relative;"><input type="radio" name="location" class="minimal"
                                        value="multiple" style="position: absolute; opacity: 0;" required
                                        <?= ($client_data->location == "multiple") ? "checked" : "" ?>> Multi Location
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="form-group has-feedback">
                        <label for="reg_username" class="col-sm-4 control-label">Username</label>
                        <div class="col-sm-8">
                            <input type="text" name="reg_username" id="reg_username" class="form-control"
                                placeholder="Username" required value="{{$client_data->reg_username}}">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="reg_userpassword" class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-8">
                            <input type="password" name="reg_userpassword" id="reg_userpassword" class="form-control"
                                placeholder="Password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="reg_companyid" class="col-sm-4 control-label">Business</label>
                        <div class="col-sm-8">
                            <input type="text" id="reg_companyid" id="reg_companyid" class="form-control"
                                placeholder="Business" value="{{$client_data->reg_companyid}}">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label for="reg_dealercode" class="col-sm-4 control-label">Dealer Code</label>
                        <div class="col-sm-8">
                            <input type="text" id="reg_dealercode" name="reg_dealercode" class="form-control"
                                placeholder="Dealer Code" value="{{$client_data->reg_dealercode}}">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="col-sm-4 control-label">Upload Logo</label>
                        <div class="col-sm-6">
                            <input type="file" id="reg_dealercode" name="upload_logo" class="form-control"
                                placeholder="Upload Logo">
                            <span class="glyphicon glyphicon-folder-open form-control-feedback"></span>
                        </div>
                        <div class="col-sm-2">
                            <a href="logo/{{$client_data->upload_logo}}" target="_blank"><img
                                    src="logo/{{$client_data->upload_logo}}" alt="{{$client_data->upload_logo}}"
                                    class="img img-thumbnail"
                                    onerror="this.onerror = null; this.src = 'logo/notfound/not-found.png';"></a>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label class="">
                            <div class="icheckbox_minimal-blue checked" aria-checked="false" aria-disabled="false"
                                style="position: relative;">
                                <input type="checkbox" class="minimal" name="permission[]" value="1" id="billing"
                                    style="position: absolute; opacity: 0;" required> Billing App
                            </div>
                        </label>
                    </div>
                </div>
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{url('client_data')}}" class="btn btn-danger">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2()
    });
</script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script type="text/javascript">
    //            $("#btnsubmit").on("click",function(){

    var jvalidate = $("#update_client_form").validate({
        rules: {
            email: {
                required: true
            }
            // ,
            // password: {
            //     required: true
            // },
        },
        messages: {
            email: "Please Enter Email Address"
            // password: "Please Enter Password"
        }
    });

    $('#btnsubmit').on('click', function() {
        $("#orderForm").valid();
    });

    $("#reg_mobileno").focusout(function() {
        var email = $(this).val();
        $.ajax({
            url: 'mobile-validate/' + email,
            type: "GET",
            success: function(data) {
                console.log(data);
                $("#mobile_validate").html(data);
                if (data != "") {
                    $("#reg_mobileno").val("");
                }
            }
        });
    });

    $("#email").focusout(function() {
        var email = $(this).val();
        $.ajax({
            url: 'email-validate/' + email,
            type: "GET",
            success: function(data) {
                console.log(data);
                $("#email_validate").html(data);
                if (data != "") {
                    $("#email").val("");
                }
            }
        });
    });

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function phoneno() {
        $('#reg_mobileno').keypress(function(e) {
            var length = jQuery(this).val().length;
            if (length > 11) {
                return false;
            } else if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            } else if ((length == 0) && (e.which == 48)) {
                return false;
            }
        });
    }
</script>
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
    $(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });
</script>
@endsection
