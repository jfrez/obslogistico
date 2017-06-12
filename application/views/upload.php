<?php
$active=2;
include_once("header.php");
?>
<style>
body {
    margin: 0;
}
</style>
<div class="clear"></div>
     <div class="tabs-contenor">
     </div>
<div class="clear"></div>
  <div id="content">

<form action="/?/Prep/do_upload" enctype="multipart/form-data" method="post" accept-charset="utf-8">
<h4>Cargar CSV a preprarar</h4>
<input type="text" name="tablename" value="tmptable" class="input-text small input-error" />
<input  class="input-text small"  type="file" name="userfile" size="20" />


<input type="submit" class="button" value="upload" />

</form>
</div>

</div>
</body>
</html>
