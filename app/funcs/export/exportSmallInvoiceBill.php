<?php

function smallInvoicePrint($inv_id, $cust_id){
	$result=smallInvoicePrintDetailsTable($inv_id, $cust_id);
	return '<div style="margin-left:1%;margin-right:1%;">
<p style="font-size:8pt;">Invoice No - <b>'.PREFIX_INV_NR.$inv_id.'</b><br> 
Invoice Date - '.$result['date'].' 
</p>
'.$result['table'].'
</div>';
}


function smallInvoicePrintDetailsTable($inv_id, $cust_id){
	$result=array();
	
	$sql="select
	order_id, inv_id,
	(select mdate from invoices where inv_id=o.inv_id)mdate, 
	(select nm from tree_data where id=product_id)pro, 
	quantity, unit_weight, g_unit_price, unit_amount 
	from orders o where o.inv_id=".$inv_id;
	$rows=getFetchArray($sql);
	$data=null;
	if(count($rows)>0){
		$rowCount=1;
		$tableStyle='style="width:100%;"';
		$data= '<div style="margin-top:1%;margin-left:1%;margin-right:1%;">
	<table id="custTable1" '.$tableStyle.'>
<thead>
<tr>
<td width="5%" style="border-left:0.1mm solid #BFBFBC;"></td>
<td width="45%">Product</td>
<td width="5%">N0s</td>
<td width="15%">Grams</td>
<td width="15%">Price</td>
<td width="15%">Amount</td>
</tr>
</thead>
<tbody>
<!-- ITEMS HERE -->
<!-- END ITEMS HERE -->
';		
		$date=null;
		foreach ($rows as $row){
			$data=$data.
'<tr>
<td align="center" style="border-left:0.1mm solid #BFBFBC;">'.$rowCount.'</td>
<td>'.$row['pro'].'</td>
<td align="center">'.$row['quantity'].'</td>
<td align="center">'.$row['unit_weight'].'</td>
<td align="right">'.$row['g_unit_price'].'</td>
<td align="right">'.$row['unit_amount'].'</td>
</tr>';
			$rowCount++;
			$date=$row['mdate'];
		}
		$data=$data.getTotalsRowForSmallBill($inv_id).
"
<tr>
<td colspan='6' style='border:none;'><div>
	<ul>
		<p>
		<br>".getCustomerDetailsForA6Export($cust_id)."
		</p>
	</ul>
</div>
</td>
</tr>";
	}

	$data=$data.	
	"</tbody>
</table>
</div>";
	$result['table']=$data;
	$result['date']=$date;
	return $result;

}


function getTotalsRowForSmallBill($inv_id){
	$sql="select * from transactions where inv_id=".$inv_id."";
	$rows=getFetchArray($sql);
	$data=null;
	if(count($rows)>0){
		$data=$data."<tr>";
		foreach ($rows as $row){
			$data=$data.
				'
				<td class="blanktotal" colspan="2" rowspan="6" style="border-left:none;border-bottom:none;" >
				<td class="totals" colspan="2">Subtotal</td>
				<td class="totals" colspan="4">'.$row['total_price'].' CHF</td>
				</tr>
				<tr>
				<td class="totals" colspan="2">Old Gold/Discount</td>
				<td class="totals" colspan="4">'.$row['discount'].' CHF</td>
				</tr>
				<tr>
				<td class="totals" colspan="2"><b>Net Amount</b></td>
				<td class="totals" colspan="4"><b>'.$row['net_amount'].' CHF</b></td>
				</tr>
				<tr>
				<td class="totals" colspan="2">Deposit</td>
				<td class="totals" colspan="4">'.$row['deposit'].' CHF</td>
				</tr>
				<tr>
				<td class="totals" colspan="2"><b>Balance</b></td>
				<td class="totals" colspan="4"><b>'.$row['balance'].' CHF</b></td>
				</tr>
				<tr>
				<td class="totals" colspan="2">Status</td>
				<td class="totals" colspan="4">'.$row['status'].'</td>
				';
		}
		$data=$data."</tr>";
	}

	return $data;
}