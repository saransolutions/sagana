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
require_once 'funcs/customer/customer.php';

require_once 'funcs/customer/selectCustomer.php';
require_once 'funcs/customer/insertCustomer.php';
require_once 'funcs/customer/editCustomer.php';
require_once 'funcs/invoice/editInvoice.php';


checkUserLogin();

 if(isset($_GET['cust_id']))
{
	$cust_id=$_GET['cust_id'];	
	displaySingleCustomerById($cust_id);
}else if(isset($_GET['ecust_id']))
{
	$cust_id=$_GET['ecust_id'];	
	displayCustomerEditForm($cust_id, null);
}else if(isset($_POST['updateCustomer']))
{
	$cust_id=$_POST['cust_id'];	
	$result=insertOrUpdateCustomer($cust_id);
	displaySingleCustomerById($cust_id);
}

else if(isset($_GET['add_cust_id']))
{
	$inv_id=$_GET['add_cust_id'];	
	displayNewCustomerFormForInvoice("customer.php", $inv_id, null);
}

else if(isset($_GET['add_custm_id']))
{
	$inv_id=$_GET['add_custm_id'];	
	displayNewCustomerFormForInvoice("mortage.php", $inv_id, null);
}

else if(isset($_POST['addCustomerWithInvice']))
{
	$inv_id=$_POST['inv_id'];	
	$cust_id=insertOrUpdateCustomer($cust_id);
	if(is_numeric($cust_id)){
		updateInvoiceForCustomer($inv_id, $cust_id);
		header('Location: invoice.php?inv_id='.$inv_id);
		exit();
	}else{
		/* display the add memeber form with error message */
		displayNewCustomerFormForInvoice($inv_id, $cust_id);
	}
	
}
else if(isset($_GET['addCustomerForm']))
{
	echo displayFormToAddNewCustomer(null);
}
else if(isset($_POST['addCustomer']))
{
	$cust_id= prepareToInsertCustomer();
	if(is_numeric($cust_id)){
		displaySingleCustomerById($cust_id);
	}else{
		echo displayFormToAddNewCustomer($cust_id);
	}
}

else if(isset($_POST['search']))
{
	$searchBy=$_POST['searchBy'];
	if(isset($_POST['searchValue'])){		
		$searchValue=$_POST['searchValue'];		
		displayAllCustomers(SQL_ALL_CUSTOMERS_OV,$searchBy, $searchValue, $_SESSION['user'], $_SESSION['role']);	
			
	}else{
		
	}	
}else{	
displayAllCustomers(SQL_ALL_CUSTOMERS_OV,null, null, $_SESSION['user'], $_SESSION['role']);	
}


