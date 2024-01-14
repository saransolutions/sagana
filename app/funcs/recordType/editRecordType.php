<?php



function displayRecordTypeEditForm($cust_id, $errMsg){
	$data=$errMsg;
	$data=$data."<form action='recordTypes.php' method='post' enctype='multipart/form-data' id='customtheme'>";	
	$data=$data.getCustomerDetailsForEdit($cust_id, true);
	$data=$data."<br><input type='submit' name='updateRecordType' value='Update Record Type' id='submitbutton' />";
	$data=$data."</form>";
	echo getHTMLPage(MAIN_TITLE." - Record Type", MAIN_TITLE." - Record Type - ".$cust_id."", $data, null, BGC_FOR_CUSTOMER);
}

function getCustomerDetailsForEdit($pid){
	$rows = getFetchArray("select * from record_types where tid=".$pid." ");
	$data=null;
	foreach ($rows as $result){
		$type= $result['type'];		
		$pname= $result['name'];
		$comments= $result['description'];
		$data=$data."
		<p>
	<label for='origin'>Type</label>
	<input type='hidden' name='type' value='".$type."' />
	<label for='origin'>".$type."</label>  	
 </p> 
 <p>
	<label for='origin'>Record Type Name</label>
	<input type='hidden' name='tid' value='".$pid."' />
  	<input type='text' name='name' id='cnameNew' value='".$pname."' style='margin-top:4px;width:150px;height:1px;' />
 </p>
  <p>
	<label for='origin'>Comments</label>
	<textarea name='comment'>".$comments."</textarea>  	
 </p>";

	}
	return $data;
}


function updateRecordType($pid){	
	$pname= $_POST['name'];
	$comments= $_POST['comment'];
	$type= $_POST['type'];
	$sql="update record_types set name = ".cheSNull($pname).", description = ".cheSNull($comments)." where tid=".$pid." ";
	executeSQL($sql);
	return $pid;
}