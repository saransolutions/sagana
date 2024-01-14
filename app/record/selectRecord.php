<?php

function displayAllRecords($sql, $key, $value, $user, $role){
	$page=null;
	$header=JQUERY_SCRIPT_CALL.getJqueryCalendarJSCall().getVerticalMenuJSCall();	
	$page = $page.returnMainPageTemplate($errMsg, $header, $user, $role, BGC_FOR_CUSTOMER).
	"<br>".getVerticalNavMenu($role)."
	";
	$page = $page.BOX_FOR_NEW_RECORD;
	$sql=getSQLBasedOnKeys($sql,$key,$value);
	$page=$page.displayCustomerOV($sql, $user,$role, $key, $value);
	$page=$page."	
</div>        
".HTML_FOOT_LINE."  
</div>
</body>
</html>
	";	
	
	return $page;;
}

function displayCustomerOV($sql, $user,$role, $key, $value){
	//echo "SQL for search - ".$sql;
	$data=null;
	$rows=getFetchArray($sql." order by rdate desc");
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
				$data=$data."<a id='id1' href='records.php?key=".$key."&value=".$value."&p=".$i."'>".$i."</a>";
			}
		}
		$data=$data."
		</font>
		</div>
	<table class='footable' width='100%' style='margin-top:0px;'>
		<thead>			
			<tr>		
				<th style='width:3%;'>ID</th>
				<th style='width:1%;'>Type</th>
				<th style='width:10%;'>Name</th>
				<th style='width:5%;'>Amount</th>
				<!--<th style='width:5%;'>Owner</th>-->
				<th style='width:7%;'>Party</th>
				<th style='width:5%;'>Paid By</th>
				<th style='width:5%;'>Date</th>								
				<th style='width:5%;'></th>				
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
		$rows = getFetchArray($sql . " order by rdate desc limit " . $first . "," . $limit . "");		
		foreach($rows as $result)
		{
			$cust_id= $result['rid'];
			$cname= $result['rtype'];
			$type= $result['type'];
			$user= $result['user'];			
			$city= $result['total_amount'];
			$paid_to= $result['party_name'];
			$p_m_name= $result['p_m_name'];
			$mdate= $result['rdate'];
			$mdate = date("d-m-Y", strtotime($mdate));
			
			$file_name= $result['file_name'];
			$attach=null;
			if(strlen($file_name) > 0){
				$attach = "<a href='records.php?attach=".$file_name."' target='_blank' ><img src='img/icon/attachment.png' style='width:18px;height:18px;' /></a>";
			}
			
			$data=$data."<tr>			
			<td><a href='records.php?rid=".$cust_id."'>".PREFIX_RECORD_NR.$cust_id."</a></td>
			<td>".getImageForExpenditureIncomeType($cname)."</td>				
			<td><a href='records.php?rid=".$cust_id."'>".$type."</a>"."</td>
			<td>".$city."</td>
			<!--<td>".$user."</td>-->
			<td>".$paid_to."</td>
			<td>".$p_m_name."</td>			
			<td>".$mdate."</td>								
			<td>".getActionsForCustomer($role, $cust_id, $attach)."</td>
		</tr>";
		}
		$data=$data."</tbody></table>";
		$data=$data."<div style='padding:3px;'>
			<font style='font-family:verdana;font-size:12px;'>pages(".$totalpage.")";
		$pageNrFlag=true;
		if($pageNrFlag){
			$data=$data."...";
			for($i = 1; $i <= $totalpage; $i ++) {
				$data=$data."<a id='id1' href='records.php?key=".$key."&value=".$value."&p=".$i."'>".$i."</a>";
			}
		}
	}else{
		return "<p style='font-family:verdana;font-size:12px;color:red;'>No rows found</p>";
	}
	return $data;
}


function getRetrieveData($sql){

	$data=null;
	$data=$data."<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	</head>
	<body>
	<table class='footable' width='100%' style='margin-top:0px;'>
		<thead>			
			<tr>		
				<th style='width:3%;'>ID</th>
				<th style='width:1%;'>Type</th>
				<th style='width:10%;'>Name</th>
				<th style='width:5%;'>Amount</th>
				<!--<th style='width:5%;'>Owner</th>-->
				<th style='width:7%;'>Party</th>
				<th style='width:5%;'>Paid By</th>
				<th style='width:5%;'>Date</th>	
			</tr>
		</thead>
		<tbody>";	
	$rows = getFetchArray($sql . " order by rdate desc");$totalAmount=0;
	foreach($rows as $result)
	{
		$cust_id= $result['rid'];
		$cname= $result['rtype'];
		$type= $result['type'];
		$user= $result['user'];
		$city= $result['total_amount'];
		$paid_to= $result['party_name'];
		$p_m_name= $result['p_m_name'];
		$mdate= $result['rdate'];
		$mdate = date("d-m-Y", strtotime($mdate));
			
		$file_name= $result['file_name'];
		$attach=null;
		if(strlen($file_name) > 0){
			$attach = "<a href='records.php?attach=".$file_name."' target='_blank' ><img src='img/icon/attachment.png' style='width:18px;height:18px;' /></a>";
		}
			
		$data=$data."<tr>
			<td><a href='records.php?rid=".$cust_id."'>".PREFIX_RECORD_NR.$cust_id."</a></td>
			<td>".$cname."</td>				
			<td><a href='records.php?rid=".$cust_id."'>".$type."</a>"."</td>
			<td>".$city."</td>
			<!--<td>".$user."</td>-->
			<td>".$paid_to."</td>
			<td>".$p_m_name."</td>			
			<td>".$mdate."</td>
		</tr>";
		$totalAmount=$totalAmount+$city;
	}
	$data=$data."<table class='footable' width='100%' style='margin-top:10px;'>
		<thead>			
			<tr><th style='width:3%;'>Total Amount</th>"."<th style='width:3%;'>".$totalAmount."</th></tr>";
	$data=$data."</tbody></table></body>
</html>";
	return $data;
}

function getActionsForCustomer($role, $cust_id, $attach){
	$data=null;
	$data=$data."
	<a id='id11' href='records.php?erid=".$cust_id."'>
			<img src='img/icon/edit.png' title='edit record' style='width:18px;height:18px;'/>
		</a>";
	
	if($role=='admin'){
		$data=$data."		
		<a href='records.php?drid=".$cust_id."' onclick=\"return confirm('Are you sure to delete this Record ?')\" >
			<img src='img/icon/delete.png' title='delete record' style='width:15px;height:15px;' /></a>
		";
	}
	$data=$data.$attach;
	return $data;
}

function displayRecordId($cust_id){
	$nav="<li style='list-style:none;'>
				 <a id='id11' href='records.php'>Home</a>
				 <a id='id11' href='records.php?erid=".$cust_id."'>Edit Record</a>
				 <a id='id11' href='records.php?eattach=".$cust_id."'>Edit Attach</a>
			</li>";
	echo getHTMLPage(MAIN_TITLE." - Record ", MAIN_TITLE." - Record - ".$cust_id, $nav."<br>".displayRecordDetailsById($cust_id), null, BGC_FOR_CUSTOMER);
}

function displayRecordDetailsById($cust_id){
	$rows=getFetchArray("select (select username from bookies where bid=r.bid)user,
	(select value from payment_method_list where key_id=r.p_method) p_method_value, 
	r.*,(select name from record_types where tid=r.sub_type)sub_type from records r where r.rid=".$cust_id." ");
	$data=null;
	if(count($rows)>0){
		foreach ($rows as $result){
			$rdate= $result['rdate'];
			$pname= $result['sub_type'];
			$street= $result['notes'];	
			$rtype= $result['rtype'];
			$user= $result['user'];
			$p_method= $result['p_method_value'];
			$total_amount = $result['total_amount'];			
			$party_name = $result['party_name'];			
			$rtype= $result['rtype'];
			$file_name= $result['file_name'];
				
			$data=$data."			
			<p>
				<label for='origin'>Created Date</label>
				<label for='origin'>".$rdate."</label>
			</p>";
			if($rtype==EXPEND){
				$data=$data."
			<p>
				<label for='origin'>Record Type</label>
				<label for='origin' class='rpayButton'>".$rtype."</label>
			</p>";
			}else if($rtype==INCOME){
				$data=$data."
			<p>
				<label for='origin'>Record Type</label>
				<label for='origin' class='payButton'>".$rtype."</label>
			</p>";
			}
				
			$data=$data."			
			<p>
				<label for='origin'>Notes</label> 
  				<label>$street</label>
			</p>			
			<p>
				<label for='origin'>Record Name</label>
				<label for='origin' >".$pname."</label>
			</p>			
			<p>
				<label for='origin'>Total Amount</label>
				<label for='origin'>".$total_amount." CHF </label>
			</p>			
			<p>
				<label for='origin'>Created By</label>
				<label for='origin'>".$user." </label>
			</p>			
			<p>
				<label for='origin'>Given to</label>
				<label for='origin'>".$party_name." </label>
			</p>			
			<p>
				<label for='origin'>Payment Method</label>
				<label for='origin'>".$p_method." </label>
			</p>";
					
			
			if(strlen($file_name) > 0){
				$data=$data."<p>
				<label for='origin'>Attachment</label>
				<label for='origin'><a href='records.php?attach=".$file_name."' target='_blank' >$file_name<img src='img/icon/attachment.png' style='width:18px;height:18px;' /></a> </label>
			</p>";
			}
		}
		return $data;
	}else{
		return "No Customer Found - ".$cust_id;
	}
	
}
