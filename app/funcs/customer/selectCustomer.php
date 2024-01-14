<?php

function displayAllCustomers($sql, $key, $value, $user, $role){
	$page=null;
	$page = $page.returnMainPageTemplate($errMsg, null, $user, $role, BGC_FOR_CUSTOMER).
	"<br><center><h2 style='background:#C9E9C9'>Customer</h2></center>".
	BOX_FOR_NEW_CUSTOMER;
	if($key=='cname'){
		$sql=$sql." and cname like '%".$value."%'";
		$page=$page.displayCustomerOV($sql, $user,$role);
	}else if($key=='city'){
		$sql=$sql." and city like '".$value."%'";
		$page=$page.displayCustomerOV($sql, $user,$role);
	}else if($key=='mobile'){
		$sql=$sql." and mobile like '".$value."%'";
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
	$rows=getFetchArray($sql." order by cust_id desc");
	$rowCounts = count($rows);
	$limit=NO_OF_CUSTOMER_PER_PAGE;
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
				$data=$data."<a id='id1' href='customer.php?p=".$i."'>".$i."</a>";
			}
		}
		$data=$data."
		</font>
		</div>
	<table class='footable' width='100%' style='margin-top:0px;'>
		<thead>			
			<tr>		
				<th>ID</th>
				<th>Customer Name</th>
				<th style='width:10%;'>City</th>
				<th style='width:5%;'>Phone</th>
				<th style='width:5%;'>Mobile</th>
				<th style='width:10%;'>Email</th>				
				<th></th>				
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
		$rows = getFetchArray($sql . " order by cust_id desc limit " . $first . "," . $limit . "");		
		foreach($rows as $result)
		{
			$cust_id= $result['cust_id'];
			$cname= $result['cname'];			
			$city= $result['city'];
			
			$phone= $result['phone'];
			$mobile= $result['mobile'];
			$email= $result['email'];
			
			$data=$data."<tr>			
			<td><a href='customer.php?cust_id=".$cust_id."'>".PREFIX_CUSTOMER_NR.$cust_id."</a></td>			
			<td><a href='customer.php?cust_id=".$cust_id."'>".$cname."</a>"."</td>
			<td>".$city."</td>
			<td>".$phone."</td>
			<td>".$mobile."</td>
			<td>".$email."</td>
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
				$data=$data."<a id='id1' href='customer.php?p=".$i."'>".$i."</a>";
			}
		}
	}else{
		return "<p style='font-family:verdana;font-size:12px;color:red;'>No rows found</p>";
	}
	return $data;
}

function getActionsForCustomer($role, $cust_id){
	$data=null;
	if($role=='admin'){
		$data=$data."<a id='id11' href='customer.php?ecust_id=".$cust_id."'><img src='img/icon/edit_customer.png' title='edit customer' style='width:18px;height:18px;' /></a>";
	}
	return $data;
}

function displaySingleCustomerById($cust_id){
	$nav="<li style='list-style:none;'>
				 <a id='id11' href='customer.php'>Home</a>
				 <a id='id11' href='customer.php?ecust_id=".$cust_id."'>Edit Customer</a>
			</li>";
	echo getHTMLPage(MAIN_TITLE." - Customer", MAIN_TITLE." - Customer - ".$cust_id, $nav."<br>".displayCustomerDetailsById($cust_id), null, BGC_FOR_CUSTOMER);
}

function displayCustomerDetailsById($cust_id){
	$rows=getFetchArray("select * from customer where cust_id=".$cust_id." ");
	$data=null;
	if(count($rows)>0){
		foreach ($rows as $result){
			$cname= $result['cname'];
			$street= $result['street'];
			$zip= $result['zip'];
			$city= $result['city'];
			$phone= $result['phone'];
			$mobile= $result['mobile'];
			$email= $result['email'];
				
			$data=$data."<form action='customer.php' method='post' enctype='multipart/form-data' id='customtheme'>
			<p>
			<label for='origin'>Customer Name</label>
			<label for='origin'>".$cname."</label>
		</p>
<p>
  <label for='origin'>No, Street</label> 
  <label>$street</label>
</p> 
  <p>
  	<label for='origin'>Zip</label> 
  	<label>$zip</label>
  </p>
  <p>
  	<label for='origin'>City</label> 
  	<label>$city</label>
  </p>
  <p>
  	<label for='origin'>Phone</label> 
  	<label>$phone</label>
  </p>
  <p>
  	<label for='origin'>Mobile</label> 
  	<label>$mobile</label>
  </p>
  <p>
  	<label for='origin'>Email</label> 
  	<label>$email</label>
  </p>		
		</form>";
		}
		return $data;
	}else{
		return "No Customer Found - ".$cust_id;
	}
	
}
