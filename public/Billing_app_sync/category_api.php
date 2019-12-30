<?php
require 'db_config.php';

if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$Firstlimit=$_POST['firstlimt'];
$Secondlimit=$_POST['secondlimit'];
$lid=$_POST['lid'];
$cid=$_POST['cid'];
$empid=$_POST['empid'];
$cat_datetime=$_POST['cat_datetime'];

if($lid == 'null'){
	$sql="SELECT * FROM bil_category WHERE updated_at>='$cat_datetime' AND cid=$cid LIMIT $Firstlimit, $Secondlimit";
}else{
	$sql="SELECT * FROM bil_category WHERE updated_at>='$cat_datetime' AND cid=$cid AND lid=$lid LIMIT $Firstlimit, $Secondlimit";
}
$new_arr=array();
if ($result=mysqli_query($con,$sql))
{
	while ($obj=mysqli_fetch_object($result))
	{
		$flag['cat_id']=$obj->cat_id;
		$flag['cat_name']=$obj->cat_name;
		$flag['cat_description']=$obj->cat_description;
		$flag['cat_image']=$obj->cat_image;
		$flag['type_id']=$obj->type_id;
		$flag['created_at']=$obj->created_at;
		$flag['updated_at']=$obj->updated_at;
		$flag['is_active']=$obj->is_active;
		$flag['cid']=$obj->cid;
		$flag['lid']=$obj->lid;
		$flag['emp_id']=$obj->emp_id;
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
