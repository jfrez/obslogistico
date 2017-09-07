function dropdownizer(i){
	var txt = '<div class="dropdown pull-right"><button class="btn btn-xs myFakeClass  dropdown-toggle" type="button"  style="float:left;"><span class="glyphicon glyphicon-cog"></span></button><ul class="dropdown-menu" style="min-width:200px;"><li><input data-role="tagsinput" type="text" name="columnas'+i+'" id="columnas'+i+'" class="form-control atributes" data-col="'+i+'"></li><li><a class=" pull-rigth glyphicon glyphicon-ok-circle" href="#" onclick="validar('+i+',\'numeric\')">Numerico</a></li><li><a href="#" onclick="validar('+i+',\'periodos\')" class="glyphicon glyphicon-ok-circle"  >Periodo</a></li><li><a class="glyphicon glyphicon-ok-circle" href="#" onclick="validar('+i+',\'anno\')">Año</a></li> <li><a href="#" onclick="validar('+i+',\'PAIS_VIEW\')" class="glyphicon glyphicon-ok-circle" >País</a></li><li><a class="glyphicon glyphicon-ok-circle" href="#" onclick="validar('+i+',\'REGION_VIEW\')">Región</a></li><li><a class="glyphicon glyphicon-ok-circle" href="#" onclick="validar('+i+',\'PROVINCIA_VIEW\')" >Provincia</a></li><li><a class="glyphicon glyphicon-ok-circle"  href="#" onclick="validar('+i+',\'COMUNA_VIEW\')" >Comuna</a></li> <li><a href="#" onclick="validar('+i+',\'LUGAR_VIEW\')" class="glyphicon glyphicon-ok-circle" >Lugar<input  type="text" name="tipo'+i+'" id="tipo'+i+'" class="form-control"></a></li></ul>  </div>';
	var ret = "<b style='font-size:19px;float:left;'>"+i+"</b>"+txt;
	return ret;
}
String.prototype.replaceAll = function(search, replacement) {
	var target = this;
	return target.split(search).join(replacement);
};
var app={};
app.editcelllist = [];
app.editrowlist = [];
app.editcollist = [];
app.editing=true;
app.tabledata = [];
app.store = function(){
	if(document.getElementById('well').innerHTML!=app.tabledata[app.tabledata.length-1])
		app.tabledata.push(document.getElementById('well').innerHTML);
}
app.undo =function(){
	addCommand("undo();");
	undo();
}
app.complete = function(){
	icol = parseInt($(downstart).attr("data-col"));
	irow = parseInt($(downstart).attr("data-row"));
	completeCol(icol,irow);
	addCommand("completeCol("+icol+","+irow+");");
}
app.removeRows= function(){
	if(app.editing)app.store();
	app.editrowlist.sort(function(a, b){return b-a});
	for(var e in app.editrowlist){
		app.removeRow(app.editrowlist[e]);
	}
	app.editrowlist = [];
	app.recalc();
}
app.transpose= function(){
	if(app.editing)app.store();
	icol = parseInt($(downstart).attr("data-col"));
	irow = parseInt($(downstart).attr("data-row"));
	ecol = parseInt($(downend).attr("data-col"));
	erow = parseInt($(downend).attr("data-row"));
	app.editing=false;
	transpose(irow,icol,erow,ecol);
	app.editing=true;
	addCommand("transpose("+irow+","+icol+","+erow+","+ecol+");");
	app.recalc();
}
app.crop= function(){
	if(app.editing)app.store();
	icol = parseInt($(downstart).attr("data-col"));
	irow = parseInt($(downstart).attr("data-row"));
	ecol = parseInt($(downend).attr("data-col"));
	erow = parseInt($(downend).attr("data-row"));
	addCommand("crop("+irow+","+icol+","+erow+","+ecol+");");
	app.editing=false;
	crop(irow,icol,erow,ecol);
	app.editing=true;
	app.recalc();
}
app.removeCols= function(){
	if(app.editing)app.store();
	app.editcollist.sort(function(a, b){return b-a});

	for(var e in app.editcollist){
		app.removeCol(app.editcollist[e]);
	}
	app.editcollist = [];
	app.recalc();
}


app.noedit = function(){
	for(var e in app.editrowlist){
		var aux = app.editrowlist[e];
	}
	app.editrowlist = [];


	for(var e in app.editcollist){
		var aux = app.editcollist[e];
	}
	app.editcollist = [];

};

app.edit = function(row,col){
	app.noedit();
	var val = $("#cell-"+row+"-"+col+" ").text();
	$("#cell-"+row+"-"+col).html("<input  maxlength='255' onblur='app.noeditcell("+row+","+col+")' class='cell' id='input-"+row+"-"+col+"' value='"+val+"'/>").focus();
	$("#input-"+row+"-"+col).focus();
	$("#input-"+row+"-"+col).keypress(function(e) {
			if(e.which == 13) {
			$("#input-"+row+"-"+col).attr('onblur',"").unbind('onblur');

			app.noeditcell(row,col);
			}
			});
	app.editcelllist.push({row:row,col:col});
};

app.noeditcell= function(row,col){
	app.setVal(row,col,$("#input-"+row+"-"+col).val());
}
app.setVal= function(row,col,val){
	if(app.editing)app.store();
	if(app.editing)addCommand("setVal("+row+","+col+',"'+val+'");');
	$("#cell-"+row+"-"+col).html(val);
}
app.getVal= function(row,col){
	return $("#cell-"+row+"-"+col).html();
}
app.replace2= function(){
	icol = parseInt($(downstart).attr("data-col"));
	ecol = parseInt($(downend).attr("data-col"));
	var val1 = prompt("Buscar","");
	var val2 = prompt("Reemplazar por","");
	for(var i=icol;i<=ecol;i++){
		app.replace(i,val1,val2);
	}
}
app.replace= function(col,val,val2){
	if(app.editing)addCommand("replace("+col+',"'+val+'","'+val2+'");');
	for(var i=1;i<getrows();i++){
		text=$("#cell-"+i+"-"+col).html();
		text = text.replaceAll(val,val2);
		text=$("#cell-"+i+"-"+col).html(text);
	}
}
app.setColumns = function(val){
	if(app.editing)addCommand('setColumns("'+val+'");');
if(!app.editing){
	$("#columnas").tagsinput("removeAll");
$("#columnas").tagsinput("add",val);
}}
app.setColumn = function(col,val){
	if(app.editing)addCommand('setColumn('+col+',"'+val+'");');
if(!app.editing){
$("#columnas"+col).tagsinput("removeAll");
$("#columnas"+col).tagsinput("add",val);
}
}
app.addrow = function(){
	if(app.editing)app.store();
	if(app.editing)addCommand("addrow();");
	rows = document.getElementById("tabla").rows.length;
	cols=document.getElementById("tabla").rows[0].cells.length
		r =document.getElementById("tabla").insertRow(rows);
	r.setAttribute("class","r");
	r.setAttribute("id","row"+rows);
	for(var i=0;i<cols;i++){
		cell=r.insertCell(i);
		if(i==0){
			cell.innerHTML=rows;
			cell.setAttribute("ondblclick","app.editrow("+rows+")");
		}else if(i>0){
			cell.setAttribute("ondblclick","app.edit("+rows+","+i+")");
			cell.setAttribute("data-row",rows);
			cell.setAttribute("data-col",i);
			cell.setAttribute("class","cellcol"+i+" cellrow"+rows);
			cell.setAttribute("ondblclick","app.edit("+rows+","+i+")");
			cell.id= "cell-"+rows+"-"+i; 
		}
	}
	if(app.editing)app.recalc();
}
app.addcol= function(){
	if(app.editing)app.store();
	if(app.editing)addCommand("addcol();");
	rows = document.getElementById("tabla").rows.length;
	cols=document.getElementById("tabla").rows[0].cells.length-1;
	var tr = document.getElementById('tabla').tHead.children[0],
	th = document.createElement('th');
	th.innerHTML =dropdownizer(cols);
	th.setAttribute("id","col"+(cols));
	th.setAttribute("data-col",(cols));
	th.setAttribute("class","cellcol"+(cols));
	th.setAttribute("ondblclick","app.editcol("+(cols)+")");
	th.setAttribute("style","min-width:100px;");
	tr.appendChild(th);
	for(var i=1;i<rows;i++){
		cell=document.getElementById("tabla").rows[i].insertCell(cols-1);
		cell.setAttribute("data-row",i);
		cell.setAttribute("data-col",(cols));
		cell.setAttribute("class","cellcol"+(cols)+" cellrow"+i);
		cell.setAttribute("ondblclick","app.edit("+i+","+(cols)+")");
		cell.id= "cell-"+i+"-"+(cols); 
	}
	if(app.editing)app.recalc();
}
app.editrow = function(row){
	if(app.editrowlist.indexOf(row)>-1){
		app.editrowlist.splice(app.editrowlist.indexOf(row),1);
	}else{
		for(var i = 0;i<getcols();i++){
			selected.push($("#cell-"+row+"-"+i));
		}
		app.editrowlist.push(row);
	}
}
app.recalc = function(){

	for(var i=0;i<$(".r").length;i++){
		index=i;
		var td = $($(".r")[i]).children();
		for(var col=0;col<$($(".r")[0]).children().length;col++){
			if(i==0){
				var th = document.getElementById("tabla").rows[0].cells[col];
				if(col>0){
					th.innerHTML=dropdownizer(col);
					th.id = "col"+col;
					$(th).css("background-color","lightgrey");
					$(th).attr('ondblclick',"").unbind('click');
					$(th).attr('ondblclick',"app.editcol("+col+")");
					$(th).attr("data-col",col);
					$(th).attr("class","cellcol"+col);
					$(th).attr("style","min-width: 150px;");
				}
				$('#columnas'+col).tagsinput({trimValue: true});
				$("#columnas"+col).on("itemAdded", function(event) {
						val = $(event.currentTarget).val();
						col2 = event.currentTarget.dataset.col;
						if(app.editing)
						app.setColumn(col2,val);
						});
				$("#columnas"+col).on("itemRemoved", function(event) {
						val = $(event.currentTarget).val();
						col2 = event.currentTarget.dataset.col;
						if(app.editing)
						app.setColumn(col2,val);
						}); 
			}
				if(col==0){
					$(td[col]).html(index+1);
					$(td[col]).attr("class","rows editrow"+(index+1));
					$(td[col]).attr("id","rowindex"+(index+1));
					$(td[col]).attr("data-row",(index+1));
					$(td[col]).attr('ondblclick',"").unbind('dblclick');
					$(td[col]).attr("ondblclick","app.editrow("+(index+1)+")");
				
				}else{
					$(td[col]).attr("id","cell-"+(index+1)+"-"+col);
					$(td[col]).attr("data-row",(index+1));
					$(td[col]).attr("data-col",(col));
					$(td[col]).attr("class","cellcol"+(col)+" cellrow"+(index+1));
					$(td[col]).attr('ondblclick',"").unbind('dblclick');
					$(td[col]).attr('ondblclick',"app.edit("+(index+1)+","+col+")");

				}
		}
	}


}
app.removeRow = function(row){
	try{
	if(app.editing)app.store();
	if(app.editing)addCommand("delRow("+row+");");
	document.getElementById("tabla").deleteRow(row);


	}catch(err){}
}
app.editcol = function(col){
	if(app.editcollist.indexOf(col)>-1){
		app.editcollist.splice(app.editcollist.indexOf(col),1);
	}else{
		app.editcollist.push(col);
	}
}
app.removeCol= function(col){
	if(app.editing)app.store();
	if(app.editing)addCommand("delCol("+col+");");
	rlength= document.getElementById("tabla").rows.length;
	for(var i=0;i<rlength;i++){
	try{
		document.getElementById("tabla").rows[i].deleteCell(col);
	}catch(err){}
	}
	$('.dropdown-toggle').on('click', function (event) {
			$(this).parent().toggleClass('open');
			});	
}
