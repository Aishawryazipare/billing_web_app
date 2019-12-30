@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<style>
    .error{
        color:red;
    }
</style>
<section class="content-header">
      <h1>
          Edit User
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('user_mgt')}}"><i class="fa fa-dashboard"></i>User</a></li>
        <li class="active">Edit User</li>
      </ol>
    </section>
<section class="content">
<div class="row">
 <div class="col-md-8">
          <div class="box" style="border-top: 3px solid #ffffff;">
            <div class="box-header">
              <h3 class="box-title"></h3>
            </div>
            {!! Form::model($userData,[
                        'method' => 'PUT',
                        'url' => ['update-user',$userData->id],
                        'class'=> 'form-horizontal',
                        'id'=>'orderForm'
                    ]) !!}
                {{ csrf_field() }}
              <div class="box-body">
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Employee Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" placeholder="Employee Name" value="{{$userData->name}}" name="name" required >
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="company" class="col-sm-4 control-label">Role</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" style="width: 100%;" name="role" required>
                                    <option value="">-- Select Role -- </option>
                                    <option value="1"<?php if($userData->role == "1") echo "selected"; ?>>Admin</option>
                                    <option value="2"<?php if($userData->role == "2") echo "selected"; ?>>Employee</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Email</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="email" placeholder="Email" value="{{$userData->email}}" name="email" required >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="password" placeholder="Password" value="" name="password"  >
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Mobile No</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="mobile_no" placeholder="Mobile No" value="{{$userData->mobile_no}}" name="mobile_no" required >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-sm-4 control-label">Address</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="address" placeholder="Address" name="address" style='resize: vertical; max-width: 600px; min-width: 200px;' required >{{$userData->address}}</textarea>
                            </div>
                        </div>
                    </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-success">Update</button>
                  <a href="{{url('user-list')}}" class="btn btn-danger" >Cancel</a>
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
    $('.select2').select2() 
 });
</script>
@endsection
