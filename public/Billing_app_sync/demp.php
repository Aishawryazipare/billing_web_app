<?php 
    if (isset($_POST)) {
        
		$name=$_POST["name"];
		$mobileno=$_POST["mobileno"];
		$compname=$_POST["compname"];
		
		if(isset($_POST["name"])){
			echo $_POST["name"];
		}

		if(isset($_POST["mobileno"])){
			echo ' '.$_POST["mobileno"];
		}

		if(isset($_POST["compname"])){
			echo ' '.$_POST["compname"];
		}
    }
 ?>
