<?php



ob_start();

if (version_compare(phpversion(), '5.3.0', '>=') == 1)

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

else

error_reporting(E_ALL & ~E_NOTICE);

session_start();



require_once 'includes/cons.php';

require_once 'funcs/db/db.php';

require_once 'funcs/utility.php';

require_once 'funcs/customer/customer.php';

require_once 'funcs/customer/selectCustomer.php';

require_once 'funcs/customer/editCustomer.php';

require_once 'funcs/customer/insertCustomer.php';



require_once 'funcs/member/insertMember.php';

require_once 'funcs/member/selectMember.php';

require_once 'funcs/member/updateMember.php';



require_once 'funcs/ms/updateMS.php';



require_once 'funcs/trans/trans.php';



require_once 'funcs/export/export_mini_bill_pdf.php';



checkUserLogin();



if(isset($_GET['add']) and $_GET['add']=='mem'){

		echo displayNewMemberForm($_GET['sid']);

}



else if(isset($_GET['sid']))

{		

	$sid=$_GET['sid'];

	echo displayMembers(getMemberDetailsBySId($sid), null, null, $sid, $_SESSION['user'], $_SESSION['role']);

}

else if(isset($_POST['submitMember']))

{	

	$sid=$_POST['sid'];	

	$sid = validateMemberAndInsert($sid);

	header("Location: member.php?sid=".$sid."");

	exit();

}

else if(isset($_GET['paymemberid']))

{	

	$mid=$_GET['paymemberid'];

	$sid=$_GET['scid'];

	

	payMemberMonthlyTerm($mid);

	header("Location: member.php?sid=".$sid."");

	exit();

	

}else if(isset($_GET['revertmemberid']))

{	

	$mid=$_GET['revertmemberid'];

	$sid=$_GET['scid'];

	

	revertMemberMonthlyTerm($mid);

	header("Location: member.php?sid=".$sid."");

	exit();

	

}

else if(isset($_GET['markwinner']))

{	

	$mid=$_GET['markwinner'];

	$sid=$_GET['scid'];

	

	markWinner($mid);

	header("Location: member.php?sid=".$sid."");

	exit();

	

}

else if(isset($_GET['revertwinner']))

{	

	$mid=$_GET['revertwinner'];

	$sid=$_GET['scid'];

	

	revertWinner($mid);

	header("Location: member.php?sid=".$sid."");

	exit();

	

}else if(isset($_GET['member_id']))

{	

	$mid=$_GET['member_id'];

	displayMemberById($mid, $_SESSION['role']);

	

}else if(isset($_GET['mprint']))

{	

	

	$mid=$_GET['mprint'];

	$content=miniBillMainContent($mid);

	strlen($content);

	prepareMiniBill($mid, $content);

	

}else if(isset($_GET['dmid']))

{	

	

	$mid=$_GET['dmid'];

	$sid=$_GET['scid'];

	deleteMemberById($mid);

	header("Location: member.php?sid=".$sid."");

	exit();

}else if(isset($_POST['search']))

{

	$searchBy=$_POST['searchBy'];

	if(isset($_POST['searchValue'])){

		

		$searchValue=$_POST['searchValue'];

		$sid=$_POST['searchSID'];

		echo displayMembers(getMemberDetailsBySId($sid), $searchBy, $searchValue, $sid, $_SESSION['user'], $_SESSION['role']);

				

	}	

}





function prepareMiniBill($member_id, $content){

include("../mpdf/mpdf.php");

require_once  'includes/cons.php';

	//default page length is 160 for join       margin_left, margin_right, margin_top, margin_bottom, margin_header, margin_footer

$mpdf=new mPDF('utf-8', array(80,150), 0, '', 4, 4, 25, 25, 12, 12); 



$html = '

<html>

'.PDF_HEAD_TEMPLATE.'

<body>

<!--mpdf

'.miniBillContentHeader().'

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />

<sethtmlpagefooter name="myfooter" value="on" />

mpdf-->

'.$content.'

'.miniBillContentFooter().'

</body>

</html>

';



$mpdf->SetJS('this.print();');

$mpdf->WriteHTML($html);

$mpdf->Output(PREFIX_MEMBER_NR.$member_id.'.pdf','I');



exit;

	

	

}

