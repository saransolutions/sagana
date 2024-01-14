<?php

function A6PDFContentHeader($inv_id, $mdate){
	$bdate = date('d.m.y', strtotime($mdate));
	return '<htmlpageheader name="myheader">
<table width="100%">
	<tr>
		<td style="float:left;width:60%;">
			<span style="float:left;font-size:1.6em;">'.MAIN_TITLE.'</span>
			<br />	
			'.HEAD_ADDRESS_LINE_1.'<br /><span>&#9742;</span>'.HEAD_PHONE.'<br />			
			'.HEAD_WED_ADDRESS.'		
		</td>
		<td width="50%" style="text-align: right;">
			Invoice No :	<span style="font-weight: bold; font-size: 12pt;">'.$inv_id.'</span><br />			
			</span><br />
			Invoice Date :	'.$bdate.'			
			</span>
		</td>
</tr>
</table>
<hr>
</htmlpageheader>';
}

function A6PDFContentFooter(){
	return '<htmlpagefooter name="myfooter">	
	<p style="margin-left:2%;font-family:ind_ta_1_001;color:#000;"><font style="font-size:0.8em;">* எந்த காரணம் கொண்டும் விற்ற நகைகள் திரும்ப பெற மாட்டது.</font> 
	<br>Danke நன்றி !!!  மீண்டும் வருக !!!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Signature&nbsp;
	</p>
'.PDF_FOOTER_SARAN_SOLUTIONS.'	

</htmlpagefooter>';
}



function A6PDFContentTable($inv_id, $cust_id){
	$result=array();
	//$rows=getFetchArray(getInvoiceDetailsByIdSQL($inv_id));
	$productRow = getProductRowForA6Export($inv_id);
	$rowCount=$productRow['noRows'];
	$cellPadding=8;
	if($rowCount>=5){
		$cellPadding=4;	
	}
	$customerRow=getCustomerDetailsForA6Export($cust_id);
	$totalsRow=getTotalsRow($inv_id);
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
	$result['mdate']=$productRow['mdate'];
	return $result;

}

function getProductRowForA6Export($inv_id){
	$sql="select 
	order_id, inv_id,(select mdate from invoices where inv_id=o.inv_id)mdate, 
	(select nm from tree_data where id=product_id)pro, 
	quantity, unit_weight, g_unit_price, unit_amount 
	from orders o where o.inv_id=".$inv_id."";
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








function getCustomerDetailsForA6Export($cust_id){
	if(is_null($cust_id) || strlen($cust_id) == 0){
		return;
	}
	$rows=getFetchArray("select * from customer where cust_id=".$cust_id." ");
	if(count($rows) == 0){
		return;
	}
	$rowCount=1;
	$del="<br>";
	$data="<b>Customer Details</b><br>";
	foreach ($rows as $row){
		$data=$data.$row['cname'].$del.'
		'.$row['street'].' '.$del.'
		'.$row['zip'].' '.$row['city'].'.'.$del.'
		'.$del.'
		'.$row['mobile'].''.$del.'
		'.$row['email'].'';
		$rowCount++;
	}
	return $data;
}

function getTotalsRow($inv_id){
	$sql="select * from transactions where inv_id=".$inv_id."";
	$rows=getFetchArray($sql);
	$data=null;
	foreach ($rows as $row){
		$data=$data.
'<td class="totals">Subtotal</td>
<td class="totals">'.$row['total_price'].' CHF</td>
</tr>
<tr>
<td class="totals">Old Gold/Discount</td>
<td class="totals">'.$row['discount'].' CHF</td>
</tr>
<tr>
<td class="totals"><b>Net Amount</b></td>
<td class="totals"><b>'.$row['net_amount'].' CHF</b></td>
</tr>
<tr>
<td class="totals">Deposit</td>
<td class="totals">'.$row['deposit'].' CHF</td>
</tr>
<tr>
<td class="totals"><b>Balance</b></td>
<td class="totals"><b>'.$row['balance'].' CHF</b></td>
</tr>
<tr>
<td class="totals">Status</td>
<td class="totals">'.$row['status'].'</td>
</tr>
';
	}
	return $data;
}