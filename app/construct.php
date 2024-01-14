<?php

if(isset($_POST['submit'])){
	
	
}else{
	


?>
<!DOCTYPE html><html lang='en-US'>
<head>
  <meta charset='UTF-8'>
	<title>Sagana - Invoice </title>	
	<link rel='stylesheet' href='css/style.css'>
	
	 
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  
  
  <script>
  function closeWin() {
	    myWindow.close();
	}

  $(function() {
	    $(".player p").draggable({
	        revert: "invalid"
	    });

	    $(".position").droppable({       
	        drop: function(event, ui) {
	            var playerid = ui.draggable.attr("id");
	            $("input", this).val(playerid);
	        }
	    });
	    
	    $("form").submit(function (e) {
	        e.preventDefault();
	        alert($(this).serialize());
	    });

	});
  
  </script>
  
 
	
</head>
<body>

<div id='container'>
	<div id="content_cons"> 
	    <div id="left_prod">     
	    	<div id="object1">some more stuff</div>     
	    	<div class="player"><ul><?php construct();?></ul></div>
	    </div> 
	    <div id="right_bucket">     
	    	<div id="object3">unas cosas</div>     
	    		<div id="cart">
			 		 <h1>Shopping Cart</h1>
			  		<form id="resultform" name="resultform" action="1.php" method="post">
			  		<div class="position">
			    		<ul>
			      			<li><img src='img/icon/shopping_bucket.png' /> </li>
			    		</ul>
			  		</div>
			  		<input name="submit" type="submit" id="submit" value="Submit" />
			  		</form>
			</div>
  
        
	    </div>
    </div>
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
				//
				echo '<p><input type="checkbox" name="" value=""></input><a href="'.$link.$row1['id'].'" style="text-decoration:none;" onclick="closeWin()" id="'.$row1['id'].'">'.$del.$row1['node_name'].'</a></p>';
				echo '<input type="hidden" name="'.$row1['id'].'" id="'.$row1['id'].'" value="Player1" />';
			}else{
				echo '<pre>'.$del.'<img src="img/icon/folder_icon.png" /> '.$row1['node_name'].'</pre>';
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