<?php
require 'db_config.php';
date_default_timezone_set('Asia/Kolkata');
$now = new DateTime();

if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$lid=$_POST['lid'];
$cid=$_POST['cid'];
$empid=$_POST['empid'];

$limit=100;

if($lid=='null'){
	$sql_cat="SELECT COUNT(*) as total FROM bil_category WHERE sync_flag=0 AND cid=$cid";
	$sql_unit="SELECT COUNT(*) as total FROM bil_AddIUnits WHERE sync_flag=0 AND cid=$cid";
	$sql_item="SELECT COUNT(*) as total FROM bil_AddItems WHERE sync_flag=0 AND cid=$cid";
	$sql_sup="SELECT COUNT(*) as total FROM bil_AddSupplier WHERE sync_flag=0 AND cid=$cid";
	$sql_cust="SELECT COUNT(*) as total FROM bil_Addcustomer WHERE sync_flag=0 AND cid=$cid";
	$sql_purch="SELECT COUNT(*) as total FROM bil_inventory WHERE sync_flag=0 AND cid=$cid";
}else{
	$sql_cat="SELECT COUNT(*) as total FROM bil_category WHERE sync_flag=0 AND cid=$cid AND lid=$lid";
	$sql_unit="SELECT COUNT(*) as total FROM bil_AddIUnits WHERE sync_flag=0 AND cid=$cid AND lid=$lid";
	$sql_item="SELECT COUNT(*) as total FROM bil_AddItems WHERE sync_flag=0 AND cid=$cid AND lid=$lid";
	$sql_sup="SELECT COUNT(*) as total FROM bil_AddSupplier WHERE sync_flag=0 AND cid=$cid AND lid=$lid";
	$sql_cust="SELECT COUNT(*) as total FROM bil_Addcustomer WHERE sync_flag=0 AND cid=$cid AND lid=$lid";
	$sql_purch="SELECT COUNT(*) as total FROM bil_inventory WHERE sync_flag=0 AND cid=$cid AND lid=$lid";
}

//category
$newaraycat=array();
$total=0;
if ($result=mysqli_query($con,$sql_cat))
{
	while ($obj=mysqli_fetch_object($result))
	{
		$total=$obj->total;
    }
	mysqli_free_result($result);
}
if($total>$limit){
	$divide=(int)($total/$limit);
	if($total%$limit==0){
		$mods=0;
	}else{	
		$mods=1;
	}
	$totalcount=$divide+$mods;
	$flagcat["count"]=$totalcount;
	$flagcat["cat_datetime"]=$now->format('Y-m-d H:i:s');
	array_push($newaraycat,$flagcat);
}else{
	$flagcat["count"]=1;
	$flagcat["cat_datetime"]=$now->format('Y-m-d H:i:s');
	array_push($newaraycat,$flagcat);
}
$json_arr["tbl_category"]=$newaraycat;

//unit
$newarayunit=array();
$total=0;
if ($result=mysqli_query($con,$sql_unit))
{
	while ($obj=mysqli_fetch_object($result))
	{
		$total=$obj->total;
    }
	mysqli_free_result($result);
}
if($total>$limit){
	$divide=(int)($total/$limit);
	if($total%$limit==0){
		$mods=0;
	}else{	
		$mods=1;
	}
	$totalcount=$divide+$mods;
	$flagunit["count"]=$totalcount;
	$flagunit["unit_datetime"]=$now->format('Y-m-d H:i:s');
	array_push($newarayunit,$flagunit);
}else{
	$flagunit["count"]=1;
	$flagunit["unit_datetime"]=$now->format('Y-m-d H:i:s');
	array_push($newarayunit,$flagunit);
}
$json_arr["tbl_unit"]=$newarayunit;

//items
$newarayitem=array();
$total=0;
if ($result=mysqli_query($con,$sql_item))
{
	while ($obj=mysqli_fetch_object($result))
	{
		$total=$obj->total;
    }
	mysqli_free_result($result);
}
if($total>$limit){
	$divide=(int)($total/$limit);
	if($total%$limit==0){
		$mods=0;
	}else{	
		$mods=1;
	}
	$totalcount=$divide+$mods;
	$flagitem["count"]=$totalcount;
	$flagitem["item_datetime"]=$now->format('Y-m-d H:i:s');
	array_push($newarayitem,$flagitem);
}else{
	$flagitem["count"]=1;
	$flagitem["item_datetime"]=$now->format('Y-m-d H:i:s');
	array_push($newarayitem,$flagitem);
}
$json_arr["tbl_item"]=$newarayitem;

//suppliers
$newaraysuppliers=array();
$total=0;
if ($result=mysqli_query($con,$sql_sup))
{
	while ($obj=mysqli_fetch_object($result))
	{
		$total=$obj->total;
    }
	mysqli_free_result($result);
}
if($total>$limit){
	$divide=(int)($total/$limit);
	if($total%$limit==0){
		$mods=0;
	}else{	
		$mods=1;
	}
	$totalcount=$divide+$mods;
	$flagsupp["count"]=$totalcount;
	$flagsupp["sup_datetime"]=$now->format('Y-m-d H:i:s');
	array_push($newaraysuppliers,$flagsupp);
}else{
	$flagsupp["count"]=1;
	$flagsupp["sup_datetime"]=$now->format('Y-m-d H:i:s');
	array_push($newaraysuppliers,$flagsupp);
}
$json_arr["tbl_supplier"]=$newaraysuppliers;

//Customers
$newaraycustomers=array();
$total=0;
if ($result=mysqli_query($con,$sql_cust))
{
	while ($obj=mysqli_fetch_object($result))
	{
		$total=$obj->total;
    }
	mysqli_free_result($result);
}
if($total>$limit){
	$divide=(int)($total/$limit);
	if($total%$limit==0){
		$mods=0;
	}else{	
		$mods=1;
	}
	$totalcount=$divide+$mods;
	$flagcust["count"]=$totalcount;
	$flagcust["cust_datetime"]=$now->format('Y-m-d H:i:s');
	array_push($newaraycustomers,$flagcust);
}else{
	$flagcust["count"]=1;
	$flagcust["cust_datetime"]=$now->format('Y-m-d H:i:s');
	array_push($newaraycustomers,$flagcust);
}
$json_arr["tbl_customer"]=$newaraycustomers;

//Purchase
$newaraypurchase=array();
$total=0;
if ($result=mysqli_query($con,$sql_purch))
{
	while ($obj=mysqli_fetch_object($result))
	{
		$total=$obj->total;
    }
	mysqli_free_result($result);
}
if($total>$limit){
	$divide=(int)($total/$limit);
	if($total%$limit==0){
		$mods=0;
	}else{	
		$mods=1;
	}
	$totalcount=$divide+$mods;
	$flagpurchase["count"]=$totalcount;
	$flagpurchase["purc_datetime"]=$now->format('Y-m-d H:i:s');
	array_push($newaraypurchase,$flagpurchase);
}else{
	$flagpurchase["count"]=1;
	$flagpurchase["purc_datetime"]=$now->format('Y-m-d H:i:s');
	array_push($newaraypurchase,$flagpurchase);
}
$json_arr["tbl_inventory"]=$newaraypurchase;

echo json_encode($json_arr);
mysqli_close($con);
?>	