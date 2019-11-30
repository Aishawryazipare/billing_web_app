<?php
require 'db_config.php';

if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$lid=$_POST['lid'];
$cid=$_POST['cid'];
$empid=$_POST['empid'];

if($lid == 'null'){
	$sql="SELECT * FROM bil_header_footer WHERE sync_flag=0 AND cid=$cid";
}else{
	$sql="SELECT * FROM bil_header_footer WHERE sync_flag=0 AND cid=$cid AND lid=$lid";
}
$new_arr=array();
if ($result=mysqli_query($con,$sql))
{
	while ($obj=mysqli_fetch_object($result))
	{
		$flag['id']=$obj->id;
		$flag['h1']=$obj->h1;
		$flag['h2']=$obj->h2;
		$flag['h3']=$obj->h3;
		$flag['h4']=$obj->h4;
		$flag['h5']=$obj->h5;
		$flag['f1']=$obj->f1;
		$flag['f2']=$obj->f2;
		$flag['f3']=$obj->f3;
		$flag['f4']=$obj->f4;
		$flag['f5']=$obj->f5;
		$flag['created_at']=$obj->created_at;
		$flag['updated_at']=$obj->updated_at;
		$flag['is_active']=$obj->is_active;
		$flag['cid']=$obj->cid;
		$flag['lid']=$obj->lid;
		$flag['emp_id']=$obj->emp_id;
		$flag['page_size']=$obj->page_size;
		$flag['gst_setting']=$obj->gst_setting;
		$flag['bill_printing']=$obj->bill_printing;
		$flag['multiple_print']=$obj->multiple_print;
		$flag['reset_bill']=$obj->reset_bill;
		$flag['sync_flag']=$obj->sync_flag;
		array_push($new_arr,$flag);
    }
  // Free result set
  mysqli_free_result($result);
}
$json_arr["data"]=$new_arr;

echo json_encode($json_arr);
mysqli_close($con);
?>