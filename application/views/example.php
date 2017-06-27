<!DOCTYPE html>
<?php
$active=3;
include_once("header.php");
?>
<style>
body {
    margin: 0;
}
</style>
<div class="clear"></div>
<hr/>
     <div class="tabs-contenor">
		<a class="button" href='<?php echo site_url('Mantenedor/periodo')?>'>Periodos</a> |
		<a class="button" href='<?php echo site_url('Mantenedor/comuna')?>'>Comuna</a> |
		<a class="button" href='<?php echo site_url('Mantenedor/provincia')?>'>Provincia</a> |
		<a class="button" href='<?php echo site_url('Mantenedor/region')?>'>Region</a> |
		<a class="button" href='<?php echo site_url('Mantenedor/pais')?>'>Pais</a> |
		<a class="button" href='<?php echo site_url('Mantenedor/Unidad')?>'>Unidad</a> 
		<a class="button" href='<?php echo site_url('Mantenedor/Preparation')?>'>Preparaciones</a> 
	
	</div>
  <div id="content">

<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</head>
<body>
	<div>
	
	</div>
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
    </div>
</body>
</html>
