<?php



function displayFormToEditMortage($inv_id, $errMsg, $role){
	$flag=3;
	$content=null;
	$insideHead=null;
	$data=null;
	$rows=getFetchArray(getMortageDetailsByIdSQL($inv_id));
	foreach ($rows as $result)
	{
		$content=getMortageFieldsForEdit( $result['mdate'], $result['m_id'], $result['extra_amount'],$result['deposit'],$flag, $role, $result['cust_id']);
	}
	$heading="Edit Mortage - ".PREFIX_MORTAGE_NR.$inv_id;
	$data=getHTMLPage(MAIN_TITLE,$heading,$content, $insideHead, BGC_FOR_MORTAGE);
	return $data;

}
	
function getMortageFieldsForEdit($bdate, $inv_id, $discount,$deposit,$flag, $role, $cust_id){
return "<p><label>Mortage Start Date</label><label>".$bdate."</label></p>
Product Details 
<form method='POST' action='mortage.php' name='editInvoice'>
".getProductDetailsByMorIdForEdit($inv_id)." 
<hr>
Transaction Details
<p><label>Extra Amount</label> <label><input style='height:1px;width:80px;' type='text' name='discount'  value='".$discount."' /></label></p>
<p><label>Deposit</label><label><input style='height:1px;width:80px;' type='text' name='deposit'  value='".$deposit."' /></label></p>
".getSubmitButton($flag, $inv_id, $role, $cust_id)."</form>";

}
	
function getProductDetailsByMorIdForEdit($inv_id){
	$data=null;
	$rowCount=1;
	$sql=getProductsDetailsByMortageIdSQL($inv_id);
	$rows=getFetchArray($sql);
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


function updateMortage($inv_id, $total, $discount, $deposit){
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
	$net_amount=($discount);
	$balance=$net_amount-$deposit;
	$status=STATUS_UNPAID_VALUE;
	if($balance==0){
		$status=STATUS_PAID_VALUE;
	}
	updateMortageForTransaction($inv_id, $total_amount, $discount, $net_amount, cheNull($deposit), $balance, cheSNull($status));

}


function updateMortageForCustomer($inv_id, $cust_id){
	$sql="update mortages set cust_id=".$cust_id." where m_id=".$inv_id."";
	executeSQL($sql);
}

function displayFormToPayMortage($inv_id, $errMsg, $role){
	$flag=4;$content=null;$insideHead=null;
	$data=null;
	$rows=getFetchArray(getMortageDetailsByIdSQL($inv_id));
	foreach ($rows as $result)
	{
		$inv_id= $result['m_id'];
		$bdate= $result['mdate'];
		$cust_id=$result['cust_id'];
		$total_amount=$result['total_price'];

		$discount=null;
		$net_amount=$result['net_amount'];
		$deposit=$result['deposit'];
		$balance=$result['balance'];
		$status=$result['status'];
		$content=$errMsg.getMortageFieldsForPay($bdate, $inv_id, $total_amount, $discount,$net_amount,$deposit, $balance, displayOrderStatus($status), $cust_id, $flag, $role);			
	}
	$heading="Invoice - ".PREFIX_INV_NR.$inv_id;
	$data=getHTMLPage(MAIN_TITLE,$heading,$content, $insideHead, BGC_FOR_MORTAGE);
	return $data;

	}
	
function getMortageFieldsForPay($bdate, $inv_id, $total_amount, $discount,$net_amount,$deposit, $balance, $statusStr, $cust_id, $flag, $role){
	
	
$data="<form action='mortage.php' name='payInvoice' method='post'>";
$data=$data."<p><label>Purchase Date</label><label>".$bdate."</label></p>
Product Details 
".getTicketDetailsByInvId($inv_id, 2)." 
<hr>
Transaction Details 
<p><label>Total Price</label> <label>".$total_amount."</label> </p>
<p><label>Final Loan Amount</label> <label><font style='font-size:18px;'>".$net_amount."</font> CHF</label></p>
<p><label>Deposit</label><label><input type='text' name='pay_amount' style='height:1px;width:80px;'></input> CHF </label></p>
<input type='hidden' name='balance' value='".$balance."' />
<input type='hidden' name='deposit' value='".$deposit."' />
<p><label>Balance</label><label><font style='font-size:18px;font-style:italic;'>".$balance."</font> CHF</label> </p>
<p> <label>Status</label> <label>".$statusStr."</label> </p>	 						
".getSubmitButton($flag, $inv_id,$cust_id, $role)."</form>";
return $data;
}


function checkMortageStatus(){
	$sql="SELECT TIMESTAMPDIFF(MONTH, mdate, now())t1, m_id, mdate, per_interest, interest_amount, balance, loan_amount from mortages where balance > 0";
	$rows=getFetchArray($sql);
	if(count($rows)>0){
		foreach ($rows as $row){
			$mor_id = $row['m_id'];
			$mdate = $row['mdate'];
			$monthly_interest = $row['interest_amount'];
			$net_amount = $row['loan_amount'];
			$balance=$row['balance'];
			$term =$row['t1'];
			if($term>0){
				$paid = countPaidTermsByMorId($mor_id);
				$remain = $term - $paid;
				if($remain>0){
					$amount = $remain*$monthly_interest;
					$newBalance=$balance+$amount;
					if($newBalance>0){
						$mtrans_id=getSingleValue("select max(trans_id) from mortage_transactions where m_id = ".$mor_id);
						$sql="select * from (SELECT TIMESTAMPDIFF(MONTH, mdate, now())diff from mortage_transactions where trans_id=".$mtrans_id." )t2 where diff = 1";
						$alreadyAdded=getSingleValue($sql);
						if(!is_null($alreadyAdded) && strlen($alreadyAdded) > 0){
							addMortageInterestByAuto($mor_id,$newBalance,$newBalance );
						}
					}
				}
			}
		}
	}
}

function countPaidTermsByMorId($mor_id){
	$rowCount=0;
	$sql="select * from mortage_transactions where m_id=".$mor_id." and action='SUB'";
	$rows=getFetchArray($sql);
	return count($rows);
}
