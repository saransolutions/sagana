<?php

function insertCustomer($cname,$street,$city, $zip, $state,$phone, $mobile, $email){
	$insert=
	"INSERT INTO 
	`customer`(`cust_id`, `cname`, `street`, `city`, `zip`, `state`, `phone`, `mobile`, `email`, `jdate`, `status`) 
	VALUES (null, 
		'".$cname."', 
		".cheSNull($street).",
		".cheSNull($city).",
		".cheNull($zip).",
		".cheSNull($state).",
		".cheSNull($phone).",
		".cheSNull($mobile).",
		".cheSNull($email).", 		 
		CURDATE(),
		null 
	)";	
	executeSQL($insert);
	$cust_id=null;
	$query = selectSQL("SELECT max(cust_id) cust_id FROM customer");
	while($result = mysqli_fetch_array($query))
	{
		$cust_id= $result['cust_id'];
	}	
	return $cust_id;	
}

function prepareToInsertCustomer(){	
	if(isset($_POST['cnameNew']) && strlen($_POST['cnameNew']) > 0 ){		
		if(isset($_POST['no_street'])){$no_street=$_POST['no_street'];}
		if(isset($_POST['zip'])){$zip=$_POST['zip'];}
		if(isset($_POST['canton'])){$city=$_POST['canton'];}
		if(isset($_POST['phone'])){$phone=$_POST['phone'];}
		if(isset($_POST['mobile'])){$mobile=$_POST['mobile'];}
		if(isset($_POST['email'])){$email=$_POST['email'];}
		$cnameNew=$_POST['cnameNew'];
		$cust_id=getSingleValue("SELECT cust_id FROM customer where cname='".$cnameNew."'");
		if(!is_null($cust_id)){
			return "<p id='errMsg'>Customer name is not unique - ".$cnameNew."</p>";
		}		
		$cust_id=insertCustomer($cnameNew,$no_street,$city, $zip, null,$phone, $mobile, $email);
		return $cust_id;
	}
}

function displayFormToAddNewCustomer($errmsg){
	$data= $errmsg."<form action='customer.php' method='POST' enctype='multipart/form-data' id='customtheme'>
			<h6>Customer Details</h6>
			".getCustomerForm()."		
			<p>
				<center><input type='submit' name='addCustomer' value='Add Customer' id='submitbutton' /></center>
			</p>			
		".getChoosyJSScriptCode()."		
		</form>";
	echo getHTMLPage(MAIN_TITLE." Customer",  MAIN_TITLE." - Add Customer", $data, null, BGC_FOR_CUSTOMER);
}
