<?php

if(isset($_GET['inv_id'])){
$inv_id=$_GET['inv_id'];
$result=getInvoice($inv_id);
if(!is_null($result)){
	
printPDF($inv_id, $result['data'], null,null);	
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

function printPDF($inv_id, $data,$cancel_charge,$baggage){

include("../mpdf/mpdf.php");
require_once  'includes/cons.php';

$mpdf=new mPDF('win-1252','A4','','',20,15,48,25,10,10); 
$mpdf->useOnlyCoreFonts = true;    // false is default
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle(GPDF_Title);
$mpdf->SetAuthor(GPDF_Author);
$mpdf->SetWatermarkText("Paid");
$mpdf->showWatermarkText = false;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');

$html = '
<html>
'.PDF_HEAD_TEMPLATE.'
<body>
<!--mpdf
'.returnPDFHeader($inv_id).'
'.returnPDFFooter($cancel_charge, $baggage).'
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
'.$data.'
</body>
</html>
';

$mpdf->WriteHTML($html);
$mpdf->Output(); exit;
exit;
}
?>