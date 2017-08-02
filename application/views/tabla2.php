<?php
$active=2;
include_once("header.php");
function startsWith($haystack, $needle)
{
	$length = strlen($needle);
	return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
	$length = strlen($needle);
	if ($length == 0) {
		return true;
	}

	return (substr($haystack, -$length) === $needle);
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rainbow/1.2.0/themes/github.css">
<link rel="stylesheet" href="/assets/google/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/google/css/bootstrap-theme.css">
<link rel="stylesheet" href="/assets/google/css/todc-bootstrap.min.css">
<style>
body {

}
#content{
position: absolute;
}
.ExcelTable2007 {
border: 1px solid #B0CBEF;
	border-width: 1px 0px 0px 1px;
	font-size: 11pt;
	font-family: Calibri;
	font-weight: 100;
	border-spacing: 0px;
	border-collapse: collapse;
}

.ExcelTable2007 TH {
	font-weight: normal;
	font-size: 14px;
border: 1px solid #9EB6CE;
	border-width: 0px 1px 1px 0px;
height: 17px;
}

.ExcelTable2007 TD {
border: 0px;
padding: 0px 4px 0px 2px;
border: 1px solid #D0D7E5;
	border-width: 0px 1px 1px 0px;
}

.ExcelTable2007 TD B {
border: 0px;
	font-weight: bold;
}

.ExcelTable2007 TD.heading {
	background-color: #E4ECF7;
	text-align: center;
border: 1px solid #9EB6CE;
	border-width: 0px 1px 1px 0px;
}

th{
	max-width:100px;
}
</style>
<div class="clear"></div>
<div class="tabs-contenor">
</div>
<div class="clear"></div>
<div id="content">
<table class="table ">
<thead>
<tr>
<?php
foreach($cols as $c){
	if(!endsWith($c,"_PRINT")){
		if(!startsWith($c,"SYS_TRIMESTRE") && strlen($table[0][$c])==0 )
			echo "";
		else
		   if(strlen($table[0]["SYS_TRIMESTRE"]) ==0 && strlen($table[0]["SYS_TRIMESTRE_MOVIL"])==0 && startsWith($c,"SYS_TRIMESTRE") )
			echo "";
			else
			echo "<th>".$c."</th>";

	}

}
?>
</tr>
</thead>
<tbody>
<?php
foreach($table as $tr){
	echo "<tr>";
	foreach($tr as $c => $td){ 
	if(!endsWith($c,"_PRINT")){
		if(!startsWith($c,"SYS_TRIMESTRE") && strlen($table[0][$c])==0 )
			echo "";
		else
		   if(strlen($table[0]["SYS_TRIMESTRE"]) ==0 && strlen($table[0]["SYS_TRIMESTRE_MOVIL"])==0 && startsWith($c,"SYS_TRIMESTRE") )
			echo "";
			else
			echo "<td>".$td."</td>";

	}




	}
	echo "</tr>";
}
?>
</tbody>
</div>
</div>
</body>
</html>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
<script src='https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js'></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
<script>
$(document).ready(function () {
		$('table').DataTable();
		});
</script>
