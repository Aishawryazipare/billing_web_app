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
	$sql="SELECT * FROM bil_payement_type WHERE sync_flag=0 AND cid=$cid";
}else{
	$sql="SELECT * FROM bil_payement_type WHERE sync_flag=0 AND cid=$cid AND lid=$lid";
}
$new_arr=array();
if ($result=mysqli_query($con,$sql))
{
	while ($obj=mysqli_fetch_object($result))
	{
		$flag['id']=$obj->id;
		$flag['payment_type']=$obj->payment_type;
		$flag['is_active']=$obj->is_active;
		$flag['cid']=$obj->cid;
		$flag['lid']=$obj->lid;
		$flag['emp_id']=$obj->emp_id;
		$flag['sync_flag']=$obj->sync_flag;
		$flag['created_at']=$obj->created_at;
		$flag['updated_at']=$obj->updated_at;
		array_push($new_arr,$flag);
    }
  // Free result set
  mysqli_free_result($result);
}
$json_arr["data"]=$new_arr;

echo json_encode($json_arr);
mysqli_close($con);
?>