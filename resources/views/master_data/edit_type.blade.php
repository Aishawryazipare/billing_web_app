@extends('layouts.app')
@section('title', 'Type-List')
@section('content')
<?php // echo "<pre/>";print_r($type_data);exit;?>
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<section class="content-header">
  <h1>
    Edit Unit
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Master Data</a></li>
    <li class="active">Edit Unit</li>
  </ol>
  @if (Session::has('alert-success'))
  <div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
    <h4 class="alert-heading">Success!</h4>
    {{ Session::get('alert-success') }}
  </div>
  @endif
</section>
<section class="content">
  <div class="row">
    <!--        <div class="col-md-3"></div>-->
    <div class="col-md-10">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Unit</h3>
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
        <form action="{{ url('edit-type') }}" method="POST" id="type_form" class="form-horizontal">
          {{ csrf_field() }}
          <div class="box-body">
              <span id="lblError" style="color: red"></span>
            <div class="form-group">
              <label for="lbl_type_name" class="col-sm-2 control-label">Unit Name<span
                  style="color:#ff0000;">*</span></label>
              <div class="col-sm-6">
                <input type="text" class="form-control special_char" id="type_name" placeholder="Unit Name" name="Unit_name"
                  value="{{$type_data->Unit_name}}" required title="Enter Unit Name"
                  oninvalid="this.setCustomValidity('Enter Valid Unit Name')" pattern="[a-zA-Z0-9\s]+"
                  oninput="this.setCustomValidity('')">
                <input type="hidden" class="form-control" id="type_id" placeholder="Type" name="Unit_Id"
                  value="{{$type_data->Unit_Id}}">
              </div>
            </div>
            <div class="form-group">
              <label for="lbl_type_desc" class="col-sm-2 control-label">Unit Code<span
                  style="color:#ff0000;">*</span></label>
              <div class="col-sm-6">
                <input type="text" class="form-control special_char" id="type_name" placeholder="Unit Code" name="Unit_Taxvalue"
                  value="{{$type_data->Unit_Taxvalue}}" required title="Enter Unit Code"
                  oninvalid="this.setCustomValidity('Enter Valid Unit Code')" pattern="[a-zA-Z0-9\s]+"
                  oninput="this.setCustomValidity('')">
              </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success" id="btn_submit" name="btn_submit">Update</button>
            <a href="{{url('type_data')}}" class="btn btn-danger">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(document).ready(function(){
//    alert();
    $(".delete").on("click",function(){
        return confirm('Are you sure to delete user');
    });
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
});
$(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
@endsection
