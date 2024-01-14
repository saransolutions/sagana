<?php

define("NO_OF_TICKETS", "10");
define("NO_OF_INV_PER_PAGE", "50");
define("NO_OF_CUSTOMER_PER_PAGE", "50");

define("MAIN_TITLE", "Sagana Jewellery");

define("MAIN_LOGO_IMG", "logo.png");


/***
 * Constants for PDF generation
 */

define("GPDF_Title",MAIN_TITLE." - Invoice");
define("GPDF_Author",MAIN_TITLE." - Invoice");
define("GPDF_COMPANY_NAME",MAIN_TITLE);

define("HEAD_FOR_PDF", MAIN_TITLE);
define("HEAD_ADDRESS_LINE_1", "Zelgstrasse 1,3027 Bern");
define("HEAD_ADDRESS_LINE_2", "");
define("HEAD_ADDRESS_LINE_3", "");
define("HEAD_PHONE", " 031 534 80 99, 079 606 90 63");
define("HEAD_MOBILE", " ");
define("HEAD_WED_ADDRESS", "v.perinparajah@gmx.ch www.saganajewellery.com");
define("HEAD_LOGO", "");
define("HEAD_LOGO_STYLE", "float:right;");

define("FOOT_MSG", 'என்றும் உங்களுடன் - Sagana Jewellers');

function returnPDFHeader($inv_id){
	return '<htmlpageheader name="myheader">
<table width="100%"><tr>
<td style="float:left;width:60%;">
			<span style="float:left;font-size:14pt;">
				<img src="img/logo/'.MAIN_LOGO_IMG.'" style="border:none;float:left;height:8%;margin:0;padding:0"/>				
			</span>
			'.HEAD_ADDRESS_LINE_1.'<span>&#9742;</span>'.HEAD_PHONE.'<br />			
			email : '.HEAD_WED_ADDRESS.' Web: gkswiss-travels.ch		
		</td>
<td width="50%" style="text-align: right;">Invoice No.<br /><span style="font-weight: bold; font-size: 12pt;">'.$inv_id.'</span></td>
</tr></table>
<hr>
</htmlpageheader>';
};
function returnSQLToGetAllRecordsByUser($bid,$role){	if($role=='admin'){		return "select t1.* from (select 			r.*,			(select name from record_types where tid=r.sub_type)type, 			(select value from payment_method_list where key_id=p_method)p_m_name, 			(select username from bookies where bid=r.bid)user from records r)t1 where 1=1 ";	}else{		return "select r.*,(select username from bookies where bid=r.bid)user from records r where 1=1 and r.bid=".$bid;	}}
function getJqueryCalendarJSCall(){	$page=" <script>  $(function() {    $( '#datepicker' ).datepicker({      changeMonth: true,      changeYear: true    });  });  </script> ";		return $page;}function getVerticalNavMenu($role){	$page="		<div style='float:right;margin:5px;'>	<ul id='menu'>	<li><a href='records.php' name='reports'>Search</a>	<ul>		<li><a href='records.php?key=ex' name='reports'>All Expenditure</a></li>		<li><a href='records.php?key=in' name='reports'>All Income</a></li>		<li><a href='records.php?key=paid_by&value=UBS' name='reports'>Paid By UBS</a></li>		<li><a href='records.php?key=paid_by&value=Bargeld' name='reports'>Paid By Bargeld</a></li>		<li><a href='records.php?key=paid_by&value=Die Post' name='reports'>Paid By Die Post</a></li>	</ul>	</li>	  	<li><a href='records.php?dr' name='reports'>Reports</a></li>  	<li><a href='records.php' name='reports'>Export</a>	<ul>		<li><a href='records.php?tab=xport&key=ex' name='reports'>All Expenditure</a></li>		<li><a href='records.php?tab=xport&key=in' name='reports'>All Income</a></li>		<li><a href='records.php?tab=xport&key=paid_by&value=UBS' name='reports'>Paid By UBS</a></li>		<li><a href='records.php?tab=xport&key=paid_by&value=Bargeld' name='reports'>Paid By Bargeld</a></li>		<li><a href='records.php?tab=xport&key=paid_by&value=Die Post' name='reports'>Paid By Die Post</a></li>	</ul>	</li>  	</ul>	</div>";	if($role=='admin'){		return $page;	}else{		return null;	}}define("JQUERY_SCRIPT_CALL", "<link rel='stylesheet' href='//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css'>  <script src='//code.jquery.com/jquery-1.10.2.js'></script>  <script src='//code.jquery.com/ui/1.11.2/jquery-ui.js'></script>");function getVerticalMenuJSCall(){	$page=" <script>  $(function() {    $( '#menu' ).menu();  });  </script>  <style>  .ui-menu { width: 150px; }  </style>";	return $page;}function getJqueryCalendarForMonthJSCall(){	$page="<script type='text/javascript'>$(document).ready(function(){       $('.monthPicker').datepicker({        dateFormat: 'MM yy',        changeMonth: true,        changeYear: true,        showButtonPanel: true,        onClose: function(dateText, inst) {            var month = $('#ui-datepicker-div .ui-datepicker-month :selected').val();            var year = $('#ui-datepicker-div .ui-datepicker-year :selected').val();            $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));        }    });    $('.monthPicker').focus(function () {        $('.ui-datepicker-calendar').hide();        $('#ui-datepicker-div').position({            my: 'center top',            at: 'center bottom',            of: $(this)        });    });});</script>	";	return $page;}function getRecordReportSQLByDate($date){	$page="select * from ( select 	r.*,	(select name from record_types where tid=r.sub_type)type,	(select value from payment_method_list where key_id=p_method)p_m_name, 	(select username from bookies where bid=r.bid)user 	from records r where 1=1 and rdate like '%".$date."%')t2 where 1=1 order by rdate desc ";	return $page;}define("DIR_FILE_UPLOAD", "attach/bills/");

function returnPDFFooter($cancel_charge, $baggage){
	$data=null;
	$footer1='<htmlpagefooter name="myfooter">
	<div style="border-top: 1px solid #EEE;height:10%;width:100%;padding:3pt;font-size:9pt;line-height:200%;">
	<b>Attention</b> <br>	
	<ul>';
	
	$footer2='</ul>
	
	</div>
	<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 1mm; ">
		<p style="font-family:ind_ta_1_001;color:#000;">'.FOOT_MSG.'</p>
	</div>
</htmlpagefooter>';	
	$data=$data.$footer1;
	if(is_numeric($cancel_charge) && $cancel_charge > 0){
		$data=$data.'<li>Cancellation fees after ticket edition '.$cancel_charge.' CHF per person</li>';
	}else{
		$data=$data.'<li>Sold Jwells will not be return back for any reason</li>';
	}
	if(is_numeric($baggage) && $baggage > 0){
		$data=$data.'<li>Baggage '.$baggage.' Kg per person</li>';
	}
	$data=$data.$footer2;
	return $data;
}

/**
 * SQL for Select Box
 */
define("SQL_SELECT_ALL_ROUTES","select key_id, value from routes");
define("SQL_SELECT_ALL_AIRLINES","select key_id, value from airlines");

/**
 * Parameters for Invoice  
 */

define("PREFIX_MORTAGE_NR","MSJ-");
define("PREFIX_INV_NR","SJ-");
define("PREFIX_MEMBER_NR","SAJ-");
define("PREFIX_CUSTOMER_NR","CUST-");

define("PDF_HEAD_TEMPLATE","<head>
<style>
body {font-family: sans-serif;
    font-size: 10pt;
}

#custTable1 {
    border-collapse: separate;
    border-spacing: 0;
    min-width: 350px;
    border-top: 1px solid #bbb;
}
#custTable1 tr th,
#custTable1 tr td {
    border-right: 1px solid #bbb;
    border-bottom: 1px solid #bbb;
    padding: 5px;
}
#custTable1 tr th:first-child,
#custTable1 tr td:first-child {
    border-left: 1px solid #bbb;
}
#custTable1 tr th {
    background: #eee;
    border-top: 1px solid #bbb;
    text-align: left;
}

/* top-left border-radius */
#custTable1 tr:first-child th:first-child {
    border-top-left-radius: 6px;
}

/* top-right border-radius */
#custTable1 tr:first-child th:last-child {
    border-top-right-radius: 6px;
}

/* bottom-left border-radius */
#custTable1 tr:last-child td:first-child {
    border-bottom-left-radius: 6px;
}

/* bottom-right border-radius */
#custTable1 tr:last-child td:last-child {
    border-bottom-right-radius: 6px;
}

</style>
</head>");


define("PDF_HEAD_TEMPLATE_FOR_INVOICE", "<head>
<style>
body {font-family: sans-serif;
    font-size: 10pt;
}
p {    margin: 0pt;
}
td { vertical-align: top; }
.items td {
    border-left: 0.1mm solid #000000;
    border-right: 0.1mm solid #000000;
}
table thead td { background-color: #EEEEEE;
    text-align: center;
    border: 0.1mm solid #000000;
}
.items td.blanktotal {
    background-color: #FFFFFF;
    border: 0mm none #000000;
    border-top: 0.1mm solid #000000;
    border-right: 0.1mm solid #000000;
}
.items td.totals {
    text-align: right;
    border: 0.1mm solid #000000;
}
</style>
</head>");


/**
 * Navigation Menu
 */

	
	function returnNavigationMenuBasedOnUserRole($user, $role){
		$data1="<div id='navigation'>
    	<ul>		  
		  <li><a href='index.php'>Invoices</a> | </li>
		  <li><a href='ms.php'>Monthly Schemes</a> | </li>
		  <li><a href='mortage.php'>Mortage</a> | </li>
		  <li><a href='customer.php'>Customers</a></li> |
		  <li><a href='pc/sitebrowser/addProduct.php'>Product Catalog</a></li> | 		  		  <li><a href='records.php'>Records</a> </li> |		  		  <li><a href='recordTypes.php'>Record Types</a> </li> |		 
		  ";
		  $data2="
		  <li style='float:right;'><a href='index.php?logoff'>Logoff</a></li>
		  <li style='float:right;'>Welcome to <a href='#'>".$user." |</a> </li>
		</ul>  
	</div>";
		if($role == 'admin'){
			$data3=" <li><a href='index.php?reports'>Reports</a> </li> |		  	  		  
		  <li><a href='http://localhost/phpmyadmin' target='_blank'>Admin</a></li>";
			return $data1.$data3.$data2;
		}else{
			return $data1.$data2;
		}
		
	}

define("NAV_MENU_MAIN", "<li id='nav-tab-newInv'>
<a href='index.php'>Home</a> | 
<a href='customer.php'>Customers</a>
<!--| <a href='index.php?routes'>Routes</a>--> | 
<a href='index.php?reports'>Reports</a>
</li>");

/**
 * functions for returnConstants
 * */
function returnSQLForInvoiceMain($inv_id){
	return "select 
i.inv_id, 
i.bdate, 
i.tickets,
i.cust_id,
(select value from routes where key_id=p.origin) origin,
(select value from routes where key_id=p.destination) destination,  				
(select value from airlines where key_id=p.airlines) airlines, 				
p.description, 
(select value from baggageKgs where key_id=p.baggage)baggage,
(select cname from customer where cust_id=i.cust_id)cname,
(select street from customer where cust_id=i.cust_id)street, 
(select zip from customer where cust_id=i.cust_id)zip, 
(select city from customer where cust_id=i.cust_id)city, 
(select state from customer where cust_id=i.cust_id)state,
(select phone from customer where cust_id=i.cust_id)phone,
(select mobile from customer where cust_id=i.cust_id)mobile,
(select email from customer where cust_id=i.cust_id)email,
(select username from bookies where bid=i.bid)bookie,      
x.*,
p.product_id 
from invoices i, transactions x, products p
where i.inv_id=".$inv_id." and i.inv_id=x.inv_id 
and p.inv_id = i.inv_id";
}



function returnSQLForInvoiceByDate($date){
	return "select i.inv_id, i.mdate, (select cname from customer where cust_id=i.cust_id)cname, cust_id, 
t.total_price,t.discount, t.net_amount, t.deposit, t.balance, t.status 
 from invoices i, transactions t where t.inv_id=i.inv_id and 1=1 and mdate like '%".$date."%'";	
}

function returnSQLForInvoiceForReport($date){
	return "select i.inv_id, i.mdate, (select cname from customer where cust_id=i.cust_id)cname, cust_id, 
t.total_price,t.discount, t.net_amount, t.deposit, t.balance, t.status 
 from invoices i, transactions t where t.inv_id=i.inv_id and mdate like '%".$date."%' ";
}

//define("SQL_MAIN_INV_OV", "select i.inv_id,i.cust_id, i.price, i.tax, i.total, p.prefix, p.fname, p.lname, i.breference, i.bdate from invoices i, passengers p where i.inv_id=p.inv_id");
define("SQL_MAIN_INV_OV", "select t1.* from ( select i.inv_id, i.mdate, (select cname from customer where cust_id=i.cust_id)cname, cust_id, 
t.total_price,t.discount, t.net_amount, t.deposit, t.balance, t.status 
 from invoices i, transactions t where t.inv_id=i.inv_id and 1=1 )t1 where 1=1 ");

define("SQL_MAIN_MORTAGE_OV", "select 
m_id,cust_id,total_price,per_interest,interest_amount,loan_amount,deposit,balance,mdate,status,  
(select cname from customer where cust_id=m.cust_id)cname from mortages m where 1=1 ");

function returnInvoiceWithPassengerByInvId($inv_id){
	return "select i.inv_id,i.cust_id, i.price, i.tax, i.total, p.prefix, p.fname, p.lname, i.breference, i.bdate  from invoices i, passengers p where i.inv_id=".$inv_id." and i.inv_id=p.inv_id";
}

function getInvoiceDetailsByIdSQL($inv_id){
	return "select i.inv_id, i.mdate, (select cname from customer where cust_id=i.cust_id)cname, cust_id, 
t.total_price,t.discount, t.net_amount, t.deposit, t.balance, t.status 
 from invoices i, transactions t where t.inv_id=i.inv_id and i.inv_id=".$inv_id." ";
}

function getProductsDetailsByInvoiceIdSQL($inv_id){
	$sql="select 
order_id,
inv_id,
(select nm from tree_data where id=product_id)pro,
quantity,
unit_weight,
g_unit_price, 
unit_amount 
from orders where inv_id=".$inv_id."";
	return $sql;
}


function getProductsDetailsByMortageIdSQL($mor_id){
	$sql="select 
order_id,
inv_id,
(select nm from tree_data where id=product_id)pro,
quantity,
unit_weight,
g_unit_price, 
unit_amount 
from orders where m_id=".$mor_id."";
	return $sql;
}

function getMortageDetailsByIdSQL($mor_id){
	return "select  
	(select cname from customer where cust_id=i.cust_id)cname,
	 m_id,cust_id,total_price,per_interest,interest_amount,loan_amount,deposit,balance,mdate,status 
	from mortages i where  i.m_id=".$mor_id." ";
}

function getMonthlySchemeById($ms_id){
	return "select scheme_id,scheme_name,start_date,no_of_terms,mpay,members,status,price_amount from mschemes where scheme_id=".$ms_id." ";
}

function getMSChemesDetailsById($sid){
	return "select * from mschemes where scheme_id=".$sid." ";
}

function getPassengerDetailsByInvIdSQL($inv_id){
	return "select passenger_id, inv_id, fname, lname, prefix, etkt, price, tax, total, iata_price from passengers where inv_id=".$inv_id." order by passenger_id ";
}


function getMemberDetailsBySId($sid){
	return "
	select t1.* from (
	select 
	m.scheme_id,
	m.status,	
	(select mpay from mschemes where scheme_id=m.scheme_id)mpay,
	(select status from mschemes where scheme_id=m.scheme_id)scheme_status,    
	m.member_id,
	m.paid_terms,
	m.total_paid_amount,
	m.cust_id, 
	cname, 
	street, 
	city, 
	zip, 
	state, 
	phone, 
	mobile, 
	email, 
	jdate
	
	from members m, customer c 
	 where scheme_id=".$sid." and c.cust_id=m.cust_id)t1 where 1=1 ";
}

define("SQL_ALL_CUSTOMERS_OV", "select * from (
	select 
		cust_id, 
		cname, 
		street, 
		city, 
		zip, 
		phone, 
		mobile, 
		email, 
		jdate			 
		
		from (
			select 
				c.* 
				from customer c 
			)t2		
)total where 1=1 
"); 

function returnSQLToDisplaySingleCustomer($cust_id){ 
	return "select * from (
	select 
		t1 inv_id, 
		t3 no_of_invs, 
		cust_id, 
		cname, 
		street, 
		city, 
		zip, 
		state, 
		phone, 
		mobile, 
		email, 
		jdate				
		from (
			select 
				(select max(inv_id) from invoices where cust_id=c.cust_id)t1, 
				(select count(inv_id) from invoices where cust_id=c.cust_id)t3, 
				c.* 
				from customer c 
			)t2 
		where coalesce(t1, 0)!=0 
)total where cust_id = ".$cust_id." 

";
} 

define("BOX_FOR_NEW_INVOICE", "<table class='footable'>
      	<thead>			
			<tr>				
				<th>
				<form action='index.php' method='post'>
					<a href='invoice.php?add'><img src='img/icon/icon_addNew.png' style='border:none;' />&nbsp;New Invoice</a>
					<select name='searchBy' style='margin-left:59%;font-family:verdana;font-size:12px;'>
						<option value='inv_id'>Id</option>						
						<option value='cname'>Customer</option>
						<option value='status'>Status</option>												
					</select>
					<input type='text' name='searchValue' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />
					<input type='submit' name='search' value='Go' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />
				</form>
				</th>					
			</tr>
		</thead>
	</table>");


define("BOX_FOR_NEW_MORTAGE", "<table class='footable'>
      	<thead>			
			<tr>				
				<th>
				<form action='mortage.php' method='post'>
					<a href='mortage.php?add'><img src='img/icon/icon_addNew.png' style='border:none;' />&nbsp;New Mortage</a>
					<select name='searchBy' style='margin-left:59%;font-family:verdana;font-size:12px;'>
						<option value='inv_id'>Id</option>						
						<option value='cname'>Customer</option>
						<option value='status'>Status</option>												
					</select>
					<input type='text' name='searchValue' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />
					<input type='submit' name='search' value='Go' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />
				</form>
				</th>					
			</tr>
		</thead>
	</table>");



define("BOX_FOR_NEW_CUSTOMER", "<table class='footable'>
      	<thead>			
			<tr>				
				<th>
				<form action='customer.php' method='post'>
					<a href='customer.php?addCustomerForm'><img src='img/icon/icon_addNew.png' style='border:none;' />&nbsp;New Customer</a>
					<select name='searchBy' style='margin-left:57%;font-family:verdana;font-size:12px;'>										
						<option value='cname'>Customer</option>						
						<option value='city'>City</option>
						<option value='mobile'>Mobile</option>																							
					</select>
					<input type='text' name='searchValue' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />
					<input type='submit' name='search' value='Go' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />
				</form>
				</th>					
			</tr>
		</thead>
	</table>");


define("BOX_FOR_NEW_MONTHLY_SCHEME", "<table class='footable'>
      	<thead>			
			<tr>				
				<th>
				<a href='ms.php?add=mscheme'><img src='img/icon/icon_addNew.png' style='border:none;' />&nbsp;New Monthly Schme</a>
				
				</th>					
			</tr>
		</thead>
	</table>");

function getSimpleNavigationMenu(){
return 
"<li style='list-style:none;'>
	<ul id='navMovie'>
		<li><a href='index.php'>Invoices</a></li>
		<li><a href='mortage.php'>Mortage</a></li>
		<li><a href='ms.php'>Monthly Schemes</a></li>		
		<li><a href='customer.php'>Customers</a></li>			    <li><a href='records.php'>Records</a></li>	    		<li><a href='recordTypes.php'>Record Types</a></li>		         <li><a href='index.php?reports'>Reports</a></li>
	</ul>
</li>";
}

/*
define("BOX_FOR_NEW_MONTHLY_MEMBER", "<table class='footable'>
      	<thead>			
			<tr>				
				<th>
				<form action='ms.php' method='post'>
					<a href='ms.php?add=mem'><img src='img/icon/icon_addNew.png' style='border:none;' />&nbsp;New Member</a>
					<select name='searchBy' style='margin-left:56%;font-family:verdana;font-size:12px;'>
						<option value='id'>Member Id</option>
						<option value='mname'>Member Name</option>
					</select>
					<input type='text' name='searchValue' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />
					<input type='submit' name='search' value='Go' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />
				</form>
				</th>					
			</tr>
		</thead>
	</table>");
*/
function returnBoxForMonthlyMember($sid){
	return "<table class='footable'>
      	<thead>			
			<tr>				
				<th>
				<form action='member.php' method='post'>
					<a href='member.php?add=mem&sid=".$sid."'><img src='img/icon/icon_addNew.png' style='border:none;' />&nbsp;New Member</a> 
					<a href='ms.php?setDate=".$sid."'><img src='img/icon/clock.png' style='border:none;' />&nbsp;Set Date</a>
					<select name='searchBy' style='margin-left:46%;font-family:verdana;font-size:12px;'>
						<option value='id'>Member Id</option>
						<option value='mname'>Member Name</option>
						<option value='status'>Member Status</option>
					</select>
					<input type='hidden' name='searchSID' value='".$sid."' />
					<input type='text' name='searchValue' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />
					<input type='submit' name='search' value='Go' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />
				</form>
				</th>					
			</tr>
		</thead>
	</table>";
}



define("BOX_FOR_CUSTOMER_TAB", "<h2>
	  	Customers
	  </h2>");

define("BOX_FOR_SEARCH_FILTER", "<table class='inMTH1'>
      	<thead>			
			<tr>							
				<th>
				<form action='customer.php' method='post'>					
					<select name='searchBy' style='font-family:verdana;font-size:12px;'>						
						<option value='cname'>Customer Name</option>
						<option value='invoice'>Invoice Id </option>
					</select>
					<input type='text' name='searchValue' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />
					<input type='submit' name='searchCust' value='Go' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />
				</form>	
				</th>				
			</tr>
		</thead>
	</table>");


function returnMainPageTemplate($insideBody, $insideHead, $user, $role, $bgcColorForPage){
	return "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<title>".MAIN_TITLE."</title>
<meta http-equiv='content-type' content='text/html; charset=iso-8859-1'/>
<link href='css/base.css' rel='stylesheet' type='text/css'/>
<link href='css/footable-0.1.css' rel='stylesheet' type='text/css'/>  
<style>
	#errMsg{
		color:red;font-size:12px;font-family:courier;
	}
	#id1{
		font-family:verdana;font-size:12px;padding-left:2px;
	}
	#id1:hover{
		font-family:verdana;font-size:12px;padding:2px;color:#000;background:yellow;
	}
</style>
".$insideHead."	 
</head>
<body>

<div id='container' style='background:".$bgcColorForPage."'>
".$insideBody."
  <a href='index.php'>
  	<img src='img/logo/".MAIN_LOGO_IMG."' style='float:left;border:none;'/>
  </a>	
  <div id='header'>     
     <a href='index.php'><h1>".MAIN_TITLE."</h1></a>
      <a href='index.php'><h2>Invoice System</h2>   </a>   
  </div>
  	".returnNavigationMenuBasedOnUserRole($user, $role)."
<div id='easy'>
	";
}


/**
 * HTML Footer
 */

define("HTML_FOOTER_MSG", '<font style="font-size:11px;">'.MAIN_TITLE.'</font>.');
define("HTML_FOOT_LINE", "<div id='footer'><a href='index.php'>".HTML_FOOTER_MSG."</a> </div>");


/**
 * HTML part for form display for single invoice.
 * used in the page - singleInvoice.php
 *   
*/

function returnHTMLPartFormSingleInvoiceHead($title){
	return "<head>
  <meta charset='UTF-8'>
	<title>".$title."</title>	
	<link rel='stylesheet' href='css/chosen.css'>	
	<link rel='stylesheet' href='css/style.css'>
	<script type='text/javascript'>
		$(function()
		{
			$('form').form();
		});
	</script>	
	<style>
		#errMsg{
			color:red;font-size:12px;font-family:courier;
		}
		#nav-tab-newInv{
			list-style:none;margin-bottom:10px;padding:5px;
		}
		#nav-tab-newInv a{
			color:#000;
			text-decoration:none;
		}
		#nav-tab-newInv a:hover{
			color:#000;
			font-weight:bold;
			text-decoration:underline;
		}
		table { margin: 1em 1em 3em 3em; border-collapse: collapse; }
		td, th { padding: 0.9em 0.9em 0.9em .9em; border: 1px #ccc solid; }
		thead {  }
		tbody { }
		
		/* Style for a href for buttons */
		#id11{
			font-family:verdana;font-size:12px;padding:5px;font-weight:bold;text-decoration:none;
		}
		#id11:hover{
			font-family:verdana;font-size:12px;padding:5px;font-weight:bold;text-decoration:none;background:black;color:yellow;
		}		
	#navMovie{
			border:1px solid #ccc;
			border-width:1px 0;
			list-style:none;
			margin-top:1px;
			margin-bottom:5px;
			padding:0;
			text-align:center;
		}
		#navMovie li{
			position:relative;
			display:inline;
		}
		#navMovie a{
			display:inline-block;
			padding:10px;
			color:#c00;
			text-decoration:none;
			font-weight:bold;
		}
		#navMovie ul{
			position:absolute;
			/*top:100%; Uncommenting this makes the dropdowns work in IE7 but looks a little worse in all other browsers. Your call. */
			left:-9999px;
			margin:0;
			padding:0;
			text-align:left;
		}
		#navMovie ul li{
			display:block;
		}
		#navMovie li:hover ul{
			left:0;
		}
		#navMovie li:hover a{
			text-decoration:underline;
			background:#f1f1f1;
		}
		#navMovie li:hover ul a{
			text-decoration:none;
			background:none;
		}
		#navMovie li:hover ul a:hover{
			text-decoration:underline;
			background:#f1f1f1;
		}
		#navMovie ul a{
			white-space:nowrap;
			display:block;
			border-bottom:1px solid #ccc;
		}		
	</style>
	";
}

function returnHTMLHead($title, $insideHead){
	return "<head>
  <meta charset='UTF-8'>
	<title>".$title."</title>	
	<link rel='stylesheet' href='css/chosen.css'>	
	<link rel='stylesheet' href='css/style.css'>
	<script type='text/javascript'>
		$(function()
		{
			$('form').form();
		});
	</script>	
	".$insideHead."
	";
}




define("INVOICE_PAGE_TITLE_FOR_NEW_INVOICE", "New Invoice");
define("INVOICE_FORM_TITLE_FOR_NEW_INVOICE", "New Invoice");

define("INVOICE_FORM_TITLE_FOR_NEW_MORTAGE", "New Mortage");
define("INVOICE_FORM_TITLE_FOR_NEW_MONTHLY_SCHEME", "New Monthly Scheme");
define("INVOICE_FORM_TITLE_FOR_NEW_MEMBER", "New Member");


define("STATUS_COMPLETED_VALUE", "COMPLETED");
define("STATUS_PAID_VALUE", "PAID");
define("STATUS_UNPAID_VALUE", "UNPAID");
define("STATUS_ORDERED_VALUE", "ORDERED");
define("STATUS_DELIVERED_VALUE", "DELIVERED");

define("STATUS_MEMBER_JOINED", "JOINED");
define("STATUS_MEMBER_WINNER", "WINNER");
define("STATUS_MEMBER_CLOSED", "CLOSED");
define("STATUS_MEMBER_STARTED", "STARTED");
define("STATUS_MEMBER_RUNNING", "RUNNING");


define("BGC_FOR_MEMBER", "");
define("BGC_FOR_CUSTOMER", "#FFE8FF");
define("BGC_FOR_INVOICE", "#FFFFE0");
define("BGC_FOR_MONTHLY_SCHEME", "#F3FFE7");
define("BGC_FOR_MORTAGE", "#EEEEFF");


define("PDF_FOOTER_SARAN_SOLUTIONS", '<div><p style="margin-left:75%;font-size: 8pt;">Developed By <font style="font-style:italic;text-decoration: underline;">www.saransolutions.in</font></p></div>');
define("PDF_FOOTER_SARAN_SOLUTIONS_MINI", '<div><p style="margin-left:32%;font-size: 8pt;">Developed By <font style="font-style:italic;text-decoration: underline;">www.saransolutions.in</font></p></div>');


define("MORTAGE_ACTION_ADD_FIRST_TIME", "FIRST_TIME");
define("MORTAGE_ACTION_ADD_INTEREST", "ADD-INTEREST");
define("MORTAGE_ACTION_SUB_INTEREST", "SUB-INTEREST");

define("MORTAGE_COMMENTS_ADD_INTEREST", "ADDED_AUTO");


define("BOX_FOR_NEW_RECORD_TYPE", "<table class='footable'>      	<thead>						<tr>								<th>				<form action='recordTypes.php' method='post'>					<a href='recordTypes.php?action=add'><img src='img/icon/icon_addNew.png' style='border:none;' />&nbsp;New Record Type</a>					<select name='searchBy' style='margin-left:57%;font-family:verdana;font-size:12px;'>																<option value='name'>Name</option>																		</select>					<input type='text' name='searchValue' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />					<input type='submit' name='search' value='Go' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />				</form>				</th>								</tr>		</thead>	</table>");define("PREFIX_RECORD_TYPE_NR","RTYPE-");/* * cpoy from gk-swiss */define("SQL_ALL_RECORD_TYPES", "select * from record_types where 1=1");define("NO_OF_RECORD_TYPE_PER_PAGE", "50");define("BOX_FOR_NEW_RECORD", "<table class='footable'>      	<thead>						<tr>								<th>								<form action='records.php' method='post'>				<a href='records.php?addExRecordForm'><img src='img/icon/icon_addNew.png' style='border:none;' />&nbsp;New Ausgaben </a>				&nbsp;&nbsp;&nbsp;<a href='records.php?addInRecordForm'><img src='img/icon/icon_addNew.png' style='border:none;' />&nbsp;New Einkommen </a>										<select name='searchBy' style='margin-left:43%;font-family:verdana;font-size:12px;'>																<option value='paid_to'>Party</option>						<option value='paid_by'>Paid by</option>						<option value='amount'>Amount</option>						<option value='name'>Name</option>					</select>					<input type='text' name='searchValue' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />					<input type='submit' name='search' value='Go' style='margin:0px;padding:1px;font-family:verdana;font-size:11px;' />				</form>				</th>			</tr>		</thead>	</table>");define("NO_OF_PRODUCT_PER_PAGE", "50");define("PREFIX_PRODUCT_NR","PROD-");define("PREFIX_RECORD_NR","RE-");define("EXPEND", "Expenditure");define("INCOME", "Income");