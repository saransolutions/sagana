<?php

function displayDailyReportForm($errMsg){
	$actionPage='index.php';
	$page="<div id='easy'>
	<!-- div for report form -->
	<div>	
		<table class='footable' >
			<tr>
				<td>
					<form method='post' action='records.php'>	           
     					<p style='float:left;'>Date : <input type='text' name='rdate' id='datepicker'></p>
     					<input name='reportDSubmit' type='submit' value='Daily Report' />
     				</form>
     			</td>     		
     			<td>
     				<form method='post' action='records.php'>
						<p style='float:left;'>Month : <input type='text' name='rmonth' id='month' class='monthPicker'></p>
     					<input  name='reportMSubmit' type='submit' value='Monthly Report' />
     				</form>     		
     			</td>
     			<td>
     				<form method='post' action='records.php'>	           
     					<p style='float:left;'>Year : <select name='ryear'
							id='baggage' style='width:250px;' data-placeholder='Select Year ...' class='chosen-select'>
							<option value=''></option>
							".getReportYears("2000", "2035")."
						</select></p>					
     					<input name='reportYSubmit' type='submit' value='Yearly Report' />
     				</form> 
     			</td>
     		</tr>
     	</table>     
    </div>
     <!-- end of div for report form -->
  </div>
     <!-- end of div for easy -->".RETURN_CHOOSY_JS_FOOTER.$errMsg;
	$header=JQUERY_SCRIPT_CALL.getJqueryCalendarJSCall().getVerticalMenuJSCall().getJqueryCalendarForMonthJSCall();
	echo getHTMLPage(MAIN_TITLE." - Record Report ", MAIN_TITLE." - Record Report", $page, $header, BGC_FOR_CUSTOMER);
}



function displayRecordReport($date,$type){
	$sql=getRecordReportSQLByDate($date);	
	$rows=getFetchArray($sql);
	//echo "sql - ".$sql;
	$rowCount=count($rows);
	//echo "sql - ".$sql." row count - ".$rowCount;
	if($rowCount>0){
		$reportSummary=reportSummary($sql, $type, $date);
		$reportSummary=$reportSummary.extendedReportSummary($sql);		
		$buttonForExport="<div style='float:right;margin-bottom:5px;'>
		 <a id='id11' href='records.php?xl=".$date."&type=".$type."' target='_blank'>
			<img src='img/icon/icon_excel.png' title='export to excel' style='width:15px;height:15px;' /> Export to Excel Sheet
		</a>
	</div>";
		
		
		
		$divReportTableStart="<center><div style='width:75%;'>";
		$divReportTableEnd="</div></center>";
		$reportTable=getReportTableOnly($rows);
		$content= getSimpleNavigationMenu().$divReportTableStart.$reportSummary.$buttonForExport.$reportTable.$divReportTableEnd;
		return displayPageForReportContent($content);
	}else{
		return null;
	}
	
}


function getReportTableOnly($rows){
	$reportTable="<table class='footable' id='reportContentTable' style='margin-top:10px;'>
			<thead>			
				<tr>
					<th style='width:10%;'>ID</th>					
					<th style='width:10%;'>Type</th>
					<th style='width:20%;'>Name</th>
					<th style='width:10%;'>Amount</th>
					<th style='width:10%;'>Created By</th>										
					<th style='width:20%;'>Party</th>
					<th style='width:10%;'>Paid By</th>
					<th style='width:10%;'>Date</th>									
				</tr>
			</thead>
			<tbody>";
	return $reportTable.getReportRowsOnly($rows)."</tbody></table><!-- end of reportContentTable -->";
}

function getReportRowsOnly($rows){
	$data=null;
	foreach ($rows as $result)
	{
		$id= $result['rid'];
		$recordName= $result['rtype'];
		$recordType= $result['type'];
		$user= $result['user'];			
		$total_amount= $result['total_amount'];
		$paid_to= $result['party_name'];
		$p_m_name= $result['p_m_name'];
		$mdate= $result['rdate'];
		$mdate = date("d-m-Y", strtotime($mdate));
			
		$data=$data.
	"<tr>			
		<td><a href='records.php?rid=".$id."'>".PREFIX_RECORD_NR.$id."</a></td>
		<td>".$recordName."</td>				
		<td><a href='records.php?rid=".$id."'>".$recordType."</a>"."</td>
		<td>".$total_amount."</td>
		<td>".$user."</td>
		<td>".$paid_to."</td>
		<td>".$p_m_name."</td>		
		<td>".$mdate."</td>
	</tr>";
	}
	return $data;
}

function reportSummary($query, $type, $date){
	
	$totalTxns=0;$total_expen=0;$total_income=0;
	$total_bargeld=0;$total_ubs=0;$total_post=0;
	$total_salary=0;
	$rows=getFetchArray($query);
	foreach ($rows as $result)
	{	
		$total_amount= $result['total_amount'];
		$p_m_name= $result['p_m_name'];
		if($p_m_name=='Bargeld'){
			$total_bargeld=$total_bargeld+$total_amount;			
		}
		if($p_m_name=='UBS'){
			$total_ubs=$total_ubs+$total_amount;			
		}
		if($p_m_name=='Die Post'){
			$total_post=$total_post+$total_amount;			
		}
		
		$recordType= $result['type'];
		if($recordType=='Salary'){
			$total_salary=$total_salary+$total_amount;
		}
		
		
		if($result['rtype'] == EXPEND){
			$total_expen=floatval($total_expen+$result['total_amount']);				
		}else if($result['rtype'] == INCOME){
			$total_income=floatval($total_income+$result['total_amount']);
		}						
		$totalTxns++;
	}
	
	$content = "<!-- summary tab for report -->
	<h1 id='reportHeading'>".$type." Report</h1>
	
		<table class='footable'>
        	<thead>
            	<tr>
                	<th scope='col' abbr='Starter'>Report for</th>
                	<th scope='col' abbr='Starter'>Total Records</th>
                	<th scope='col' abbr='Starter'>Total Expenditure</th>
                	<!--<th scope='col' abbr='Starter'>Total Bargeld</th>
                	<th scope='col' abbr='Starter'>Total UBS</th>
                	<th scope='col' abbr='Starter'>Total Die Post</th>
                	<th scope='col' abbr='Starter'>Total Salary</th>-->
                	<th scope='col' abbr='Starter'>Total Income</th>                	
                	<th scope='col' abbr='Starter'>Balance</th>                   	
                </tr>
            </thead>
            <tbody>
                    <tr>                        
                        <td>".$date."</td>
                        <td>".$totalTxns."</td>                        
                        <td>".$total_expen." CHF</td>
                        <!--<td>".$total_bargeld." CHF</td>
                        <td>".$total_ubs." CHF</td>
                        <td>".$total_post." CHF</td>
                        <td>".$total_salary." CHF</td>-->
                        <td>".$total_income." CHF</td>                        
                        <td>".$total_income." - ".$total_expen." = ".($total_income-$total_expen)." CHF</td>                                                
                    </tr>
            </tbody>
         </table>		
	";
	
	return $content;
}


function extendedReportSummary($query){
	
	
	$totalTxns=0;$total_expen=0;$total_income=0;
	$total_bargeld_ex=0;$total_ubs_ex=0;$total_post_ex=0;
	$total_bargeld_in=0;$total_ubs_in=0;$total_post_in=0;
	$total_salary=0;
	$rows=getFetchArray($query);
	foreach ($rows as $result)
	{
		$total_amount= $result['total_amount'];
		
		$p_m_name= $result['p_m_name'];
		

		$recordType= $result['type'];
		if($recordType=='Salary'){
			$total_salary=$total_salary+$total_amount;
		}


		if($result['rtype'] == EXPEND){
			$total_expen=floatval($total_expen+$result['total_amount']);
			if($p_m_name=='Bargeld'){
				$total_bargeld_ex=$total_bargeld_ex+$total_amount;
			}
			if($p_m_name=='UBS'){
				$total_ubs_ex=$total_ubs_ex+$total_amount;
			}
			if($p_m_name=='Die Post'){
				$total_post_ex=$total_post_ex+$total_amount;
			}
		}else if($result['rtype'] == INCOME){
			$total_income=floatval($total_income+$result['total_amount']);
			
			$total_expen=floatval($total_expen+$result['total_amount']);
			if($p_m_name=='Bargeld'){
				$total_bargeld_in=$total_bargeld_in+$total_amount;
			}
			if($p_m_name=='UBS'){
				$total_ubs_in=$total_ubs_in+$total_amount;
			}
			if($p_m_name=='Die Post'){
				$total_post_in=$total_post_in+$total_amount;
			}
		
		}
		$totalTxns++;
	}
	
	$content = "<!-- summary tab for report -->
		<table class='footable'>
        	<thead>
            	<tr>                	
                	<th scope='col' abbr='Starter'>Total Expenditure Bargeld</th>
                	<th scope='col' abbr='Starter'>Total Expenditure UBS</th>
                	<th scope='col' abbr='Starter'>Total Expenditure Die Post</th>                   	
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>".$total_bargeld_ex." CHF</td>
                        <td>".$total_ubs_ex." CHF</td>
                        <td>".$total_post_ex." CHF</td>                    
                    </tr>
            </tbody>
         </table>
		
         <table class='footable'>
        	<thead>
            	<tr>                	
                	<th scope='col' abbr='Starter'>Total Income Bargeld</th>
                	<th scope='col' abbr='Starter'>Total Income UBS</th>
                	<th scope='col' abbr='Starter'>Total Income Die Post</th>                   	
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>".$total_bargeld_in." CHF</td>
                        <td>".$total_ubs_in." CHF</td>
                        <td>".$total_post_in." CHF</td>                    
                    </tr>
            </tbody>
         </table>
         
	";
	
	return $content;
	
}


function displayPageForReportContent($content){
	$header="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<title>".MAIN_TITLE."</title>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
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


function prepareToExportToXL($date,$type){	
	$sql=getRecordReportSQLByDate($date);	
	$rows=getFetchArray($sql);
	//echo "sql - ".$sql;
	$rowCount=count($rows);
	//echo "sql - ".$sql." row count - ".$rowCount;
	if($rowCount>0){
		$reportSummary=reportSummary($sql, $type, $date);
		$divReportTableStart="<center><div style='width:75%;'>";
		$divReportTableEnd="</div></center>";
		$reportTable=getReportTableOnly($rows);
		$content= "
<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	</head>
	<body>
		".$divReportTableStart.$reportSummary."<br><br><br>".$reportTable.$divReportTableEnd."
	</body>
</html>";
		return $content;
	}else{
		return null;
	}
}

?>