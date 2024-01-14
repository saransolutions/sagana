<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=document_name.doc");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";
echo "
<table style='width:80mm;table-layout:fixed;'>
	<tr>
		<td>
		
		</td>
	</tr>
<table>";
echo "</body>";
echo "</html>";
?>