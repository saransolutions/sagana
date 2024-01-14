<?php
ob_start();
if (version_compare(phpversion(), '5.3.0', '>=') == 1)
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
error_reporting(E_ALL & ~E_NOTICE);
session_start();


require_once 'funcs/invoice/singleInvoice.php';
require_once 'funcs/invoice/editInvoice.php';
require_once 'funcs/invoice/insertInvoice.php';
require_once 'funcs/invoice/displayInvoice.php';

require_once 'funcs/trans/trans.php';
require_once 'includes/cons.php';
require_once 'funcs/db/db.php';
require_once 'funcs/utility.php';
require_once 'funcs/export/export_A6_pdf.php';
require_once 'funcs/customer/customer.php';
require_once 'funcs/customer/editCustomer.php';
require_once 'funcs/customer/insertCustomer.php';

checkUserLogin();


if(isset($_GET['add']))
{		
	//echo displayInvoiceForm();
	
	echo displayInvoiceFormNew(null);
}
if(isset($_POST['processOrder']))
{		
	//echo displayInvoiceForm();
	$result= displayProductsWithTotal();
	if(!$result['isError'] && !is_null($result['data'])){
		echo $result['data'];
	}else{		
		echo displayInvoiceFormNew($result['errMsg']);	
	}
}
if(isset($_POST['cancelOrder']))
{		
	//echo displayInvoiceForm();
	echo displayInvoiceFormNew(null);
}

else if(isset($_GET['edit_id']))
{
	$userRole=null;
	$inv_id=$_GET['edit_id'];
	echo displayFormToEditInvoice($inv_id, null, $userRole);
}
else if(isset($_GET['pinv_id']))
{
	$userRole=null;
	$inv_id=$_GET['pinv_id'];
	echo displayFormToPayInvoice($inv_id, null, $userRole);
}

else if(isset($_POST['submitOrder'])){
	require_once 'funcs/orders/orders.php';
	
	$result = processOrder(null);
	$flag = $result['isError'];
	if($flag){
		$errMsg=$result['errMsg'];		
		echo displayInvoiceFormNew($errMsg);
	}else{
		header('Location: index.php');
		exit();
	}
}
else if(isset($_POST['payInvoice'])){
	$role=$_SESSION['role'];
	$inv_id=$_POST['pinv_id'];
	$pay_amount=$_POST['pay_amount'];	
	$balance=$_POST['balance'];
	$deposit=$_POST['deposit'];
	
	if(is_numeric($pay_amount) && $balance >= $pay_amount){		
		$balance=$balance-$pay_amount;
		$deposit=$deposit+$pay_amount;
		$status=STATUS_UNPAID_VALUE;
		if($balance==0){
			$status=STATUS_PAID_VALUE;
		}
		updateTransactionForInvPayment($inv_id, $balance,$deposit, $status);		
		echo displayInvoiceById($inv_id, $role);
	}else{
		$errMsg = "<p style='font-family:verdana;font-size:12px;color:red;'>Invalid amount ' ".$pay_amount." ' for the balance ".$balance."</p> ";
		echo displayFormToPayInvoice($inv_id,$errMsg,$role);
	}
}

else if(isset($_POST['editInvoice'])){
	$inv_id=$_POST['update_id'];
	$total=$_POST['total_no_of_products'];
	$discount=$_POST['discount'];
	$deposit=$_POST['deposit'];
	$result = updateInvoice($inv_id, $total, $discount, $deposit);
	header('Location: invoice.php?inv_id='.$inv_id);
	exit();	
}
/**
 * Displaying a single invoice using id
 */
else if(isset($_GET['inv_id']))
{
	/** 1 - create 	 * 2 - display 	 * 3 - edit */	
	if(isset($_SESSION['role'])){
		$role=$_SESSION['role'];	
	}else{
		$role=null;
	}	
	echo displayInvoiceById($_GET['inv_id'], $role);
}
/**
 * Delete a invoice
 */
else if(isset($_GET['d_inv_id']))
{
	if(isset($_SESSION['role']) && $_SESSION['role']=='admin'){
		$inv_id=$_GET['d_inv_id'];
		deleteInvoiceById($inv_id);
	}
	
}else if(isset($_GET['deleteAllInvoices']))
{
	//deleteAllInvoices();
}
else if(isset($_GET['iprint']))
{	
	$inv_id=$_GET['iprint'];
	$cust_id=$_GET['cust_id'];
	$content=A6PDFContentTable($inv_id, $cust_id);	
	prepareA6InvoicePrint($inv_id, $content['data'], $content['mdate']);
	
}

else if(isset($_GET['smprint']))
{	
require_once 'funcs/export/exportSmallInvoiceBill.php';
require_once 'funcs/export/export_mini_bill_pdf.php';
	$inv_id=$_GET['smprint'];
	$cust_id=$_GET['cust_id'];	
	$data= smallInvoicePrint($inv_id, $cust_id);	
	$height=substr_count( $data, "\n" ) + 95;
	
	prepareSmallInvoicePrint($inv_id, $data, "April 1st 2015", $height);
	
}

function prepareA6InvoicePrint($inv_id, $content, $mdate){
include("../mpdf/mpdf.php");
require_once  'includes/cons.php';
	//default page length is 160 for join       margin_left, margin_right, margin_top, margin_bottom, margin_header, margin_footer
$mpdf=new mPDF('utf-8', array(210,148), 0, '', 10, 10, 23, 1, 5,5); 

$html = '
<html>
'.PDF_HEAD_TEMPLATE_FOR_INVOICE.'
<body>
<!--mpdf
'.A6PDFContentHeader(PREFIX_INV_NR.$inv_id, $mdate).'
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

'.$content.'

'.A6PDFContentFooter().'
</body>
</html>
';

$mpdf->SetJS('this.print();');
$mpdf->WriteHTML($html);
$mpdf->Output(PREFIX_INV_NR.$inv_id.'.pdf','I');
exit;
}

function prepareSmallInvoicePrint($inv_id, $content, $mdate, $height){
include("../mpdf/mpdf.php");
require_once  'includes/cons.php';

	//default page length is 160 for join       margin_left, margin_right, margin_top, margin_bottom, margin_header, margin_footer
$mpdf=new mPDF('utf-8', array(80, $height), 0, '', 4, 4, 35, 25, 12, 12); 

$html = '
<html>
'.PDF_HEAD_TEMPLATE.'
<body>
<!--mpdf
'.miniBillContentHeader().'
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
'.$content.'
'.miniBillContentFooter().'
</body>
</html>
';

//$mpdf->SetJS('this.print();');
$mpdf->WriteHTML($html);
$mpdf->Output(PREFIX_INV_NR.$inv_id.'.pdf','I');

exit;
	
	

	
}

