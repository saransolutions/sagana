<?php

function displayFormToEditMS($ms_id, $errMsg, $role){
	$flag=7;
	$content=null;
	$insideHead=null;
	$data=null;
	$rows=getFetchArray(getMonthlySchemeById($ms_id));
	if(count($rows)==0){return;}	
	foreach ($rows as $result)
	{

		$content="
<form method='POST' action='ms.php' name='editMS'>
Scheme Details
<input type='hidden' name='uscheme_id' value=".$ms_id." />
<p><label>Scheme Name</label><label><input style='height:1px;width:80px;' type='text' name='scheme_name'  value='".$result['scheme_name']."' /></label></p>
<p><label>Start Date</label><label><input style='height:1px;width:80px;' type='text' name='start_date'  value='".$result['start_date']."' /></label></p>
<p><label>No of Terms</label><label><input style='height:1px;width:80px;' type='text' name='no_of_terms'  value='".$result['no_of_terms']."' /></label></p>
<p><label>Montly Payment</label><label><input style='height:1px;width:80px;' type='text' name='mapy'  value='".$result['mpay']."' /></label></p>
<p><label>Price Amount</label><label><input style='height:1px;width:80px;' type='text' name='price_amount'  value='".$result['price_amount']."' /></label></p>
<p><label>Scheme Status</label>
	<select name='scheme_status'>
		<option value='--'></option>
		<option value='".STATUS_MEMBER_STARTED."'>".STATUS_MEMBER_STARTED."</option>
		<option value='".STATUS_MEMBER_RUNNING."'>".STATUS_MEMBER_RUNNING."</option>
		<option value='".STATUS_MEMBER_CLOSED."'>".STATUS_MEMBER_CLOSED."</option>
	</select>				
</p>
".getSubmitButton($flag, $ms_îd, $role, $cust_id)."</form>";
		
	}
	$heading="Edit Scheme - ".PREFIX_INV_NR.$ms_id;
	$data=getHTMLPage(MAIN_TITLE,$heading,$content, $insideHead);
	return $data;
}

function validateMSchemeFields(){
	$sql="UPDATE mschemes SET scheme_name=".cheSNull($_POST['scheme_name']).",
	start_date=".cheSNull($_POST['start_date']).",
	no_of_terms=".cheNull($_POST['no_of_terms']).",
	mpay=".cheNull($_POST['mapy']).",
	status=".cheSNull($_POST['scheme_status']).",
	price_amount=".cheNull($_POST['price_amount'])." WHERE scheme_id=".$_POST['uscheme_id']."";
	executeSQL($sql);
}

function updateMSchemesForNewMember($ms_id){
	$totalMembers = getSingleValue("select members from mschemes where scheme_id=".$ms_id."");
	$sql="update mschemes set members=".($totalMembers+1)." where scheme_id=".$ms_id." ";
	executeSQL($sql);
}
