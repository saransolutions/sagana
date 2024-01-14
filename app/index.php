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


//http://mpdf1.com/ - for PDF generation

if(isset($_GET['rdate']))
{
	include_once 'try.php';
	$date=$_GET['rdate'];
	$date = date('Y-m-d', strtotime($date));
	$content= displayDReport($date, "Daily");
	include_once 'funcs/reports/daily_reports.php';
	echo displayPageForReportContent($content);
}
/**
 * Reports
 */

else if(isset($_GET['reports']))
{
	require_once 'funcs/reports/daily_reports.php';
	echo displayReports($_SESSION['user'], $_SESSION['role']);
}
else if(isset($_POST['reportDSubmit']))
{	
	require_once 'funcs/reports/daily_reports.php';
	echo displayReports($_SESSION['user'], $_SESSION['role']);
}
else if(isset($_GET['exportReport']))
{
	
	require_once 'funcs/export/exportPDF.php';
	echo exportMonthlyReport($_GET['exportReport'], $_GET['type']);
}
else if(isset($_GET['exportToXL']))
{
	require_once 'funcs/export/export_xl.php';
	
	require_once 'funcs/reports/daily_reports.php';
	
	
	
	$date=$_GET['exportToXL'];$type=$_GET['type'];
	if($type=='Monthly'){
		$date = date('Y-m', strtotime($date));		
	}else{
		$date = date('Y-m-d', strtotime($date));
	}
	
	
	$reportFileName=getReportFileName($date,$type);	
	$rows=getFetchArray(returnSQLForInvoiceForReport($date));
	$data = getReportTableOnly($rows);
	echo exportMReportIntoXL($data, $reportFileName);
}

/**
 * Searches
 */
else if(isset($_POST['search']))
{
	$searchBy=$_POST['searchBy'];
	if(isset($_POST['searchValue'])){
		
		$searchValue=$_POST['searchValue'];
		$searchBy;
		displayMainPage(SQL_MAIN_INV_OV,$searchBy, $searchValue,  $_SESSION['user'], $_SESSION['role']);
			
	}	
}

else if(isset($_POST['searchCust']))
{
	$searchBy=$_POST['searchBy'];
	if(isset($_POST['searchValue'])){
		
		$searchValue=$_POST['searchValue'];
		$searchBy;
		require_once 'funcs/customer/customer.php';
		displayAllCustomers(SQL_ALL_CUSTOMERS_OV,$searchBy, $searchValue);
			
	}else{
		
	}	
}


/**
 * Export to PDF
 */

else if(isset($_GET['exportToPDF']))
{
	require_once 'funcs/export/exportPDF.php';
	require_once 'try.php';
	$date= $_GET['exportToPDF'];
	$cdateFormat = date('d.m.y', strtotime($date));
	$data="<h1>Daily Sales Report - ".$cdateFormat."</h1>".exportToXL($date, true);
	//echo "Report table - ".$data;
	echo writeIntoPDF($data, $isDownload, $fileName);
	exit();
}
else {
	displayMainPage(SQL_MAIN_INV_OV, null, null, $_SESSION['user'], $_SESSION['role']);
}

?>


<?php

function displayMainPage($sql, $key, $value, $user,$role){
	/*
	 * Displaying error message
	 * */
	$errMsg=null;
	if (isset($_SESSION['error_msg'])){
		$errMsg= $_SESSION['error_msg'];
	}else{
		$_SESSION['error_msg']=null;
		unset($_SESSION['error_msg']);
	}
	$page=null;
	$page = $page.returnMainPageTemplate($errMsg, null, $user, $role, BGC_FOR_INVOICE).
	"<br><center><h2 style='background:#FFE0E0;border:1px solid #A2A2A8;'>Invoices</h2></center>".
	BOX_FOR_NEW_INVOICE;
	if($key=='inv_id'){
			if(is_numeric($value)){
				$sql=SQL_MAIN_INV_OV." and inv_id = ".$value;
				$page=$page.displaySInvoiceOV($sql, $user,$role);
			}else{
				$page=$page."<p style='font-family:verdana;font-size:12px;color:red;'>
					Invalid value <font style='color:#000;'>'".$value."'</font> for key Search By Date 
				</p>";			
			}		
		}else if($key=='cname'){
			$sql=$sql." and cname like '%".$value."%'";
			$page=$page.displaySInvoiceOV($sql, $user,$role);
		}else if($key=='status'){
			$sql=$sql." and status like '".$value."%'";
			$page=$page.displaySInvoiceOV($sql, $user,$role);
		}
		else{
			$page=$page.displaySInvoiceOV($sql, $user,$role);
		}	
		
	$page=$page."
</div>        
".HTML_FOOT_LINE."  
</div>
</body>
</html>
	";
	$_SESSION['error_msg']=null;
	unset($_SESSION['error_msg']);
	echo $page;
}

function displaySInvoiceOV($sql, $user,$role){
	//echo "SQL for search - ".$sql;
	$data=null;
	$rows=getFetchArray($sql." order by inv_id desc");
	$rowCounts = count($rows);
	$limit=NO_OF_INV_PER_PAGE;
	if($rowCounts!=0){
		if($rowCounts>$limit){
			$totalpage = round (($rowCounts / $limit)) + 1;	
		}else{
			$totalpage = round (($rowCounts / $limit)) ;
		}
		$data=$data."<div style='padding:3px;float:right;'>
			<font style='font-family:verdana;font-size:12px;'>pages(".$totalpage.")";
		$pageNrFlag=true;
		if($pageNrFlag){
			$data=$data."...";
			for($i = 1; $i <= $totalpage; $i ++) {
				$data=$data."<a id='id1' href='index.php?p=".$i."'>".$i."</a>";
			}
		}
		$data=$data."
		</font>
		</div>
	<table class='footable' width='100%' style='margin-top:0px;'>
		<thead>			
			<tr>				
				<th>Id</th>				
				<th>Date</th>
				<th>Customer Name</th>
				<th>Total price</th>
				<th>Discount</th>
				<th>Net Amount</th>
				<th>Deposit</th>
				<th>Balance</th>
				<th>Status</th>				
				<th></th>				
			</tr>
		</thead>
		<tbody>";

		$first;
		$last;
		if (! isset ( $_GET ['p'] ) || $_GET ['p'] == '1') {
			$first = 0;
		} else {
			$page = $_GET ['p'];
			$first = (($page - 1) * $limit);
		}
		$rows = getFetchArray($sql . " order by inv_id desc limit " . $first . "," . $limit . "");
		foreach($rows as $result)
		{
			$inv_id= $result['inv_id'];			
			$cust_id= $result['cust_id'];
			$cname= $result['cname'];
			$bdate= $result['mdate'];			
			$bdate = date('d.m.y', strtotime($bdate));
			$total_amount= $result['total_price'];
			
			$discount=$result['discount'];
			$net_amount=$result['net_amount'];
			$deposit=$result['deposit'];
			$balance=$result['balance'];
			$status=$result['status'];	
			$data=$data."<tr>
			<td><a href='invoice.php?inv_id=".$inv_id."'>".PREFIX_INV_NR.$inv_id."</a></td>			
					
			<td>".$bdate."</td>
			<td><a href='customer.php?cust_id=".$cust_id."'>".$cname."</a>"."</td>
			<td>".$total_amount."</td>
			<td>".$discount."</td>
			<td>".$net_amount."</td>
			<td>".$deposit."</td>
			<td>".$balance."</td>
			<td>".displayOrderStatus($status)."</td>
			<td>".getActionsForInvoice($role, $inv_id, $cust_id, $status)."
			</td>
		</tr>";		
		}
		$data=$data."</tbody></table>";
		$data=$data."<div style='padding:3px;'>
			<font style='font-family:verdana;font-size:12px;'>pages(".$totalpage.")";
		$pageNrFlag=true;
		if($pageNrFlag){
			$data=$data."...";
			for($i = 1; $i <= $totalpage; $i ++) {
				$data=$data."<a id='id1' href='index.php?p=".$i."'>".$i."</a>";
			}
		}
	}else{
		return "<p style='font-family:verdana;font-size:12px;color:red;'>No rows found</p>";
	}
	return $data;
}

function getActionsForInvoice($role, $inv_id, $cust_id, $status){
	$data=null;
	$data=$data. "
<a href='invoice.php?iprint=".$inv_id."&cust_id=".$cust_id."' target='_blank'>
<img src='img/icon/print.png' title='print invoice' style='width:18px;height:18px;' /></a> ";
	if($status==STATUS_UNPAID_VALUE || $status==STATUS_ORDERED_VALUE ){
		$data=$data."<a id='id11' href='invoice.php?pinv_id=".$inv_id."'><img src='img/icon/pay.png' title='pay invoice' style='width:18px;height:18px;' /></a> ";
	}
	$data=$data."
<a href='invoice.php?edit_id=".$inv_id."'><img src='img/icon/edit.png' title='edit invoice' style='width:18px;height:18px;' /></a>
";

	if(is_null($cust_id)){
		$data=$data."<a id='id11' href='customer.php?add_cust_id=".$inv_id."'><img src='img/icon/add_customer.png' title='add customer' style='width:18px;height:18px;' /></a>";
	}else{
		$data=$data."<a id='id11' href='customer.php?ecust_id=".$cust_id."'><img src='img/icon/edit_customer.png' title='edit customer' style='width:18px;height:18px;' /></a>";
	}

	if($role=='admin'){
		$data=$data."
<a href='invoice.php?d_inv_id=".$inv_id."' onclick=\"return confirm('Are you sure to delete this Invoice ?')\" ><img src='img/icon/delete.png' title='delete invoice' style='width:15px;height:15px;' /></a>";
	}
$data=$data."<a href='invoice.php?smprint=".$inv_id."&cust_id=".$cust_id."' target='_blank'><img src='img/icon/printer.png' title='small bill' style='margin-left:5px;width:18px;height:18px;' /></a> ";

	return $data;
}

?>