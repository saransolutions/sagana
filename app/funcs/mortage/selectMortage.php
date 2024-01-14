<?php


function displayMortageById($inv_id, $role){
	$flag=2;$content=null;$insideHead=null;
	$data=null;
	$rows=getFetchArray(getMortageDetailsByIdSQL($inv_id));
	foreach ($rows as $result)
	{
		$inv_id= $result['m_id'];
		$bdate= $result['mdate'];
		$cust_id=$result['cust_id'];
		$total_amount=$result['total_price'];
		$perInterest=$result['per_interest'];
		$interest_amount=$result['interest_amount'];
		$net_amount=$result['loan_amount'];
		$deposit=$result['deposit'];
		$balance=$result['balance'];
		$status=$result['status'];
		if ($status==STATUS_ORDERED_VALUE || $status==STATUS_UNPAID_VALUE ){
			$flag=9;
		}				
		$content=getInvoiceFields($bdate, $inv_id, $total_amount,$perInterest, $interest_amount, $net_amount, $deposit, $balance, displayOrderStatus($status), $cust_id, $flag, $role);			
	}
	$heading="Mortage - ".PREFIX_MORTAGE_NR.$inv_id;
	$data=getHTMLPage(MAIN_TITLE,$heading,$content, $insideHead, BGC_FOR_MORTAGE);
	return $data;

}

function getInvoiceFields($bdate, $inv_id, $total_amount,$per_interest, $extra_amount,$net_amount,$deposit, $balance, $statusStr, $cust_id, $flag, $role){
return "<p><label>Mortage Start Date</label><label>".$bdate."</label></p>
Product Details 
".getTicketDetailsByInvId($inv_id, 2)." 
<hr>
Transaction Details 
<p><label>Total Price</label> <label>".$total_amount."</label> </p>

<p><label>Final Loan Amount</label> <label><font style='font-size:18px;'>".$net_amount."</font> CHF</label></p>
<p><label>% of Interest</label> <label><font style='font-size:18px;'>".$extra_amount."</font></label></p>
<p><label>Monthly Interest</label> <label><font style='font-size:18px;'>".$extra_amount."</font> CHF</label></p>
<p><label>Deposit</label><label>".$deposit."</label></p>
<p><label>Balance</label><label><font style='font-size:18px;font-style:italic;'>".$balance."</font> CHF</label> </p>
<p> <label>Status</label> <label>".$statusStr."</label> </p>
".getMortageTransactionDetails($inv_id)."
".getCustomerDetailsForForm($flag, $cust_id)."		 						
".getLinksForMortage($flag, $inv_id,$cust_id, $role);
}


function getLinksForMortage($flag, $inv_id, $cust_id, $role){	
	$buttonForDelete="<a href='mortage.php?d_m_id=".$inv_id."' onclick=\"return confirm('Are you sure to delete this Mortage ?')\" id='id11'>
						<img src='img/icon/delete.png' title='delete mortage' style='width:15px;height:15px;' /> Delete
					</a>";

		
		$buttonForEdit="<a id='id11' href='mortage.php?edit_id=".$inv_id."'>
						<img src='img/icon/edit.png' title='edit invoice' style='width:15px;height:15px;' /> Edit Mortage
					</a>";
		
		$buttonForPay="<a id='id11' href='mortage.php?pinv_id=".$inv_id."'>
						<img src='img/icon/pay.png' title='pay invoice' style='width:15px;height:15px;' /> Pay Mortage
					</a>";
		
		$buttonToPayInterest="<a id='id11' href='mortage.php?pint_id=".$inv_id."'>
						<img src='img/icon/pay_interest.png' title='pay invoice' style='width:18px;height:18px;' /> Pay Interest
					</a>";
		
		$buttonToPrintMortage="<a id='id11' href='mortage.php?pmor_id=".$inv_id."'>
						<img src='img/icon/print.png' title='pay invoice' style='width:18px;height:18px;' /> Print Mortage
					</a>";
		
		
		$buttonForCustomer=null;
if(is_null($cust_id)){
	$buttonForCustomer="<a id='id11' href='customer.php?add_custm_id=".$inv_id."'><img src='img/icon/add_customer.png' title='Add Customer' style='width:15px;height:15px;' />Add Customer</a>";
}else{
	$buttonForCustomer="<a id='id11' href='customer.php?ecust_id=".$cust_id."'><img src='img/icon/edit_customer.png' title='Edit Customer' style='width:15px;height:15px;'/>Edit Customer</a>";
}
		if($role=='admin'){
			$data=null;
			$data=$data. "
		<p style='margin-top:40px;'>						
			<li style='list-style:none;'>
				 ".$buttonForEdit;
				if($flag==9){
					$data=$data." | ".$buttonForPay. " | ".$buttonToPayInterest." | ".$buttonToPrintMortage;		
				}				
			$data=$data				
				." | ".$buttonForCustomer
				." | ".$buttonForDelete
				." | <a id='id11' href='index.php'>Home</a>
			</li>
		</p>";
		}else{
			$data=null;
			$data=$data. "
		<p style='margin-top:40px;'>						
			<li style='list-style:none;'>" 
				.$buttonForEdit;
				if($flag==9){
					$data=$data." | ".$buttonForPay." | ".$buttonToPayInterest." | ".$buttonToPrintMortage;		
				}				
			$data=$data." | ".$buttonForCustomer				
				." | <a id='id11' href='index.php'>Home</a>
			</li>
		</p>";
		}	
		return $data;
}

