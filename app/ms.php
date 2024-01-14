<?php

ob_start();
if (version_compare(phpversion(), '5.3.0', '>=') == 1)
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
error_reporting(E_ALL & ~E_NOTICE);
session_start();


require_once 'includes/cons.php';
require_once 'funcs/db/db.php';
require_once 'funcs/utility.php';
require_once 'funcs/customer/customer.php';

require_once 'funcs/ms/selectMS.php';
require_once 'funcs/ms/insertMS.php';
require_once 'funcs/ms/updateMS.php';
require_once 'funcs/invoice/singleInvoice.php';

checkUserLogin();
if(isset($_GET['add']))
{	
	echo displayNewMSForm();
}
else if(isset($_GET['edit_id']))
{	
	$ms_id=$_GET['edit_id'];
	$errMsg=$_SESSION['errMsg'];
	$role=$_SESSION['role'];
	echo displayFormToEditMS($ms_id, $errMsg, $role);
}
else if(isset($_POST['updateScheme']))
{		
	$sid = validateMSchemeFields();
	header("Location: ms.php");
	exit();
}

else if(isset($_GET['setDate']))
{	
	$sid=$_GET['setDate'];
	$sql="update members set status='".STATUS_UNPAID_VALUE."' where scheme_id=".$sid." and status != '".STATUS_MEMBER_WINNER."'";
	executeSQL($sql);
	header("Location: member.php?sid=".$sid."");
	exit();
}

else if(isset($_POST['submitMscheme']))
{		
	$sid = validateNewMSchemeFields();
	header("Location: ms.php");
	exit();
}
else{
	$sql="select * from mschemes where 1=1 ";
	$user=$_SESSION['user'];
	$role=$_SESSION['role'];
	displayMainSchemes($sql, null, null, $user,$role);
}
