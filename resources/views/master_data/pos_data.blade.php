@extends('layouts.app')
@section('title', 'Payment & POS')
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
        Payment & POS List
      </h1>
    
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>  Master Data</a></li>
        <li class="active">Payment & POS List</li>
      </ol>
    </section>
   
  <section class="content">
         <div class="row">
                <div class="col-md-6">   
   <div class="box">
            <div class="box-header">
              <h3 class="box-title">Payment LIST</h3><a href="{{url('add_payment')}}" class="panel-title" style="margin-left: 43%;color: #dc3d59;"><span class="fa fa-plus-square"></span> Add New Payment</a>
            </div>
            <!-- /.box-header -->
             <?php $x = 1; ?>
               <div class="box-body">
              <table id="example2" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                  <th style="width:50px;">Sr.No</th>
                  <th>Name</th>
                  <th style="width: 100px;">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($payment_data as $t)
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{$t->payment_type}}</td>
                            <td>
                                <a href="{{ url('edit-payment?id='.$t->id)}}"><span class="fa fa-edit"></span></a>
                                <button style="color:red;background-color: #f9f9f9;border: none;padding:1px;" class="payment_delete" id='{{$t->id}}'><span class="fa fa-trash"></span></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->     
                </div>
            </div>
             <div class="col-md-6">   
   <div class="box">
            <div class="box-header">
              <h3 class="box-title">POS LIST</h3><a href="{{url('add_pos')}}" class="panel-title" style="margin-left: 60%;color: #dc3d59;"><span class="fa fa-plus-square"></span> Add New POS</a>
            </div>
            <!-- /.box-header -->
             <?php $x = 1; ?>
               <div class="box-body">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                  <th style="width:50px;">Sr.No</th>
                  <th>Name</th>
		  <th>Counter Sell</th>
                  <th style="width: 100px;">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($point_data as $t)
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{$t->point_of_contact}}</td>
			    <td>{{$t->counter_sell}}</td>
                            <td>
                                <a href="{{ url('edit-contact?id='.$t->id)}}"><span class="fa fa-edit"></span></a>
                                <button style="color:red;background-color: #f9f9f9;border: none;padding:1px;" class="pos_delete" id='{{$t->id}}'><span class="fa fa-trash"></span></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->     
                </div>
            </div>
            
 </div>   
  </section>
 
<!-- END PAGE CONTENT WRAPPER -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){
    $(".payment_delete").on("click", function () {
        var id = this.id;
//        alert(id);
         swal({
            title: "Please Confirm",
            text: "You want to Delete Payment Type?",
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
                    url: 'delete-payment/' + id,
                    type: 'get',
                    success: function (response) {
                        swal({ type: "success", title: "Done!", confirmButtonColor: "#292929", text: "Payment Type Deleted Successfully", confirmButtonText: "Ok" }, 
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
    $(".pos_delete").on("click", function () {
        var id = this.id;
//        alert(id);
        swal({
            title: "Please Confirm",
            text: "You want to Delete POS?",
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
                    url: 'delete-contact/' + id,
                    type: 'get',
                    success: function (response) {
                        swal({ type: "success", title: "Done!", confirmButtonColor: "#292929", text: "POS Deleted Successfully", confirmButtonText: "Ok" }, 
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
    $('#example2').DataTable()
  })
</script>
@endsection
