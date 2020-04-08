@extends('layouts.app')
@section('title', 'Edit Item')
@section('content')
<section class="content-header">
  <h1>
    Edit Item
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Master Data</a></li>
    <li class="active">Edit Item</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <!--        <div class="col-md-3"></div>-->
    <div class="col-md-12">
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Item</h3>
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
        <form action="{{ url('edit-item') }}" method="POST" id="type_form" class="form-horizontal"
          enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="box-body">
              <span id="lblError" style="color: red"></span>
            <div class="form-group">
              <label for="lbl_cat_name" class="col-sm-2 control-label">Item Name<span
                  style="color:#ff0000;">*</span></label>
              <div class="col-sm-4">
                <input type="text" class="form-control special_char" id="cat_name" placeholder="Item" name="item_name"
                  value="{{$item_data->item_name}}" maxlength="50" required title="Enter Unit Code"
                  oninvalid="this.setCustomValidity('Enter Valid Item name')" pattern="[a-zA-Z0-9\s]+"
                  oninput="this.setCustomValidity('')">
              </div>
              <label for="lbl_cat_name" class="col-sm-2 control-label">Rate<span style="color:#ff0000;">*</span></label>
              <div class="col-sm-4">
                <input type="text" class="form-control rate_cal number" id="rate" placeholder="Item Rate"
                  name="item_rate" value="{{$item_data->item_rate}}" required
                  title="Enter Item Rate" oninvalid="this.setCustomValidity('Enter Valid Item Rate')"
                  oninput="this.setCustomValidity('')">
              </div>
            </div>
            <div class="form-group">
              <label for="lbl_cat_desc" class="col-sm-2 control-label">Discount %<span
                  style="color:#ff0000;">*</span></label>
              <div class="col-sm-4">
                <input type="text" class="form-control rate_cal number" id="disc" placeholder="Item Disc"
                  name="item_dis" value="{{$item_data->item_dis}}" required>
              </div>
              <label for="lbl_cat_desc" class="col-sm-2 control-label">Discount Rate</label>
              <div class="col-sm-4">
                <input type="text" class="form-control rate_cal number" id="disc_rate" placeholder="Disc Rate"
                  name="item_disrate" value="{{$item_data->item_disrate}}" required>
              </div>
            </div>
            <div class="form-group">
              <label for="lbl_cat_desc" class="col-sm-2 control-label">Tax<span style="color:#ff0000;">*</span></label>
              <div class="col-sm-4">
                <input type="text" class="form-control rate_cal number" id="tax" placeholder="Tax" name="item_tax"
                  value="{{$item_data->item_tax}}" required>
              </div>
              <label for="lbl_cat_desc" class="col-sm-2 control-label">Tax Value</label>
              <div class="col-sm-4">
                <input type="text" class="form-control rate_cal number" id="tax_value" placeholder="Tax value"
                  name="item_taxvalue" value="{{$item_data->item_taxvalue}}" required>
              </div>
            </div>
            <div class="form-group">
              <label for="lbl_cat_desc" class="col-sm-2 control-label">Final Rate</label>
              <div class="col-sm-4">
                <input type="text" class="form-control final_rate number" id="final_rate" placeholder="Final Rate"
                  name="item_final_rate" value="{{$item_data->item_final_rate}}" readonly
                  required>
              </div>
              <label for="lbl_cat_desc" class="col-sm-2 control-label">Unit</label>
              <div class="col-sm-4">
                <select class="form-control select2" style="width: 100%;" name="item_units" required>
                  <option value="">-- Select Unit -- </option>
                  @foreach($unit_data as $u)
                  <option value="{{$u->Unit_Id}}" <?php if($u->Unit_Id==$item_data->item_units) echo "selected";?>>
                    {{$u->Unit_name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="lbl_cat_desc" class="col-sm-2 control-label">Category<span
                  style="color:#ff0000;">*</span></label>
              <div class="col-sm-4">
                <select class="form-control select2" style="width: 100%;" name="item_category" required>
                  <option value="">-- Select Category -- </option>
                  @foreach($category_data as $c)
                  <option value="{{$c->cat_id}}" <?php if($c->cat_id==$item_data->item_category) echo "selected";?>>
                    {{$c->cat_name}}</option>
                  @endforeach
                </select>
              </div>
              <label for="lbl_cat_desc" class="col-sm-2 control-label">Stock</label>
              <div class="col-sm-4">
                <input type="text" class="form-control number" id="cat_name" placeholder="Stock" name="item_stock"
                  value="{{$item_data->item_stock}}">
              </div>
            </div>
            <div class="form-group">

              <label for="lbl_cat_desc" class="col-sm-2 control-label">Bar Code</label>
              <div class="col-sm-4">
                <input type="text" class="form-control special_char" id="cat_name" placeholder="Bar Code" name="item_barcode"
                  value="{{$item_data->item_barcode}}">
              </div>
              <label for="lbl_cat_desc" class="col-sm-2 control-label">HSN No.</label>
              <div class="col-sm-4">
                <input type="text" class="form-control special_char" id="cat_name" placeholder="HSN No." name="item_hsncode"
                  value="{{$item_data->item_hsncode}}">
              </div>

              <input type="hidden" name="item_id" value="{{$item_data->item_id}}">
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-success" id="btn_submit" name="btn_submit">Update</button>
            <a href="{{url('item_data')}}" class="btn btn-danger">Cancel</a>
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

                    var text = $(this).val();
                    if ((event.which == 46) && (text.indexOf('.') == - 1)) {
                    setTimeout(function() {
                    if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                    $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
                    }
                    }, 1);
                    }

                    if ((text.indexOf('.') != - 1) &&
                            (text.substring(text.indexOf('.')).length > 2) &&
                            (event.which != 0 && event.which != 8) &&
                            ($(this)[0].selectionStart >= text.length - 2)) {
                    event.preventDefault();
                    }
                    });
       $('.number').bind("paste", function(e) {
                    var text = e.originalEvent.clipboardData.getData('Text');
                    if ($.isNumeric(text)) {
                    if ((text.substring(text.indexOf('.')).length > 3) && (text.indexOf('.') > - 1)) {
                    e.preventDefault();
                    $(this).val(text.substring(0, text.indexOf('.') + 3));
                    }
                    }
                    else {
                    e.preventDefault();
                    }
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
     $( ".rate_cal" ).keyup(function() {
    var rate=$('#rate').val();
    var disc=$('#disc').val();
    var tax=$('#tax').val();
//    alert(tax);
    var disc_r=(rate*disc)/100;
    var disc_rate=rate-disc_r
    var tax_value=(tax*disc_rate)/100;
    var final_rate=(tax_value+disc_rate);
  //  alert(final_rate);
    $('#disc_rate').val(disc_rate.toFixed(2));
    $('#tax_value').val(tax_value.toFixed(2));
    $('.final_rate').val(final_rate.toFixed(2));
    
});
});
</script>
@endsection
