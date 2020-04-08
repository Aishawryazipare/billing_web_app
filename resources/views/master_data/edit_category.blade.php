@extends('layouts.app')
@section('content')
<section class="content-header">
  <h1>
    Edit Category
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Master Data</a></li>
    <li class="active">Edit Category</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <!--        <div class="col-md-3"></div>-->
    <div class="col-md-10">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Category</h3>
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
        <form action="{{ url('edit-category') }}" method="POST" id="type_form" class="form-horizontal"
          enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="box-body">
            <div class="form-group">
              <label for="lbl_cat_name" class="col-sm-2 control-label">Category<span
                  style="color:#ff0000;">*</span></label>
              <div class="col-sm-4">
                <input type="text" class="form-control special_char" id="cat_name" placeholder="Category" name="cat_name" required
                  title="Enter Category Name" oninvalid="this.setCustomValidity('Enter Valid Category Name')"
                  pattern="[a-zA-Z0-9\s]+" oninput="this.setCustomValidity('')" value="{{$category_data->cat_name}}">
                  <span id="lblError" style="color: red"></span>
              </div>
            </div>
            <input style="display:none;" type="text" class="form-control" id="cat_id" placeholder="Category"
              name="cat_id" required value="{{$category_data->cat_id}}">

          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success" id="btn_submit" name="btn_submit">Update</button>
            <a href="{{url('category_data')}}" class="btn btn-danger">Cancel</a>
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
  $(document).ready(function(){
    $('.select2').select2();
    $(".special_char").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
 
            $("#lblError").html("");
 
            //Regex for Valid Characters i.e. Alphabets and Numbers.
            var regex = /^[A-Za-z]+$/;
 
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                $("#lblError").html("Only Alphabets allowed.");
            }
 
            return isValid;
        });
 });
</script>
@endsection
