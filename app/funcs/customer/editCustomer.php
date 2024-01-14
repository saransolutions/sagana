<?php



function insertOrUpdateCustomer($cust_id){
	$cname=null;$no_street=null;$zip=null;$city=null;$phone=null;$mobile=null;$email=null;
	if(isset($_POST['cname'])){$cname=$_POST['cname'];}	
	if(isset($_POST['cnameNew']) && strlen($_POST['cnameNew']) > 0 ){
		if(isset($_POST['no_street'])){$no_street=$_POST['no_street'];}
		if(isset($_POST['zip'])){$zip=$_POST['zip'];}
		if(isset($_POST['canton'])){$city=$_POST['canton'];}
		if(isset($_POST['phone'])){$phone=$_POST['phone'];}
		if(isset($_POST['mobile'])){$mobile=$_POST['mobile'];}
		if(isset($_POST['email'])){$email=$_POST['email'];}

		/**
		 * New Customer
		 */
		$cnameNew=$_POST['cnameNew'];
		$cust_id=getSingleValue("SELECT cust_id FROM customer where cname='".$cnameNew."'");
		if(is_null($cust_id)){
			$cust_id = insertCustomer($cnameNew,$no_street,$city, $zip, null, $phone, $mobile, $email);
			//updateInvoiceForCustomer($inv_id, $cust_id);
			return $cust_id;
		}else{
			/**
			 * Error - unique customer is required.
			 */
			if(is_null($cust_id)){
				echo "customer name is not unique";
				return "<p>customer name ".$cnameNew." is not unique</p>";
			}else{
				$sql="UPDATE customer SET cname='".$cnameNew."', street=".cheSNull($no_street).", city=".cheSNull($city).",zip=".cheNull($zip).",state=null,phone=".cheSNull($phone)."
				,mobile=".cheSNull($mobile).",email=".cheSNull($email)." WHERE cust_id=".$cust_id."";
				executeSQL($sql);
				return $cust_id;
			}
		}
	}else{
		return $cname;
	}
}


