<?php


function insertMortageTransaction($mor_id, $action, $comments, $amount){
	$sql="INSERT INTO mortage_transactions(trans_id, m_id, action, mdate, comments, final_amount) 
	VALUES (null,".$mor_id.",".$action." ,now(),$comments, ".$amount.")";
	executeSQL($sql);
	return getSingleValue("select max(trans_id) from mortage_transactions");
}


function addMortageInterestByAuto($mor_id, $newBalance, $amount){
	addMortageInterest($mor_id, $newBalance, $amount);
}

function addMortageInterest($mor_id, $newBalance, $amount){
	insertMortageTransaction($mor_id, cheSNull(MORTAGE_ACTION_ADD_INTEREST), cheSNull($newBalance), cheNull($amount));	
	updateTransactionForMortageInterest($mor_id, $newBalance, STATUS_UNPAID_VALUE);
}

function subMortageInterest($mor_id){
	$rows=getFetchArray("SELECT interest_amount, balance, loan_amount FROM mortages WHERE balance > 0 and m_id=".$mor_id." ");
	if(count($rows)>0){
		foreach ($rows as $row){
			$loan_amount=$row['loan_amount'];
			$balance = $row['balance'];
			if($balance > $loan_amount ){				
				$interest_amount = $row['interest_amount'];
				$newBalance = $balance - $interest_amount;
				insertMortageTransaction($mor_id, cheSNull(MORTAGE_ACTION_SUB_INTEREST), cheSNull($newBalance), cheNull($newBalance));
				updateTransactionForMortageInterest($mor_id, $newBalance, STATUS_UNPAID_VALUE);
			}				
		}
	}
}

function getMortageTransactionDetails($mor_id){
	$data="<table style='margin-left:25%;'><thead><tr>
	<th>S.No</th><th>Loan</th><th>Interest</th><th>Amount</th>
	<th>Action</th><th>Date</th>
	</tr></thead><tbody>";
	$rows=getFetchArray("select 
	m.m_id,m.cust_id,m.total_price,m.per_interest,m.interest_amount,m.loan_amount,m.deposit,
	m.balance,m.mdate,m.status,t.trans_id,t.action,t.mdate,t.comments, t.final_amount 
	
	from mortage_transactions t, mortages m where t.m_id=".$mor_id." and t.m_id=m.m_id");
	$rowCount=0;
	if(count($rows)>0){
		foreach ($rows as $row){
			$rowCount++;
			$data=$data."<tr>";
			$trans_id = $row['trans_id'];
			$action= $row['action'];
			$date=$row['mdate'];
			$data=$data."<td>".$rowCount."</td>
			<td>".$row['loan_amount']."</td>
			<td>".$row['interest_amount']."</td>
			<td>".$row['final_amount']."</td>
			<td>".$action."</td>
			<td>".$date."</td>";
			$data=$data."</tr>";
		}
	}
	$data=$data."</tbody></table>";
	return $data;		
}

