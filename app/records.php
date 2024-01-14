<?php

ob_start();
if (version_compare(phpversion(), '5.3.0', '>=') == 1)
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
error_reporting(E_ALL & ~E_NOTICE);
session_start();

require_once 'funcs/utility.php';
require_once 'funcs/db/db.php';
require_once 'includes/cons.php';
require_once 'funcs/record/record.php';

require_once 'funcs/record/selectRecord.php';
require_once 'funcs/record/insertRecord.php';
require_once 'funcs/record/editRecord.php';
require_once 'funcs/record/recordReports.php';

require_once 'funcs/export/export_xl.php';


checkUserLogin();

 if(isset($_GET['rid']))
{
	$rid=$_GET['rid'];	
	displayRecordId($rid);
}
else if(isset($_GET['erid']))
{
	$cust_id=$_GET['erid'];	
	displayRecordEditForm($cust_id, null);
}
else if(isset($_POST['updateRecord']))
{
	$id=prepareToUpdateRecord();	
	displayRecordId($id);
}

else if(isset($_POST['addExRecord']))
{
	$rid = prepareToInsertRecord(EXPEND);	
	if(is_numeric($rid)){
		echo displayAllRecords(returnSQLToGetAllRecordsByUser($_SESSION['bid'],$_SESSION['role']),null, null, $_SESSION['user'], $_SESSION['role']);	
	}else{
		echo displayFormToAddNewExRecord($rid, $_SESSION['bid'], $_SESSION['user']);
	}
}


else if(isset($_POST['addInRecord']))
{
	$rid = prepareToInsertRecord(INCOME);	
	if(is_numeric($rid)){
		echo displayAllRecords(returnSQLToGetAllRecordsByUser($_SESSION['bid'],$_SESSION['role']),null, null, $_SESSION['user'], $_SESSION['role']);	
	}else{
		echo displayFormToAddNewExRecord($rid, $_SESSION['bid'], $_SESSION['user']);
	}
}

else if(isset($_GET['drid']))
{
	$cust_id=$_GET['drid'];	
	$sql="delete from records where rid=".$cust_id."";
	executeSQL($sql);
	header('Location: records.php');
	exit();
}else if(isset($_GET['addExRecordForm']))
{
	echo displayFormToAddNewExRecord(null, $_SESSION['bid'], $_SESSION['user']);
}
else if(isset($_GET['addInRecordForm']))
{
	echo displayFormToAddNewInRecord(null, $_SESSION['bid'], $_SESSION['user']);
}

else if(isset($_POST['search']))
{
	$searchBy=$_POST['searchBy'];
	if(isset($_POST['searchValue'])){		
		$searchValue=$_POST['searchValue'];		
		echo displayAllRecords(returnSQLToGetAllRecordsByUser($_SESSION['bid'],$_SESSION['role']),$searchBy, $searchValue, $_SESSION['user'], $_SESSION['role']);	
	}
}
else if(isset($_POST['reportDSubmit']))
{
	if(isset($_POST['rdate']) && strlen($_POST['rdate']) > 0){
		$date = date('Y-m-d', strtotime($_POST['rdate']));
		$type="Daily";	
		$page= displayRecordReport($date, $type);
		if(is_null($page)){	
			$errMsg="<p id='errMsg'>No Record Found for - ".$date."</p>";
			displayDailyReportForm($errMsg);			
		}else{
			echo $page;
		}
	}
}
else if(isset($_POST['reportMSubmit']))
{
	if(isset($_POST['rmonth']) && strlen($_POST['rmonth']) > 0){
		$date = date('Y-m', strtotime($_POST['rmonth']));
		$type="Monthly";
		$page= displayRecordReport($date, $type);
		if(is_null($page)){	
			$errMsg="<p id='errMsg'>No Record Found for - ".$date."</p>";
			displayDailyReportForm($errMsg);			
		}else{
			echo $page;
		}	
	}
}
else if(isset($_POST['reportYSubmit']))
{
	if(isset($_POST['ryear']) && strlen($_POST['ryear']) > 0){
		$date=$_POST['ryear'];
		$type="Yearly";
		$page=displayRecordReport($date, $type);
		if(is_null($page)){	
			$errMsg="<p id='errMsg'>No Record Found for - ".$date."</p>";
			displayDailyReportForm($errMsg);			
		}else{
			echo $page;
		}
	}
}

else if(isset($_GET['dr']))
{
	displayDailyReportForm(null);	
}
else if(isset($_GET['xl']))
{	
	$date=$_GET['xl'];
	$type=$_GET['type'];	
	$page=prepareToExportToXL($date,$type);	
	echo exportMReportIntoXL($page,$type."_Record_Report_".$date);
}

else if(isset($_GET['attach']))
{
	$file=$_GET['attach'];	
	downloadFile(DIR_FILE_UPLOAD.$file);
}

else if(isset($_GET['eattach']))
{
	$id=$_GET['eattach'];	
	displayEditAttachForm($id, null);
}

else if(isset($_GET['tab']) && $_GET['tab']=="xport" )
{
	$tab=$_GET['tab'];
	if(isset($_GET['key']) && !is_null($_GET['key'])){
		$key=$_GET['key'];
	}
	if(isset($_GET['value']) && !is_null($_GET['value'])){
		$value=$_GET['value'];
	}
	$sql=returnSQLToGetAllRecordsByUser($_SESSION['bid'],$_SESSION['role']);
	$sql=getSQLBasedOnKeys($sql, $key, $value);
	$data=getRetrieveData($sql);
	exportMReportIntoXL($data, "export_".$key);
}


else if(isset($_POST['updateAttach']))
{
	$id=$_POST['rid'];
	$attachment=basename($_FILES['attachment']['name']);	
	$result=updateAttach($attachment, $id);
	if(is_numeric($result)){
		displayRecordId($id);	
	}else{
		displayEditAttachForm($id, $result);
	}
}
else{	
	$key=null; $value=null;
	if(isset($_GET['key']) && !is_null($_GET['key'])){
		$key=$_GET['key'];
	}
	if(isset($_GET['value']) && !is_null($_GET['value'])){
		$value=$_GET['value'];
	}
echo displayAllRecords(returnSQLToGetAllRecordsByUser($_SESSION['bid'],$_SESSION['role']),$key, $value, $_SESSION['user'], $_SESSION['role']);	
}






?>
