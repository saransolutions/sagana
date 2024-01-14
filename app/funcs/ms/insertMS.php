<?php

function insertMS($name, $sdate, $noOfTerms, $mpay, $memebers, $status, $priceAmount){
	$sql="INSERT INTO mschemes(scheme_id, scheme_name, start_date, no_of_terms, mpay, members, status, price_amount) 
	VALUES (
		null,
		$name,
		$sdate,
		$noOfTerms,
		$mpay,
		$memebers,
		$status,
		$priceAmount
	)";
		executeSQL($sql);
		$sid = getSingleValue("select max(scheme_id) from mschemes");
		return $sid;
		
}

function displayNewMSForm(){
	
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
	<title>".INVOICE_FORM_TITLE_FOR_NEW_MONTHLY_SCHEME."</title>
	<link rel='stylesheet' href='css/chosen.css'>	
	<link rel='stylesheet' href='css/style.css'>
	<link rel='stylesheet' href='//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css'>
<script src='//code.jquery.com/jquery-1.10.2.js'></script>
<script src='//code.jquery.com/ui/1.11.0/jquery-ui.js'></script>
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

	<script type='text/javascript'>
$(document).ready(function()
{   
    $('.monthPicker').datepicker({
        dateFormat: 'MM yy',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,

        onClose: function(dateText, inst) {
            var month = $('#ui-datepicker-div .ui-datepicker-month :selected').val();
            var year = $('#ui-datepicker-div .ui-datepicker-year :selected').val();
            $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
        }
    });

    $('.monthPicker').focus(function () {
        $('.ui-datepicker-calendar').hide();
        $('#ui-datepicker-div').position({
            my: 'center top',
            at: 'center bottom',
            of: $(this)
        });
    });
});
</script>

 <script>
  $(function() {
    $( '#datepicker' ).datepicker();
  });   
  </script>	
</head>
<body>
	<div id='container' style='width:80%;'>		
		".NAV_MENU_MAIN."
		<h1>".INVOICE_FORM_TITLE_FOR_NEW_MONTHLY_SCHEME."</h1>
			".$errMsg."
			".newMschemForm()."
	</div>
</body>
</html>
	";
			
	return $page;	
}



function newMschemForm(){
	return "<form action='ms.php' method='post' enctype='multipart/form-data' id='customtheme'>
			<h6>Monthly Scheme Details</h6>
			".newMschemFields()."		
			<p>
				<center><input type='submit' name='submitMscheme' value='Submit' id='submitbutton' /></center>
			</p>			
		".getChoosyJSScriptCode()."			
		</form>";
}

function newMschemFields(){
	return "
	<p>
		<label for='name' style='vertical-align: top;'>Scheme Name</label>
		<input type='text' name='scheme_name' id='discount' style='width:150px;height:1px;' />				
	</p>		
	<p>
		<label for='startDate' >Start Date</label>
		<input type='text' name='startDate' id='datepicker' style='width: 230px; height: 20px;'></input>     				
     </p>
	<p>
		<label for='deposit'>Number of Terms</label>
		<input type='text' name='noOfTerms' id='deposit' style='width:150px;height:1px;' />				
	</p>
	<p>
		<label for='deposit'>Monthly Amount</label>
		<input type='text' name='mpay' id='deposit' style='width:150px;height:1px;' />				
	</p>
	<p>
		<label for='deposit'>Price Amount</label>
		<input type='text' name='priceAmount' id='deposit' style='width:150px;height:1px;' />				
	</p>	
	";
}

function validateNewMSchemeFields(){
	$name=$_POST['scheme_name'];
	$startDate=$_POST['startDate'];
	$noOfTerms=$_POST['noOfTerms'];
	$mpay=$_POST['mpay'];
	$priceAmount=$_POST['priceAmount'];
	$sid = insertMS(cheSNull($name), cheSNull($startDate), cheNull($noOfTerms), cheNull($mpay), cheNull(null), "'Started'", cheNull($priceAmount));
	return $sid;
}