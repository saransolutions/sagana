<?php

function displayInvoiceById($inv_id, $role){
	$flag=2;$content=null;$insideHead=null;
	$data=null;
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
		if ($status==STATUS_ORDERED_VALUE || $status==STATUS_UNPAID_VALUE ){
			$flag=9;
		}
				
		$content=getInvoiceFields($bdate, $inv_id, $total_amount, $discount,$net_amount,$deposit, $balance, displayOrderStatus($status), $cust_id, $flag, $role);			
	}
	$heading="Invoice - ".PREFIX_INV_NR.$inv_id;
	$data=getHTMLPage(MAIN_TITLE,$heading,$content, $insideHead, BGC_FOR_INVOICE);
	return $data;

}

function getInvoiceFields($bdate, $inv_id, $total_amount, $discount,$net_amount,$deposit, $balance, $statusStr, $cust_id, $flag, $role){
return "<p><label>Purchase Date</label><label>".$bdate."</label></p>
Product Details 
".getTicketDetailsByInvId($inv_id, 1)." 
<hr>
Transaction Details 
<p><label>Total Price</label> <label>".$total_amount."</label> </p>
<p><label>Discount</label> <label>".$discount."</label></p>
<p><label>Net Price</label> <label><font style='font-size:18px;'>".$net_amount."</font> CHF</label></p>
<p><label>Deposit</label><label>".$deposit."</label></p>
<p><label>Balance</label><label><font style='font-size:18px;font-style:italic;'>".$balance."</font> CHF</label> </p>
<p> <label>Status</label> <label>".$statusStr."</label> </p>
".getCustomerDetailsForForm($flag, $cust_id)."		 						
".getSubmitButton($flag, $inv_id,$cust_id, $role);
}


function displayFormToPayInvoice($inv_id, $errMsg, $role){
	$flag=4;$content=null;$insideHead=null;
	$data=null;
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
		$content=$errMsg.getInvoiceFieldsForPay($bdate, $inv_id, $total_amount, $discount,$net_amount,$deposit, $balance, displayOrderStatus($status), $cust_id, $flag, $role);			
	}
	$heading="Invoice - ".PREFIX_INV_NR.$inv_id;
	$data=getHTMLPage(MAIN_TITLE,$heading,$content, $insideHead, BGC_FOR_INVOICE);
	return $data;

	}
	
function getInvoiceFieldsForPay($bdate, $inv_id, $total_amount, $discount,$net_amount,$deposit, $balance, $statusStr, $cust_id, $flag, $role){
	
	
$data="<form action='invoice.php' name='payInvoice' method='post'>";
$data=$data."<p><label>Purchase Date</label><label>".$bdate."</label></p>
Product Details 
".getTicketDetailsByInvId($inv_id, 1)." 
<hr>
Transaction Details 
<p><label>Total Price</label> <label>".$total_amount."</label> </p>
<p><label>Discount</label> <label>".$discount."</label></p>
<p><label>Net Price</label> <label><font style='font-size:18px;'>".$net_amount."</font> CHF</label></p>
<p><label>Deposit</label><label><input type='text' name='pay_amount' style='height:1px;width:80px;'></input> CHF </label></p>
<input type='hidden' name='balance' value='".$balance."' />
<input type='hidden' name='deposit' value='".$deposit."' />
<p><label>Balance</label><label><font style='font-size:18px;font-style:italic;'>".$balance."</font> CHF</label> </p>
<p> <label>Status</label> <label>".$statusStr."</label> </p>	 						
".getSubmitButton($flag, $inv_id,$cust_id, $role)."</form>";
return $data;
}



