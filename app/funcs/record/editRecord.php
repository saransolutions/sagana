<?php



function displayRecordEditForm($cust_id, $errMsg){
	$data=$errMsg;
	$data=$data."<form action='records.php' method='post' enctype='multipart/form-data' id='customtheme'>";	
	$data=$data.getRecordDetailsForEdit($cust_id, true);
	$data=$data."<br><center><input type='submit' name='updateRecord' value='Update Record' id='submitbutton' /></center>";
	$data=$data."</form>".RETURN_CHOOSY_JS_FOOTER;
	
	$header="<link rel='stylesheet' href='//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css'>
  <script src='//code.jquery.com/jquery-1.10.2.js'></script>
  <script src='//code.jquery.com/ui/1.11.2/jquery-ui.js'></script>
  <link rel='stylesheet' href='/resources/demos/style.css'>
  <script>
  $(function() {
    $( '#datepicker' ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  });
  </script>";
	
	echo getHTMLPage(MAIN_TITLE." Record", MAIN_TITLE." Record - ".$cust_id."", $data, $header, BGC_FOR_CUSTOMER);
}

function getRecordDetailsForEdit($pid){
	$rows = getFetchArray("select
	(select username from bookies where bid=r.bid)user, r.*   
	 from records r where r.rid=".$pid." ");
	$data=null;
	foreach ($rows as $result){
		$rdate= $result['rdate'];
		$sub_type= $result['sub_type'];
		$notes= $result['notes'];
		$rtype= $result['rtype'];
		$user= $result['user'];
		$p_method= $result['p_method'];
		$total_amount = $result['total_amount'];
		$party_name = $result['party_name'];
		
		if($rtype==EXPEND){
			$data=$data.
			getHiddenButton("rid", $pid).
			getHiddenButton("rtype", $rtype).
		"		
		<p><label for='invoice_date'>Expenditure Date *</label>
<input type='text' id='datepicker' name='rec_date' style='width:250px;height:1px;' value='".$rdate."'>
</p>

<p><label for='cname'>Expenditure Type *</label> 
  	<label for='origin'>
 		<select name='rec_name'
			id='baggage' style='width:150px;' data-placeholder='Select Expenditure ...' class='chosen-select'>
			<option value=''></option>
			".displayRecordTypeDetailsForSelectBoxById(EXPEND, $sub_type)."
		</select>		
  	</label>		
</p>

<p>
	<label for='street'>Notes</label>				
	<textarea name='notes'>".$notes."</textarea>				
</p>

<p><label for='tamount'>Total Amount *</label>
<input type='text' name='tamount' id='tamount' value='".$total_amount."' style='width:250px;height:1px;' />
</p>	

<p><label for='tamount'>Paid By</label>
<input type='hidden' name='bid' value=".$bid."/>
<label for='user'>".$user."</label>
</p>

<p><label for='tamount'>Paid To *</label>
<input type='text' name='paid_to' id='tamount' value='".$party_name."' style='width:250px;height:1px;' />
</p>
<p><label for='pmethod'>Payment Method</label>
<select name='p_method' 
id='baggage' style='width:150px;' data-placeholder='Payment Method ...' class='chosen-select'>
	<option value=''></option>
	".displayPaymentListForSelectBoxById($p_method)."
</select>
</p>";		
				
		}else{
			
			
			$data=$data.
			getHiddenButton("rid", $pid).
			getHiddenButton("rtype", $rtype).
		"		
		<p><label for='invoice_date'>Income Date *</label>
<input type='text' id='datepicker' name='rec_date' style='width:250px;height:1px;' value='".$rdate."'>
</p>

<p><label for='cname'>Income Type *</label> 
  	<label for='origin'>
 		<select name='rec_name'
			id='baggage' style='width:150px;' data-placeholder='Select Expenditure ...' class='chosen-select'>
			<option value=''></option>
			".displayRecordTypeDetailsForSelectBoxById(INCOME, $sub_type)."
		</select>		
  	</label>		
</p>

<p>
	<label for='street'>Notes</label>				
	<textarea name='notes'>".$notes."</textarea>				
</p>

<p><label for='tamount'>Total Amount *</label>
<input type='text' name='tamount' id='tamount' value='".$total_amount."' style='width:250px;height:1px;' />
</p>	

<p><label for='tamount'>Accepted By</label>
<input type='hidden' name='bid' value=".$bid."/>
<label for='user'>".$user."</label>
</p>

<p><label for='tamount'>Collected From *</label>
<input type='text' name='paid_to' id='tamount' value='".$party_name."' style='width:250px;height:1px;' />
</p>
<p><label for='pmethod'>Payment Method</label>
<select name='p_method' 
id='baggage' style='width:150px;' data-placeholder='Payment Method ...' class='chosen-select'>
	<option value=''></option>
	".displayPaymentListForSelectBoxById($p_method)."
</select>
</p>";		
			
			
		}


	}
	return $data;
}


function updateProduct(){
	$pid= $_POST['pid'];
	$pname= $_POST['pname'];
	$comments= $_POST['comments'];
	$sql="update products set pname = ".cheSNull($pname).", description = ".cheSNull($comments)." where pid=".$pid." ";
	executeSQL($sql);
	return $pid;
}

function updateRecord($rid, $rdate,$rtype,$sub_type,$total_amount,$bid,$party_name,$p_method,$notes){
	$sql="UPDATE records SET rdate=".cheSNull($rdate).", rtype=".cheSNull($rtype).", sub_type=".cheNull($sub_type).", 
	total_amount=".cheNull($total_amount).", bid=".cheNull($bid).", 
	party_name=".cheSNull($party_name).", p_method=".cheNull($p_method).", notes=".cheSNull($notes)." WHERE rid=".$rid."";
	executeSQL($sql);
	return $rid;
}


function prepareToUpdateRecord(){	
	if( isset($_POST['rec_date']) && strlen($_POST['rec_date']) > 0  ){		
		if( isset($_POST['rec_name']) && strlen($_POST['rec_name']) > 0  ){
			if( isset($_POST['tamount']) && strlen($_POST['tamount']) > 0  ){
				if( isset($_POST['paid_to']) && strlen($_POST['paid_to']) > 0  ){
					
					$rdate=$_POST['rec_date'];
					$rdate = date("Y-m-d", strtotime($rdate));					
					$sub_type=$_POST['rec_name'];
					$total_amount=$_POST['tamount'];					
					$party_name=$_POST['paid_to'];
					$notes=$_POST['notes'];
					$bid=$_SESSION['bid'];
					$p_method=$_POST['p_method'];					
					$rid=$_POST['rid'];					
					$rtype=$_POST['rtype'];
					
					$cust_id=updateRecord($rid, $rdate,$rtype,$sub_type,$total_amount,$bid,$party_name,$p_method,$notes);
					return $cust_id;
				}else{
				return "<p id='errMsg'>Paid To is empty</p>";
			}
			}else{
				return "<p id='errMsg'>Total Amount is empty</p>";
			}
		}else{
			return "<p id='errMsg'>Record Type is empty</p>";
		}		
	}else{
		return "<p id='errMsg'>Record Date is empty</p>";
	}
}

function displayEditAttachForm($cust_id, $errMsg){
	$data=$errMsg;
	$data=$data."<form action='records.php' method='post' enctype='multipart/form-data' id='customtheme'>";	
	$data=$data."
	<input type='hidden' name='rid' value='".$cust_id."' />
	  <p>
  	<label for='origin'>Attachment</label> 
  	<label>
  		<input type='file' name='attachment'  />		
  	</label>
  </p>";
	$data=$data."<br><input type='submit' name='updateAttach' value='Update Record' id='submitbutton' />";
	$data=$data."</form>";
	echo getHTMLPage(MAIN_TITLE." Record", MAIN_TITLE." Record - ".$cust_id."", $data, null, BGC_FOR_CUSTOMER);
}

function updateAttach($fileName,$cust_id){
	if(strlen($fileName) > 0 && !is_null($cust_id)){		
		$err=uploadFile("attachment", DIR_FILE_UPLOAD);
		if($err!=0){
			return "<p id='errMsg'>Error in File Load - check your file size or type - ".$fileName."</p>";
		}
		$sql="update records SET file_name=".cheSNull($fileName)." where rid=".$cust_id."";
		executeSQL($sql);
		return $cust_id;
	}
}