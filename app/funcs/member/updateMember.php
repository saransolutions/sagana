<?php

function payMemberMonthlyTerm($mid){
	$rows=getFetchArray("select 
	m.*,
	s.mpay 
	from members m, mschemes s where m.member_id = ".$mid."
	and s.scheme_id=m.scheme_id");
	if(count($rows) >0 ){
		foreach ($rows as $result){
			$mpay=$result['mpay'];
			$paidTerms=$result['paid_terms'];
			$totalAmount=$result['total_paid_amount'];
			$sql="update members set
	paid_terms=".($paidTerms+1).", 
	total_paid_amount=".($totalAmount+$mpay).",
	status='".STATUS_PAID_VALUE."' 
	where member_id=".$mid."";			
			executeSQL($sql);
			insertMemberTransaction($mid);
			return true;
			
		}
	}
}

function revertMemberMonthlyTerm($mid){
	$rows=getFetchArray("select 
	m.*,
	s.mpay 
	from members m, mschemes s where m.member_id = ".$mid."
	and s.scheme_id=m.scheme_id");
	if(count($rows) >0 ){
		foreach ($rows as $result){
			$mpay=$result['mpay'];
			$paidTerms=$result['paid_terms'];
			$totalAmount=$result['total_paid_amount'];
			$sql="update members set
	paid_terms=".($paidTerms-1).", 
	total_paid_amount=".($totalAmount-$mpay).",
	status='".STATUS_UNPAID_VALUE."' 
	where member_id=".$mid."";			
			executeSQL($sql);
			insertMemberTransaction($mid);
			return true;
			
		}
	}
}


function revertWinner($mid){
$sql="update members set 	
	status='".STATUS_UNPAID_VALUE."' 
	where member_id=".$mid."";			
	executeSQL($sql);
}

function markWinner($mid){
$sql="update members set 	
	status='".STATUS_MEMBER_WINNER."' 
	where member_id=".$mid."";			
	executeSQL($sql);
}


function deleteMemberById($mid){
	executeSQL("delete from member_transactions where member_id=".$mid."");
	executeSQL("delete from members where member_id=".$mid);
}