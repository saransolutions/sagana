<?php

function displayAllRecordTypes($sql, $key, $value, $user, $role){
	$page=null;
	$page = $page.returnMainPageTemplate($errMsg, null, $user, $role, BGC_FOR_CUSTOMER).
	"<br><center><h2 style='background:#FFFF99'>Record Type</h2></center>".
	BOX_FOR_NEW_RECORD_TYPE;
	if($key=='name'){
		$sql=$sql." and name like '%".$value."%'";
		$page=$page.displayCustomerOV($sql, $user,$role);
	}
	else{
		$page=$page.displayCustomerOV($sql, $user,$role);
	}

	$page=$page."
</div>        
".HTML_FOOT_LINE."  
</div>
</body>
</html>
	";	
	echo $page;
}

function displayCustomerOV($sql, $user,$role){
	//echo "SQL for search - ".$sql;
	$data=null;
	$rows=getFetchArray($sql." order by tid desc");
	$rowCounts = count($rows);
	$limit=NO_OF_PRODUCT_PER_PAGE;
	if($rowCounts!=0){
		if($rowCounts>$limit){
			$totalpage = round (($rowCounts / $limit)) + 1;	
		}else{
			$totalpage = round (($rowCounts / $limit)) ;
		}
		$data=$data."<div style='padding:3px;float:right;'>
			<font style='font-family:verdana;font-size:12px;'>pages(".$totalpage.")";
		$pageNrFlag=true;
		if($pageNrFlag){
			$data=$data."...";
			for($i = 1; $i <= $totalpage; $i ++) {
				$data=$data."<a id='id1' href='recordTypes.php?p=".$i."'>".$i."</a>";
			}
		}
		$data=$data."
		</font>
		</div>
	<table class='footable' width='100%' style='margin-top:0px;'>
		<thead>			
			<tr>		
				<th style='width:10%;'>ID</th>
				<th style='width:10%;'>Type</th>
				<th style='width:20%;'>Name</th>
				<th style='width:30%;'>Comments</th>
				<th style='width:15%;'>Created Date</th>							
				<th style='width:10%;'></th>				
			</tr>
		</thead>
		<tbody>";

		$first;
		$last;
		if (! isset ( $_GET ['p'] ) || $_GET ['p'] == '1') {
			$first = 0;
		} else {
			$page = $_GET ['p'];
			$first = (($page - 1) * $limit);
		}
		$rows = getFetchArray($sql . " order by tid desc limit " . $first . "," . $limit . "");		
		foreach($rows as $result)
		{
			$cust_id= $result['tid'];
			$cname= $result['name'];
			$type= $result['type'];			
			$city= $result['description'];
			$mdate= $result['mdate'];
			
			$data=$data."<tr>					
			<td><a href='recordTypes.php?tid=".$cust_id."'>".PREFIX_PRODUCT_NR.$cust_id."</a></td>
			<td>".$type."</td>				
			<td><a href='recordTypes.php?tid=".$cust_id."'>".$cname."</a>"."</td>
			<td>".$city."</td>
			<td>".$mdate."</td>								
			<td>".getActionsForCustomer($role, $cust_id)."</td>
		</tr>";
		}
		$data=$data."</tbody></table>";
		$data=$data."<div style='padding:3px;'>
			<font style='font-family:verdana;font-size:12px;'>pages(".$totalpage.")";
		$pageNrFlag=true;
		if($pageNrFlag){
			$data=$data."...";
			for($i = 1; $i <= $totalpage; $i ++) {
				$data=$data."<a id='id1' href='recordTypes.php?p=".$i."'>".$i."</a>";
			}
		}
	}else{
		return "<p style='font-family:verdana;font-size:12px;color:red;'>No rows found</p>";
	}
	return $data;
}

function getActionsForCustomer($role, $cust_id){
	$data=null;
	$data=$data."<a id='id11' href='recordTypes.php?etid=".$cust_id."'>
			<img src='img/icon/edit.png' title='edit record type' style='width:18px;height:18px;'/>
		</a>";
	
	if($role=='admin'){
		$data=$data."<a href='recordTypes.php?dtid=".$cust_id."' onclick=\"return confirm('Are you sure to delete this Record Type ?')\" >
			<img src='img/icon/delete.png' title='delete record type' style='width:15px;height:15px;' /></a>";
	}
	return $data;
}

function displayRecordTypeById($cust_id){
	$nav="<li style='list-style:none;'>
				 <a id='id11' href='recordTypes.php'>Home</a>
				 <a id='id11' href='recordTypes.php?etid=".$cust_id."'>Edit Record Type</a>
			</li>";
	echo getHTMLPage(MAIN_TITLE." - Record Type", MAIN_TITLE." - Record Type - ".$cust_id, $nav."<br>".displayRecordTypeDetailsById($cust_id), null, BGC_FOR_CUSTOMER);
}

function displayRecordTypeDetailsById($cust_id){
	$rows=getFetchArray("select * from record_types where tid=".$cust_id." ");
	$data=null;
	if(count($rows)>0){
		foreach ($rows as $result){
			$type= $result['type'];
			$pname= $result['name'];
			$street= $result['description'];			
				
			$data=$data."
			<p>
			<label for='origin'>Type</label>
			<label for='origin'>".$type."</label>
		</p>
			<p>
			<label for='origin'>Record Name</label>
			<label for='origin'>".$pname."</label>
		</p>
<p>
  <label for='origin'>Comments</label> 
  <label>$street</label>
</p>";
		}
		return $data;
	}else{
		return "No Customer Found - ".$cust_id;
	}
	
}
