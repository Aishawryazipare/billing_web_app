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
$table_datetime=$_POST['table_datetime'];

if($lid == 'null'){
	$sql="SELECT * FROM bil_add_table WHERE updated_at>='$table_datetime' AND cid=$cid LIMIT $Firstlimit, $Secondlimit";
}else{
	$sql="SELECT * FROM bil_add_table WHERE updated_at>='$table_datetime' AND cid=$cid AND lid=$lid LIMIT $Firstlimit, $Secondlimit";
}

$new_arr=array();
if ($result=mysqli_query($con,$sql))
{
	while ($obj=mysqli_fetch_object($result))
	{
		$flag['table_id']=$obj->table_id;
		$flag['table_no']=$obj->table_no;
		$flag['capacity']=$obj->capacity;
		$flag['is_active']=$obj->is_active;
		$flag['created_at']=$obj->created_at;
		$flag['updated_at']=$obj->updated_at;
		$flag['cid']=$obj->cid;
		$flag['lid']=$obj->lid;
		$flag['emp_id']=$obj->emp_id;
		array_push($new_arr,$flag);
    }
  // Free result set
  mysqli_free_result($result);
}
$json_arr["data"]=$new_arr;

echo json_encode($json_arr);
mysqli_close($con);
?>
