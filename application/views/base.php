<?php
$active=1;
include_once("header.php");

function starts($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}
?>
<link rel="stylesheet" href="/assets/google/css/bootstrap.min.css">
<link rel="stylesheet" href="/assets/google/css/bootstrap-theme.css">
<link rel="stylesheet" href="/assets/google/css/todc-bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
body {
    margin: 0;
}
.box{
	width:auto;
	float:left;
	margin:10px;

}
#columns {
	-webkit-column-count: 3;
	-webkit-column-gap: 10px;
	-webkit-column-fill: auto;
	-moz-column-count: 3;
	-moz-column-gap: 10px;
	-moz-column-fill: auto;
	column-count: 3;
	column-gap: 15px;
	column-fill: auto;
}
.pin {
	display: inline-block;
	-webkit-column-break-inside: avoid;
	-moz-column-break-inside: avoid;
	column-break-inside: avoid;
	opacity: 1;
	
	-webkit-transition: all .2s ease;
	-moz-transition: all .2s ease;
	-o-transition: all .2s ease;
	transition: all .2s ease;
}

</style>
<div class="tabs-contenor"></div>
<div class="row">
<a href="/?/Prep/" class=" col-md-12 btn btn-primary">Agregar/Actualizar</a>
</div>
	<div id="columns">
<?php

foreach($tables as $n => $t){
echo "<div class='tabla pin box panel panel-default'>";
echo '<div class="panel-heading">';
$tooltip="";
foreach($t['desc'] as $f){
if(starts($f['Field'],"SYS")){
if($t['count'][0][$f['Field']]>1){
$tooltip .= $f['Field']."<br>";
}
}
}

echo "<h3 lass='panel-title'><a href='/?/Prep/getTable/$n' target='_blank'>".$n."</a><span class='badge'>".$t['count'][0]['id']."</span><a class='glyphicon glyphicon-info-sign' data-toggle='tooltip' data-html='true' data-placement='bottom' title='$tooltip'></a></h3>";
echo "</div>";
echo '<div class="panel-body">';
echo '<ul class="list-group">';
foreach($t['desc'] as $f){
if(!starts($f['Field'],"SYS")){
echo '<li class="list-group-item"><h5><a class="" href="#" data-toggle="tooltip2" data-html="true" data-placement="bottom" title="descripción">'.$f['Field'].' <span class="badge">'.$f['Type'].'</span></a></h5></li>';
}
}
echo "</ul>";
echo "</div>";
echo "</div>";
echo "</div>";
}

?>
</div>
</div>
</div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
