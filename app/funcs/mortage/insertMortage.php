<?php

function insertMortage($cust_id){
$sql="INSERT INTO mortages(m_id, cust_id, mdate) VALUES ( null, ".$cust_id.", now())";
executeSQL($sql);
$m_id = getSingleValue("select max(m_id) from mortages");
return $m_id;
}

function insertFullMortage($cust_id,$total_price,  $extra_amount, $net_amount,$deposit, $balance, $status ){
	$sql="INSERT INTO mortages(m_id, cust_id, total_price, extra_amount, net_amount, deposit, balance, mdate, status) 
	VALUES( null, ".$cust_id.", ".$total_price.", ".$extra_amount.", ".$net_amount.", ".$deposit.", ".$balance.", now(), ".$status."
	)";
	executeSQL($sql);
	$m_id = getSingleValue("select max(m_id) from mortages");
	return $m_id;	
}

function payMortage($mor_id, $deposit, $balance, $status){
	$sql="UPDATE mortages SET deposit=".$deposit.",balance=".$balance.", status=".$status." 
WHERE m_id=".$mor_id." 
	)";
	executeSQL($sql);
	return $mor_id;
}

function deleteMortage($mor_id){
	executeSQL("DELETE FROM ORDERS WHERE m_id=".$mor_id);
	executeSQL("DELETE FROM mortages WHERE m_id=".$mor_id);
	return $mor_id;
}


function displayMortageFormNew($errMsg){
	$content= $errMsg."<form action='mortage.php' method='post' enctype='multipart/form-data' id='customtheme'>
			<h6>Product Details</h6>
			<p>
				<table>
					<thead>
						<tr><th>S.No</th><th>Product *</th><th>Quantity *</th><th>Weight in g *</th><th>Price/g *</th></tr>
					</thead>
					<tbody>					
						".invoiceTicketRows(NO_OF_TICKETS)."						
					</tbody>
				</table>
			</p>	
			<p>
				<center><input type='submit' name='processOrder' value='Submit Order' id='submitbutton' /></center>
			</p>
		".getChoosyJSScriptCode()."	
		</form>";
	
	$page=null;	$insideHead=null;
	$page=getHTMLPage(INVOICE_FORM_TITLE_FOR_NEW_MORTAGE, INVOICE_FORM_TITLE_FOR_NEW_MORTAGE, $content, $insideHead, BGC_FOR_MORTAGE);
	return $page;
}

function displayMortageProductWithTotal(){
	$result=array();
	$totalOrders=0;$total_amount=0;$inv_id=null;
	$content= "<form action='mortage.php' method='post' enctype='multipart/form-data' id='customtheme'>
			<h6>Product Details</h6>
			<p>
				<table>
					<thead>
						<tr><th>S.No</th><th>Product *</th><th>Quantity *</th><th>Weight in g *</th><th>Price/g *</th><th>Unit Amount in CHF </th></tr>
					</thead>
					<tbody>					
										
					";
	for($i=1;$i<=NO_OF_TICKETS;$i++){
		$key="pname".$i;
		if(strlen($_POST[$key])!=0 && is_numeric($_POST[$key])){
			$prod_id=$_POST[$key];
			$quantity=$_POST['quan'.$i];
			
			$g_unit_weight=$_POST['weight'.$i];
			$g_unit_price=$_POST['price'.$i];
			$mcharges=null;
			$unit_amount=floatval(($g_unit_weight * $g_unit_price));			
			$total_amount=$total_amount+$unit_amount;
			$totalOrders++;
			$product_name=getSingleValue("select nm from tree_data where id=".$prod_id."");
			$content= $content.
			"<input type='hidden' name='pname".$i."' value='$prod_id' />
			<input type='hidden' name='quan".$i."' value='$quantity' />
			<input type='hidden' name='weight".$i."' value='$g_unit_weight' />
			<input type='hidden' name='price".$i."' value='$g_unit_price' />
			<tr>
				<td>".$i."</td>
				<td>".$product_name."</td>
				<td>".$quantity."</td>
				<td>".$g_unit_weight."</td>
				<td>".$g_unit_price."</td>
				<td>".$unit_amount."</td>
			</tr>";	
		}			
	}
	if($totalOrders>0){
		$content=$content. "</tbody>
				</table>
			</p>
			
			<p>
				<label for='total' style='vertical-align: top;'>Total Amount</label>				
				<label for='total'><font style='font-size:24px;color:#000000;'>".$total_amount."</font> CHF</label>
			</p>
			
			<p>
				<label for='total' style='vertical-align: top;'>Total No of Products</label>				
				<label for='discount'>".$totalOrders."</label>
			</p>
			
			<hr>
			
			<p>
				<label for='discount' style='vertical-align: top;'>Final Loan Amount</label>
				<input type='text' name='extra_amount' id='discount' style='width:150px;height:1px;' />
				<label for='discount'>CHF</label>
			</p>

			<p>
				<label for='discount' style='vertical-align: top;'>% of  Interest</label>
				<input type='text' name='monthlyInterest' id='discount' style='width:150px;height:1px;' />
				<label for='discount'>CHF</label>
			</p>
			
			<!--<p>
				<label for='deposit'>Deposit</label>
				<input type='text' name='deposit' id='deposit' style='width:150px;height:1px;' />
				<label for='deposit'>CHF</label>
			</p>-->
						
			<hr>
			".getCustomerForm()."
			<p>
				<center>
					<input type='submit' name='cancelOrder' value='Go Back' id='submitbutton' />
					<input type='submit' name='submitOrder' value='Submit Order' id='submitbutton' />
				</center>
			</p>
			".getChoosyJSScriptCode()."				
			</form>";
		$page=getHTMLPage(INVOICE_FORM_TITLE_FOR_NEW_MORTAGE, INVOICE_FORM_TITLE_FOR_NEW_MORTAGE, $content, $insideHead, BGC_FOR_MORTAGE);
		$result['isError']=false;
		$result['data']=$page;
		return $result;
		
	}else{
		$result['isError']=true;
		$result['errMsg']="<p id='errMsg'>Select a product and then submit</p>";
		return $result;
	}		
}


