@extends('layouts.app')
@section('title', 'Add Table')
@section('content')
<link href="css/sweetalert.css" rel="stylesheet">
<section class="content-header">
    <h1>
      Add Table
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>  Master Data</a></li>
      <li class="active">Add Table</li>
    </ol> 
</section>
    <section class="content">
      <div class="row">
        <!--<div class="col-md-3"></div>-->
        <div class="col-md-10">
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Add Table</h3>
            </div>
              <form action="{{ url('add_table') }}" method="POST" id="type_form" class="form-horizontal" >
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="lbl_type_name" class="col-sm-2 control-label">Table No.<span style="color:#ff0000;">*</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control unit_name" id="table_no" placeholder="Table No." name="table_no" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lbl_type_desc" class="col-sm-2 control-label">Capacity</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="capacity" placeholder="Table Capacity" name="capacity">
                        </div>
                    </div>
                </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success" id="btn_submit" name="btn_submit">Submit</button>
                <a href="{{url('table_data')}}" class="btn btn-danger" >Cancel</a>
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
    $('.select2').select2() 
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
 var jvalidate = $("#type_form").validate({
    rules: { 
            password : {required: true},
        },
         messages: {
             table_no: "Please Enter Table No",
             Unit_Taxvalue: "Please Enter Unit Tax Value"
           }  
    });    
</script>
@endsection
