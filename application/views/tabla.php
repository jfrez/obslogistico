<?php
$active=2;
include_once("header.php");
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
  width: 30000px;
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
padding:2px;
}
</style>
<div class="clear"></div>
     <div class="tabs-contenor">
     </div>
<div class="clear"></div>
  <div id="content">
<h3>Se actualizarán los siguientes registros</h3>
<table class="ExcelTable2007">
<thead>
<tr>
<?php
foreach($cols as $c){
echo "<th>".$c."</th>";
}
?>
</tr>
</thead>
<tbody>
<?php
foreach($table as $tr){
echo "<tr>";
foreach($tr as $td){ 
echo "<td>".$td."</td>";
}
echo "</tr>";
}
?>
</tbody>
</table>
<a class="btn btn-danger" href="/?/Fuentes/confirm/<?php echo $tablename?>/TRUE">Confirmar Actualizaciones</a>
</div>

</div>
</body>
</html>
