<?php

/*
function exportMReportIntoXL($out){
	$filename_prefix="Monthly Report ";
	$filename = $filename_prefix."-".date("Y-m-d_H-i",time());

//Generate the CSV file header
header("Content-type: application/vnd.ms-excel");
header("Content-Encoding: UTF-8");
header("Content-type: text/csv; charset=UTF-8");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header("Content-disposition: filename=".$filename.".csv");
echo "\xEF\xBB\xBF"; // UTF-8 BOM
//Print the contents of out to the generated file.
print $out;

//Exit the script
exit;
}
*/

function exportMReportIntoXL($out,$fileName){
$file=$fileName.".xls";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");
echo $out;
}

?>

<?php
?>