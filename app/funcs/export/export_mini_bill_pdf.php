<?php

function miniBillContentHeader(){
	return '<htmlpageheader name="myheader">
<div style="margin-left:2%;padding-left:2%;">
<!--<img src="img/logo/'.MAIN_LOGO_IMG.'" style="border:none;float:left;height:8%;"/>-->
	<span style="float:left;font-size:1.6em;">'.MAIN_TITLE.'</span>
	
	<br /><span style="font-size:0.9em;">'.HEAD_ADDRESS_LINE_1.'</span><br />			
	<span style="font-size:0.9em;">&#9742;'.HEAD_PHONE.'</span><br />			
	<span style="font-size:0.9em;">'.HEAD_WED_ADDRESS.'</span>
</div>
<hr>
</htmlpageheader>';
}

function miniBillContentFooter(){
	return '<htmlpagefooter name="myfooter">
<p style="margin-left:12%;font-family:ind_ta_1_001;color:#000;">Danke நன்றி !!!  மீண்டும் வருக !!!</p>
'.PDF_FOOTER_SARAN_SOLUTIONS_MINI.'	
</htmlpagefooter>';
}


function miniBillMainContent($member_id){
	return '<div style="margin-top:12%;margin-left:1%;margin-right:1%;">
<p style="margin-left:15%;">verkaufen / Kaufen / Reparatur</p>
'.miniBillMemberDetailsTable($member_id).'
</div>';
}


function miniBillMemberDetailsTable($member_id){
	
	$sql="select m.member_id,m.scheme_id,m.cust_id,m.paid_terms,m.total_paid_amount,m.status,scheme_name,start_date,no_of_terms,mpay,members,price_amount,cname,street,city,zip,state,phone,mobile,email,jdate from members m, mschemes s, customer c where m.member_id=".$member_id." and m.scheme_id=s.scheme_id and m.cust_id=c.cust_id";
	$rows=getFetchArray($sql);
	$data=null;
	foreach ($rows as $result){
	$tableStyle='style="width:100%;border-left:0.1mm solid #BFBFBC;"';
	$data= '<table id="custTable1" '.$tableStyle.'>';	
	$data=$data.'
<tr><td colspan="2">Member Details</td></tr>
<tr>
	<td>ID</td>
	<td>'.PREFIX_MEMBER_NR.$member_id.'</td>
</tr>
<tr>
	<td>Name</td>
	<td>'.$result['cname'].'</td>
</tr>
<tr>
	<td>Address</td>
	<td>'.returnAddressRow($result['street'], $result['zip'].",".$result['city'], $result['state']).'
	</td>
</tr>';
		
$data=$data.'
</table>
<br>
<table id="custTable1" style="width:100%;border-left:0.1mm solid #BFBFBC;">
<tr><td style="width:50%;">Monthly Amount</td><td style="width:50%;">'.$result['mpay'].' CHF</td></tr>
<tr><td style="width:50%;">Status</td><td style="width:50%;">'.$result['status'].'</td></tr>
';	
		if(!($result['status']=='Joined') ){
			$data=$data.'<tr><td style="width:50%;">Paid Terms</td><td style="width:50%;">'.$result['paid_terms'].'</td></tr>
<tr><td style="width:50%;">Total Amount Paid</td><td style="width:50%;">'.$result['total_paid_amount'].' CHF</td></tr>
';
		}
		$data=$data.'</table>';
		
	}
	return $data;
	
}

function returnAddressRow($add1,$add2,$add3){
	$data=null;
	if(!is_null($add1)){
		$data=$data.$add1;
	}
	if (!is_null($add2)){
		$data=$data.'<br>'.$add2;
	}if (!is_null($add3)){
		$data=$data.'<br>'.$add3;
	}
	return $data;

}