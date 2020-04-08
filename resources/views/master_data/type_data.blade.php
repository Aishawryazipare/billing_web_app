@extends('layouts.app')
@section('title', 'Unit-List')
@section('content')
<link href="css/sweetalert.css" rel="stylesheet">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    @if (Session::has('alert-success'))
    <div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Success!</h4>
        {{ Session::get('alert-success') }}
    </div>
    @endif  
    <section class="content-header">
      <h1>
        Unit List
      </h1>
    
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>  Master Data</a></li>
        <li class="active">Unit List</li>
      </ol>
    </section>
   
  <section class="content">
   <div class="box">
            <div class="box-header">
              <h3 class="box-title">&nbsp;</h3><a href="{{url('add_type')}}" class="panel-title" style="margin-left: 87%;color: #dc3d59;"><span class="fa fa-plus-square"></span> Add New Unit</a>
            </div>
            <!-- /.box-header -->
             <?php $x = 1; ?>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                  <th style="width:50px;">Sr.No</th>
                  <th>Name</th>
                  <th>Unit Code</th>
                  <th style="width: 100px;">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($type as $t)
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{$t->Unit_name}}</td>
                            <td>{{$t->Unit_Taxvalue}}</td>
                            <td>
                                <a href="{{ url('edit-type?type_id='.$t->Unit_Id)}}"><span class="fa fa-edit"></span></a>
                               <button style="color:red;background-color: #f9f9f9;border: none;padding:1px;" class="delete" id='{{$t->Unit_Id}}'><span class="fa fa-trash"></span></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
 </div>   
  </section>
 
<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){
    $(".delete").on("click", function () {
        var id = this.id;
//        alert(id);
    swal({
            title: "Please Confirm",
            text: "You want to Delete Unit ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e74c3c",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true,
            closeOnCancel: false,
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: 'delete-type/' + id,
                    type: 'get',
                    success: function (response) {
                        swal({ type: "success", title: "Done!", confirmButtonColor: "#292929", text: "Unit Deleted Successfully", confirmButtonText: "Ok" }, 
                                function() {
                                    location.reload();
                                });
                    }
                });
            }else {
//                        $("#Modal2").modal({backdrop: 'static', keyboard: false});
                // swal("Cancelled", "", "error");
                location.reload();
            }
        });
    })
    
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
