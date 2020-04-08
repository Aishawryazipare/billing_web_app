@extends('layouts.app')
@section('content')
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
        Main Setting
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Settings</a></li>
        <li class="active">Main Setting</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Main Setting</h3>
                    <?php if($flag==1) {?>
                    <button type="button" class="btn btn-success" id="sync_btn" name="sync_btn"
                        style="margin-left:83%"><i class="fa fa-fw fa-cloud-upload"></i>Sync</button>
                    <?php } ?>
                </div>
                <form action="{{ url('main-setting') }}" method="POST" id="type_form" class="form-horizontal"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group" id="div1">
                            <label for="lbl_cat_name" class="col-sm-2 control-label">Page size</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" style="width: 100%;" name="page_size"
                                    id="page_size">
                                    @if(!empty($hf_setting))
                                    @if($hf_setting->page_size!=null)
                                    <option value="{{$hf_setting->page_size}}">{{$hf_setting->page_size}}</option>
                                    @endif
                                    @else
                                    <option value="">Select</option>
                                    @endif
                                    <option value="3 inch">3 inch</option>
                                    <option value="2 inch">2 inch</option>
                                    <option value="A5">A5</option>
                                    <option value="other">other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lbl_cat_name" class="col-sm-2 control-label">Bill GST Setting</label>
                            @if(@$hf_setting->gst_setting=="Yes")
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="gst_setting" value="Yes" checked>GST Enable
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gst_setting" value="No">GST Disable
                                </label>
                            </div>
                            @else
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="gst_setting" value="Yes">GST Enable
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gst_setting" value="No" checked>GST Disable
                                </label>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="lbl_cat_name" class="col-sm-2 control-label">Bill Printing</label>
                            @if(@$hf_setting->bill_printing=="Yes")
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="bill_printing" value="Yes" checked>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="bill_printing" value="No">No
                                </label>
                            </div>
                            @else
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="bill_printing" value="Yes">Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="bill_printing" value="No" checked>No
                                </label>
                            </div>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="lbl_cat_name" class="col-sm-2 control-label">Multiple Print</label>
                            @if(@$hf_setting->multiple_print=="Yes")
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="multiple_print" value="Yes" checked>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="multiple_print" value="No">No
                                </label>
                            </div>
                            @else
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="multiple_print" value="Yes">Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="multiple_print" value="No" checked>No
                                </label>
                            </div>
                            @endif
                        </div>
                        <div class="form-group" style="display:none;">
                            <label for="lbl_cat_name" class="col-sm-2 control-label">Reset Bill Number</label>
                            @if(@$hf_setting->reset_bill=="Yes")
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="reset_bill" value="Yes" checked>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="reset_bill" value="No">No
                                </label>
                            </div>
                            @else
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="reset_bill" value="Yes">Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="reset_bill" value="No" checked>No
                                </label>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="lbl_cat_name" class="col-sm-2 control-label">Point Of Contact</label>
                            @if(@$hf_setting->point_of_contact=="Yes")
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="point_of_contact" value="Yes" checked>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="point_of_contact" value="No">No
                                </label>
                            </div>
                            @else
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="point_of_contact" value="Yes">Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="point_of_contact" value="No" checked>No
                                </label>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="lbl_cat_name" class="col-sm-2 control-label">Payment Method</label>
                            @if(@$hf_setting->payment_method=="Yes")
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="payment_method" value="Yes" checked>Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="payment_method" value="No">No
                                </label>
                            </div>
                            @else
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="payment_method" value="Yes">Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="payment_method" value="No" checked>No
                                </label>
                            </div>
                            @endif
                        </div>
                        <?php if($res_sync)
                        {?>
                        <div class="form-group">
                            <label for="lbl_cat_name" class="col-sm-2 control-label">Upload Time</label>
                            <?php $milisec = 3600000;
                            
                                $up_time=($res_sync->upload_interval)/$milisec;?>

                            @if(@$res_sync->upload_interval)
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="up_time" value="1" <?= ($up_time==1)?"checked":"";?>>1
                                    Hour
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="up_time" value="2" <?= ($up_time==2)?"checked":"";?>>2
                                    Hours
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="up_time" value="3" <?= ($up_time==3)?"checked":"";?>>3
                                    Hours
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="up_time" value="6" <?= ($up_time==6)?"checked":"";?>>6
                                    Hours
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="up_time" value="24" <?= ($up_time==24)?"checked":"";?>>1
                                    Day
                                </label>
                            </div>
                            @else
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="up_time" value="1" checked>1 Hour
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="up_time" value="2">2 Hours
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="up_time" value="3">3 Hours
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="up_time" value="6">6 Hours
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="up_time" value="24">1 Day
                                </label>
                            </div>
                            @endif
                        </div>
                        <?php }?>
                        <?php if($res_sync){
                            ?>
                        <div class="form-group">
                            <label for="lbl_cat_name" class="col-sm-2 control-label">Download Time</label>
                            <?php 
                            
                            $down_time = ($res_sync->download_interval)/$milisec;
                            ?>
                            @if(@$res_sync->download_interval)
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="down_time" value="1" <?= ($down_time==1)?"checked":"";?>>1
                                    Hour
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="down_time" value="2" <?= ($down_time==2)?"checked":"";?>>2
                                    Hours
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="down_time" value="3" <?= ($down_time==3)?"checked":"";?>>3
                                    Hours
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="down_time" value="6" <?= ($down_time==6)?"checked":"";?>>6
                                    Hours
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="down_time" value="24"
                                        <?= ($down_time==24)?"checked":"";?>>1
                                    Day
                                </label>
                            </div>
                            @else
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="down_time" value="1" checked>1 Hour
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="down_time" value="2">2 Hours
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="down_time" value="3">3 Hours
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="down_time" value="6">6 Hours
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="down_time" value="24">1 Day
                                </label>
                            </div>
                            @endif
                        </div>
                        <?php }?>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success" id="btn_submit" name="btn_submit">Submit</button>
                        <a href="{{url('main-setting')}}" class="btn btn-danger">Cancel</a>
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
//    alert("hi");
    $.ajax({
                url: 'get_setting_details',
                type: "get",
                success: function(reportdata) {
                        console.log(reportdata);
                        var data1 = JSON.parse(reportdata);
                           
                        if(data1!="")
                        {
                            $("#h1").val(data1.h1);
                            $("#h2").val(data1.h2);
                            $("#h3").val(data1.h3);
                            $("#h4").val(data1.h4);
                            $("#h5").val(data1.h5);
                            $("#f1").val(data1.f1);
                            $("#f2").val(data1.f2);
                            $("#f3").val(data1.f3);
                            $("#f4").val(data1.f4);
                            $("#f5").val(data1.f5);
                            if(data1!="")
                        {
                            if(data1.h1!=null)
                            {
                                 $("#print_content").append('<center><h5><b>'+data1.h1+'</b></h5></center>');
                            }
                            if(data1.h2!=null)
                            {
                                 $("#print_content").append('<center><h5><b>'+data1.h2+'</b></h5></center>');
                            }
                            if(data1.h3!=null)
                            {
                                 $("#print_content").append('<center><h5><b>'+data1.h3+'</b></h5></center>');
                            }
                            if(data1.h4!=null)
                            {
                                 $("#print_content").append('<center><h5><b>'+data1.h4+'</b></h5></center>');
                            }
                            if(data1.h5!=null)
                            {
                                 $("#print_content").append('<center><h5><b>'+data1.h5+'</b></h5></center>');
                            }
                            $("#print_content").append('<center>Billing content to print in the page</center>');
                            if(data1.f1!=null)
                            {
                                 $("#print_content").append('<center><h5><b>'+data1.f1+'</b></h5></center>');
                            }
                            
                        }
                        }
                        else
                        {
                            $("#h1").val("");
                            $("#h2").val("");
                            $("#h3").val("");
                            $("#h4").val("");
                            $("#h5").val("");
                            $("#f1").val("");
                            $("#f2").val("");
                            $("#f3").val("");
                            $("#f4").val("");
                            $("#f5").val("");
                        }
                }
                });  
                 $("#btn_print").click(function(){
                $.ajax({
                url: 'bill_print',
                type: "get",
                success: function(reportdata) {
                        console.log(reportdata);
                        var data1 = JSON.parse(reportdata);
                           
                        
                }
                });  
                });
				$( "#sync_btn" ).click(function() {
        var msg="Inventory";
        $.ajax({
                url: 'sync_category',
                type: "GET",
                data: {data:msg},
                success: function(result) 
                {
                    var res=JSON.parse(result);
                    console.log(res); 
                }
            });
    });
                
                
});
</script>
@endsection
