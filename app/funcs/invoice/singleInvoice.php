<?php

function deleteInvoiceById($inv_id){
	require_once 'funcs/db/db.php';
	executeSQL("delete from orders where inv_id=".$inv_id);
	executeSQL("delete from transactions where inv_id=".$inv_id);	
	executeSQL("delete from invoices where inv_id=".$inv_id);
	
	header('Location: index.php');
	exit();
}

function deleteAllInvoices(){
	require_once 'funcs/db/db.php';
	executeSQL("delete from passengers");
	executeSQL("delete from tickets");
	executeSQL("delete from transactions");
	executeSQL("delete from invoices");
	header('Location: index.php');
	exit();
}

function getTicketDetailsByInvId($inv_id, $flag){
	$data= 
"<table>
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
	<tbody>";
	if($flag==1){
		$data=$data.getTicketDetails(getProductsDetailsByInvoiceIdSQL($inv_id));
	}else{
		$data=$data.getTicketDetails(getProductsDetailsByMortageIdSQL($inv_id));
	}
	$data=$data."
	</tbody>
</table>";
	return $data;
}

function getInputBoxForForm($flag,$name,$style,$value){
	if($flag==1){
		return "<td><input type='text' name='".$name."' style='".$style."'/></td>";
	}else if($flag==3){
		return "<td><input type='text' name='".$name."' style='".$style."' value='".$value."'/></td>";
	}else{
		return "<td style='".$style."'>".$value."</td>";
	}
}

function getSubmitButton($flag, $inv_id,$cust_id, $role){
	if($flag==1){
		return "<p style='margin-top:40px;'>
	<input type='hidden' value='".$inv_id."' name='update_id' />
	<center>
		<input type='submit' name='completeInvoice' value='Complete' id='submitbutton' />
	</center>
</p>";
	}
	
	if($flag==4){
		return "<p style='margin-top:40px;'>
	<input type='hidden' value='".$inv_id."' name='pinv_id' />
	<center>
		<input type='submit' name='payInvoice' value='Pay' id='submitbutton' />
	</center>
</p>";
	}
	
if($flag==7){
		return "<p style='margin-top:40px;'>
	<input type='hidden' value='".$inv_id."' name='escheme_id' />
	<center>
		<input type='submit' name='updateScheme' value='Update Scheme' id='submitbutton' />
	</center>
</p>";
	}
	
	if($flag==3){
		return "<p style='margin-top:40px;'>
	<input type='hidden' value='".$inv_id."' name='update_id' />
	<center>
		<input type='submit' name='editInvoice' value='Update' id='submitbutton' />
	</center>
</p>";
	}else{
		
		$buttonForDelete="<a href='invoice.php?d_inv_id=".$inv_id."' onclick=\"return confirm('Are you sure to delete this Invoice ?')\" id='id11'>
						<img src='img/icon/delete.png' title='delete invoice' style='width:15px;height:15px;' /> Delete
					</a>";

		$buttonForExport="<a id='id11' href='invoice.php?iprint=".$inv_id."' target='_blank'>
						<img src='img/icon/icon_pdf.png' title='export to pdf' style='width:15px;height:15px;' /> Export to PDF
					</a>";

		$buttonForEdit="<a id='id11' href='invoice.php?edit_id=".$inv_id."'>
						<img src='img/icon/edit.png' title='edit invoice' style='width:15px;height:15px;' /> Edit Invoice
					</a>";
		
		$buttonForPay="<a id='id11' href='invoice.php?pinv_id=".$inv_id."'>
						<img src='img/icon/pay.png' title='pay invoice' style='width:15px;height:15px;' /> Pay Invoice
					</a>";
		$buttonForCustomer=null;
if(is_null($cust_id)){
	$buttonForCustomer="<a id='id11' href='customer.php?add_cust_id=".$inv_id."'><img src='img/icon/add_customer.png' title='Add Customer' style='width:15px;height:15px;' />Add Customer</a>";
}else{
	$buttonForCustomer="<a id='id11' href='customer.php?ecust_id=".$cust_id."'><img src='img/icon/edit_customer.png' title='Edit Customer' style='width:15px;height:15px;'/>Edit Customer</a>";
}
		if($role=='admin'){
			$data=null;
			$data=$data. "
		<p style='margin-top:40px;'>						
			<li style='list-style:none;'>
				 ".$buttonForExport." | "
				.$buttonForEdit;
				if($flag==9){
					$data=$data." | ".$buttonForPay;		
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
			<li style='list-style:none;'>
				 ".$buttonForExport." | "
				.$buttonForEdit;
				if($flag==9){
					$data=$data." | ".$buttonForPay;		
				}				
			$data=$data." | ".$buttonForCustomer				
				." | <a id='id11' href='index.php'>Home</a>
			</li>
		</p>";
		}	
		return $data;
	}
}

function getTicketDetails($sql){
	$data=null;
	$rowCount=1;
	$rows=getFetchArray($sql);
	foreach($rows as $result)
	{
		$pro= $result['pro'];
		$ticket_id= $result['order_id'];
		$inv_id= $result['inv_id'];
		$quantity= $result['quantity'];
		$unit_weight= $result['unit_weight'];
		$g_unit_price= $result['g_unit_price'];
		$unit_amount= $result['unit_amount'];
		
		$data =$data. "<tr>
			<td>".$rowCount."</td>			
			<td>".$pro."</td>			
			<td>".$quantity."</td>
			<td>".$unit_weight."</td>
			<td>".$g_unit_price."</td>
			<td>".$unit_amount."</td>			
			</tr>";
		$rowCount++;
	}
	return $data;
}

function displayInvoiceForm(){
	/***
	 * Display the form to fill the invoice
	 */
	$errMsg=null;
	if (isset($_SESSION['error_msg'])){
		$errMsg= $_SESSION['error_msg'];
	}else{
		$_SESSION['error_msg']=null;
		unset($_SESSION['error_msg']);
	}
	$page=null;	$content=newInvoiceFieldsForForm($errMsg);$insideHead=null;
	$page=getHTMLPage(INVOICE_PAGE_TITLE_FOR_NEW_INVOICE, INVOICE_FORM_TITLE_FOR_NEW_INVOICE, $content, $insideHead, BGC_FOR_INVOICE);	
	return $page;
}

function newInvoiceFieldsForForm($errMsg){
	return $errMsg.
"<form action='invoice.php' method='post' enctype='multipart/form-data' id='customtheme'>
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
				<label for='discount' style='vertical-align: top;'>Old Gold/Discount</label>
				<input type='text' name='discount' id='discount' style='width:150px;height:1px;' />
				<label for='discount'>CHF</label>
			</p>		
			<p>
				<label for='deposit'>Deposit</label>
				<input type='text' name='deposit' id='deposit' style='width:150px;height:1px;' />
				<label for='deposit'>CHF</label>
			</p>
			
			<p>
				<label for='deposit'>Order Status</label>
				<select name='order_status'>
					<option value='DELIVERED'>Delivered</option><
					<option value='ORDERED'>Ordered</option>					
				</select>
			</p>
			<p>
				<hr/>
			</p>		
			".getCustomerForm()."			
			<p>
				<center><input type='submit' name='submitOrder' value='Submit Order' id='submitbutton' /></center>
			</p>
		".getChoosyJSScriptCode()."	
		</form>";
}

function invoiceTicketRows($rows){
	$page="";
	for($i=1;$i<=$rows;$i++){
		$page=$page."<tr>
							<td>".$i."</td>
							<td>							
							".getSelectBox("select t.id key_id, nm value from tree_data t where t.id!=1", "pname".$i."", "pname".$i."", " data-placeholder='Choose a product ...' class='chosen-select' style='width:350px;'")."
							</td>
							<td><input type='text' name='quan".$i."' id='eticket' style='width:50px;height:1px;' /></td>
							<td><input type='text' name='weight".$i."' id='price' style='width:70px;height:1px;' /></td>
							<td><input type='text' name='price".$i."' id='iata' style='width:70px;height:1px;' /></td>
			</tr>";
	}
	return $page;
}
