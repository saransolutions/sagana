<?php

function insertProduct($type, $name,$description){
	$insert=
	"INSERT INTO record_types(tid, type, name, description, mdate) VALUES (null, ".cheSNull($type).", ".cheSNull($name).", ".cheSNull($description).", now())";	
	executeSQL($insert);	
	return getSingleValue("SELECT max(tid) tid FROM record_types");
}

function prepareToInsertRecordType(){	
	if(isset($_POST['recordSubTypeName']) && strlen($_POST['recordSubTypeName']) > 0 ){
		$type=$_POST['recordType'];
		$cnameNew=$_POST['recordSubTypeName'];
		$comment=$_POST['comment'];
		
		$cust_id=getSingleValue("SELECT tid FROM record_types where name='".$cnameNew."'");
		if(!is_null($cust_id)){
			return "<p id='errMsg'>Record name is not unique - ".$cnameNew."</p>";
		}		
		$cust_id=insertProduct($type, $cnameNew, $comment);
		return $cust_id;
	}
}

function displayFormToAddNewRecordType($errmsg, $type){
	$data= $errmsg."<form action='recordTypes.php' method='POST' enctype='multipart/form-data' id='customtheme'>
			<h6>Record Type Details</h6>	
			".getRecordTypeForm($type)."				
			<p>
				<center><input type='submit' name='addRecordType' value='Add Record Type' id='submitbutton' /></center>
			</p>						
		</form>";
	echo getHTMLPage(MAIN_TITLE." Record Type",  MAIN_TITLE." - Add Record Type", $data, null, BGC_FOR_CUSTOMER);
}
