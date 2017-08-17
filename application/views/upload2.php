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
<form action="/?/Fuentes/do_upload" enctype="multipart/form-data" method="post" accept-charset="utf-8">
 <div class="form-group">
<h4>Seleccione nombre de la tabla</h4>
<input type="hidden" value="" id="steps" name="steps"/>
<input  placeholder="Nombre de la tabla" value="" type="text" id="prepname" name="prepname"/>
<select name="" class="input" id="select">
<option value="Nueva">Nuevo</option>
<?php foreach($prep as $p){?>
<option value="<?php echo $p['name']?>"><?php echo $p['name']?></option>
<?php } ?>
</select>
</div>
<hr/>
 <div class="form-group">
<h4>Archivo CSV a cargar</h4>
<input  class="input-text small"  type="file" name="userfile" size="20" />


<input type="submit" class="button btn btn-danger" value="Subir" />
<label>
 </label>
</form>



</div>

</div>
<script>
$(function(){

});
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

$("#select").change(function(){
$( "#select option:selected" ).each(function() {
	if($(this).text()=="Nuevo"){
	$("#prepname").val("");
	$("#prepname").fadeIn();
			$("#steps").val("");		
	}else{
	$("#prepname").fadeOut();
	$("#prepname").val($(this).text());
      getCode($( this ).text());

	}

    });

});

</script>

</body>
</html>
