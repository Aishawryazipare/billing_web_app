<?php 
include 'config.php';
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 
    if (isset($_POST)) {
        
		//print_r($_POST);
		$empid=$_POST["empid"];
		$sql = "UPDATE bil_employees SET login_active=0 WHERE id=".$empid."";
		if(mysqli_query($con,$sql)){
			echo "Logout successfully";
		}else{
			echo "Something Went To Wrong";
		 
		}
		mysqli_close($con);		
    }
 ?>
