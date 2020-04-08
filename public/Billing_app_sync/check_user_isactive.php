<?php
include 'config.php';

 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 if($con)
{
//echo"Success";
}
 $empid = $_POST['empid'];
 $Sql_Query = "select is_active,login_active from bil_employees where id='$empid'";
 $isactive=0;
 $login_active=0;
$new_arr=array();
 $result=mysqli_query($con,$Sql_Query);
 $rowcount=mysqli_num_rows($result);
 if($rowcount>0)
 { 
	while ($obj=mysqli_fetch_object($result))
	{
		$isactive=$obj->is_active;
	}
	
	if($isactive==0){
		$data['is_active']=0;
	}else{
		$data['is_active']=1;
	}

	array_push($new_arr,$data);
 }
 else{
	$data['is_active']=0;
 }
 $json_arr["data"]=$new_arr;

echo json_encode($json_arr);

 mysqli_close($con);
?>
