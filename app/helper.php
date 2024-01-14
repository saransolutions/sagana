<?php

constructCodeForSQLColumns();
function constructCodeForSQLColumns(){
	$columnLine ="member_id,paid_terms,total_paid_amount,cust_id,cname,street,city,zip,state,phone,mobile,email,jdate";
	$columns=explode(",", $columnLine);
	foreach ($columns as $column){		
		echo "$".$column."=$"."result['".$column."'];<br>";
	} 
}