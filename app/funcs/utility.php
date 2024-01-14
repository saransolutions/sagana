<?php

function checkUserLogin(){
	if(!isset($_SESSION['user'])){
		header("Location: login/login.php");
	}else if(isset($_GET['logoff']))
	{
		// Delete certain session
		unset($_SESSION['user']);
		// Delete all session variables
		// session_destroy();
		session_destroy();
		// Jump to login page
		header('Location: login/login.php');
	}
}


function getSelectBox($arg1, $arg2, $arg3, $arg4){
$part1;
$part2='';
$part3= "</select>";
	require_once 'funcs/db/db.php';
	$query = selectSQL($arg1);	
	$part1= "<select name='".$arg2."'
	id='".$arg3."' ".$arg4.">
	<option value=''></option>";
	
	while($row = mysqli_fetch_array($query))
	{
		$key_id=$row['key_id'];
		$value=$row['value'];
		$part2=$part2."<option value='".$key_id."'>".$value."</option>";
	}
	
	return $part1.$part2.$part3;
}

function getSelectBoxById($arg1, $arg2, $arg3, $arg4, $arg5){
	
	$part2='';
	$result=selectSQL($arg1);
	$part1= "<select name='".$arg2."'
	id='".$arg3."' ".$arg4.">
	<option value='--'>--</option>";
	while($row = mysqli_fetch_array($result))
	{
		$key_id=$row['key_id'];
		$value=$row['value'];
		if($arg5==$value){
			$part2=$part2. "<option value='".$key_id."' selected>".$value."</option>";	
		}else{
			$part2=$part2. "<option value='".$key_id."'>".$value."</option>";
		}		
	}
	$part3= "</select>";	
	return $part1.$part2.$part3;
}

/**
 * This is the exceptional method to get the key and value from customer 
 * in case of duplicate customers
 * Aug 14th 2014
 * Enter description here ...
 * @param unknown_type $arg1
 * @param unknown_type $arg2
 * @param unknown_type $arg3
 * @param unknown_type $arg4
 */
function getSelectBoxExp($arg1, $arg2, $arg3, $arg4){
$part1;
$part2='';
$part3= "</select>";
	require_once 'funcs/db/db.php';
	$query = selectSQL($arg1);	
	$part1= "<select name='".$arg2."'
	id='".$arg3."' ".$arg4.">
	<option value=''></option>";
	
	while($row = mysqli_fetch_array($query))
	{
		$key_id=$row['cname'];
		$value=$row['cname'];
		$part2=$part2."<option value='".$key_id."'>".$value."</option>";
	}
	
	return $part1.$part2.$part3;
}


function getBaggageListBox(){
	
}

function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}function getSQLBasedOnKeys($sql,$key,$value){	if($key=='paid_to'){		$sql=$sql." and party_name like '%".$value."%'";	}else if($key=='paid_by'){		$sql=$sql." and p_m_name like '%".$value."%'";	}else if($key=='amount'){		$sql=$sql." and total_amount like '%".$value."%'";	}else if($key=='name'){		$sql=$sql." and type like '%".$value."%'";	}else if($key=='ex'){		$sql=$sql." and rtype like '%".EXPEND."%'";	}else if($key=='in'){		$sql=$sql." and rtype like '%".INCOME."%'";	}else{		$sql=$sql;	}	return $sql;}	
function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

function InStr($haystack, $needle) 
{ 
    $pos=strpos($haystack, $needle); 
    if ($pos !== false) 
    { 
        return $pos; 
    } 
    else 
    { 
        return -1; 
    } 
} 

function getOriginalCellFromRow($row, $delimitter){
	$cells=explode($delimitter, $row);
	$origCells=array();$origNo=0;
	foreach ($cells as $cell){
		if(strlen($cell) > 0){
			$origCells[$origNo]=$cell;
			$origNo++;
		}
	}
	return $origCells;
}


function displayRows($rows){
$rowCount=0;
	foreach ($rows as $row){
		echo $rowCount." row - ".$row."<br>";
		$rowCount++;
	}
}

function displayTempHTML_HEAD(){
	echo "<html>
  <head>
    <meta name='generator' content='' />
    <title>TEST</title>
    <style>
    	#body_id{
    		font-family:verdana;font-size:12px;background:gray;color:#FFF;
		}
    </style>
  </head>
  <body id='body_id'>
	";
}

function displayTempHTML_FOOT(){
	echo "</body></html>";
}

//Invoice - ".$inv_id."
function getHTMLPage($title,$heading,$content, $insideHead, $bgc){
	$data="<html lang='en-US'>".returnHTMLHead($title, $insideHead)."
<body>	
	<div id='container' style='width:70%;background:".$bgc.";'>
		".getSimpleNavigationMenu()."
		<center><p style='font-size:18px;line-height:200%;background:#FFE0E0;border:1px solid #A2A2A8;'>".$heading."</p></center>	
			".$content."	
	</div>
</body>
</html>";
	return $data;
}

function getChoosyJSScriptCode(){
	return "<script src='js/jquery.min.js' type='text/javascript'></script>
		<script src='js/chosen.jquery.js' type='text/javascript'></script>
		<script type='text/javascript'>
			var config = {
			  '.chosen-select'           : {},
			  '.chosen-select-deselect'  : {allow_single_deselect:true},
			  '.chosen-select-no-single' : {disable_search_threshold:10},
			  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
			  '.chosen-select-width'     : {width:'15%'}
			}
			for (var selector in config) {
			  $(selector).chosen(config[selector]);
			}
		</script>";
	
}



function displayOrderStatus($status){
	$statusStr=null;
	$style="padding:3px;color:#FFF;font-size:12px;";
	$forPaid="style='background:#006600;".$style."'";
	$forUnpaid="style='background:#FF3300;".$style."'";
	$forOrdered="style='background:#3385FF;".$style."'";	
	$forWinner="style='background:#FFFF00;".$style.";color:red;'";
	
	if($status==STATUS_PAID_VALUE){
		$statusStr="<label ".$forPaid.">".$status."</label>";		
	}else if($status==STATUS_UNPAID_VALUE){
		$statusStr="<label ".$forUnpaid.">".$status."</label>";						
	}else if($status==STATUS_ORDERED_VALUE){
		$statusStr="<label ".$forOrdered.">".$status."</label>";						
	}else if($status==STATUS_MEMBER_WINNER){
		$statusStr="<label ".$forWinner.">".$status."</label>";						
	}else if($status==STATUS_MEMBER_JOINED){
		$statusStr="<label ".$forOrdered.">".$status."</label>";						
	}
	return $statusStr;
}

function getLinkWithIcon($link,$img,$title,$style, $word){
	return "<a href='".$link."' id='id11'><img src='img/icon/".$img."' title='".$title."' style='".$style."' />".$word."</a>";
}function getImageForExpenditureIncomeType($rtype){	if($rtype=='Expenditure'){		return "<img src='img/icon/sub.png' style='width:18px;height:18px;' title='Expenditure' />";	}else {		return "<img src='img/icon/add.png' style='width:18px;height:18px;' title='Income' />";	}}
function uploadFile($buttonName, $target_dir){		if($_FILES[$buttonName]['name'])	{		$image_file_name=$_FILES[$buttonName]['name'];		if(!$_FILES[$buttonName]['error'])		{			$new_file_name = strtolower($_FILES[$buttonName]['tmp_name']);			if($_FILES[$buttonName]['size'] > (2048000))			{				return 1;			}else{				$image_file_name = basename($_FILES[$buttonName]['name']);				$target = $target_dir.$image_file_name;				move_uploaded_file($_FILES[$buttonName]['tmp_name'], $target);				return 0;			}		}else		{			return $_FILES[$buttonName]['error'];		}	}}function downloadFile($file){        if(file_exists($file)) {            header('Content-Description: File Transfer');            header('Content-Type: application/octet-stream');            header('Content-Disposition: attachment; filename='.basename($file));            header('Content-Transfer-Encoding: binary');            header('Expires: 0');            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');            header('Pragma: public');            header('Content-Length: ' . filesize($file));            ob_clean();            flush();            readfile($file);            exit;        }   }/*copied from gk*/   function getReportYears($from, $to){	$data=null;	for ($from;$from<=$to;$from++){		$data=$data."<option value='".$from."'>".$from."</option>";	}	return $data;}      
?>