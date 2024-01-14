<?php

function insertMember($scheme_id, $cust_id, $paid_terms, $total_paid_amount, $status){
	$tableName="members";
	$sql="INSERT INTO ".$tableName."(member_id, scheme_id, cust_id, paid_terms, total_paid_amount, status) 
	VALUES (
	null,
	".$scheme_id.",
	".$cust_id.",
	".$paid_terms.",
	".$total_paid_amount.",	
	".$status."
	)";
		executeSQL($sql);
		$mid = getSingleValue("select max(member_id) from ".$tableName."");
		return $mid;
		
}


function insertMemberTransaction($member_id){
	$tableName="member_transactions";
	$sql="INSERT INTO ".$tableName." (trans_id, member_id, paid_date) 
VALUES (null, $member_id, now())";
		executeSQL($sql);
		$mid = getSingleValue("select max(trans_id) from ".$tableName."");
		return $mid;
}

function displayNewMemberForm($sid){
	
	require_once 'includes/cons.php';
	require_once 'funcs/utility.php';
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
	$page=null;
	$page=$page."<html lang='en-US'>
<head>
  <meta charset='UTF-8'>
	<title>".INVOICE_FORM_TITLE_FOR_NEW_MEMBER."</title>
	<link rel='stylesheet' href='css/chosen.css'>	
	<link rel='stylesheet' href='css/style.css'>
	<style>
		#errMsg{
			color:red;font-size:12px;font-family:courier;
		}
		#nav-tab-newInv{
			list-style:none;margin-bottom:10px;padding:5px;
		}
		#nav-tab-newInv a{
			color:#000;
			text-decoration:none;
		}
		table { margin: 1em 1em 3em 3em; border-collapse: collapse; }
		td, th { padding: 0.9em 0.9em 0.9em .9em; border: 1px #ccc solid; }
		thead {  }
		tbody { }
	</style>			
</head>
<body>
	<div id='container' style='width:80%;'>		
		".NAV_MENU_MAIN."
		<h1>".INVOICE_FORM_TITLE_FOR_NEW_MEMBER."</h1>
			".$errMsg."
			".newMemberForm($sid)."
	</div>
</body>
</html>
	";
			
	return $page;	
}

function newMemberForm($sid){
	return "<form action='member.php' method='POST' enctype='multipart/form-data' id='customtheme'>
			<h6>Member Details</h6>
			".newMemberFields()."		
			<p>
				<input type='hidden' name='sid' value='".$sid."' />
				<center><input type='submit' name='submitMember' value='Add Member' id='submitbutton' /></center>
			</p>			
		".getChoosyJSScriptCode()."		
		</form>";
}

function newMemberFields(){
	return getCustomerForm();
}





function validateMemberAndInsert($sid){
	$cust_id=null;
	if(!is_null($_POST['cname']) && strlen($_POST['cname']) > 1){
		$cust_id=$_POST['cname'];
	}else{
		$cust_id=insertOrUpdateCustomer(null);
	}
	
	$paid_terms=0;
	$total_paid_amount=0;
	$paid_date=null;	
	$mid=getSingleValue("select member_id from members where scheme_id=".$sid." and cust_id=".$cust_id."");
	if(is_null($mid)){
		$mid = insertMember($sid, $cust_id, $paid_terms, $total_paid_amount, "'".STATUS_MEMBER_JOINED."'");
		updateMSchemesForNewMember($sid);
	}	
	return $sid;
}