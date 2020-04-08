@extends('layouts.app')
@section('content')
<style>
    .example-modal .modal {
        position: relative;
        top: auto;
        bottom: auto;
        right: auto;
        left: auto;
        display: block;
        z-index: 1;
    }

    .example-modal .modal {
        background: transparent !important;
    }
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
    /* The container */
    @font-face {
        font-family: "Fake Reciept";
        src: url('fake receipt.ttf')
    }

    .container {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 18px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default radio button */
    .container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
    }

    /* On mouse-over, add a grey background color */
    .container:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .container input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container input:checked~.checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .container .checkmark:after {
        top: 9px;
        left: 9px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }

    .serial_no {
        pointer-events: none;
        font-size: 15px;
    }

    .tbl_width_oveflow {
        max-height: 500px;
        overflow: auto;
    }

    .btn btn-block btn-default {
        font-family: Fake Reciept;
    }

    @media print {
        .print_content {
            font-family: "Courier New" !important;
            font-size: 30px !important;
        }

        .tbl_width_oveflow {
            max-height: 0px;
            overflow: hidden;
        }

        .serial_no {
            font-size: 20px;
        }

        .item_name {
            font-family: Fake Reciept;
        }

        .clear_item {
            display: none;
        }

        @page {
            size: A4 portrait;
            margin-top: 4cm;
            margin-bottom: 1cm;
            margin-right: 1cm;
            margin-left: 1cm;
            font-family: Fake Reciept;
            font-size: 10px !important;
        }

        html,
        body {
            height: 100%;
            width: 100%;
        }
    }
</style>
<link href="css/sweetalert.css" rel="stylesheet">
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
<section class="content-header" style="padding-top: 0px;">
    <h1>
        Sales Form
    </h1>
    <!--    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Sales</a></li>
      <li class="active">Thumbnail Form</li>
    </ol> -->
</section>
<section class="content">
    <form action="{{ url('add_bill') }}" method="POST" id="bill_form" class="form-horizontal"
        enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="search_code" id="search_code" class="form-control"
                    placeholder="Search By Name/Code/Barcode" />
                <!--<input type="text" name="search_code" id="search_code" class="form-control" onblur="get_code(this.value)" placeholder="Search By Name/Code/Barcode"/>-->
                <div id="countryList">
                </div>
            </div>
            <div class="col-md-2">
                <input list="browsers" name="cust_name" class="form-control" onkeyup="assign_name(this.value)"
                    placeholder="Customer Name">

                <datalist id="browsers">
                    @foreach($customer_data as $data)
                    <option>{{$data->cust_name}}</option>
                    @endforeach
                </datalist>
            </div>
            <div class="col-md-2" style="width:13%;">
                <!--                <div class="form-group">
                    <label class="radio-inline">
      <input type="radio" name="cash_or_credit1" value="cash" checked>Card
    </label>
    <label class="radio-inline">
      <input type="radio" name="cash_or_credit1" value="cash">Cash
    </label>
                </div>-->
                <select class="form-control select2" style="width: 100%;" name="payment_type" id="payment_type">
                    <option value="">Select Payment Type</option>
                    @foreach($payment_type as $d)
                    <option value="{{$d->payment_type}}">{{$d->payment_type}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1" style="width: 4px;margin-left: -15px;margin-top: 10px;">
                <i class="fa fa-fw fa-credit-card remove_field" data-toggle="modal" data-target="#bill_modal"
                    style="color: black;"></i>
            </div>
            <div class="col-md-1" style="width:176px;">

                <!--<input list="point_of_contact" name="point_of_contact" class="form-control" placeholder="Point Of Sales">-->
                <select class="form-control select2" style="width: 100%;" name="point_of_contact" id="point_of_contact">
                    <option value="">Select Point Of Contact</option>
                    @foreach($point_of_contact as $d)
                    <option value="{{$d->point_of_contact}}">{{$d->point_of_contact}}</option>
                    @endforeach
                </select>


            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-default" style="max-height:600px;overflow:auto;">
                    <!--            <div class="box-header with-border">
              <h3 class="box-title">Bill No:1</h3>
            </div>-->

                    <div class="box-body">
                        <?php  foreach($category_data as $data){?>
                        <button type="button" class="btn btn-success btn-lg cat"
                            id="btn_submit_<?php echo $data->cat_id;?>" name="btn_submit"
                            style="background-color:#00ffc3;color:black;margin-bottom:5px;font-weight:bold;width:96px;overflow: hidden;text-overflow: ellipsis;white-space:normal;margin-right:-4px;height:50px;font-size:14px;"
                            onclick="get_items(<?php echo $data->cat_id;?>,0)">{{$data->cat_name}}</button>
                        <span class="info-box-number cat_id" style="display:none;">
                            <h2>{{$data->cat_id}}</h2>
                        </span>

                        <?php }$all=0; ?>
                        <button type="button" class="btn btn-success btn-lg" id="btn_submit1" name="btn_submit"
                            style="background-color:#00ffc3;color:black;margin-top: -5px;font-weight:bold;height:50px;font-size:14px;width:96px;"
                            onclick="get_items(<?php echo $all;?>),0">All Items</button>
                        <br />
                        <br />

                        <div id="item_data">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 table-responsive" id="print_content">

                <div class="box box-default tbl_width_oveflow">
                    <div class="box-body">
                        <div id="set_header">
                            @if(!empty($hf_setting))
                            @if($hf_setting->h1!=null)
                            <h2>
                                <center>{{$hf_setting->h1}}</center>
                            </h2>
                            @endif
                            @if($hf_setting->h2!=null)
                            <h4>
                                <center>{{$hf_setting->h2}}</center>
                            </h4>
                            @endif
                            @if($hf_setting->h3!=null)
                            <h4>
                                <center>{{$hf_setting->h3}}</center>
                            </h4>
                            @endif
                            @if($hf_setting->h4!=null)
                            <h4>
                                <center>{{$hf_setting->h4}}</center>
                            </h4>
                            @endif
                            @if($hf_setting->h5!=null)
                            <h4>
                                <center>{{$hf_setting->h5}}</center>
                            </h4>
                            @endif


                            @endif
                            @if(!empty($hf_setting))
                            <input type="hidden" id="gst_setting" name="gst_setting"
                                value="{{$hf_setting->gst_setting}}">
                            @else
                            <input type="hidden" id="gst_setting" name="gst_setting" value="No">
                            @endif
                            <hr>
                            <table width="100%">
                                <tr>
                                    <td class='print_1'><b>Bill No: {{@$bill_data->bill_no+1}}</b></td>
                                    <td class='print_1' style="text-align: right;"><b>Date: <?php echo date('Y-m-d');?> <?php
                                date_default_timezone_set("Asia/Kolkata");
                                echo date("h:i:sa");
                                ?></b></td>
                                    <!--<td class='print_1'><b>Customer Name: {{@$bill_data->bill_no+1}}</b></td>-->
                                </tr>
                            </table>
                        </div>
                        <input type="hidden" id="bil_no" name="bil_no"
                            value="<?php if(isset($bill_data->bill_no)) echo $bill_data->bill_no; else echo "1"; ?>">
                        <h4 align="center" id="bill_no">Bill No:
                            <?php if(isset($bill_data->bill_no)) echo ($bill_data->bill_no+1); else echo "1"; ?></h4>
                        <div class="row">
                            <div class="col-md-6"><span id="cust_data"></span><input type="hidden" name="cust_name"
                                    id="cust_name" class="form-control" /></div>
                            <div class="col-md-6"><span id="date" style="margin-left: 100px;"></span></div>
                            <input type="hidden" name="cash_or_credit" id="cash_or_cerdit" value="cash" />
                        </div>
                        <br />
                        <table border="0" width="100%" id="h_lost">
                            <thead>
                                <tr>
                                    <th> No</th>
                                    <th style="width:200px;">Item Name</th>
                                    <th>Qty</th>
                                    <th>Rate</th>
                                    @if(!empty($hf_setting))
                                    @if($hf_setting->gst_setting=="Yes")
                                    <th class="gst">Dis</th>
                                    <th class="gst">Tax</th>
                                    @endif
                                    @endif
                                    <th>Amt</th>
                                </tr>
                            </thead>
                            <tbody id="bill_tbl">
                                <tr class="row1">
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    @if(!empty($hf_setting))
                                    @if($hf_setting->gst_setting=="Yes")
                                    <td></td>
                                    <td></td>
                                    <!--<th class="gst">Tax</th>-->
                                    @endif
                                    @endif
                                    <td style="font-weight: bold;" class="print">Total</td>
                                    <td style="font-weight: bold;"> <input type="text" class="print"
                                            name="bill_totalamt" class="bill_totalamt" id="bill_totalamt"
                                            style="border:none;width:70px;text-align:center;" value="0" readonly /></td>
                                </tr>
                            </tbody>

                        </table>
                        <div id="set_footer">
                            <hr>
                            @if(!empty($hf_setting))
                            @if($hf_setting->f1!=null)
                            <h2>
                                <center>{{$hf_setting->f1}}</center>
                            </h2>
                            @endif
                            @if($hf_setting->f2!=null)
                            <h4>
                                <center>{{$hf_setting->f2}}</center>
                            </h4>
                            @endif
                            @if($hf_setting->f3!=null)
                            <h4>
                                <center>{{$hf_setting->f3}}</center>
                            </h4>
                            @endif
                            @if($hf_setting->f4!=null)
                            <h4>
                                <center>{{$hf_setting->f4}}</center>
                            </h4>
                            @endif
                            @if($hf_setting->f5!=null)
                            <h4>
                                <center>{{$hf_setting->f5}}</center>
                            </h4>
                            @endif
                            @endif
                        </div>

                    </div>
                    <div class="box-footer">
                        @if(@$hf_setting->bill_printing=="Yes")
                        <button type="button" style="" class="btn btn-success pull-right" id="print_bill"><i
                                class="fa fa-credit-card"></i> Print Bill
                        </button>
                        @else
                        <button type="button" style="display:none;" class="btn btn-success pull-right"
                            id="print_bill"><i class="fa fa-credit-card"></i> Print Bill
                        </button>
                        @endif
                        <?php if(isset($bill_data->bill_no)) $b_no=$bill_data->bill_no; else $b_no="1";?>
                        <!--          <a href="{{ url('download_bill?bill_no='.$b_no)}}"><button type="button" id="dwn_pdf" class="btn btn-success pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Download Bill
          </button></a>-->
                        <button type="button" class="btn btn-danger clear_item" id="clear_item"><i
                                class="fa fa-credit-card"></i> Clear Item
                        </button>
                        <button type="button" class="btn btn-success pull-right" id="save_bill"
                            style="margin-right: 5px;">
                            <i class="fa fa-download"></i> Generate Bill
                        </button>


                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="bill_modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Payment & Order Details</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="lbl_cat_name" class="col-sm-2 control-label">Transaction ID</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="cat_name" placeholder="Transaction ID"
                                    name="payment_details[0]">
                            </div>
                            <label for="lbl_cat_name" class="col-sm-2 control-label">Transaction Status</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" style="width: 100%;" name="payment_details[1]"
                                    id="payment_details">
                                    <option value="">--Transaction Status--</option>
                                    <option value="Success">Success</option>
                                    <option value="Fail">Fail</option>
                                    <option value="Processing">Processing</option>
                                </select>
                                <!--<input type="text" class="form-control rate_cal" id="rate" placeholder="Transaction Status" name="payment_details[1]">-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lbl_cat_name" class="col-sm-2 control-label">Transaction<br />Details</label>
                            <div class="col-sm-4">
                                <textarea class="form-control" rows="3" name="payment_details[2]"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lbl_cat_name" class="col-sm-2 control-label">Order<br />Details</label>
                            <div class="col-sm-4">
                                <textarea class="form-control" rows="3" name="order_details[0]"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </form>
    <div class="row">
        <div id="item_data">

        </div>
    </div>
    <input type="hidden" id="new_bill_no" name="new_bill_no">
</section>
<!--<script src="bower_components/jquery/dist/jquery.min.js"></script>-->
<!--<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>-->
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="js/sweetalert.min.js"></script>
<script>
    $(document.body).addClass('skin-blue sidebar-mini sidebar-collapse');
var gst=$("#gst_sett").val();
var i=1;
$(document).ready(function(){
   $("#search_code").keydown(function (e) {
       $('.focus_this').removeClass('focus_this');
 //  alert(e.which);
   if (e.which == 9)
   {
        var code=$(this).val();
             var flag=0;
    // alert(flag);
                $.ajax({
                            url: 'check-code',
                            type: "GET",
                            data: {code:code},
                            success: function(result) 
                            {
                            console.log(result);
                            var a=JSON.parse(result);
                            var item=a.item_name;
                            var rate=a.item_rate;
                            var disc=a.item_dis;
                            var tax=a.item_tax;
                            var qty=1;
                            var amt=parseFloat(rate)*parseFloat(qty);
                            $('.item_name').each(function() {
    var prev_item=$(this).val();
    if(item==prev_item)
    {
//        alert($(this).closest('.item_qty').val());
        prev_qty=$(this).closest('tr').find('.item_qty').val();
        var rate=$(this).closest('tr').find('.item_rate').val();
        new_qty=parseFloat(prev_qty)+1;
        var amt=parseFloat(new_qty)*parseFloat(rate);
        $(this).closest('tr').find('.item_qty').val(new_qty);
        $(this).closest('tr').find('.item_amt').val(amt);
        flag=1;
        return false;
    }
    
});
$('.item_qty').blur();
if(flag==0)
{
    var j = $("#bill_tbl").find("tr").length;
    if(gst=="Yes")
    {
         $(".row1:last").before("<tr class='input_fields_wrap'>\n\
                    <td style='text-align:center;'><input type='text' value='"+j+"' class='form-control serial_no' style='width:60px;border:none;text-align:center;'></td>\n\
                    <td style='text-align:center;'><textarea name='stoppage[" + i + "][1]' class='form-control item_name print' cols='10' style='border:none;resize:none;width:200px;height:33px;background-color:#ffffff;' readonly>" + item + "</textarea></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][2]' class='form-control item_qty print focus_this' id='item_qty_" + i + "'  value='" + qty + "' style='width:50px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][3]' class='form-control item_rate print' id='item_rate_" + i + "' value='" + rate + "' style='width:60px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
                    <td style='text-align:center;' class='gst'><input type='text' name='stoppage[" + i + "][4]' class='form-control item_disc print' id='item_disc_" + i + "' value='" + disc + "' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;' class='gst'><input type='text' name='stoppage[" + i + "][5]' class='form-control item_tax print' id='item_tax_" + i + "' value='" + tax + "' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][6]' class='form-control item_amt print' id='item_amt_" + i + "' value='" + amt + "' style='border:none;width:80px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
\n\                 <td style='text-align:center;'><i class='fa fa-fw fa-times remove_field' style='color: red;'></i></td>\n\
            </tr>");
    }
    else
    {
         $(".row1:last").before("<tr class='input_fields_wrap'>\n\
                    <td style='text-align:center;'><input type='text' value='"+j+"' class='form-control serial_no' style='width:60px;border:none;text-align:center;'></td>\n\
                    <td style='text-align:center;'><textarea name='stoppage[" + i + "][1]' class='form-control item_name print' cols='10' style='border:none;resize:none;width:200px;height:33px;background-color:#ffffff;' readonly>" + item + "</textarea></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][2]' class='form-control item_qty print focus_this' id='item_qty_" + i + "'  value='" + qty + "' style='width:50px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][3]' class='form-control item_rate print' id='item_rate_" + i + "' value='" + rate + "' style='width:60px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
\n\                  <td style='text-align:center;display:none;' class='gst'><input type='text' name='stoppage[" + i + "][4]' class='form-control item_disc print' id='item_disc_" + i + "' value='0' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;display:none;' class='gst'><input type='text' name='stoppage[" + i + "][5]' class='form-control item_tax print' id='item_tax_" + i + "' value='0' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][6]' class='form-control item_amt print' id='item_amt_" + i + "' value='" + amt + "' style='border:none;width:80px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
\n\                 <td style='text-align:center;'><i class='fa fa-fw fa-times remove_field' style='color: red;'></i></td>\n\
            </tr>");
    }
     $(".focus_this").focus();
    $("#h_lost").find(".item_qty").last().focus();

     i++;
      var total=$('#bill_totalamt').val();
     total=parseFloat(total)+parseFloat(rate);
    // alert(total)
       $('#bill_totalamt').val(total.toFixed(2));
}
                            }
                    });
                    $('#search_code').val("");
                    $('#save_bill').click();
   }
   if (e.which == 13)
   {
      var code=$(this).val();
             var flag=0;
    // alert(flag);
                $.ajax({
                            url: 'check-code',
                            type: "GET",
                            data: {code:code},
                            success: function(result) 
                            {
                            console.log(result);
                            var a=JSON.parse(result);
                            var item=a.item_name;
                            var rate=a.item_rate;
                            var disc=a.item_dis;
                            var tax=a.item_tax;
                            var qty=1;
                            var amt=parseFloat(rate)*parseFloat(qty);
                            $('.item_name').each(function() {
    var prev_item=$(this).val();
    if(item==prev_item)
    {
//        alert($(this).closest('.item_qty').val());
        prev_qty=$(this).closest('tr').find('.item_qty').val();
        var rate=$(this).closest('tr').find('.item_rate').val();
        new_qty=parseFloat(prev_qty)+1;
        var amt=parseFloat(new_qty)*parseFloat(rate);
        $(this).closest('tr').find('.item_qty').val(new_qty);
        $(this).closest('tr').find('.item_amt').val(amt);
        flag=1;
        return false;
    }
    
});
if(flag==0)
{
    var j = $("#bill_tbl").find("tr").length;
    if(gst=="Yes")
    {
         $(".row1:last").before("<tr class='input_fields_wrap'>\n\
                    <td style='text-align:center;'><input type='text' value='"+j+"' class='form-control serial_no' style='width:60px;border:none;text-align:center;'></td>\n\
                    <td style='text-align:center;'><textarea name='stoppage[" + i + "][1]' class='form-control item_name print' cols='10' style='border:none;resize:none;width:200px;height:33px;background-color:#ffffff;' readonly>" + item + "</textarea></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][2]' class='form-control item_qty print focus_this' id='item_qty_" + i + "'  value='" + qty + "' style='width:50px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][3]' class='form-control item_rate print' id='item_rate_" + i + "' value='" + rate + "' style='width:60px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
                    <td style='text-align:center;' class='gst'><input type='text' name='stoppage[" + i + "][4]' class='form-control item_disc print' id='item_disc_" + i + "' value='" + disc + "' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;' class='gst'><input type='text' name='stoppage[" + i + "][5]' class='form-control item_tax print' id='item_tax_" + i + "' value='" + tax + "' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][6]' class='form-control item_amt print' id='item_amt_" + i + "' value='" + amt + "' style='border:none;width:80px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
\n\                 <td style='text-align:center;'><i class='fa fa-fw fa-times remove_field' style='color: red;'></i></td>\n\
            </tr>");
    }
    else
    {
         $(".row1:last").before("<tr class='input_fields_wrap'>\n\
                    <td style='text-align:center;'><input type='text' value='"+j+"' class='form-control serial_no' style='width:60px;border:none;text-align:center;'></td>\n\
                    <td style='text-align:center;'><textarea name='stoppage[" + i + "][1]' class='form-control item_name print' cols='10' style='border:none;resize:none;width:200px;height:33px;background-color:#ffffff;' readonly>" + item + "</textarea></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][2]' class='form-control item_qty print focus_this' id='item_qty_" + i + "'  value='" + qty + "' style='width:50px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][3]' class='form-control item_rate print' id='item_rate_" + i + "' value='" + rate + "' style='width:60px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
\n\                  <td style='text-align:center;display:none;' class='gst'><input type='text' name='stoppage[" + i + "][4]' class='form-control item_disc print' id='item_disc_" + i + "' value='0' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;display:none;' class='gst'><input type='text' name='stoppage[" + i + "][5]' class='form-control item_tax print' id='item_tax_" + i + "' value='0' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][6]' class='form-control item_amt print' id='item_amt_" + i + "' value='" + amt + "' style='border:none;width:80px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
\n\                 <td style='text-align:center;'><i class='fa fa-fw fa-times remove_field' style='color: red;'></i></td>\n\
            </tr>");
    }
     i++;
     $(".focus_this").focus();
      var total=$('#bill_totalamt').val();
     total=parseFloat(total)+parseFloat(rate);
    // alert(total)
       $('#bill_totalamt').val(total.toFixed(2));
}
                            }
                    });
                    $('#search_code').val("");
   }
      
});
    document.getElementById("search_code").onkeypress = function(event){
    if (event.keyCode == 13 || event.which == 13){
       
                    
    }
};
    $(function () {
//    $('input').iCheck({
//      checkboxClass: 'icheckbox_square-blue',
//      radioClass: 'iradio_square-blue',
//      increaseArea: '20%' /* optional */
//    });

  });
  var gst=$('#gst_setting').val();
//alert(gst);
if(gst=="No")
{
    $(".gst").hide();
}
else
{
    $(".gst").show();
}
  //$("#dwn_pdf").attr("disabled", true);
//  $("#print_bill").attr("disabled", true);
     $(document).on('click', 'li', function(){  
        $('#search_code').val($(this).text());  
        $('#countryList').fadeOut();  
    });  
  $('input[type=radio]').change( function() {
   //alert($(this).val());   
   $('#cash_or_cerdit').val($(this).val());
});

    $('.select2').select2() 

 $("#set_header").hide(); 
 $("#set_footer").hide(); 
  $("#print_bill").hide();
 $("#print_bill").click(function(){
        
        var multi_print="<?php echo @$hf_setting->multiple_print;?>";
       
        
        $("#set_header").show(); 
        $("#set_footer").show(); 
        $("#save_bill").hide(); 
        $("#clear_item").hide(); 
        $("#print_bill").hide(); 
        $("#date").hide(); 
        $("#bill_no").hide(); 
        
        var printContent =document.getElementById("print_content");
       // $("#print_content").css("font-family","Fake Reciept");
//        $(".box box-default").css("overflow","hidden");
        var allInputs = printContent.querySelectorAll("input,select,textarea");
        for( var counter = 0; counter < allInputs.length; counter++)
        {
           var input = allInputs.item(counter);
           input.setAttribute("value", input.value);
        }
        var windowUrl = 'about:blank';
        var uniqueName = new Date();
        var windowName = 'Print' + uniqueName.getTime();
        var printWindow = window.open(windowUrl, windowName, 'left=50000,top=50000,width=800,height=600');
        printWindow.document.write(printContent.innerHTML);
        printWindow.document.write('<style>th { font-size: 20px; }.print{ font-size: 20px }.print_1{ font-size: 18px }.print{border:none} .remove_field{display:none;} .serial_no{font-size:20px;}</style>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
        $("#save_bill").show(); 
        $("#print_bill").hide(); 
        $("#set_header").hide(); 
        $("#set_footer").hide(); 
        $("#date").show(); 
        $("#bill_no").show(); 
        
    });
 $( "#save_bill" ).click(function() {
        var cust_name=$('#cust_name').val();
        var payment_type=$('#cash_or_credit').val();
        var total=$('#bill_totalamt').val();
        if(payment_type == "" || total == 0)
        {
            //alert("Required");
            swal({
  position: 'top-end',
  type: 'warning',
  title: 'Please  Fill All Details',
  showConfirmButton: false,
  timer: 1500
}); 
        }
        else
        {
                     $.ajax({
                            url: 'add_bill',
                            type: "POST",
                            data: $('#bill_form').serialize(),
                            success: function(result) 
                            {
                            
                            var res=JSON.parse(result);
                            console.log(res);
                            $("#print_bill").click();
                            swal({ type: "success", title: "Done!", confirmButtonColor: "#292929", text: "Bill Generated Successfully", confirmButtonText: "Ok" }, 
                                function() {
                                    location.reload();
                                });
                            $('#print_bill').attr("display","block");
                            $("#new_bill_no").val(res.bill_no);
                            $("#dwn_pdf").attr("disabled", false);
                            $("#print_bill").attr("disabled", false);
    }
                    });
        }
		
		var multi_print="<?php echo @$hf_setting->multiple_print;?>";
		//alert(multi_print);
		if(multi_print=="No")
        {
             //alert(multi_print);
             $("#print_bill").hide(); 
			 //location.reload();
        }
        else
        {
//            location.reload();
//             alert(multi_print);
             //$("#print_bill").show(); 
        }
		
    });
     $("#h_lost").on('click','.remove_field',function(){
         var count = $('#bill_tbl').children('tr').length;
            
            var amt = $(this).closest('tr').find('.item_amt').val();
            var total_amt = $('#bill_totalamt').val();
            var new_amt = total_amt-amt;
            if(count == 1){
                $('#bill_totalamt').val(0);
            }else{
                $('#bill_totalamt').val(new_amt.toFixed(2));
            }
            $(this).parent().parent().remove();
             var i=1;
             $(".serial_no").each(function() {
                 //alert(i);
                 $(this).val(i);
                 i++;
             });
        });
        $( "#clear_item" ).click(function() {
            $('table tr.input_fields_wrap').remove();
            $('#bill_totalamt').val(0);
            var i=1;;
        });
 $( "#download_bill" ).click(function() {
    
    var bill_no=$('#bil_no').val();
   // alert(bill_no);
    $.ajax({
                url: 'download_bill',
                type: "GET",
                data: {bill_no:bill_no},
                success: function(result) 
                {
                    var res=JSON.parse(result);
                    console.log(res); 
                }
            });
    });  
    
 });
  function get_items(cat_id,x){
         var gst_setting=$('#gst_setting').val();
       //  if(cat_id==0)
       //  {
             $('#item_data').html("");
         //    $('.cat').css("pointer-events", "none");
        // }
         $.ajax({
                            url: 'get-item',
                            type: "GET",
                            data: {cat_id:cat_id,gst:gst_setting},
                            success: function(result) 
                            {
                            // console.log(result);
                            $('#item_data').append(result);
                        }
                    });
                  //   $('#btn_submit_'+cat_id).css("pointer-events", "none");
//                    $('#btn_submit_'+cat_id).attr("disabled", true);
    }
 var total=0;
 var flag=0;
 var i=1;
 var result_arr=[];
 var new_qty;
 function cal(x,item_id,disc,tax,final_rate)
 {
     flag=0;
     
     var item=$('#gitem_'+item_id).val();
   //  alert(total)
     var count = $('#bill_tbl').children('tr').length;
     if(count == 1){
         total = 0;
         i = 1;
     }
     total=parseFloat(total)+parseFloat(final_rate);
     result_arr.push(item_id);
     result_arr.push(final_rate);
     $('#bill_data').val(result_arr);
     $('#bill_totalamt').val(total.toFixed(2));
     $('#total_bill').text("Total Amount: "+total);
//     alert(result_arr);
$('.item_name').each(function() {
    var prev_item=$(this).val();
    if(item==prev_item)
    {
//        alert($(this).closest('.item_qty').val());
        prev_qty=$(this).closest('tr').find('.item_qty').val();
        var rate=$(this).closest('tr').find('.item_rate').val();
        new_qty=parseFloat(prev_qty)+1;
        var amt=(parseFloat(new_qty)*parseFloat(rate)).toFixed(2);
        $(this).closest('tr').find('.item_qty').val(new_qty);
        $(this).closest('tr').find('.item_amt').val(amt);
        flag=1;
        return false;
    }
    
});
if(flag==0)
{
    qty=1;
    rate=final_rate;
    amt=qty*rate;
    var gst=$('#gst_setting').val();
    // alert(i);
    var j = $("#bill_tbl").find("tr").length;
    // alert(j);
    if(gst=="Yes")
    {
         $(".row1:last").before("<tr class='input_fields_wrap'>\n\
                    <td style='text-align:center;'><input type='text' value='"+j+"' class='form-control serial_no' style='width:60px;border:none;text-align:center;'></td>\n\
                    <td style='text-align:center;'><textarea name='stoppage[" + i + "][1]' class='form-control item_name print' cols='10' style='border:none;resize:none;width:200px;height:33px;background-color:#ffffff;' readonly>" + item + "</textarea></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][2]' class='form-control item_qty print' id='item_qty_" + i + "'  value='" + qty + "' style='width:50px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
                    <td style='text-align:center;'><input type='text' class='form-control  print'  value='" + rate + "' style='width:60px;text-align:center;' /><input style='display:none;' type='text' name='stoppage[" + i + "][3]' class='form-control item_rate print' id='item_rate_" + i + "' value='" + final_rate + "' style='width:60px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
                    <td style='text-align:center;' class='gst'><input type='text' name='stoppage[" + i + "][4]' class='form-control item_disc print' id='item_disc_" + i + "' value='" + disc + "' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;' class='gst'><input type='text' name='stoppage[" + i + "][5]' class='form-control item_tax print' id='item_tax_" + i + "' value='" + tax + "' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][6]' class='form-control item_amt print' id='item_amt_" + i + "' value='" + amt + "' style='border:none;width:80px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
\n\                 <td style='text-align:center;'><i class='fa fa-fw fa-times remove_field' style='color: red;'></i></td>\n\
            </tr>");
    }
    else
    {
              $(".row1:last").before("<tr class='input_fields_wrap'>\n\
                    <td style='text-align:center;'><input type='text' value='"+j+"' class='form-control serial_no' style='width:60px;border:none;text-align:center;'></td>\n\
                    <td style='text-align:center;'><textarea name='stoppage[" + i + "][1]' class='form-control item_name print' cols='10' style='border:none;resize:none;width:200px;height:33px;background-color:#ffffff;' readonly>" + item + "</textarea></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][2]' class='form-control item_qty print' id='item_qty_" + i + "'  value='" + qty + "' style='width:50px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][3]' class='form-control item_rate print' id='item_rate_" + i + "' value='" + rate + "' style='width:60px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
\n\                  <td style='text-align:center;display:none;' class='gst'><input type='text' name='stoppage[" + i + "][4]' class='form-control item_disc print' id='item_disc_" + i + "' value='0' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;display:none;' class='gst'><input type='text' name='stoppage[" + i + "][5]' class='form-control item_tax print' id='item_tax_" + i + "' value='0' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][6]' class='form-control item_amt print' id='item_amt_" + i + "' value='" + amt + "' style='border:none;width:80px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
\n\                 <td style='text-align:center;'><i class='fa fa-fw fa-times remove_field' style='color: red;'></i></td>\n\
            </tr>");
    }
   
     i++;
}
 }

 function get_code(code)
 {
     var flag=0;
    // alert(flag);
                $.ajax({
                            url: 'check-code',
                            type: "GET",
                            data: {code:code},
                            success: function(result) 
                            {
                            console.log(result);
                            var a=JSON.parse(result);
                            var item=a.item_name;
                            var rate=a.item_rate;
                            var disc=a.item_dis;
                            var tax=a.item_tax;
                            var qty=1;
                            var amt=parseFloat(rate)*parseFloat(rate);
                            $('.item_name').each(function() {
    var prev_item=$(this).val();
    if(item==prev_item)
    {
//        alert($(this).closest('.item_qty').val());
        prev_qty=$(this).closest('tr').find('.item_qty').val();
        var rate=$(this).closest('tr').find('.item_rate').val();
        new_qty=parseFloat(prev_qty)+1;
        var amt=parseFloat(new_qty)*parseFloat(rate);
        $(this).closest('tr').find('.item_qty').val(new_qty);
        $(this).closest('tr').find('.item_amt').val(amt);
        flag=1;
        return false;
    }
    
});
if(flag==0)
{
    var j = $("#bill_tbl").find("tr").length;
    if(gst=="Yes")
    {
         $(".row1:last").before("<tr class='input_fields_wrap'>\n\
                    <td style='text-align:center;'><input type='text' value='"+j+"' class='form-control serial_no' style='width:60px;border:none;text-align:center;'></td>\n\
                    <td style='text-align:center;'><textarea name='stoppage[" + i + "][1]' class='form-control item_name print' cols='10' style='border:none;resize:none;width:200px;height:33px;background-color:#ffffff;' readonly>" + item + "</textarea></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][2]' class='form-control item_qty print' id='item_qty_" + i + "'  value='" + qty + "' style='width:50px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][3]' class='form-control item_rate print' id='item_rate_" + i + "' value='" + rate + "' style='width:60px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
                    <td style='text-align:center;' class='gst'><input type='text' name='stoppage[" + i + "][4]' class='form-control item_disc print' id='item_disc_" + i + "' value='" + disc + "' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;' class='gst'><input type='text' name='stoppage[" + i + "][5]' class='form-control item_tax print' id='item_tax_" + i + "' value='" + tax + "' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][6]' class='form-control item_amt print' id='item_amt_" + i + "' value='" + amt + "' style='border:none;width:80px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
\n\                 <td style='text-align:center;'><i class='fa fa-fw fa-times remove_field' style='color: red;'></i></td>\n\
            </tr>");
    }
    else
    {   
         $(".row1:last").before("<tr class='input_fields_wrap'>\n\
                    <td style='text-align:center;'><input type='text' value='"+j+"' class='form-control serial_no' style='width:60px;border:none;text-align:center;font-family: Fake Reciept;'></td>\n\
                    <td style='text-align:center;'><textarea name='stoppage[" + i + "][1]' class='form-control item_name print' cols='10' style='border:none;resize:none;width:200px;height:33px;background-color:#ffffff;font-family: Fake Reciept;' readonly>" + item + "</textarea></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][2]' class='form-control item_qty print' id='item_qty_" + i + "'  value='" + qty + "' style='width:50px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][3]' class='form-control item_rate print' id='item_rate_" + i + "' value='" + rate + "' style='width:60px;text-align:center;' onkeyup='table_cal("+i+",event)'/></td>\n\
\n\                  <td style='text-align:center;display:none;' class='gst'><input type='text' name='stoppage[" + i + "][4]' class='form-control item_disc print' id='item_disc_" + i + "' value='0' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;display:none;' class='gst'><input type='text' name='stoppage[" + i + "][5]' class='form-control item_tax print' id='item_tax_" + i + "' value='0' style='border:none;width:50px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
                    <td style='text-align:center;'><input type='text' name='stoppage[" + i + "][6]' class='form-control item_amt print' id='item_amt_" + i + "' value='" + amt + "' style='border:none;width:80px;text-align:center;background-color:#ffffff;' readonly/></td>\n\
\n\                 <td style='text-align:center;'><i class='fa fa-fw fa-times remove_field' style='color: red;'></i></td>\n\
            </tr>");
    }
     i++;
      var total=$('#bill_totalamt').val();
     total=parseFloat(total)+parseFloat(rate);
    // alert(total)
       $('#bill_totalamt').val(total.toFixed(2));
}
                            }
                    });
                    $('#search_code').val("");
 }
 function table_cal(i,e)
 {
     var evt=window.event?event:e;
    var code=evt.keyCode;
     if(code==13)
     {
         $('#search_code').focus();
     }
     var total_amt=0;
     var qty=$('#item_qty_'+i).val();
     var rate=$('#item_rate_'+i).val();
     var disc=$('#item_disc_'+i).val();
     var tax=$('#item_tax_'+i).val();
     //alert(qty);
     var amt=parseFloat(qty)*parseFloat(rate);
     $('#item_amt_'+i).val(amt);
     $('.item_amt').each(function() {
         total_amt = parseFloat(total_amt)+parseFloat($(this).val());
     });
     $('#bill_totalamt').val(total_amt.toFixed(2));
     $('.bill_totalamt').val(total_amt.toFixed(2));
 }
 function assign_name(cust_name)
 {
     $('#cust_name').val(cust_name);
     $('#cust_data').html("<b>Customer Name: </b> "+cust_name+"");
     $('#cust_data').hide();
 }
 
 $("#search_code").autocomplete({
 
        source: function(request, response) {
            $.ajax({
            url: "{{url('autocomplete')}}",
            data: {
                    term : request.term
             },
            dataType: "json",
            success: function(data){
                // console.log(data);
               var resp = $.map(data,function(obj){
                    // console.log(obj.city_name);
                    return obj.item_name;
               }); 
 
               response(resp);
            }
        });
    },
    minLength: 1
 });
 
</script>
@endsection
