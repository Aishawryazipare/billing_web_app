<?php
require 'db_config.php';

if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$point_contact_id = $_POST['id'];
$arr[]=json_decode($point_contact_id,true);
$response=array();
$j=0;
foreach($arr as $row){
	foreach($row as $val){
		$sql = "UPDATE bil_point_of_contact SET sync_flag=0 WHERE id=".$val;

		if (mysqli_query($con, $sql)) {
			$response[$j]="Updated";
		}else {
			$response[$j]="Error";
		}
		$j++;
	}
}
if(in_array("Error", $response,true)) 
{ 
	echo "Error in Updating Point of Contact";
}else{ 
	echo "Point of Contact Updated Succesfully"; 
} 

mysqli_close($con);
?>