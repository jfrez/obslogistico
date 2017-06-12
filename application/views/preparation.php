<?php
$active=2;
include_once("header.php");
?>
<style>
body {
    margin: 0;
}
</style>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<style>
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


td:hover {
          background-color: #716D67;
        }
.cell{
border: none;
border-color: transparent;
width:100%;

}
div.well {
    overflow-x: auto;
    overflow-y: auto;
    white-space: nowrap;
    max-height:90vh;
	padding:20px;
}
body {
    overflow:hidden;
}
textarea {
    background-color: #000;
    border: 1px solid #000;
    color: #00ff00;
    padding: 8px;
    font-family: courier new;
}
</style>
<html><body>
<div class="row">
<div class="col-md-8" >
        <div class="well" style="">

<?php
function dropdown($i){
$dropdown ='<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">'.$i.'<span class="caret"></span></button>    <ul class="dropdown-menu">      <li><a href="#">Periodo</a></li>      <li><a href="#">Anno</a></li>      <li><a href="#">Pais</a></li><li><a href="#">Region</a></li><li><a href="#">Provincia</a></li><li><a href="#">Comuna</a></li>       </ul>  </div>';
return $dropdown; 
}

$table = Array();
$thead= "<table id='tabla' class='ExcelTable2007'><thead><th></th>\n\n";
$f = fopen($file, "r");
$cols = 0;
$rows = 1;
$tbody="";
$tfoot="";
while (($line = fgetcsv($f,0,';')) !== false) {
        $tbody .= "<tr class='row' id='row$rows'><td class='rows editrow$rows' id='rowindex$rows' data-row='$rows' ondblclick='app.editrow($rows)'>$rows</td>";
		$table[]=$line;
	$tmpcol =1; 
        foreach ($line as $cell) {
                $tbody .= "<td id='cell-$rows-$tmpcol' data-row='$rows' data-col='$tmpcol' class='cellcol$tmpcol cellrow$rows' ondblclick='app.edit($rows,$tmpcol)'>" . htmlspecialchars($cell) . "</td>";
		$tmpcol++;
        }
	$rows++;
	if($tmpcol > $cols)$cols = $tmpcol;
        $tbody .= "</tr>\n";
}
for($i=0;$i<$cols;$i++){
if($i>0)
$thead .= "<th id='col$i' class='cellcol".($i)."' ondblclick='app.editcol($i)'>".dropdown($i)."</th>";
else
$thead .= "<th id='col$i' class='cellcol".($i)."' ondblclick='app.editcol($i)'>0</th>";
}
$thead.="</thead>";
fclose($f);
$tfoot .= "\n</table>";

$t = $thead.$tbody.$tfoot;

echo $t;
?>

</div>
</div>
<div class="col-md-4" id="table">

<div id="menucol" class="menu">
<div class="row">
    <div class="col-md-6 ">
<h4 style="">Columnas:</h4>
      <button onclick="app.removeCols()" type="button" class="btn btn-warning">Borrar</button>
      <button onclick="app.addcol()" type="button" class="btn btn-success">Agregar</button>
    </div>
    <div class="col-md-6 ">
<h4 style="">Filas:</h4>
      <button onclick="app.removeRows()" type="button" class="btn btn-warning">Borrar</button>
      <button onclick="app.addrow()" type="button" class="btn btn-success">Agregar</button>
    </div>
  </div>


<form class="form-horizontal" method="POST">
<input type='hidden' name='tablefile' value="<?php echo $file; ?>"/>
<input type='hidden' name='tablename' value="<?php echo $tablename; ?>"/>
<textarea rows=20  class="col-md-12" name="steps" id="steps">
<?php
if(isset($_POST['steps'])){
echo $_POST['steps'];
}
?>
</textarea>
<input type="submit" value="Correr" class="btn btn-primary"style="float:left;margin-right:30px;"/>
<a href="#" class="btn btn-info" onclick="CSV();">Descargar</a>
<a href="#" class="btn btn-warning pull-right" style="margin-right:20px;" onclick="sendCSV();">Cargar</a>
</form>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/js/table2CSV.js"></script>
<script src="/js/preparation.js"></script>
<script>
function CSV(){
 $table =$('#tabla');
 var csv = $table.table2CSV({separator : ';',delivery:'value'});
      content =  encodeURIComponent(csv);
saveContent(content,"tabla.csv");
}
function sendCSV(){
 $table =$('#tabla');
 var csv = $table.table2CSV({separator : ';',delivery:'value'});
      content =  encodeURIComponent(csv);
	$.ajax({
		'url':"/?/Fuentes/carga",
		'method':'POST',
		data:{'tablename':'<?php echo $tablename;?>',content:content,periodo:'periodo',periodoano:'anno'},
		success:function(msg){
		alert(msg);
		}

		});
}

function saveContent(fileContents, fileName)
{
    var link = document.createElement('a');
    link.download = fileName;
    link.href = 'data:,' + fileContents;
    link.click();
}
function addCommand(comm){
$("#steps").val($("#steps").val()+"\n"+comm);
}
function addrow(){
app.addrow();
}
function addcol(){
app.addcol();
}
function delCol(col){
app.removeCol(col);
}
function delRow(row){
app.removeRow(row);
}
function setVal(row,col,val){
app.setVal(row,col,val);
}
function replace(row,col,val,val2){
app.replace(row,col,val,val2);
}
function getVal(row,col){
return app.getVal(row,col);
}
function getcols(){
return  document.getElementById("tabla").rows[0].cells.length -1;
}
function getrows(){
return  document.getElementById("tabla").rows.length;
}
<?php
if(isset($_POST['steps'])){
$code =trim(preg_replace('/\s\s+/', ' ', $_POST['steps']));
echo "app.editing=false;";
echo "eval('".$code."');";
echo "app.editing=true;";
}

?>

</script>
