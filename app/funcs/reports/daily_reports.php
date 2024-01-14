<?php

ob_start();
if (version_compare(phpversion(), '5.3.0', '>=') == 1)
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
error_reporting(E_ALL & ~E_NOTICE);
session_start();
//http://mpdf1.com/ - for PDF generation
if(!isset($_SESSION['user'])){
	header("Location: login/login.php");
}else if(!isset($_SESSION['role'])){
	$_SESSION['error_msg']="<p style='font-family:verdana;font-size:12px;color:red;'><b>Invalid role to view reports</b></p>";
	header("Location: index.php");
}

function displayReports($user, $role){
	require_once 'includes/cons.php';
	$page=null;
	$insideHead="
<link rel='stylesheet' href='//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css'>
<script src='//code.jquery.com/jquery-1.10.2.js'></script>
<script src='//code.jquery.com/ui/1.11.0/jquery-ui.js'></script>
<style>
	#errMsg{
		color:red;font-size:12px;font-family:courier;
	}
	
	/***FIRST STYLE THE BUTTON***/
input#gobutton{
cursor:pointer; /*forces the cursor to change to a hand when the button is hovered*/
padding:5px 25px; /*add some padding to the inside of the button*/
background:#35b128; /*the colour of the button*/
border:1px solid #33842a; /*required or the default border for the browser will appear*/
/*give the button curved corners, alter the size as required*/
-moz-border-radius: 10px;
-webkit-border-radius: 10px;
border-radius: 10px;
/*give the button a drop shadow*/
-webkit-box-shadow: 0 0 4px rgba(0,0,0, .75);
-moz-box-shadow: 0 0 4px rgba(0,0,0, .75);
box-shadow: 0 0 4px rgba(0,0,0, .75);
/*style the text*/
color:#f3f3f3;
font-size:1.1em;
}
/***NOW STYLE THE BUTTON'S HOVER AND FOCUS STATES***/
input#gobutton:hover, input#gobutton:focus{
background-color :#399630; /*make the background a little darker*/
/*reduce the drop shadow size to give a pushed button effect*/
-webkit-box-shadow: 0 0 1px rgba(0,0,0, .75);
-moz-box-shadow: 0 0 1px rgba(0,0,0, .75);
box-shadow: 0 0 1px rgba(0,0,0, .75);
}

#reportHeading{
            font-family:'Trebuchet MS',sans-serif;
            font-size:24px;
            font-style:normal;            
            margin:10px;
            padding:0px 0px;
            clear:both;
            float:left;
            width:100%;
            color:#000;
        }	
	
</style>


<script type='text/javascript'>
$(document).ready(function()
{   
    $('.monthPicker').datepicker({
        dateFormat: 'MM yy',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,

        onClose: function(dateText, inst) {
            var month = $('#ui-datepicker-div .ui-datepicker-month :selected').val();
            var year = $('#ui-datepicker-div .ui-datepicker-year :selected').val();
            $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
        }
    });

    $('.monthPicker').focus(function () {
        $('.ui-datepicker-calendar').hide();
        $('#ui-datepicker-div').position({
            my: 'center top',
            at: 'center bottom',
            of: $(this)
        });
    });
});
</script>

 <script>
  $(function() {
    $( '#datepicker' ).datepicker();
  });   
  </script>

	";
	
	$page= returnMainPageTemplate(null, $insideHead, $user, $role, "#FFF")."
<div id='easy'>
	<!-- div for report form -->
	<div style='background:#EEE;padding:1px;border:1px solid #FFF;border-radius:15px;margin:5px;'>
		<table style='border:collapse;' >
			<tr>
				<td style='padding:10px;'>
			<form method='post' action='index.php'>
				<h1 id='reportHeading'>Daily Reports</h1>	           
     			<p style='padding-left:10px;'>Date : <input type='text' name='rdate' id='datepicker'>
     				<input id='gobutton' name='reportDSubmit' type='submit' value='Go!' />
     			</p>
     		</form>
     		</td>
     		<td style='padding-left:95px;'>
     		</td>
     		<td style='padding-left:10px;'>
			<form method='post' action='index.php'>
				<h1 id='reportHeading'>Monthly Reports</h1>	           
     			<p>Date : <input type='text' name='rmonth' id='month' class='monthPicker'>
     				<input id='gobutton' name='reportDSubmit' type='submit' value='Go!' />
     			</p>
     		</form>
     		</td>
     	</tr>
     </table>
     </div>
     <!-- end of div for report form -->
     </div>
     <!-- end of div for easy -->
     </div>
     <!-- end of div for container -->
     </body></html>
		";
	
	
	
	$navTab="<ul id='navMovie'>
				<li><a href='index.php'>Invoices</a></li>		
				<li><a href='customer.php'>Customers</a></li>
				<li><a href='index.php?reports'>Reports</a></li>
			</ul>";
	
	$reportBody="
	<body>
		<center>
			<div id='mainDiv' style=''>		
				<div id='divTable' style='width:95%;margin:10px;'>";
	
	
	
	
	if(isset($_POST['rdate'])){
		$date=$_POST['rdate'];
		$date = date('Y-m-d', strtotime($date));
		require_once 'funcs/db/db.php';
		$data=null;
		$fullSQL=returnSQLForInvoiceForReport($date)." order by i.inv_id desc ";
		$query = selectSQL($fullSQL);
		$rowCounts = mysqli_num_rows($query);
		$rowCount=0;
		if($rowCounts!=0){
			$data=$reportBody.$navTab;
			$data=$data.reportRows($date, "Daily");
			return displayPageForReportContent($data);
			//$data=displayReportContent($rowCounts, $query,"Daily", $date);
		}else{
			return $page."
			<div><font style='color:red;font-size:18px;font-family:Trebuchet MS;'>No Data Found</font></div>
	</div>
</center>
</body>
</html>";
		}
		return $data;
	}else if(isset($_POST['rmonth'])){
		
		$date=$_POST['rmonth'];
		$date = date('Y-m', strtotime($date));
		require_once 'funcs/db/db.php';
		$data=null;
		$fullSQL=returnSQLForInvoiceByDate($date)." order by i.inv_id desc ";
		$query = selectSQL($fullSQL);
		$rowCounts = mysqli_num_rows($query);
		$rowCount=0;
		if($rowCounts!=0){
			//$data=displayReportContent($rowCounts, $query, "Monthly", $_POST['rmonth']);
			$data=$reportBody.$navTab;
			$data=$data.reportRows($date, "Monthly");
			return displayPageForReportContent($data);
		}else{
			return $page."
			<div><font style='color:red;font-size:18px;font-family:Trebuchet MS;'>No Data Found</font></div>
	</div>
</center>
</body>
</html>";
		}
		return $data;	
	}
	return $page;

}

function getReportFileName($date,$type){
	$reportNameFile=null;
	if($type=="Monthly"){
		$dateForDisplay=date('F Y', strtotime($date));			
	}else{
		$dateForDisplay=date('d-m-Y', strtotime($date));		
	}
	return $reportFileName=$type." Report - ".$dateForDisplay;
}



function displayReportContent($rowCounts, $query, $type, $date){

	$data=null;	
	$reportSummary=reportSummary($query, $type, $date);
	$reportRows=null;
	$reportRows=reportRows($type, $date);	
	$data=$data.$reportSummary.$reportHeading.$reportRows."
		</tbody>			
		</table>
	</div>
	";	
	return displayPageForReportContent($data);
}

function reportSummary($query, $type, $date){
	
	$inv_id=null;$total_price=0;$total_iata=0;$gain=0;
	while($result = mysqli_fetch_array($query))
	{
		$inv_id= $result['inv_id'];				
		$totalTxns++;
	}
	
	$content = "<!-- summary tab for report -->
	<h1 id='reportHeading'>".$type." Report</h1>
	<div style='width:90%;border:2px solid green;border-radius:15px;padding:3px;margin-top:15px;margin-bottom:15px;'>
		<table class='table1'>
        	<thead>
            	<tr>
                	<th scope='col' abbr='Starter'>Invoice for</th>
                	<th scope='col' abbr='Starter'>Total Inovices</th>
                	<th scope='col' abbr='Starter'>Total Price</th>
                	<th scope='col' abbr='Starter'>Total IATA</th>
                	<th scope='col' abbr='Starter'>Gain</th>
                </tr>
            </thead>
            <tbody>
                    <tr>                        
                        <td>".$date."</td>
                        <td>".$totalTxns."</td>                        
                        <td>".$total_price." CHF</td>
                        <td>".$total_iata." CHF</td>
                        <td>".$gain." CHF</td>
                    </tr>
            </tbody>
         </table>		
	</div>";
	
	return $content;
}

function reportRows($date,$type){
	$reportTable=null;
	$fullSQL=returnSQLForInvoiceByDate($date)." order by i.inv_id desc ";
	$rows=getFetchArray($fullSQL);
	
	$buttonForExport="<div style='float:right;margin-bottom:5px;'>
		<!--<a id='id11' href='index.php?exportReport=".$date."&type=".$type."' target='_blank'>
			<img src='img/icon/icon_pdf.png' title='export to pdf' style='width:15px;height:15px;' /> Export to PDF
		</a> |--> <a id='id11' href='index.php?exportToXL=".$date."&type=".$type."' target='_blank'>
			<img src='img/icon/icon_excel.png' title='export to excel' style='width:15px;height:15px;' /> Export to Excel Sheet
		</a>
	</div>";
	if(count($rows)>0){
		$reportTable=getReportTableOnly($rows);
		return $buttonForExport.$reportTable;		
	}
	return null;
}

function getReportTableOnly($rows){
	$reportTable="<table class='footable'  id='reportContentTable' style='margin-top:10px;width:80%;'>
			<thead>			
			<tr>				
				<th>Id</th>				
				<th>Date</th>
				<th>Customer Name</th>
				<th>Total price</th>
				<th>Discount</th>
				<th>Net Amount</th>
				<th>Deposit</th>
				<th>Balance</th>
				<th>Status</th>
			</tr>
		</thead>
			<tbody>";
	return $reportTable.getReportRowsOnly($rows)."</tbody></table><!-- end of reportContentTable --></div>";
}

function getReportRowsOnly($rows){
	$reportRows=null;
	foreach ($rows as $result)
	{	
			$inv_id= $result['inv_id'];			
			$cust_id= $result['cust_id'];
			$cname= $result['cname'];
			$bdate= $result['mdate'];			
			$bdate = date('d.m.y', strtotime($bdate));
			$total_amount= $result['total_price'];
			
			$discount=$result['discount'];
			$net_amount=$result['net_amount'];
			$deposit=$result['deposit'];
			$balance=$result['balance'];
			$status=$result['status'];	
			$data=$data."<tr>
			<td><a href='invoice.php?inv_id=".$inv_id."'>".PREFIX_INV_NR.$inv_id."</a></td>			
					
			<td>".$bdate."</td>
			<td><a href='customer.php?cust_id=".$cust_id."'>".$cname."</a>"."</td>
			<td>".$total_amount."</td>
			<td>".$discount."</td>
			<td>".$net_amount."</td>
			<td>".$deposit."</td>
			<td>".$balance."</td>
			<td>".displayOrderStatus($status)."</td>			
		</tr>";		
		
	}
	return $data;
}

function displayPageForReportContent($content){
	$header="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<title>".MAIN_TITLE."</title>
<meta http-equiv='content-type' content='text/html; charset=iso-8859-1'/>
<link rel='stylesheet' href='css/style.css'>
<link href='css/footable-0.1.css' rel='stylesheet' type='text/css'/>

<style>
#navMovie{
			border:1px solid #ccc;
			border-width:1px 0;
			list-style:none;
			margin-top:10px;
			margin-bottom:50px;
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
		
		
		/* table for summary*/
		
		/* Table 1 Style */
table.table1{
    font-family: 'Trebuchet MS', sans-serif;
    font-size: 16px;
    font-weight: bold;
    line-height: 1.4em;
    font-style: normal;
    border-collapse:separate;
    width:100%;
}
.table1 thead th{
    padding:5px;
    color:#fff;
    text-shadow:1px 1px 1px #568F23;
    border:1px solid #93CE37;
    border-bottom:3px solid #9ED929;
    background-color:#9DD929;
    background:-webkit-gradient(
        linear,
        left bottom,
        left top,
        color-stop(0.02, rgb(123,192,67)),
        color-stop(0.51, rgb(139,198,66)),
        color-stop(0.87, rgb(158,217,41))
        );
    background: -moz-linear-gradient(
        center bottom,
        rgb(123,192,67) 2%,
        rgb(139,198,66) 51%,
        rgb(158,217,41) 87%
        );
    -webkit-border-top-left-radius:5px;
    -webkit-border-top-right-radius:5px;
    -moz-border-radius:5px 5px 0px 0px;
    border-top-left-radius:5px;
    border-top-right-radius:5px;
}
.table1 thead th:empty{
    background:transparent;
    border:none;
}
.table1 tbody th{
    color:#fff;
    text-shadow:1px 1px 1px #568F23;
    background-color:#9DD929;
    border:1px solid #93CE37;
    border-right:3px solid #9ED929;
    padding:0px 1px;
    background:-webkit-gradient(
        linear,
        left bottom,
        right top,
        color-stop(0.02, rgb(158,217,41)),
        color-stop(0.51, rgb(139,198,66)),
        color-stop(0.87, rgb(123,192,67))
        );
    background: -moz-linear-gradient(
        left bottom,
        rgb(158,217,41) 2%,
        rgb(139,198,66) 51%,
        rgb(123,192,67) 87%
        );
    -moz-border-radius:5px 0px 0px 5px;
    -webkit-border-top-left-radius:5px;
    -webkit-border-bottom-left-radius:5px;
    border-top-left-radius:5px;
    border-bottom-left-radius:5px;
}
.table1 tfoot td{
    color: #9CD009;
    font-size:32px;
    text-align:center;
    padding:1px 0px;
    text-shadow:1px 1px 1px #444;
}
.table1 tfoot th{
    color:#666;
}
.table1 tbody td{
    padding:1px;
    text-align:center;
    background-color:#DEF3CA;
    border: 2px solid #E7EFE0;
    -moz-border-radius:2px;
    -webkit-border-radius:2px;
    border-radius:2px;
    color:#666;
    text-shadow:1px 1px 1px #fff;
}
.table1 tbody span.check::before{
    content : url(../images/check0.png)
}

		</style>

</head>";

	$footer="<center></center>"."
	</div>
	<!-- end of container div -->
</center>
</body>
</html>";

	return $header.$content.$footer;
}
?>
