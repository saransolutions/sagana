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


function displayCustomerDetailsForSelectBox(){
	$rows=getFetchArray("select cust_id, cname from customer ");
	$data=null;
	if(count($rows) > 0){
		foreach ($rows as $row){
			$cust_id = $row['cust_id'];
			$cname = $row['cname'];
			$data=$data."<option value='".$cust_id."'>".$cname."</option>";
		}
	}
	return $data;
}

function getRecordTypeForm($type){
	$page=null;
	if($type=='ex'){
		$page=$page."<p>
		<label for='recordType'>Record Type</label>
		<select name='recordType' selected>
			<option value='".EXPEND."'>Expenditure</option><option value='".INCOME."'>Income</option>
		</select>
		</p>
		<p>
			<label for='cname'>Expenditure Name</label><input type='text' name='recordSubTypeName' id='pname' style='width:250px;height:1px;' />
		</p>	
		";
	}else if($type=='in'){
		$page=$page."<p><label for='recordType'>Record Type</label><select name='recordType'><option value='".EXPEND."'>Expenditure</option><option value='".INCOME."' selected>Income</option></p>
		<p>
			<label for='cname'>Income Name</label><input type='text' name='recordSubTypeName' id='pname' style='width:250px;height:1px;' />
		</p>
		";
	}else{
		$page=$page."<p><label for='recordType'>Record Type</label><select name='recordType'><option value='".EXPEND."'>Expenditure</option><option value='".INCOME."'>Income</option></select></p>
		<p>
			<label for='cname'>Record Name</label><input type='text' name='recordSubTypeName' id='pname' style='width:250px;height:1px;' />
		</p>
		";
	}
	$page=$page. "		
<p>	<label for='street'>Comments</label><textarea name='comment'></textarea></p>";
	return $page;
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