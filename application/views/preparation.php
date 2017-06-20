<?php
$active=2;
include_once("header.php");
?>
<link rel="stylesheet" href="/css//bootstrap-tagsinput.css">
<style>
body {
    margin: 0;
}
</style>
<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap-theme.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rainbow/1.2.0/themes/github.css">
<style>
.icon-github {
    background: no-repeat url('../img/github-16px.png');
    width: 16px;
    height: 16px;
}

.bootstrap-tagsinput {
    width: 100%;
}

.accordion {
    margin-bottom:-3px;
}

.accordion-group {
    border: none;
}

.twitter-typeahead .tt-query,
.twitter-typeahead .tt-hint {
    margin-bottom: 0;
}

.twitter-typeahead .tt-hint
{
    display: none;
}

.tt-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 160px;
    padding: 5px 0;
    margin: 2px 0 0;
    list-style: none;
    font-size: 14px;
    background-color: #ffffff;
    border: 1px solid #cccccc;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 4px;
    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    background-clip: padding-box;
    cursor: pointer;
}

.tt-suggestion {
    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: normal;
    line-height: 1.428571429;
    color: #333333;
    white-space: nowrap;
}

.tt-suggestion:hover,
.tt-suggestion:focus {
  color: #ffffff;
  text-decoration: none;
  outline: 0;
  background-color: #428bca;
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
    max-height:80vh;
	padding:20px;
}
body {
    overflow:hidden;
}
textarea, textarea:focus {
    background-color: #000;
    border: 1px solid #000;
    color: #00ff00;
    padding: 8px;
    font-size:14px;
    font-family: courier new;
}
.atributes{
min-width:200px;
}
</style>
<html><body>
<div class="tabs-contenor">
<div class="row" style="padding:5px;">
    <div class="col-md-6 ">
<h4 style="float:left;margin-right:20px;">Columnas:</h4>
      <button onclick="app.removeCols()" type="button" class="btn btn-warning">Borrar</button>
      <button onclick="app.addcol()" type="button" class="btn btn-success">Agregar</button>
    </div>
    <div class="col-md-6 ">
<h4 style="float:left;margin-right:20px;">Filas:</h4>
      <button onclick="app.removeRows()" type="button" class="btn btn-warning">Borrar</button>
      <button onclick="app.addrow()" type="button" class="btn btn-success">Agregar</button>
    </div>
  </div>


     </div>
<div class="row" style="margin:10px;">
<div class="col-md-8" >
        <div class="well" style="">

<?php
function dropdown($i){
$dropdown ='<div class="dropdown pull-right"><button class="btn btn-xs btn-primary dropdown-toggle" type="button"  style="float:left;">Atributos<span class="caret"></span></button>    <ul class="dropdown-menu" style="min-width:200px;">      <li><a href="#">Periodo</a></li>      <li><a href="#">Anno</a></li>      <li><a href="#">Pais</a></li><li><a href="#">Region</a></li><li><a href="#">Provincia</a></li><li><a href="#">Comuna</a></li> <li>Atributos:<br/><input type="text" placeholder=""  id="atributes'.$i.'" class="form-control atributes" ></li>       </ul>  </div>';
return $dropdown; 
}

function unidades($i){
$dropdown ="<select class='unidades pull-right' style='float:left;'>
  <option>Unidad</option>
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
</select>";
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
$thead .= "<th id='col$i' class='cellcol".($i)."' ondblclick='app.editcol($i)' style='min-width:100px;'><b style='font-size:19px;float:left;'>$i</b>".unidades($i)." ".dropdown($i)."</th>";
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

<form class="form-horizontal" method="POST">
<input type='hidden' name='tablefile' value="<?php echo $file; ?>"/>
<input type='hidden' name='tablename' value="<?php echo $tablename; ?>"/>
<input type='text' name='prepname' class="form-control" value="<?php echo $tablename."_PREP"?>"/>
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
<script src="/js/bootstrap-tagsinput.min.js"></script>
<script src="/js/typeahead.bundle.js"></script>
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
		location.href="/?/Fuentes/tmptable";
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
$(function(){
var atributes = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: {
    url: '/?/Prep/getAtributes',
    filter: function(list) {
      return $.map(list, function(attr) {
        return { name: attr }; });
    }
  }
});
atributes.initialize();
$('.atributes').tagsinput({
allowDuplicates: false,freeInput: true,
  typeaheadjs: {
    name: 'name',
    displayKey: 'name',
    valueKey: 'name',
    source: atributes.ttAdapter()
  }
});

$('.dropdown-toggle').on('click', function (event) {
    $(this).parent().toggleClass('open');
});

$('body').on('click', function (e) {
    if (!$('.dropdown').is(e.target) 
        && $('.dropdown').has(e.target).length === 0 
        && $('.open').has(e.target).length === 0
    ) {
        $('.dropdown').removeClass('open');
    }
});


});
</script>
