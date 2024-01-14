<?php

ob_start();
if (version_compare(phpversion(), '5.3.0', '>=') == 1)
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
error_reporting(E_ALL & ~E_NOTICE);
session_start();

require_once 'funcs/utility.php';
require_once 'funcs/db/db.php';
require_once 'includes/cons.php';
require_once 'funcs/recordType/recordType.php';

require_once 'funcs/recordType/selectRecordType.php';
require_once 'funcs/recordType/insertRecordType.php';
require_once 'funcs/recordType/editRecordType.php';





checkUserLogin();

 if(isset($_GET['tid']))
{
	$pid=$_GET['tid'];	
	displayRecordTypeById($pid);
}else if(isset($_GET['etid']))
{
	$cust_id=$_GET['etid'];	
	displayRecordTypeEditForm($cust_id, null);
}
else if(isset($_POST['updateRecordType']))
{
	$pid=$_POST['tid'];	
	$pid=updateRecordType($pid);
	displayRecordTypeById($pid);
}

else if(isset($_POST['addRecordType']))
{
	$pid = prepareToInsertRecordType();	
	if(is_numeric($pid)){
		displayAllRecordTypes(SQL_ALL_RECORD_TYPES,null, null, $_SESSION['user'], $_SESSION['role']);
	}else{
		echo displayFormToAddNewRecordType($pid, null);
	}
}

else if(isset($_GET['dpid']))
{
	$cust_id=$_GET['dpid'];	
	$sql="delete from products where pid=".$cust_id."";
	executeSQL($sql);
	header('Location: recordTypes.php');
	exit();
}

else if(isset($_GET['action']) && $_GET['action']=='add')
{
	if(isset($_GET['type'])){
		echo displayFormToAddNewRecordType(null,$_GET['type']);	
	}else{
		echo displayFormToAddNewRecordType(null,null);
	}	
}

else if(isset($_POST['search']))
{
	$searchBy=$_POST['searchBy'];
	if(isset($_POST['searchValue'])){		
		$searchValue=$_POST['searchValue'];		
		displayAllRecordTypes(SQL_ALL_RECORD_TYPES,$searchBy, $searchValue, $_SESSION['user'], $_SESSION['role']);	
	}else{
		
	}	
}else{	
displayAllRecordTypes(SQL_ALL_RECORD_TYPES,null, null, $_SESSION['user'], $_SESSION['role']);	
}


?>