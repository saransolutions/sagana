<?php
function displayFormToEditInvoice($inv_id, $errMsg, $role){
	$flag=3;
	$content=null;
	$insideHead=null;
	$data=null;
	$rows=getFetchArray(getInvoiceDetailsByIdSQL($inv_id));
	foreach ($rows as $result)
	{
		$content=getInvoiceFieldsForEdit( $result['mdate'], $result['inv_id'], $result['discount'],$result['deposit'],$flag, $role, $result['cust_id']);
	}
	$heading="Edit Invoice - ".PREFIX_INV_NR.$inv_id;
	$data=getHTMLPage(MAIN_TITLE,$heading,$content, $insideHead, BGC_FOR_INVOICE);
	return $data;

}
	
function getInvoiceFieldsForEdit($bdate, $inv_id, $discount,$deposit,$flag, $role, $cust_id){
return "<p><label>Purchase Date</label><label>".$bdate."</label></p>
Product Details 
<form method='POST' action='invoice.php' name='editInvoice'>
".getProductDetailsByInvIdForEdit($inv_id)." 
<hr>
Transaction Details
<p><label>Discount</label> <label><input style='height:1px;width:80px;' type='text' name='discount'  value='".$discount."' /></label></p>
<p><label>Deposit</label><label><input style='height:1px;width:80px;' type='text' name='deposit'  value='".$deposit."' /></label></p>
".getSubmitButton($flag, $inv_id, $role, $cust_id)."</form>";

}
	
function getProductDetailsByInvIdForEdit($inv_id){
	$data=null;
	$rowCount=1;
	$rows=getFetchArray("select order_id, inv_id, (select nm from tree_data where id=product_id)pro, quantity, unit_weight, g_unit_price, unit_amount from orders where inv_id=".$inv_id."");
	if(count($rows)>0){
		$data="<table>
	<thead>
		<tr>			
			<th>S.No</th>							
			<th>Product</th>							
			<th>Quantity</th>
			<th>Weight in Grams</th>
			<th>Price Per Gram in CHF </th>
		</tr>
	</thead>
	<tbody>";
		foreach ($rows as $result)
		{
			$pro=getSelectBoxById("select t.id key_id, nm value from tree_data t where t.id!=1", "pname".$rowCount."", "pname".$rowCount."", "", $result['pro']);
			
			$data =$data. "<tr>
			<td>".$rowCount."</td>			
			<td>".$pro."</td>
			<input type='hidden' name='trans_id".$rowCount."' value='".$result['order_id']."' />			
			<td><input style='height:1px;width:40px;' type='text' name='quan".$rowCount."'  value='".$result['quantity']."' /></td>
			<td><input style='height:1px;width:80px;' type='text' name='weight".$rowCount."'  value='".$result['unit_weight']."' /></td>
			<td><input style='height:1px;width:80px;' type='text' name='price".$rowCount."'  value='".$result['g_unit_price']."' /></td>				
			</tr>";
			$rowCount++;
		}
		return $data."
		<input type='hidden' name='total_no_of_products' value='".$rowCount."' />
		</tbody>
</table>";
	}
}


function updateInvoice($inv_id, $total, $discount, $deposit){
	$total_amount=null;
	for($i=1;$i<=$total;$i++){
		$key="pname".$i;
		if(strlen($_POST[$key])!=0 && is_numeric($_POST[$key])){
			$prod_id=$_POST[$key];
			$quantity=$_POST['quan'.$i];
			$g_unit_weight=$_POST['weight'.$i];
			$g_unit_price=$_POST['price'.$i];						
			$unit_amount=floatval(($g_unit_weight * $g_unit_price));
			$total_amount=$total_amount+$unit_amount;
			$trans_id=$_POST['trans_id'.$i];
			if(!is_null($trans_id)){
				$sql="UPDATE orders SET 
				product_id=".$prod_id.",
				quantity=".$quantity.",
				unit_weight=".$g_unit_weight.",
				g_unit_price=".$g_unit_price.",				
				unit_amount=".$unit_amount." WHERE order_id=".$trans_id."";
				executeSQL($sql);
			}
		}
			
	}
	$net_amount=($total_amount-$discount);
	$balance=$net_amount-$deposit;
	$status=STATUS_UNPAID_VALUE;
	if($balance==0){
		$status=STATUS_PAID_VALUE;
	}
	updateTransaction($inv_id, $total_amount, $discount, $net_amount, $deposit, $balance, $status);

}


function updateInvoiceForCustomer($inv_id, $cust_id){
	$sql="update invoices set cust_id=".$cust_id." where inv_id=".$inv_id."";
	executeSQL($sql);
}


	
