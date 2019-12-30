@extends('layouts.app')
@section('content')
<section class="content-header" style="padding-top: 0px;">
    <h1>
      Table Order
    </h1>
<!--    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Sales</a></li>
      <li class="active">Thumbnail Form</li>
    </ol> -->
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default" style="max-height:600px;overflow:auto;">
            <div class="box-body">
                <?php  foreach($table_data as $data){
                    $date=date("Y-m-d");
                    $status="Free";
                   $check_data = \App\TempMaster::select('bil_temp_master.*','bil_add_waiter.waiter_name')
                                ->leftjoin('bil_add_waiter','bil_add_waiter.id','=','bil_temp_master.waiter')
                                ->where(['bill_date'=>$date,'table_no'=>$data->table_id])
                                ->first();
                    ?>
                    <!--<button type="button" class="btn btn-success btn-lg cat" id="btn_submit_<?php echo $data->table_id;?>" name="btn_submit" style="background-color:#00ffc3;color:black;margin-bottom:5px;font-weight:bold;width:96px;overflow: hidden;text-overflow: ellipsis;white-space:normal;margin-right:-4px;height:50px;font-size:14px;" onclick="get_items(<?php echo $data->table_id;?>,0)">{{$data->table_no}}</button>-->
                    <span class="info-box-number cat_id" style="display:none;"><h2>{{$data->table_id}}</h2></span>
                    <div class="col-sm-2">
                                            <div class="hero-widget well well-sm" style="height:auto !important;<?php if(empty($check_data)) { ?>background-color: #00e6b0;"<?php } else { ?>background-color:#eef9f6;<?php } ?>>
                                                    <p style="margin:0;"><label class="text-muted"><strong>Table:{{$data->table_no}}</strong></label><small class="pull-right"><a href="{{ url('check_book_table?tbl_id='.$data->table_id)}}" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="" data-original-title="Update Order"><i class="fa fa-pencil"></i></a></small></p>
                                                    <?php if(!empty($check_data)) { $status="Ongoing";?>
                                                    <p style="margin:0;"><label class="text-muted">Order No:{{$check_data->tbl_bill_no}}</label></p>
                                                    <p style="margin:0;"><label class="text-muted">Waiter:{{$check_data->waiter_name}}</label></p>
                                                    <?php } ?>
                                                    <!--<a href="javascript:;" class="btn btn-xs btn-success btn-sm mr-1" style="<?php if(!empty($check_data)) { ?>background-color:#FFA500;<?php }?>">{{$status}}</a>&nbsp;-->
                                                    <!--<a href="javascript:;" onclick="orderconfirmorcancel(5,413)" class="btn btn-xs btn-danger btn-sm mr-1" data-toggle="tooltip" data-placement="left" data-original-title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>&nbsp;-->
                                                    <!--<a href="javascript:;" onclick="payorderbill(9,413,'158')" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="" data-original-title="Invoice"><i class="fa fa-window-restore"></i></a>&nbsp;-->
                                                    <!--<a href="javascript:;" onclick="payorderbill(10,413,'158')" class="btn btn-xs btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="left" title="" data-original-title="Pos Invoice"><i class="fa fa-window-maximize"></i></a>-->
                                            </div>
                                        </div>
                    <!--<a href="{{ url('check_book_table?tbl_id='.$data->table_id)}}" class="btn btn-success btn-lg cat" style="color:black;margin-bottom:5px;font-weight:bold;width:96px;overflow: hidden;text-overflow: ellipsis;white-space:normal;margin-right:-4px;height:50px;font-size:14px;<?php if(!empty($check_data)>0) { ?>background-color:#FFA500;<?php }else{?>background-color:#00ffc3;<?php } ?>">{{$data->table_no}}</a>-->
                  <?php }$all=0; ?>
                    


            </div> 
            </div>
        </div>
    </div>
</section>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="js/sweetalert.min.js"></script>

@endsection