<?php

if(isset($_GET['inv_id'])){
$inv_id=$_GET['inv_id'];
$result=getInvoice($inv_id);
if(!is_null($result)){
	
printPDF($inv_id, $result['data'], 160);
	
}

}

function getInvoice($inv_id){
	$result=array();
	include_once 'includes/cons.php';
	include_once 'funcs/db/db.php';	
	require_once 'funcs/invoice/singleInvoice.php';
	$data=null;$cancel_charge=null;	
	$rows=getFetchArray(getInvoiceDetailsByIdSQL($inv_id));
	foreach ($rows as $result)
	{

		$inv_id= $result['inv_id'];
		$bdate= $result['mdate'];
		$cust_id=$result['cust_id'];
		$total_amount=$result['total_price'];

		$discount=$result['discount'];
		$net_amount=$result['net_amount'];
		$deposit=$result['deposit'];
		$balance=$result['balance'];
		$status=$result['status'];

		$data=$data."	
		Product Details<br>	
		<table  id='custTable1' style='width:100%;border-left:0.1mm solid #BFBFBC;'>					
		<thead>
			<tr>			
			<th>S.No</th>							
			<th>Product</th>							
			<th>Quantity</th>
			<th>Weight in Grams</th>
			<th>Price Per Gram in CHF </th>
			<th>Unit Amount</th>							
		</tr>
	</thead>
	<tbody>
		".getTicketDetails($inv_id, null)."
	</tbody>
</table>
";
	}
	$result['data']=$data;
	
	
	return $result;
	
}

function printsamplePDF(){
include("../mpdf/mpdf.php");
require_once  'includes/cons.php';
	
$header = 'Document header';
$html   = 'Your document content goes here';
$footer = 'Print date: ' . date('d.m.Y H:i:s') . '<br />Page {PAGENO} of {nb}';

$mpdf = new mPDF('utf-8', array(80,236), 0, '', 12, 12, 25, 15, 12, 12);
$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLFooter($footer);
$mpdf->SetJS('this.print();');
$mpdf->WriteHTML($html);
$mpdf->Output();
}


function printPDF($inv_id, $data,$cancel_charge){

include("../mpdf/mpdf.php");
require_once  'includes/cons.php';
//									margin_left, margin_right, margin_top, margin_bottom, margin_header, margin_footer
$mpdf=new mPDF('utf-8', array(80,$cancel_charge), 0, '', 4, 4, 25, 25, 12, 12); 

$html = '
<html>
'.PDF_HEAD_TEMPLATE.'
<body>
<!--mpdf
<htmlpageheader name="myheader">
<div style="margin-left:2%;padding-left:2%;">
<img src="img/logo/'.MAIN_LOGO_IMG.'" style="border:none;float:left;height:8%;"/>
	<span style="float:left;font-size:1.6em;">'.MAIN_TITLE.'</span>
	
	<br /><span style="font-size:0.9em;">'.HEAD_ADDRESS_LINE_1.'</span><br />			
	<span style="font-size:0.9em;">&#9742;'.HEAD_PHONE.'</span><br />			
	<span style="font-size:0.9em;">'.HEAD_WED_ADDRESS.' www.saganajewellery.com</span>
</div>
<hr>
</htmlpageheader>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<div style="margin-top:12%;margin-left:1%;margin-right:1%;">
<p style="margin-left:15%;">verkaufen / Kaufen / Reparatur</p>
<table id="custTable1" style="width:100%;border-left:0.1mm solid #BFBFBC;background:#E9E9E2;">
<tr><td colspan="2">Member Details</td></tr>
<tr>
	<td>ID</td>
	<td>SAJ-008</td>
</tr>
<tr>
	<td>Date</td>
	<td>14-11-2014</td>
</tr>
<tr>
	<td>Name</td>
	<td>Sundaravel Natarajan</td>
</tr>
<tr>
	<td>Address</td>
	<td>226, schwarzenburgstrasse
	<br>3097,Liebefeld
	<br>Bern,
	<br>Switzerland.
	</td>
</tr>
</table>

<br>
<table id="custTable1" style="width:100%;border-left:0.1mm solid #BFBFBC;">
<tr><td style="width:50%;">Monthly Amount</td><td style="width:50%;">150 CHF</td></tr>
<tr><td style="width:50%;">Status</td><td style="width:50%;">Active</td></tr>
</table>



</div>
<htmlpagefooter name="myfooter">
<div style="margin:0%;background:#E9E9E2;padding:2%;">
<p style="margin-left:30%;margin-top:0%;"><b>Our Services</b></p>
<p style="font-size:0.9em;">All Country telephone cards, SIM cards, Money Transfer to India & Srilanka.</p>
</div>
<p style="margin-left:12%;font-family:ind_ta_1_001;color:#000;">Danke நன்றி !!!  மீண்டும் வருக !!!</p>	
</htmlpagefooter>
</body>
</html>
';
//$mpdf->SetJS('this.print();');
$mpdf->WriteHTML($html);
$mpdf->Output('SAJ-008.pdf','I');
exit;
}
?>