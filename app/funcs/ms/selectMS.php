<?php

function displayMainSchemes($sql, $key, $value, $user, $role){
	$errMsg=null;
	if (isset($_SESSION['error_msg'])){
		$errMsg= $_SESSION['error_msg'];
	}else{
		$_SESSION['error_msg']=null;
		unset($_SESSION['error_msg']);
	}	
	$page=null;
	$page = $page.returnMainPageTemplate($errMsg, null, $user,$role, BGC_FOR_MONTHLY_SCHEME).
	"<br><center><h2 style='background:#FFE0E0;border:1px solid #A2A2A8;'>Monthly Schemes</h2></center>".
	BOX_FOR_NEW_MONTHLY_SCHEME;
	if($key=='invoice'){
			if(is_numeric($value)){
				$sql=SQL_MAIN_INV_OV." and inv_id = ".$value;
				$page=$page.displayMainSchemeOV($sql);
			}else{
				$page=$page."<p style='font-family:verdana;font-size:12px;color:red;'>
					Invalid value <font style='color:#000;'>'".$value."'</font> for key Search By Date 
				</p>";			
			}		
		}else if($key=='date'){
			$sql=$sql." and mdate like '%".$value."%'";
			$page=$page.displayMainSchemeOV($sql);
		}
		else{
			$page=$page.displayMainSchemeOV($sql);
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

function displayMainSchemeOV($sql){
	$data=null;
	$rows=getFetchArray($sql." order by scheme_id desc");
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
				$data=$data."<a id='id1' href='ms.php?p=".$i."'>".$i."</a>";
			}
		}
		$data=$data."
		</font>
		</div>
	<table class='footable' width='100%' style='margin-top:0px;'>
		<thead>			
			<tr>				
				<th>Id</th>				
				<th>Scheme Name</th>
				<th>Start Date</th>
				<th>No of Terms</th>
				<th>Monthly Pay</th>
				<th>Members</th>
				<th>Status</th>
				<th>Price Amount</th>							
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
		$rows = getFetchArray($sql . " order by scheme_id desc limit " . $first . "," . $limit . "");
		foreach($rows as $result)
		{
			$scheme_id=$result['scheme_id'];
			$scheme_name=$result['scheme_name'];
			$start_date=$result['start_date'];
			$no_of_terms=$result['no_of_terms'];
			$mpay=$result['mpay'];
			$members=$result['members'];
			$status=$result['status'];
			$price_amount=$result['price_amount'];
				
				
			$data=$data."<tr>
			<td><a href='member.php?sid=".$scheme_id."'>".$scheme_id."</a></td>			
			<td><a href='member.php?sid=".$scheme_id."'>".$scheme_name."</a>"."</td>
			<td>".$start_date."</td>
			<td>".$no_of_terms."</td>
			<td>".$mpay."</td>
			<td>".$members."</td>
			<td>".$status."</td>
			<td>".$price_amount."</td>
			<td><a href='ms.php?edit_id=".$scheme_id."'>
					<img src='img/icon/edit.png' title='edit invoice' style='width:18px;height:18px;' />
				</a>&nbsp;&nbsp;";
			if($_SESSION['role']=='admin'){
				$data=$data."
				<a href='ms.php?d_scheme_id=".$scheme_id."' onclick=\"return confirm('Are you sure to delete this Monthly Scheme ?')\" >
					<img src='img/icon/delete.png' title='delete monthly scheme' style='width:15px;height:15px;' />
				</a>";	
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
				$data=$data."<a id='id1' href='ms.php?p=".$i."'>".$i."</a>";
			}
		}
	}else{
		return "<p style='font-family:verdana;font-size:12px;color:red;'>No rows found</p>";
	}
	return $data;
}




function displayMSchemeById($sid){	
	$flag=2;
	include_once 'includes/cons.php';
	include_once 'funcs/db/db.php';
	
	$data=null;
	$rows=getFetchArray(getMSChemesDetailsById($sid));
	foreach ($rows as $result)
	{
		$scheme_id=$result['scheme_id'];
		$scheme_name=$result['scheme_name'];
		$start_date=$result['start_date'];
		$no_of_terms=$result['no_of_terms'];
		$mpay=$result['mpay'];
		$members=$result['members'];
		$status=$result['status'];
		$price_amount=$result['price_amount'];
		
		$data=$data."<html lang='en-US'>".returnHTMLPartFormSingleInvoiceHead(MAIN_TITLE)."
<body>	
	<div id='container' style='width:70%;'>
		<li style='list-style:none;'>
				<ul id='navMovie'>
					<li><a href='ms.php'>Monthly Schemes</a></li>		
					<li><a href='index.php'>Invoices</a></li>
					<li><a href='index.php?allCust'>Customers</a></li>
				</ul>
			</li>
		<h2><center>Montly Scheme - ".$sid."</center></h2>		
			<p>
				<label for='route'>Scheme Name</label>
				<label for='route'>".$scheme_name."</label>
			</p>
			<p>
				<label for='route'>Start Date</label>
				<label for='route'>".$start_date."</label>
			</p>
			<p>
				<label for='route'>No of Terms</label>
				<label for='route'>".$no_of_terms."</label>
			</p>
			<p>
				<label for='route'>Monthly Payment</label>
				<label for='route'>".$mpay."</label>
			</p>
			<p>
				<label for='route'>No of Members Joined</label>
				<label for='route'>".$members."</label>
			</p>
			<p>
				<label for='route'>Price Amount</label>
				<label for='route'>".$price_amount."</label>
			</p>
			
			<p>
				<label for='route'>Status</label>
				<label for='route'>".$status."</label>
			</p>
			
			".getButtonsForMSchemes(1, $sid)."
	</div>
</body>
</html>";	
	}
	return $data;	
}

function getButtonsForMSchemes($flag, $sid){

	$toDelete="ms.php?d_id=".$sid."";
	$toExport="pdf.php?m_scheme_id=".$sid."";
	$toEdit="ms.php?edit_id=".$sid."";
	$toAddMember="ms.php?sid=".$sid."&add=mem";

	$buttonForDelete="<a href='".$toDelete."' onclick=\"return confirm('Are you sure to delete this Invoice ?')\" id='id11'>
						<img src='img/icon/delete.png' title='delete invoice' style='width:15px;height:15px;' /> Delete
					</a>";

	$buttonForExport="<a id='id11' href='".$toExport."' target='_blank'>
						<img src='img/icon/icon_pdf.png' title='export to pdf' style='width:15px;height:15px;' /> Export to PDF
					</a>";

	$buttonForEdit="<a id='id11' href='".$toEdit."'>
						<img src='img/icon/edit.png' title='edit invoice' style='width:15px;height:15px;' /> Edit Scheme
					</a>";
	
	$buttonForAddMember="<a id='id11' href='".$toAddMember."'>
						<img src='img/icon/icon_addNew.png' title='edit invoice' style='width:15px;height:15px;' /> Add Member
					</a>";
	
if($flag==1){
		return "
		<p style='margin-top:40px;'>						
			<li style='list-style:none;'>
				 ".$buttonForAddMember." | ".$buttonForExport." | ".$buttonForEdit." | <a id='id11' href='ms.php'>Monthly Schemes</a>
			</li>
		</p>";
}

}

