<?php

function insertRecord($rdate,$rtype,$sub_type,$total_amount,$bid,$party_name,$p_method,$notes, $attachment){
	$pid=null;
	$insert=
	"INSERT INTO records(rid,rdate,rtype,sub_type,total_amount,bid,party_name,p_method,notes, file_name) 
	VALUES ( null, ".cheSNull($rdate).", ".cheSNull($rtype).", ".cheNull($sub_type).", ".cheNull($total_amount).", 
	".cheNull($bid).", ".cheSNull($party_name).", ".cheSNull($p_method).", ".cheSNull($notes).", ".cheSNull($attachment)." )";	
	executeSQL($insert);	
	$pid=getSingleValue("SELECT max(rid) id FROM records");
	return $pid;
}

function prepareToInsertRecord($rtype){	
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
					if(isset($_FILES['attachment']['name'])){
						$attachment=basename($_FILES['attachment']['name']);
					}
					
					$err=uploadFile("attachment", DIR_FILE_UPLOAD);
					if($err!=0){
						return "<p id='errMsg'>Error in File Load - check your file size or type - ".$attachment."</p>";
					}
					$cust_id=insertRecord($rdate,$rtype,$sub_type,$total_amount,$bid,$party_name,$p_method,$notes, $attachment);
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

function displayFormToAddNewExRecord($errmsg,$bid,  $user){
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
	
	$data= $errmsg."<form action='records.php' method='POST' enctype='multipart/form-data' id='customtheme'>
			<h6>Record Details</h6>	
			".getExpenditureRecordForm($bid,  $user)."				
			<p>			
				<center><input type='submit' name='addExRecord' value='Add Expenditure Record' id='submitbutton' /></center>
			</p>						
		</form>".RETURN_CHOOSY_JS_FOOTER;
	echo getHTMLPage(MAIN_TITLE." Record",  MAIN_TITLE." - Add Record", $data, $header, BGC_FOR_CUSTOMER);
}

function displayFormToAddNewInRecord($errmsg,$bid,  $user){
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
	
	$data= $errmsg."<form action='records.php' method='POST' enctype='multipart/form-data' id='customtheme'>
			<h6>Record Details</h6>	
			".getIncomeRecordForm($bid,  $user)."				
			<p>			
				<center><input type='submit' name='addInRecord' value='Add Income Record' id='submitbutton' /></center>
			</p>						
		</form>".RETURN_CHOOSY_JS_FOOTER;
	echo getHTMLPage(MAIN_TITLE." Record",  MAIN_TITLE." - Add Record", $data, $header, BGC_FOR_CUSTOMER);
}


