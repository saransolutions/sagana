<?php

ob_start();
if (version_compare(phpversion(), '5.3.0', '>=') == 1)
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
error_reporting(E_ALL & ~E_NOTICE);
session_start();

require_once 'funcs/invoice/singleInvoice.php';

require_once 'funcs/mortage/insertMortage.php';
require_once 'funcs/mortage/selectMortage.php';
require_once 'funcs/mortage/editMortage.php';

require_once 'funcs/trans/trans.php';
require_once 'includes/cons.php';
require_once 'funcs/db/db.php';
require_once 'funcs/utility.php';

require_once 'funcs/customer/customer.php';
require_once 'funcs/customer/editCustomer.php';
require_once 'funcs/customer/insertCustomer.php';

require_once 'funcs/mortage/mortageTransaction.php';

require_once 'funcs/export/export_A6_pdf.php';

require_once 'funcs/orders/orders.php';
require_once 'funcs/trans/trans.php';


checkUserLogin();
checkMortageStatus();

if(isset($_GET['add']))
{		
	//echo displayInvoiceForm();
	echo displayMortageFormNew(null);
}
else if(isset($_POST['addCustomerWithInvice']))
{
	$inv_id=$_POST['inv_id'];	
	$cust_id=insertOrUpdateCustomer($cust_id);
	if(is_numeric($cust_id)){
		updateMortageForCustomer($inv_id, $cust_id);
		header('Location: mortage.php?m_id='.$inv_id);
		exit();
	}else{
		/* display the add memeber form with error message */
		displayNewCustomerFormForInvoice($inv_id, $cust_id);
	}
	
}


else if(isset($_POST['processOrder']))
{		
	//echo displayInvoiceForm();
	$result= displayMortageProductWithTotal();
	if(!$result['isError'] && !is_null($result['data'])){
		echo $result['data'];
	}else{
		echo displayInvoiceFormNew($result['errMsg']);	
	}
}
else if(isset($_POST['cancelOrder']))
{		
	//echo displayInvoiceForm();
	echo displayInvoiceFormNew(null);
}

else if(isset($_GET['pay_iid']))
{
	$userRole=null;
	$pay_iid=$_GET['pay_iid'];
	subMortageInterest($pay_iid);
	header('Location: mortage.php');
	exit();
}

else if(isset($_GET['edit_id']))
{
	$userRole=null;
	$inv_id=$_GET['edit_id'];
	echo displayFormToEditMortage($inv_id, null, $userRole);
}
else if(isset($_GET['pinv_id']))
{
	$userRole=null;
	$inv_id=$_GET['pinv_id'];
	echo displayFormToPayMortage($inv_id, null, $userRole);
}else if(isset($_GET['pint_id']))
{
	$userRole=null;
	$inv_id=$_GET['pint_id'];
	subMortageInterest($inv_id);
	header('Location: mortage.php');
	exit();
}

else if(isset($_POST['submitOrder'])){	
	$result = processOrder("mortage");
	$flag = $result['isError'];
	if($flag){
		$errMsg=$result['errMsg'];		
		echo displayInvoiceFormNew($errMsg);
	}else{
		header('Location: mortage.php');
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
		updateTransactionForMortagePayment($inv_id, $balance,$deposit, $status);		
		echo displayMortageById($inv_id, $role);
	}else{
		$errMsg = "<p style='font-family:verdana;font-size:12px;color:red;'>Invalid amount ' ".$pay_amount." ' for the balance ".$balance."</p> ";
		echo displayFormToPayMortage($inv_id,$errMsg,$role);
	}
}

else if(isset($_POST['editInvoice'])){
	$inv_id=$_POST['update_id'];
	$total=$_POST['total_no_of_products'];
	$discount=$_POST['discount'];
	$deposit=$_POST['deposit'];
	$result = updateMortage($inv_id, $total, $discount, $deposit);
	header('Location: mortage.php?m_id='.$inv_id);
	exit();
	
}




/**
 * Displaying a single invoice using id
 */
else if(isset($_GET['m_id']))
{
	/** 1 - create 	 * 2 - display 	 * 3 - edit */	
	if(isset($_SESSION['role'])){
		$role=$_SESSION['role'];	
	}else{
		$role=null;
	}	
	echo displayMortageById($_GET['m_id'], $role);
}
/**
 * Delete a invoice
 */
else if(isset($_GET['d_m_id']))
{
	if(isset($_SESSION['role']) && $_SESSION['role']=='admin'){
		$inv_id=$_GET['d_m_id'];		
		executeSQL("delete from mortage_transactions where m_id=".$inv_id);
		executeSQL("delete from mortages where m_id=".$inv_id);
		header('Location: mortage.php');
		exit();
	}
	
}else if(isset($_GET['deleteAllInvoices']))
{
	//deleteAllInvoices();
}

/**
 * Print Mortage
 */
else if(isset($_GET['pmor_id']))
{
	$mor_id=$_GET['pmor_id'];
	$cust_id=getSingleValue("select cust_id from mortages where m_id=".$mor_id);
	$mdate=getSingleValue("select mdate from mortages where m_id=".$mor_id."");
	$content=A6PDFContentTableForMortage($mor_id, $cust_id);		
	printMortage($mor_id,$content['data'], $content['mdate']);
}

else{
	displayMainPage(SQL_MAIN_MORTAGE_OV, null, null, $_SESSION['user'], $_SESSION['role']);
}

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
	$page = $page.returnMainPageTemplate($errMsg, null, $user, $role, BGC_FOR_MORTAGE).
	"<br><center><h2 style='background:#FFE0E0;border:1px solid #A2A2A8;'>Mortage</h2></center>".
	BOX_FOR_NEW_MORTAGE;
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
	$rows=getFetchArray($sql." order by m_id desc");
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
				$data=$data."<a id='id1' href='mortage.php?p=".$i."'>".$i."</a>";
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
				<th>Loan</th>
				<th>%</th>
				<th>Interest</th>
				<th>Pending</th>				
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
		$rows = getFetchArray($sql . " order by m_id desc limit " . $first . "," . $limit . "");
		foreach($rows as $result)
		{
			$inv_id= $result['m_id'];			
			$cust_id= $result['cust_id'];
			$cname= $result['cname'];
			$bdate= $result['mdate'];			
			$bdate = date('d.m.y', strtotime($bdate));
			$total_amount= $result['total_price'];
			
			$mInterest=$result['interest_amount'];
			$per_interest=$result['per_interest'];
			
			$net_amount=$result['loan_amount'];
			$deposit=$result['deposit'];
			$balance=$result['balance'];
			$status=$result['status'];	
			
			$data=$data."<tr>
			<td><a href='mortage.php?m_id=".$inv_id."'>".PREFIX_MORTAGE_NR.$inv_id."</a></td>
			<td>".$bdate."</td>
			<td><a href='customer.php?cust_id=".$cust_id."'>".$cname."</a>"."</td>			
			<td>".$net_amount."</td>
			<td>".$per_interest." %</td>			
			<td>".$mInterest." CHF</td>			
			<td>".$balance." CHF</td>
			<td>".displayOrderStatus($status)."</td>
			<td>".getActionsForMortage($role, $inv_id, $cust_id, $status)."
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
				$data=$data."<a id='id1' href='mortage.php?p=".$i."'>".$i."</a>";
			}
		}
	}else{
		return "<p style='font-family:verdana;font-size:12px;color:red;'>No rows found</p>";
	}
	return $data;
}

function getActionsForMortage($role, $inv_id, $cust_id, $status){
	$data=null;
	$data=$data. "";
	$data=$data."<a id='id11' href='mortage.php?pinv_id=".$inv_id."'><img src='img/icon/pay.png' title='pay invoice' style='width:18px;height:18px;' /></a> ";
	$data=$data."
 <a href='mortage.php?pint_id=".$inv_id."'>
 	<img src='img/icon/pay_interest.png' title='pay interest' style='width:18px;height:18px;' />
 </a>
 <a href='mortage.php?pmor_id=".$inv_id."' target='blank'>
 	<img src='img/icon/print.png' title='Print Mortage' style='width:18px;height:18px;' />
 </a>
";

	if(is_null($cust_id)){
		$data=$data."<a id='id11' href='customer.php?add_custm_id=".$inv_id."'><img src='img/icon/add_customer.png' title='add customer' style='width:18px;height:18px;' /></a>";
	}else{
		$data=$data."<a id='id11' href='customer.php?ecust_id=".$cust_id."'><img src='img/icon/edit_customer.png' title='edit customer' style='width:18px;height:18px;' /></a>";
	}

	if($role=='admin'){
		$data=$data."
<a href='mortage.php?d_m_id=".$inv_id."' onclick=\"return confirm('Are you sure to delete this Invoice ?')\" ><img src='img/icon/delete.png' title='delete invoice' style='width:15px;height:15px;' /></a>";
	}


	return $data;
}

function printMortage($inv_id, $content, $mdate){
include("../mpdf/mpdf.php");
require_once  'includes/cons.php';
	//default page length is 160 for join       margin_left, margin_right, margin_top, margin_bottom, margin_header, margin_footer
$mpdf=new mPDF('utf-8', array(210,148), 0, '', 10, 10, 23, 1, 5,5); 

$html = '
<html>
'.PDF_HEAD_TEMPLATE_FOR_INVOICE.'
<body>
<!--mpdf
'.A6PDFContentHeader(PREFIX_MORTAGE_NR.$inv_id, $mdate).'
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



function getProductRowForA6ExportForMortage($inv_id){
	$sql="select 
	order_id, inv_id,
	(select mdate from invoices where inv_id=o.inv_id)mdate, 
	(select nm from tree_data where id=product_id)pro, 
	quantity, unit_weight, g_unit_price, unit_amount 
	from orders o where o.m_id=".$inv_id."";
	$rows=getFetchArray($sql);
	$rowCount=1;
	$result=array();
	$mdate=null;
	$data=null;
	foreach ($rows as $row){
		$data=$data. '<tr>
<td align="center">'.$rowCount.'</td>
<td>'.$row['pro'].'</td>
<td align="center">'.$row['quantity'].'</td>
<td align="center">'.$row['unit_weight'].'</td>
<td align="right">'.$row['g_unit_price'].'</td>
<td align="right">'.$row['unit_amount'].'</td>
</tr>';
		$mdate=$row['mdate'];
		$rowCount++;
	}
	$result['data']=$data;
	$result['mdate']=$mdate;
	$result['noRows']=$rowCount;
	return $result;	
}


function A6PDFContentTableForMortage($inv_id, $cust_id){
	$result=array();
	$productRow = getProductRowForA6ExportForMortage($inv_id);
	$totalsRow=getTotalRowForMortage($inv_id);
	$rowCount=$productRow['noRows'];
	$cellPadding=8;
	if($rowCount>=5){
		$cellPadding=4;	
	}
	$customerRow=getCustomerDetailsForA6Export($cust_id);
	//$totalsRow=getTotalsRow($inv_id);
	$data=
	'
	<div style="margin-top:1%;margin-left:1%;margin-right:1%;">
	<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="'.$cellPadding.'">
<thead>
<tr>
<td width="5%"></td>
<td width="30%">PRODUCT</td>
<td width="5%">QUANTITY</td>
<td width="15%">GRAMS</td>
<td width="20%">UNIT PRICE</td>
<td width="15%">AMOUNT</td>
</tr>
</thead>
<tbody>
<!-- ITEMS HERE -->

'.$productRow['data'].'

<!-- END ITEMS HERE -->
<tr>
<td class="blanktotal" colspan="4" rowspan="6" >
<div>
	<ul>
		<p>
		<br>'.$customerRow.'
		</p>
	</ul>
</div>
</td>
'.$totalsRow.'
</tbody>
</table>
</div>';
	
	$result['data']=$data;
	$result['mdate']=getSingleValue("select mdate from mortages where m_id=".$inv_id);
	return $result;

}

function getTotalRowForMortage($inv_id){
	$sql="select * from mortages where m_id=".$inv_id."";
	$rows=getFetchArray($sql);
	$data=null;
	foreach ($rows as $row){
		$data=$data.
'<td class="totals">Total</td>
<td class="totals">'.$row['total_price'].' CHF</td>

</tr>
<tr>
<td class="totals"><b> Amount</b></td>
<td class="totals"><b>'.$row['loan_amount'].' CHF</b></td>
</tr>
';
	}
	return $data;
}



