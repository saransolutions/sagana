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

function getCustomerDetailsForEdit($cust_id, $flag){
	$rows = getFetchArray("select * from customer where cust_id=".$cust_id." ");
	$data=null;
	foreach ($rows as $result){
		$cname= $result['cname'];
		$street= $result['street'];
		$zip= $result['zip'];
		$city= $result['city'];
		$phone= $result['phone'];
		$mobile= $result['mobile'];
		$email= $result['email'];
		if($flag){
			$data=$data."
 
 Customer Details
 <p>
	<label for='origin'>Customer Name</label>
	<input type='hidden' name='cust_id' value='".$cust_id."' />
  	<input type='text' name='cnameNew' id='cnameNew' value='".$cname."' style='margin-top:4px;width:150px;height:1px;' />
 </p>
 <p>
  	<label for='origin'>No,Street</label> 
  	<label>
  		<input style='width:250px;height:1px;' type='text' name='no_street'  value='".$street."' />
  	</label>
  </p> 
  <p>
  	<label for='origin'>Zip/Canton</label> 
  	<label>  		
  		<input style='width:100px;height:1px;' type='text' name='zip' value='".$zip."'/>  		
  		<input style='width:150px;height:1px;' type='text' name='canton' value='".$city."' />
  	</label>
  </p>
  <p>
  	<label for='origin'>Phone/Mobile</label> 
  	<label>
  		<input style='width:100px;height:1px;' type='text' name='phone' value='".$phone."' />  		
  		<input style='width:150px;height:1px;' type='text' name='mobile' value='".$mobile."' />
  	</label>
  </p>
  <p>
  	<label for='origin'>Email</label> 
  	<label>
  		<input style='width:250px;height:1px;' type='text' name='email' value='".$email."' />  		
  	</label>
  </p>
		";
		}else{
			$data=$data."
			
			<hr>
			Customer Details
			<p>
			<label for='origin'>Customer Name</label>
			<label for='origin'>".$cname."</label>
		</p>
<p>
  <label for='origin'>No, Street</label> 
  <label>$street</label>
</p> 
  <p>
  	<label for='origin'>Zip</label> 
  	<label>$zip</label>
  </p>
  <p>
  	<label for='origin'>City</label> 
  	<label>$city</label>
  </p>
  <p>
  	<label for='origin'>Phone</label> 
  	<label>$phone</label>
  </p>
  <p>
  	<label for='origin'>Mobile</label> 
  	<label>$mobile</label>
  </p>
  <p>
  	<label for='origin'>Email</label> 
  	<label>$email</label>
  </p>";	
		}
			
	}
	return $data;
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

function getCustomerForm(){
	return "
<p>
	<label for='cname'>Customer Name</label>
	<select name='cname' id='baggage' style='width:150px;' data-placeholder='Existing Customer ...' class='chosen-select'>
			<option value=''></option>
			".displayCustomerDetailsForSelectBox()."
		</select>
				<input type='text' name='cnameNew' id='cnameNew' style='width:150px;height:1px;' />
			</p>			
			<p>
				<label for='street'>Street</label>
				<input type='text' name='no_street' id='no_street' style='width:150px;height:1px;' />
			</p>			
			<p>
				<label for='city'>Zip</label>
				<input type='text' name='zip' id='zip_city' style='width:60px;height:1px;' />
				
				<label for='phone'>City</label>
				<input type='text' name='canton' id='handy' style='width:150px;height:1px;' />
			</p>			
			<p>
				<label for='phone'>Phone</label>
				<input type='text' name='phone' id='phone' style='width:150px;height:1px;' />
				
				<label for='phone'>Handy</label>
				<input type='text' name='mobile' id='handy' style='width:150px;height:1px;' />
			</p>

			<p>
				<label for='email'>Email</label>
				<input type='text' name='email' id='email' style='width:150px;height:1px;' />
			</p>			
			<p>
			</p>";
}

function displayCustomerEditForm($cust_id, $errMsg){
	$data=$errMsg;
	$data=$data."<form action='customer.php' method='post' enctype='multipart/form-data' id='customtheme'>";	
	$data=$data.getCustomerDetailsForEdit($cust_id, true);
	$data=$data."<br><input type='submit' name='updateCustomer' value='Update Customer' id='submitbutton' />";
	$data=$data."</form>";
	echo getHTMLPage(MAIN_TITLE." Customer", MAIN_TITLE." Customer - ".$cust_id."", $data, null, BGC_FOR_CUSTOMER);
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