@extends('layouts.app')
@section('title', 'Table List')
@section('content')
<link href="css/sweetalert.css" rel="stylesheet">
<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    @if (Session::has('alert-success'))
    <div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Success!</h4>
        {{ Session::get('alert-success') }}
    </div>
    @endif  
    @if (Session::has('alert-error'))
    <div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading">Error!</h4>
        {{ Session::get('alert-error') }}
    </div>
    @endif   
    <section class="content-header">
      <h1>
        Table List
      </h1>
    
      <ol class="breadcrumb">
        <!--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>-->
        <li class="active">Tables</li>
      </ol>
    </section>
   
  <section class="content">
      <div class="row">
          <div class="col-md-6">
           <div class="box">
           <div class="box-header">
              <h3 class="box-title">TABLE LIST</h3><a href="{{url('add_table')}}" class="panel-title" style="margin-left: 52%;color: #dc3d59;"><span class="fa fa-plus-square"></span> Add New Table</a>
            </div>
             <?php $x = 1; ?>
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                  <th style="width:50px;">Sr.No</th>
                  <th>Table No.</th>
                  <th>Capacity</th>
                  <th style="width: 100px;">Action</th>
                </tr>
                </thead>
                <tbody>
                 @foreach($table_data as $t)
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{$t->table_no}}</td> 
                            <td>{{$t->capacity}}</td> 
                            <td>
                            <?php 
                             if($t->is_active==0)
                          {
                              $label="success";
                              $msg="Active";
                          }
                          else
                          {
                               $label="danger";
                              $msg="Inactive";
                          }
                            if($t->is_active==0) {?>
                                <a href="{{ url('edit_table?table_id='.$t->table_id)}}"><span class="fa fa-edit"></span></a>
								<?php } ?>
                             <button style="color:red;background-color: #f9f9f9;border: none;padding:1px;" class="delete" id='{{$t->table_id}}'><small class="label label-{{$label}}">{{$msg}}</small></button>
                                
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
              <h3 class="box-title">WAITER LIST</h3><a href="{{url('add_waiter')}}" class="panel-title" style="margin-left: 50%;color: #dc3d59;"><span class="fa fa-plus-square"></span> Add New Waiter</a>
            </div>
             <?php $x = 1; ?>
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped" border="1">
                <thead>
                <tr>
                  <th style="width:50px;">Sr.No</th>
                  <th>Waiter Name</th>
                  <th style="width: 100px;">Action</th>
                </tr>
                </thead>
                <tbody>
                 @foreach($waiter_data as $t)
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{$t->waiter_name}}</td> 
                            <td>
                            <?php 
                             if($t->is_active==0)
                          {
                              $label="success";
                              $msg="Active";
                          }
                          else
                          {
                               $label="danger";
                              $msg="Inactive";
                          }
                            if($t->is_active==0) {?>
                                <a href="{{ url('edit_waiter?waiter_id='.$t->id)}}"><span class="fa fa-edit"></span></a>
								<?php } ?>
                                <button style="color:red;background-color: #f9f9f9;border: none;padding:1px;" class="delete_waiter" id='{{$t->id}}'><small class="label label-{{$label}}">{{$msg}}</small></button>
                                
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
    $(".delete").on("click", function () {
        var id = this.id;
//        alert(id);
        swal({
            title: "Please Conform",
            text: "Are you sure to Change Table Status?",
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
                   url: 'delete_table/' + id,
                    type: 'get',
                    success: function (response) {
                         location.reload();
                    }
                });
            } else {
//                        $("#Modal2").modal({backdrop: 'static', keyboard: false});
                swal("Cancelled", "", "error");
            }
        });
    })
     $(".delete_waiter").on("click", function () {
        var id = this.id;
//        alert(id);
        swal({
            title: "Please Conform",
            text: "Are you sure to Change Table Waiter?",
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
                   url: 'delete_waiter/' + id,
                    type: 'get',
                    success: function (response) {
                         location.reload();
                    }
                });
            } else {
//                        $("#Modal2").modal({backdrop: 'static', keyboard: false});
                swal("Cancelled", "", "error");
            }
        });
    })
    
});
$(function () {
//    $('#example1').DataTable()
    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'scrollX': true
    })
  })
</script>
@endsection
