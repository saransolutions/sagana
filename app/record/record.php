<?php 

function insertNewCustomer($inv_id, $cust_id){
	$cust_id=insertOrUpdateCustomer();
	if(!is_null($cust_id)){
		updateInvoiceForCustomer($inv_id, $cust_id);
		return true;
	}		
}

function getCustomerDetailsForForm($flag, $cust_id){
	if($flag==1){
		return getCustomerDetailsForm();
	}else if($flag==3){
		if(strlen($cust_id) == 0){
			return getCustomerDetailsForm();
		}else{
			return getCustomerDetailsForEdit($cust_id, true);			
		}
		
	}else{
		$data=null;
		if(strlen($cust_id) == 0){
			return $data;
		}
		$data=$data.getCustomerDetailsForEdit($cust_id, false);	
	return $data;
	}
}

function getCustomerDetailsForm(){
	
	return "
	
	<hr>
	Customer Details
	<p>
	<label for='origin'>Customer Name</label> 
  	<label for='origin'>
 		<select name='cname'
			id='baggage' style='width:150px;' data-placeholder='Existing Customer ...' class='chosen-select'>
			<option value=''></option>
			".displayCustomerDetailsForSelectBox()."
		</select>		
  	</label>
  	<input type='text' name='cnameNew' id='cnameNew' style='margin-top:4px;width:150px;height:1px;' />
 </p>
 <p>
  	<label for='origin'>No,Street</label> 
  	<label>
  		<input style='width:250px;height:1px;' type='text' name='no_street' />
  	</label>
  </p> 
  <p>
  	<label for='origin'>Zip/Canton</label> 
  	<label>
  		<input style='width:100px;height:1px;' type='text' name='zip' />  		
  		<input style='width:150px;height:1px;' type='text' name='canton' />
  	</label>
  </p>
  <p>
  	<label for='origin'>Phone/Mobile</label> 
  	<label>
  		<input style='width:100px;height:1px;' type='text' name='phone' />  		
  		<input style='width:150px;height:1px;' type='text' name='mobile' />
  	</label>
  </p>
  <p>
  	<label for='origin'>Email</label> 
  	<label>
  		<input style='width:250px;height:1px;' type='text' name='email' />  		
  	</label>
  </p>";
}


function displayRecordTypeDetailsForSelectBox($type){
	$rows=getFetchArray("select tid, name from record_types where type=".cheSNull($type)."");
	$data=null;
	if(count($rows) > 0){
		foreach ($rows as $row){
			$cust_id = $row['tid'];
			$cname = $row['name'];
			$data=$data."<option value='".$cust_id."'>".$cname."</option>";
		}
	}
	return $data;
}

function displayRecordTypeDetailsForSelectBoxById($type, $id){
	$rows=getFetchArray("select tid, name from record_types where type=".cheSNull($type)."");
	$data=null;
	if(count($rows) > 0){
		foreach ($rows as $row){
			$cust_id = $row['tid'];
			$cname = $row['name'];
			if($id==$cust_id){
				$data=$data."<option value='".$cust_id."' selected>".$cname."</option>";	
			}else{
				$data=$data."<option value='".$cust_id."'>".$cname."</option>";
			}
			
		}
	}
	return $data;
}


function displayPaymentListForSelectBox(){
	$rows=getFetchArray("SELECT * FROM payment_method_list");
	$data=null;
	if(count($rows) > 0){
		foreach ($rows as $row){
			$cust_id = $row['key_id'];
			$cname = $row['value'];
			$data=$data."<option value='".$cust_id."'>".$cname."</option>";
		}
	}
	return $data;
}

function displayPaymentListForSelectBoxById($id){
	$rows=getFetchArray("SELECT * FROM payment_method_list where key_id=".$id." ");
	$data=null;
	if(count($rows) > 0){
		foreach ($rows as $row){
			$cust_id = $row['key_id'];
			$cname = $row['value'];
			if($id==$cust_id){
				$data=$data."<option value='".$cust_id."' selected>".$cname."</option>";	
			}else{
				$data=$data."<option value='".$cust_id."'>".$cname."</option>";
			}
			
		}
	}
	return $data;
}



function getExpenditureRecordForm($bid,  $user){
	$actionPageForAddExRecordType="recordTypes.php?action=add&type=ex";
	
	return "
<p><label for='invoice_date'>Expenditure Date *</label>
<input type='text' id='datepicker' name='rec_date' style='width:250px;height:1px;'>
</p>

<p><label for='cname'>Expenditure Type *</label> 
  	<label for='origin'>
 		<select name='rec_name'
			id='baggage' style='width:150px;' data-placeholder='Select Expenditure ...' class='chosen-select'>
			<option value=''></option>
			".displayRecordTypeDetailsForSelectBox(EXPEND)."
		</select>		
  	</label>
		&nbsp;<a href='".$actionPageForAddExRecordType."' class='payButton'><img src='img/icon/icon_addNew.png' style='border:none;' />&nbsp;Add New Expenditure Type</a>
</p>

<p>
	<label for='street'>Notes</label>				
	<textarea name='notes'></textarea>				
</p>

<p><label for='tamount'>Total Amount *</label>
<input type='text' name='tamount' id='tamount' style='width:250px;height:1px;' />
</p>	

<p><label for='tamount'>Paid By</label>
<input type='hidden' name='bid' value=".$bid."/>
<label for='user'>".$user."</label>
</p>

<p><label for='tamount'>Paid To *</label>
<input type='text' name='paid_to' id='tamount' style='width:250px;height:1px;' />
</p>
<p><label for='pmethod'>Payment Method</label>
<select name='p_method' 
id='baggage' style='width:150px;' data-placeholder='Payment Method ...' class='chosen-select'>
	<option value=''></option>
	".displayPaymentListForSelectBox()."
</select>
</p>

<p>
  	<label for='origin'>Attachment</label> 
  	<label>
  		<input type='file' name='attachment' />  		
  	</label>
  </p>

";
}


function getIncomeRecordForm($bid,  $user){
	$actionPageForAddInRecordType="recordTypes.php?action=add&type=in";
	
	return "
<p><label for='invoice_date'>Income Date *</label>
<input type='text' id='datepicker' name='rec_date' style='width:250px;height:1px;'>
</p>

<p><label for='cname'>Income Type *</label> 
  	<label for='origin'>
 		<select name='rec_name'
			id='baggage' style='width:150px;' data-placeholder='Select Expenditure ...' class='chosen-select'>
			<option value=''></option>
			".displayRecordTypeDetailsForSelectBox(INCOME)."
		</select>		
  	</label>
		&nbsp;<a href='".$actionPageForAddInRecordType."' class='payButton'>
		<img src='img/icon/icon_addNew.png' style='border:none;' />&nbsp;Add New Income Type</a>
</p>

<p>
	<label for='street'>Notes</label>				
	<textarea name='notes'></textarea>				
</p>

<p><label for='tamount'>Total Amount *</label>
<input type='text' name='tamount' id='tamount' style='width:250px;height:1px;' />
</p>	

<p><label for='tamount'>Collected By</label>
<input type='hidden' name='bid' value=".$bid."/>
<label for='user'>".$user."</label>
</p>

<p><label for='tamount'>Accepted from *</label>
<input type='text' name='paid_to' id='tamount' style='width:250px;height:1px;' />
</p>
<p><label for='pmethod'>Payment Method</label>
<select name='p_method' 
id='baggage' style='width:150px;' data-placeholder='Payment Method ...' class='chosen-select'>
	<option value=''></option>
	".displayPaymentListForSelectBox()."
</select>
</p>

<p>
  	<label for='origin'>Attachment</label> 
  	<label>
  		<input type='file' name='attachment' />  		
  	</label>
  </p>

";
}






function displayNewCustomerFormForInvoice($page, $inv_id, $errmsg){
	$data= $errmsg."<form action='".$page."' method='POST' enctype='multipart/form-data' id='customtheme'>
			<h6>Customer Details</h6>
			".getCustomerForm()."		
			<p>
				<input type='hidden' name='inv_id' value='".$inv_id."' />
				<center><input type='submit' name='addCustomerWithInvice' value='Add Customer' id='submitbutton' /></center>
			</p>			
		".getChoosyJSScriptCode()."		
		</form>";
	echo getHTMLPage(MAIN_TITLE." Customer",  MAIN_TITLE." - Add Customer", $data, null, BGC_FOR_CUSTOMER);
}





?>