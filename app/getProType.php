<?php

if(isset($_POST['submit'])){
	
	
}else{
	


?>
<!DOCTYPE html><html lang='en-US'>
<head>
  <meta charset='UTF-8'>
	<title>Sagana - Invoice </title>	
	<link rel='stylesheet' href='css/style.css'>
  
  <script>
  function closeWin() {
	    myWindow.close();
	}    
  </script>
  <style>
  input[type=radio] + label {
  color: #ccc;
  font-style: italic;
} 
input[type=radio]:checked + label {
  color: #f00;
  font-style: normal;
}
  </style>
 
	
</head>
<body>

<div id='container'>
	<?php construct();?>
</div>  

 

</body>
</html>
<?php
} 
?>

<?php 
function construct(){
	require_once 'funcs/db/db.php';
	$level=0;$pos=0;$pid=0;
	executeBasedOnLevel($level,$pid);	
}

function executeBasedOnLevel($level,$pid){
	$link="invoice.php?addSInv&";
	$del=getDelimitter($level);
	$sql="select t.id,(select nm from tree_data where id =t.id )node_name from tree_struct t where t.lvl=".$level." and t.pid=".$pid."";
	//echo "sql - ".$sql;
	$rows1=getFetchArray($sql);
	if(count($rows1) != 0){
		foreach ($rows1 as $row1){
			if(hasChild($row1['id'])){	
				$proName=$row1['node_name'];	
				$proId=$row1['id'];
				//echo $del.'<input style="float:left;padding:0px;margin:0px;" type="radio" name="pro" value="'.$proId.'">'.$proName;
				echo $del.'<input id="radio1" type="radio" name="pro" value="'.$proId.'"><label for="radio1"><span><span></span></span>'.$proName.'</label><br>';		
						
			}else{
				echo '<p>'.$del.'<img src="img/icon/folder_icon.png" /> '.$row1['node_name'].'</p>';
			}
			
			$pid = $row1['id'];
			executeBasedOnLevel($level+1,$pid);
		}
	}	
}

function hasChild($pid){
	$sql="select 1 from tree_struct t where t.pid=".$pid."";
	$rows1=getFetchArray($sql);
	if(count($rows1) == 0){
		return true;
	}
	return false;	
}

function getDelimitter($level){
	$del="&nbsp;&nbsp;&nbsp;&nbsp;";
	$result=null;
	for ($i=0;$i<$level;$i++){
		$result=$result.$del;
	}
	return $result;
}
?>