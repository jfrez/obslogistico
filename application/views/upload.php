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
<input type="hidden" value="" id="steps" name="steps"/>
<select name="tablename" class="input" id="prepname">
<option value="Nueva">Nueva</option>
<?php foreach($prep as $p){?>
<option value="<?php echo $p['name']?>"><?php echo $p['name']?></option>
<?php } ?>
</select>
<input  class="input-text small"  type="file" name="userfile" size="20" />


<input type="submit" class="button" value="upload" />

</form>



</div>

</div>
<script>
function getCode(prep){
	$.ajax({
			url:'/?/Prep/getPreparationsCode/'+prep,
			dataType:"json",
			success:function(data){
			console.log(data);
			$("#steps").val(data[0].code);		

			}
			});
}

$("#prepname").change(function(){
$( "#prepname option:selected" ).each(function() {
      getCode($( this ).text());
    });

});

</script>

</body>
</html>
