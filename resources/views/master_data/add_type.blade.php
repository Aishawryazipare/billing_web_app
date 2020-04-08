@extends('layouts.app')
@section('content')
<link href="css/sweetalert.css" rel="stylesheet">
<section class="content-header">
  <h1>
    Add Unit
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Master Data</a></li>
    <li class="active">Add Units</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <!--<div class="col-md-3"></div>-->
    <div class="col-md-10">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Add Unit</h3>
        </div>
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div><br />
        @endif
        <form action="{{ url('add_type') }}" method="POST" id="type_form" class="form-horizontal">
          {{ csrf_field() }}
          <div class="box-body">
              <span id="lblError" style="color: red"></span>
            <div class="form-group">
              <label for="lbl_type_name" class="col-sm-2 control-label">Unit Name<span
                  style="color:#ff0000;">*</span></label>
              <div class="col-sm-6">
                <input type="text" class="form-control unit_name special_char" id="Unit_name" placeholder="Unit Value"
                  name="Unit_name" required title="Enter Unit Name"
                  oninvalid="this.setCustomValidity('Enter Valid Unit Name')" pattern="[a-zA-Z0-9\s]+"
                  oninput="this.setCustomValidity('')">
              </div>
            </div>
            <div class="form-group">
              <label for="lbl_type_desc" class="col-sm-2 control-label">Unit Code<span
                  style="color:#ff0000;">*</span></label>
              <div class="col-sm-6">
                <input type="text" class="form-control special_char" id="Unit_Taxvalue" placeholder="Unit Code" name="Unit_Taxvalue"
                  required title="Enter Unit Code" oninvalid="this.setCustomValidity('Enter Valid Unit Code')"
                  pattern="[a-zA-Z0-9\s]+" oninput="this.setCustomValidity('')">
              </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success" id="btn_submit" name="btn_submit">Submit</button>
            <a href="{{url('type_data')}}" class="btn btn-danger">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script type='text/javascript' src='js/jquery.validate.js'></script>
<script src="js/sweetalert.min.js"></script>
<script>
  $(document).ready(function(){
    $('.select2').select2();
    $(".special_char").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
 
            $("#lblError").html("");
 
            //Regex for Valid Characters i.e. Alphabets and Numbers.
            var regex = /^[A-Za-z0-9]+$/;
 
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                $("#lblError").html("Only Alphabets and Numbers allowed.");
            }
 
            return isValid;
        });
    $(".unit_name").focusout(function(){
        var category = $(this).val();
         $.ajax({
                    url: 'check-exist',
                            type: "GET",
                            data: {type:"Unit",data:category},
                            success: function(result) 
                            {
                            console.log(result);
                            var a=JSON.parse(result);
                            if(a=="Already Exist")
                            {
                                swal({
                                position: 'top-end',
                                type: 'warning',
                                title: 'Already Exist',
                                showConfirmButton: false,
                                timer: 1500
                              }); 
                            }
                        }
                    });
    });
 })
</script>
@endsection
