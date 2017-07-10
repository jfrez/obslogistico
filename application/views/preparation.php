
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rainbow/1.2.0/themes/github.css">
<link rel="stylesheet" href="/assets/google/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/google/css/bootstrap-theme.css">
<link rel="stylesheet" href="/assets/google/css/todc-bootstrap.min.css">

<style>
.correct{
background-color:rgb(144,238,144);
}
.error{
background-color:rgb(250,128,144);
}
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
margin-left:0px;
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
	max-height:86vh;
padding:0px;
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
.pull-right>.dropdown-menu {
    left: 0;
}
#showcode{
}
.inside{
padding:0px;
  -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}
.well{
padding:0px;
margin:0px;
}
#code{
  -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}
td{
  -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;


}
</style>
<html><body>
<div class="tabs-contenor">
<div class="row" style="padding:5px;">
<div class="col-md-8 ">
<div style="float:left;margin-right:30px;">
<h4 style="float:left;margin-right:20px;">Columnas:</h4>
<button onclick="app.removeCols()" type="button" class="btn btn-warning">Borrar</button>
<button onclick="app.addcol()" type="button" class="btn btn-success">Agregar</button>
</div><div>
<h4 style="float:left;margin-right:20px;">Filas:</h4>
<button onclick="app.removeRows()" type="button" class="btn btn-warning">Borrar</button>
<button onclick="app.addrow()" type="button" class="btn btn-success">Agregar</button>
</div>
</div>
<div class="col-md-4 ">

<form class="form-horizontal" method="POST">
<div class="form-inline">
<!--<select name="prepname" disabled class="form-control" id="prepname" style="float:left;">
<?php foreach($preparations as $p){
if($p['name']!=$tablename){ ?>
	<option value="<?php echo $p['name']?>"><?php echo $p['name']?></option>
<?php }else{ ?>
	<option selected value="<?php echo $p['name']?>"><?php echo $p['name']?></option>
		<?php }} ?>
		</select>
-->
<input type="hidden" name="prepname" value="<?=$tablename?>"/>
		<input type="submit" value="Correr" class="btn btn-primary" style=""/>
<a href="#" style="" class="btn btn-info" onclick="showcode();" id="showcode" style=""><img src="/assets/img/js.png"  width="20px"/><?php echo $tablename; ?></a>
<a href="#" class="btn btn-warning pull-right" style="" onclick="sendCSV();">Cargar</a>
<a href="#" style="" class="btn btn-info pull-right" onclick="CSV();">Descargar</a>
	

</div>
</div>
</div>


</div>
<div class="row" style="margin:0px;">
<div id="planilla" class="col-md-12 inside" style="margin:0px;padding:0x">
<div class="well" style="">

<?php
function dropdown($i){
	$dropdown ='<div class="dropdown pull-right">
	<button class="btn btn-xs myFakeClass btn-primary dropdown-toggle" type="button"  style="float:left;">Validador<span class="caret"></span></button>
	    <ul class="dropdown-menu" style="min-width:200px;">
	      <li><a href="#" onclick="validar('.$i.',\'numeric\')">Numerico</a></li>
	      <li><a href="#" onclick="validar('.$i.',\'periodos\')">Periodo</a></li>
	      <li><a href="#" onclick="validar('.$i.',\'anno\')">Anno</a></li>
	      <li><a href="#" onclick="validar('.$i.',\'PAIS_VIEW\')">Pais</a></li>
	      <li><a href="#" onclick="validar('.$i.',\'REGION_VIEW\')">Region</a></li>
	      <li><a href="#" onclick="validar('.$i.',\'PROVINCIA_VIEW\')" >Provincia</a></li>
	      <li><a href="#" onclick="validar('.$i.',\'COMUNA_VIEW\')" >Comuna</a></li>
		 <!--<li>Atributos:<br/><input type="text" placeholder=""  id="atributo'.$i.'" class="form-control atributes" name="atributo'.$i.'"></li>    -->   
	</ul>  </div>';
	return $dropdown; 
}
function unidades($i,$unidades){
	$dropdown ="<select class='unidades pull-right' style='float:left;' id='unidad$i'>
		<option value=''>Unidad</option>";
	foreach($unidades as $u){
		$dropdown.="<option value='".$u['name']."'>".$u['name']."</option>";
	}
	$dropdown.="</select>";
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
		$thead .= "<th id='col$i' class='cellcol".($i)."' ondblclick='app.editcol($i)' style='min-width:100px;'><b style='font-size:19px;float:left;'>$i</b>".unidades($i,$unidades)." ".dropdown($i)."</th>";
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
<div id="code" class="col-md-0" >

<div id="menucol" class="menu">

<input type='hidden' name='tablefile' value="<?php echo $file; ?>"/>
<input type='hidden' name='tablename' value="<?php echo $tablename; ?>"/>
	<textarea rows=25  class="col-md-12" name="steps" id="steps">
		<?php
			echo $steps;
?>
</textarea>
Errores:
		<pre  class="col-md-12"  id="errors">
</pre>
</form>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/js/table2CSV.js"></script>
<script src="/js/preparation.js"></script>
<script src="/js/validar.js"></script>
<script src="/js/lib.js"></script>
<script src="/js/bootstrap-tagsinput.min.js"></script>
<script src="/js/typeahead.bundle.js"></script>
<script>
var codeopen = false;
function showcode(){
if(codeopen){
codeopen=false;
$("#code").removeClass("col-md-6");
$("#code").addClass("col-md-0");
$("#planilla").removeClass("col-md-6");
$("#planilla").addClass("col-md-12");
}else{
codeopen=true;
$("#code").removeClass("col-md-0");
$("#code").addClass("col-md-6");
$("#planilla").removeClass("col-md-12");
$("#planilla").addClass("col-md-6");

}
}
var atributes=Array();
function loadattr(){
	atributes=Array();
	$('[id^="atributo"]').each(function(){atributes.push($(this).val());});
}

var unidades=Array();
function loadunidades(){
	unidades=Array();
	$('[id^="unidad"]').each(function(){unidades.push($(this).val());});
}
var preparations=Array();
function loadpreparations(){
	unidades=Array();
	$('[id^="unidad"]').each(function(){unidades.push($(this).val());});
}

function getCode(prep){
	$.ajax({
			url:'/?/Prep/getPreparationsCode/'+prep,
			dataType:"json",
			success:function(data){
			$("#steps").text(data[0].code);		

			}
			});
}


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
			data:{'tablename':'<?php echo "BASE_".$tablename;?>',content:content,periodo:'periodo',periodoano:'anno'},
			success:function(msg){
		//	location.href="/?/Fuentes/tmptable/<?php echo "BASE_".$tablename;?>";
			console.log(msg);
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
function addError(row,col,type){
	$("#errors").html($("#errors").html()+"\n"+"Row: "+row+" Col:"+col+", "+type);

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
function validar(col,type){
addCommand('validate('+col+',"'+type+'");');
validate(col,type);
}
function validate(col,type){
switch(type) {
    case "anno":
       validador.anno(col,type);
        break;
    case "numeric":
       validador.numeric(col,type);
        break;
    default:
       validador.exec(col,type);
}
}






<?php
if(isset($_POST['steps'])){
	$code =trim(preg_replace('/\s\s+/', ' ', $_POST['steps']));
	echo "app.editing=false;";
	echo "try {
    eval('".$code."'); 
} catch (e) {
    if (e instanceof SyntaxError) {
        addError(e.message);showcode();
    }
}";
	//echo "eval('".$code."');";
	echo "app.editing=true;";
}

?>

$(function(){

$(".dropdown-menu li a").click(function() {
    $(this).closest(".dropdown-menu").prev().click();;
});

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
$("#prepname").change(function(){
$( "#prepname option:selected" ).each(function() {
      getCode($( this ).text());
    });

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
$("#contextmenu").hide();
});

</script>
<script type="text/javascript">
var target=Array();
var clip=Array();
var selected=Array();
        document.getElementById("tabla").addEventListener('contextmenu', function(e) {
console.log(e);
$("#contextmenu").css({left:e.pageX,top:e.pageY}).fadeIn();
target=e.target;
            e.preventDefault();
        }, false);
        document.addEventListener('click', function(e) {
$("#contextmenu").fadeOut();
	});
        document.getElementById("tabla").addEventListener('click', function(e) {
		});
var downstart;
var downend;
var selecting=false;
document.getElementById("tabla").addEventListener('mousedown', function(e) {
if(e.which!=1)return;
for(var e in selected){
selected[e].removeClass("selected2");
}
selected=Array();

downstart = e.target;
selecting=true;
});
document.getElementById("tabla").addEventListener('mouseup', function(e) {
if(e.which!=1)return;
downend = e.target;
selecting=false;
console.log(downend);
icol = parseInt($(downstart).attr("data-col"));
irow = parseInt($(downstart).attr("data-row"));
col = parseInt($(downend).attr("data-col"));
row = parseInt($(downend).attr("data-row"));
for(var j=irow;j<=row;j++){
for(var i=icol;i<=col;i++){
console.log($("#cell-"+j+"-"+i));
$("#cell-"+j+"-"+i).addClass("selected2");
selected.push($("#cell-"+j+"-"+i));
}}

});
document.getElementById("tabla").addEventListener('mousemove', function(e) {
if(e.which!=1)return;
if(selecting){
$(downstart).addClass("selected2");
}
});

function copy(){
clip=Array();
text="";
for(var s in selected){
clip.push(selected[s]);
text += selected[s].text()+",";
}
copyTextToClipboard(text);
}
function paste(){
fcol = parseInt($(target).attr("data-col"));
frow = parseInt($(target).attr("data-row"));
diffcol = fcol-parseInt(clip[0].attr("data-col"));
diffrow = frow-parseInt(clip[0].attr("data-row"));
for(var c in clip){
col = parseInt(clip[c].attr("data-col"))+diffcol;
row = parseInt(clip[c].attr("data-row"))+diffrow;
val=(clip[c].text());
addCommand("setVal("+row+","+col+',"'+val+'");');
$("#cell-"+row+"-"+col).text(val);

}
}



function copyTextToClipboard(text) {
  var textArea = document.createElement("textarea");
  // Place in top-left corner of screen regardless of scroll position.
  textArea.style.position = 'fixed';
  textArea.style.top = 0;
  textArea.style.left = 0;

  // Ensure it has a small width and height. Setting to 1px / 1em
  // doesn't work as this gives a negative w/h on some browsers.
  textArea.style.width = '2em';
  textArea.style.height = '2em';

  // We don't need padding, reducing the size if it does flash render.
  textArea.style.padding = 0;

  // Clean up any borders.
  textArea.style.border = 'none';
  textArea.style.outline = 'none';
  textArea.style.boxShadow = 'none';

  // Avoid flash of white box if rendered for any reason.
  textArea.style.background = 'transparent';


  textArea.value = text;

  document.body.appendChild(textArea);

  textArea.select();

  try {
    var successful = document.execCommand('copy');
    var msg = successful ? 'successful' : 'unsuccessful';
    console.log('Copying text command was ' + msg);
  } catch (err) {
    console.log('Oops, unable to copy');
  }

  document.body.removeChild(textArea);
}

</script>
<style>
#contextmenu{
position:absolute;
max-width:200px;
max-height:300px;
width:auto;
height:auto;
z-index:99999;
  padding: 12px 0;
  width: 240px;
  background-color: #fff;
  border: solid 1px #dfdfdf;
  box-shadow: 1px 1px 2px #cfcfcf;
}
.context-menu__items {
  list-style: none;
  margin: 0;
  padding: 0;
}

.context-menu__item {
  display: block;
  margin-bottom: 4px;
}

.context-menu__item:last-child {
  margin-bottom: 0;
}

.context-menu__link {
  display: block;
  padding: 4px 12px;
  color: #0066aa;
  text-decoration: none;
}
.selected2{
  background-color: #87CEFA;
}
.context-menu__link:hover {
  color: #fff;
  background-color: #0066aa;
}
#planilla{
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
</style>
<div id="contextmenu">
<ul class="context-menu__items">
      <li class="context-menu__item">
        <a href="#" onclick="copy()" class="context-menu__link" data-action="View"><i class="fa fa-eye"></i>Copiar</a>
      </li>
      <li class="context-menu__item">
        <a href="#" onclick="paste()" class="context-menu__link" data-action="Edit"><i class="fa fa-edit"></i>Pegar</a>
      </li>
    </ul>
</div>

