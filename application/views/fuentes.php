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
     <div class="tabs-contenor">
       <div class="tabs_links">
           <ul>
               <li><a href="#upload">Carga de CSV</a></li>
               <li><a href="#tablas">Mantenedores</a></li>
           </ul>
       </div>
     </div>
<div class="clear"></div>
  <div id="content">
<div class="tab_content" id="upload"  >

<form action="/?/Fuentes/do_upload" enctype="multipart/form-data" method="post" accept-charset="utf-8">
<h2>Cargar CSV</h2>
<div class="form-row">
<samp>Columna Mes</samp>
<input type="text" name="periodo" value="periodo" class="input-text small" />
</div>
<div class="form-row">
<samp>Columna Datetime</samp>
<input type="text" name="datetime" value="fecha" class="input-text small" />
</div>
<div class="form-row">
<samp>Columna Año</samp>
<input type="text" name="periodoano" value="anno" class="input-text small input-error" />
</div>
<div class="form-row">
<samp>Tabla</samp>
<input type="text" name="tablename" value="tmptable" class="input-text small input-error" />
<input  class="input-text small"  type="file" name="userfile" size="20" />
</div>


<input type="submit" class="button" value="upload" />

</form>

</div>
<div class="tab_content" id="tablas"  >
<p style="color:red;"><b><?php if(isset($error))echo $error;?></b></p>
<div class="clear"></div>
<ul>
<?php 
foreach( $tables as $row){
echo "<li>".$row['Tables_in_ObsLogistico']."</li>";	
}
?>
</ul>
</div>

</div>
</body>
</html>
