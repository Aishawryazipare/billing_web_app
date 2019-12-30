<?php
include 'config.php';
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 if($con)
{
echo"Success";
}
$json_array = $_POST['json_array'];
$data=json_decode($json_array, true); 
//print_r($data); //exit;
foreach($data as $s)
{		
		foreach($s as $key=>$value)
		{
			$app_bill_id= $s['app_bill_id'];
			$bill_date = $s['bill_date'];
			$cust_id = $s['cust_id'];
			$cash_or_creadit = $s['cash_or_credit'];
			$discount = $s['discount'];
			$gst_setting = $s['gst_setting'];
			$bill_totalamt = $s['bill_totalamt'];
			$bill_tax = $s['bill_tax'];
			$is_active = 0;
			$lid = $s['lid'];
			$cid = $s['cid'];
			$emp_id = $s['emp_id'];
			$android_bill_id = $s['android_bill_id'];
			$point_of_contact = $s['point_of_contact'];
			$payment_details = $s['payment_details'];
			$order_details = $s['order_details'];
			$bill_code = $s['bill_code'];
			
			if($disount=='')
			$discount=0;
		
			if($bill_tax==0)
			$bill_tax=0;

			if($lid == 'null'){
				$Sql_Query = "insert into bil_AddBillMaster (app_bill_id,bill_date,cust_name,cash_or_credit,point_of_contact,discount,gst_setting,bill_totalamt,bill_tax,payment_details,order_details,isactive,cid,emp_id,android_bill_id,bill_code)values ('$app_bill_id','$bill_date','$cust_id','$cash_or_creadit','$point_of_contact','$discount','$gst_setting','$bill_totalamt','$bill_tax','$payment_details','$order_details','$is_active','$cid','$emp_id','$android_bill_id','$bill_code')ON DUPLICATE KEY UPDATE android_bill_id='$android_bill_id',app_bill_id='$app_bill_id',bill_date='$bill_date',cust_name='$cust_id',cash_or_credit='$cash_or_creadit',point_of_contact='$point_of_contact',discount='$discount',gst_setting='$gst_setting',bill_totalamt='$bill_totalamt',bill_tax='$bill_tax',payment_details='$payment_details',order_details='$order_details',isactive='$is_active',cid='$cid',emp_id='$emp_id',bill_code='$bill_code'";
			}else{
				$Sql_Query = "insert into bil_AddBillMaster (app_bill_id,bill_date,cust_name,cash_or_credit,point_of_contact,discount,gst_setting,bill_totalamt,bill_tax,payment_details,order_details,isactive,lid,cid,emp_id,android_bill_id,bill_code)values ('$app_bill_id','$bill_date','$cust_id','$cash_or_creadit','$point_of_contact','$discount','$gst_Setting','$bill_totalamt','$bill_tax','$payment_details','$order_details','$is_active','$lid','$cid','$emp_id','$android_bill_id','$bill_code')ON DUPLICATE KEY UPDATE android_bill_id='$android_bill_id',app_bill_id='$app_bill_id',bill_date='$bill_date',cust_name='$cust_id',cash_or_credit='$cash_or_creadit',point_of_contact='$point_of_contact',discount='$discount',gst_setting='$gst_setting',bill_totalamt='$bill_totalamt',bill_tax='$bill_tax',payment_details='$payment_details',order_details='$order_details',isactive='$is_active',lid='$lid',cid='$cid',emp_id='$emp_id',bill_code='$bill_code'";
			}
		//	echo $Sql_Query;
	}
	if(mysqli_query($con,$Sql_Query)){
		echo 'Data Inserted Successfully';
	}
 else{

	echo 'Try Again';
	echo "ERROR: Could not able to execute $Sql_Query. " . mysqli_error($con);
 
 }	
// echo 'Data Synced Successfully';
}
?>
