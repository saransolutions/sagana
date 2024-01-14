<?php

function insertTransaction($inv_id, $total_price, $discount, $net_amount, $deposit, $balance, $status){
	$sql="INSERT INTO transactions(inv_id, total_price, discount, net_amount, deposit, balance, status) 
	VALUES (
	".$inv_id.",
	".$total_price.",
	".$discount.",
	".$net_amount.",
	".$deposit.",
	".$balance.",
	".$status."
	)";
	executeSQL($sql);
}

function checkTransByInvId($inv_id){
	return getSingleValue("select inv_id from transactions where inv_id=".$inv_id."");
}

function updateTransaction($inv_id, $total_price,$discount,$net_amount, $deposit, $balance,$status){
	$sql="UPDATE transactions SET total_price=".$total_price.", 
	discount=".$discount.", 
	net_amount=".$net_amount.", 
	deposit=".$deposit.", 
	balance=".$balance.", 
	status=".cheSNull($status)." WHERE inv_id=".$inv_id."";
	executeSQL($sql);
}

function updateTransactionForInvPayment($inv_id, $balance,$deposit,$status){
	$sql="update transactions set deposit=".$deposit.", balance=".$balance.", status='".$status."' where inv_id=".$inv_id." ";
	executeSQL($sql);
}

function updateTransactionForMortagePayment($id, $balance,$deposit,$status){
	$sql="update mortages set deposit=".$deposit.", balance=".$balance.", status='".$status."' where m_id=".$id." ";
	executeSQL($sql);
}

function updateTransactionForMortageInterest($id, $balance,$status){
	$sql="update mortages set  balance=".$balance.", status='".$status."' where m_id=".$id." ";
	executeSQL($sql);
}





function getMemberTransactions($member_id){
	$data=null;
	$data=$data."
	<table class='footable' width='60%' style='margin-top:40px;'>
		<thead>			
			<tr>			
				<th>Member ID</th>
				<th>Membe Name</th>
				<th>Paid Date</th>								
			</tr>
		</thead>
		<tbody>";
	
	$rows=getFetchArray("select m.*,t.trans_id, t.paid_date,(select cname from customer where cust_id=m.cust_id)cname from member_transactions t, members m where t.member_id=".$member_id." and t.member_id=m.member_id");
	if(count($rows)==0){return "No Payment received";}
	foreach ($rows as $result){
		$trans_id=$result['trans_id'];
		$paid_date=$result['paid_date'];
		$cname=$result['cname'];
		
		$data=$data."<tr>			
			<td><a href='member.php?member_id=".$member_id."'>SAJ-".$member_id."</a></td>			
			<td><a href='member.php?member_id=".$member_id."'>".$cname."</a>"."</td>
			<td>".$paid_date."</td>						
		</tr>";		
	}
	$data=$data."</tbody></table>";
	return $data;
}


function updateMortageForTransaction($mor_id, $total_price,$per_interest, $extra_amount, $net_amount,$deposit, $balance, $status){
	$sql="UPDATE mortages SET 
	total_price=".$total_price.", per_interest=".$per_interest.", interest_amount=".$extra_amount.", loan_amount=".$net_amount.", 
	deposit=".$deposit.", balance=".$balance.", mdate=now(), status=".$status."  
	WHERE m_id=".$mor_id;
	executeSQL($sql);
	return $mor_id;
}