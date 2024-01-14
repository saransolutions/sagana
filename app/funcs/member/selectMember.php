<?php

function displayMembers($sql, $key, $value, $sid, $user, $role){
	/*
	 * Displaying error message
	 * */
	$errMsg=null;
	if (isset($_SESSION['error_msg'])){
		$errMsg= $_SESSION['error_msg'];
	}else{
		$_SESSION['error_msg']=null;
		unset($_SESSION['error_msg']);
	}
	
	
	
	$page=null;
	$insideHead="<link type='text/css' rel='stylesheet' href='css/lightbox-form.css'>
<script src='js/lightbox-form.js' type='text/javascript'></script>";
	$page = $page.returnMainPageTemplate($errMsg, $insideHead, $user,$role, BGC_FOR_MEMBER).returnBoxForMonthlyMember($sid);
	if($key=='id'){
		$sql=$sql." and member_id like '%".$value."%'";
		$page=$page.displayMembersOV($sql,$sid, $user,$role);
	}else if($key=='mname'){
		$sql=$sql." and cname like '%".$value."%'";
		$page=$page.displayMembersOV($sql,$sid, $user,$role);
	}else if($key=='status'){
		$sql=$sql." and status like '%".$value."%'";
		$page=$page.displayMembersOV($sql,$sid, $user,$role);
	}else{
		$page=$page.displayMembersOV($sql,$sid, $user,$role);
	}	
		
	$page=$page."
</div>        
".HTML_FOOT_LINE."  
</div>
</body>
</html>
	";
	$_SESSION['error_msg']=null;
	unset($_SESSION['error_msg']);
	echo $page;
}

function displayMembersOV($sql,$sid, $user,$role){
	$data=null;
	$rows=getFetchArray($sql." order by member_id desc");
	$rowCounts = count($rows);
	$limit=NO_OF_INV_PER_PAGE;
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
				$data=$data."<a id='id1' href='member.php?sid=".$sid."&p=".$i."'>".$i."</a>";
			}
		}
		$data=$data."
		</font>
		</div>
	<table class='footable' width='100%' style='margin-top:0px;'>
		<thead>			
			<tr>				
				<th>Id</th>				
				<th>Member Name</th>				
				<th>Paid Terms</th>
				<th>Total Amount</th>
				<th>City</th>
				<th>Phone</th>
				<th>Mobile</th>
				<th>Status</th>				
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
		$rows = getFetchArray($sql . " order by member_id desc limit " . $first . "," . $limit . "");
		foreach($rows as $result)
		{
			$statusStr=null;
			$member_id=$result['member_id'];
			$schema_id=$result['scheme_id'];			
			$mpay=$result['mpay'];
			$paid_terms=$result['paid_terms'];
			$total_paid_amount=$result['total_paid_amount'];
			$cust_id=$result['cust_id'];
			$cname=$result['cname'];
			$street=$result['street'];
			$city=$result['city'];
			$zip=$result['zip'];
			$state=$result['state'];
			$phone=$result['phone'];
			$mobile=$result['mobile'];
			$email=$result['email'];
			$status=$result['status'];
			$jdate=$result['jdate'];
			$scheme_status=$result['scheme_status'];
				
			$data=$data."<tr>
			<td><a href='member.php?member_id=".$member_id."'>".PREFIX_MEMBER_NR.$member_id."</a></td>			
			<td><a href='member.php?member_id=".$member_id."'>".$cname."</a>"."</td>
			<td>".$paid_terms."</td>
			<td>".$total_paid_amount."</td>
			<td>".$city."</td>
			<td>".$phone."</td>
			<td>".$mobile."</td>
			<td>".displayOrderStatus($status)."</td><td>";
			if($scheme_status!=STATUS_MEMBER_CLOSED){
				$data=$data.getActionsForMember($member_id, $schema_id, $status, $role, $cust_id);
			}			
			$data=$data."
			</td>
		</tr>";		
		}
		$data=$data."</tbody></table>";
		$data=$data."<div style='padding:3px;'>
			<font style='font-family:verdana;font-size:12px;'>pages(".$totalpage.")";
		$pageNrFlag=true;
		if($pageNrFlag){
			$data=$data."...";
			for($i = 1; $i <= $totalpage; $i ++) {
				$data=$data."<a id='id1' href='member.php?sid=".$sid."&p=".$i."'>".$i."</a>";
			}
		}
	}else{
		return "<p style='font-family:verdana;font-size:12px;color:red;'>No rows found</p>";
	}
	return $data;
}

function getActionsForMember($member_id, $schema_id, $status, $role, $cust_id){
	$data=null;
	$dr="&nbsp;";
	$editAction="<a href='customer.php?ecust_id=".$cust_id."'><img src='img/icon/edit.png' title='edit member details' style='width:18px;height:18px;' /></a>";
	
	$printAction="<a href='member.php?mprint=".$member_id."' target='_blank' ><img src='img/icon/print.png' style='width:18px;height:18px;' title='print member' /></a>";
	
	$markWinnerAction="<a href='member.php?markwinner=".$member_id."&scid=".$schema_id."'  confirm('Are you sure to pay for this member ?')\">
	<img src='img/icon/winner.png' title='mark as winner' /></a>";
	
	$revertWinnerAction="<a href='member.php?revertwinner=".$member_id."&scid=".$schema_id."'  confirm('Are you sure to declare this member is not a winner ?')\">	
	<img src='img/icon/revert.png' title='mark as winner' /></a>";
	
	$payMemberAction="<a href='member.php?paymemberid=".$member_id."&scid=".$schema_id."' confirm('Are you sure to pay for this member ?')\">
	<img src='img/icon/add_customer.png' title='pay for this member' style='width:18px;height:18px;' /></a>";
	
	$revertMemberAction="<a href='member.php?revertmemberid=".$member_id."&scid=".$schema_id."' confirm('Are you sure to revert for this member ?')\">
	<img src='img/icon/revert_payment.png' title='revert this payment' style='width:18px;height:18px;' /></a>";
	
	$deleteMemberAction="<a href='member.php?dmid=".$member_id."&scid=".$schema_id."' onclick=\"return confirm('Are you sure to delete this Invoice ?')\" >
	<img src='img/icon/delete.png' title='delete this member' style='width:15px;height:15px;' /></a>";
	
	if($status==STATUS_MEMBER_WINNER){
		$data=$data.$printAction.$dr.$dr.$dr.
				$revertWinnerAction.$dr.$dr.$dr.
				$editAction.$dr.$dr;
	}else{
		$data=$data. $printAction.$dr.$dr.$dr.
			$editAction.$dr.$dr.
			$markWinnerAction.$dr.$dr.$dr.
			$payMemberAction.$dr.$dr.$dr.
			$revertMemberAction.$dr.$dr.$dr;
	}
	if($role=='admin'){
		$data=$data.$deleteMemberAction;	
	}
	
	return $data;
}

function displayMemberById($member_id, $role){
	$sql="select 
m.member_id, m.scheme_id, m.cust_id, paid_terms, total_paid_amount, m.status member_status, scheme_name, start_date, no_of_terms, 
mpay, members, s.status scheme_status, price_amount, cname, street, city, zip, state, phone, mobile, email 
	
	from members m, mschemes s, customer c where m.member_id=".$member_id." and m.scheme_id=s.scheme_id and m.cust_id=c.cust_id";
	$rows=getFetchArray($sql);
	$data=null;
	$schema_id=null;$cust_id=null;$status=null;
	foreach ($rows as $result){
		$statusStr=null;
		$member_id=$result['member_id'];
		$schema_id=$result['scheme_id'];
		$status=$result['member_status'];
		$no_of_terms=$result['no_of_terms'];
		$start_date=$result['start_date'];
		$mpay=$result['mpay'];
		$paid_terms=$result['paid_terms'];
		$total_paid_amount=$result['total_paid_amount'];
		$cust_id=$result['cust_id'];
		$cname=$result['cname'];
		$street=$result['street'];
		$city=$result['city'];
		$zip=$result['zip'];
		$state=$result['state'];
		$phone=$result['phone'];
		$mobile=$result['mobile'];
		$email=$result['email'];			
		
		
	$data=$data."
	
	<div id='tabs' style='background:#F9F9F9;'>
  <ul>
  <li><a href='#tabs-1'>Scheme Details</a></li>
	<li><a href='#tabs-2'>Contact Details</a></li>
	<li><a href='#tabs-3'>Payment Details</a></li>
  </ul>
  <div id='tabs-1'>  
	<p><label>Member Id</label><label>".PREFIX_MEMBER_NR.$member_id."</label></p>
	<p><label>Member Name</label><label>".$cname."</label></p>
	<p><label>Monthly Payment</label><label>".$mpay." CHF</label></p>
	<p><label>No of Terms</label><label>".$no_of_terms."</label></p>
	<p><label>Start Date</label><label>".$start_date."</label></p>
	<p><label>Paid Terms</label><label>".$paid_terms."</label></p>
	<p><label>Total Paid Amount</label><label>".$total_paid_amount."</label></p>
	<hr>
	<p><label>Status</label><label>".displayOrderStatus($status)."</label></p>
	<p></p>
  </div>
  <div id='tabs-2'>
  <a style='color:blue;' href='customer.php?ecust_id=".$cust_id."'>Edit Customer</a>
	<p><label>Street</label><label>".$street."</label></p>
	<p><label>City</label><label>".$city."</label></p>
	<p><label>Zip</label><label>".$zip."</label></p>
	<p><label>Phone</label><label>".$phone."</label></p>
	<p><label>Mobile</label><label>".$mobile."</label></p>
	<p><label>Email</label><label>".$email."</label></p>
  </div>
  <div id='tabs-3'>
	".getMemberTransactions($member_id)."
  </div>
</div>

<div class='tabs-background'></div>
<div class='tabs-background'></div>
<br>
".getLinkWithIcon("member.php?sid=".$schema_id."", "home.png", "Back to Members", "width:15px;height:15px;", "Back to Members")."
".getActionsForMember($member_id, $schema_id, $status, $role, $cust_id)."
	";
		echo getHTMLPage(MAIN_TITLE, "Monthly Scheme - Member", $data, getHTMLHeadContentForTabs(), BGC_FOR_MEMBER);
	}
}


function getMemeberActionLinks($sid){
	$data=null;
	$data=$data.getLinkWithIcon("member.php?sid=".$sid."","home.png","Back to Monthly Schemes","width:15px;height:15px;", "Back to Members");
	$data=$data.getLinkWithIcon("member.php?sid=".$sid."","home.png","Back to Monthly Schemes","width:15px;height:15px;", "Pay Member");
	//$data=$data."<a href='' id='id11'><img src='img/icon/' title='' style='' />Members</a>";
	return $data;
}


function getHTMLHeadContentForTabs(){
	return "
	<link rel='stylesheet' href='http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css' />
  <script src='http://code.jquery.com/jquery-1.9.1.js'></script>
  <script src='http://code.jquery.com/ui/1.10.3/jquery-ui.js'></script>
  
	<style>  
  #tabs .ui-tabs-nav { 
    float: right; 
    border-left: none; 
    -moz-border-radius: 0px 6px 6px 0px; 
    -webkit-border-radius: 0px 6px 6px 0px; 
    border-radius: 0px 6px 6px 0px; 
} 
#tabs .tabs-background { 
    height: 2.6em; 
    background: #ece8da url(css/ui-bg_gloss-wave_100_ece8da_500x100.png) repeat-x scroll 50% 50%; 
    border: 1px solid #d4ccb0; 
    -moz-border-radius: 6px; 
    -webkit-border-radius: 6px; 
    border-radius: 6px; 
}
</style>
  
  <script>
  $(function() {
    $( '#tabs' ).tabs();
  });
  </script> 
  ";
}

function getMemberDetailsForMiniBillPDF($member_id){
	$sql="select * from members m, mschemes s, customer c where m.member_id=".$member_id." and m.scheme_id=s.scheme_id and m.cust_id=c.cust_id";
	$rows=getFetchArray($sql);
	$data=null;
	foreach ($rows as $result){		
		$mpay=$result['mpay'];
		$cname=$result['cname'];
		$street=$result['street'];
		$city=$result['city'];
		$zip=$result['zip'];
		$state=$result['state'];		
		$status=$result['status'];
		
	}
}