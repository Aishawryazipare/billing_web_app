@extends('layouts.app')
@section('title', 'Add Customer')
@section('content')
<section class="content-header">
  <h1>
    Add Customer
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Master Data</a></li>
    <li class="active">Add Customer</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box" style="border-top: 3px solid #ffffff;border: 2px solid #00ffc3;">
        <div class="box-header">
          <h3 class="box-title"></h3>
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
        <form class="form-horizontal" id="userForm" method="post" action="{{ url('add_customer') }}" autocomplete="off">
          {{ csrf_field() }}
          <div class="box-body">
            <div class="form-group">
              <label for="userName" class="col-sm-2 control-label">Company Name</label>

              <div class="col-sm-4">
                <input type="text" class="form-control" id="userName" placeholder="Company Name"
                  name="cust_CompanyName">
              </div>
              <label for="company" class="col-sm-2 control-label">Contact Person Name<span
                  style="color:#ff0000;">*</span></label>

              <div class="col-sm-4">
                <input type="text" class="form-control" id="company" placeholder="Contact Person Name" name="cust_name"
                  required title="Enter Unit Code" oninvalid="this.setCustomValidity('Enter Valid Contact Person Name')"
                  pattern="[a-zA-Z0-9\s]+" oninput="this.setCustomValidity('')" value="{{old('cust_name')}}">
              </div>
            </div>
            <div class="form-group">
              <label for="gst" class="col-sm-2 control-label">Contact No.<span style="color:#ff0000;">*</span></label>
              <div class="col-sm-4">
                <input type="text" class="form-control number" id="contact" placeholder="Contact No" name="mobile_no"
                  maxlength="10" required pattern="[6-9]{1}[0-9]{9}" title="Enter Contact no"
                  oninvalid="this.setCustomValidity('Enter Valid Contact No')" oninput="this.setCustomValidity('')"
                  value="{{old('mobile_no')}}">
              </div>
              <label for="gst" class="col-sm-2 control-label">Email</label>
              <div class="col-sm-4">
                <input type="email" class="form-control" id="email" placeholder="Email" name="email_id"
                  pattern="[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*"
                  oninvalid="this.setCustomValidity('Enter Valid Email id')" oninput="this.setCustomValidity('')">
              </div>
            </div>
            <div class="form-group">
              <label for="gst" class="col-sm-2 control-label">GST No.</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="gst" placeholder="GST No." name="cust_companyId_or_GST">
              </div>
              <label class="col-sm-2 control-label">Address</label>
              <div class="col-sm-4">
                <textarea class="form-control" rows="3" placeholder="Enter Address..." name="address"
                  style='resize: vertical; max-width: 400px; min-width: 200px;'></textarea>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{url('customer_data')}}" class="btn btn-danger">Cancel</a>
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
    $('.number').keypress(function(event) {
                    var $this = $(this);
                    if ((event.which != 46 || $this.val().indexOf('.') != - 1) &&
                            ((event.which < 48 || event.which > 57) &&
                                    (event.which != 0 && event.which != 8))) {
                    event.preventDefault();
                    }

 });
 });
</script>
@endsection
