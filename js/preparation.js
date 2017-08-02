function dropdownizer(i){
	var txt = '<div class="dropdown pull-right"><button class="btn btn-xs myFakeClass  dropdown-toggle" type="button"  style="float:left;"><span class="glyphicon glyphicon-cog"></span></button><ul class="dropdown-menu" style="min-width:200px;"><li><a href="#" onclick="validar('+i+',\'numeric\')">Numerico</a></li><li><a href="#" onclick="validar('+i+',\'periodos\')">Periodo</a></li><li><a href="#" onclick="validar('+i+',\'anno\')">Anno</a></li> <li><a href="#" onclick="validar('+i+',\'PAIS_VIEW\')">Pais</a></li><li><a href="#" onclick="validar('+i+',\'REGION_VIEW\')">Region</a></li><li><a href="#" onclick="validar('+i+',\'PROVINCIA_VIEW\')" >Provincia</a></li><li><a href="#" onclick="validar('+i+',\'COMUNA_VIEW\')" >Comuna</a></li> <li><input data-role="tagsinput" type="text" name="columnas'+i+'" id="columnas'+i+'" class="form-control atributes" data-col="'+i+'"></li> </ul>  </div>';
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
	app.store();
	app.editrowlist.sort(function(a, b){return b-a});
	for(var e in app.editrowlist){
		app.removeRow(app.editrowlist[e]);
	}
	app.editrowlist = [];
}
app.transpose= function(){
	app.store();
	icol = parseInt($(downstart).attr("data-col"));
	irow = parseInt($(downstart).attr("data-row"));
	ecol = parseInt($(downend).attr("data-col"));
	erow = parseInt($(downend).attr("data-row"));
	transpose(irow,icol,erow,ecol);
	addCommand("transpose("+irow+","+icol+","+erow+","+ecol+");");
}
app.crop= function(){
	app.store();
	icol = parseInt($(downstart).attr("data-col"));
	irow = parseInt($(downstart).attr("data-row"));
	ecol = parseInt($(downend).attr("data-col"));
	erow = parseInt($(downend).attr("data-row"));
	crop(irow,icol,erow,ecol);
	addCommand("crop("+irow+","+icol+","+erow+","+ecol+");");

}
app.removeCols= function(){
	app.store();
	app.editcollist.sort(function(a, b){return b-a});

	for(var e in app.editcollist){
		app.removeCol(app.editcollist[e]);
	}
	app.editcollist = [];
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
	app.store();
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
}
app.setColumn = function(col,val){
	if(app.editing)addCommand('setColumn('+col+',"'+val+'");');
}
app.addrow = function(){
	app.store();
	if(app.editing)addCommand("addrow();");
	rows = document.getElementById("tabla").rows.length;
	cols=document.getElementById("tabla").rows[0].cells.length
		r =document.getElementById("tabla").insertRow(rows);
	r.setAttribute("class","row");
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
}
app.addcol= function(){
	app.store();
	if(app.editing)addCommand("addcol();");
	rows = document.getElementById("tabla").rows.length;
	cols=document.getElementById("tabla").rows[0].cells.length;
	console.log(cols);
	var tr = document.getElementById('tabla').tHead.children[0],
	th = document.createElement('th');
	th.innerHTML =dropdownizer(cols-1);
	th.setAttribute("id","col"+(cols -1));
	th.setAttribute("data-col",(cols -1));
	th.setAttribute("class","cellcol"+(cols -1));
	th.setAttribute("ondblclick","app.editcol("+(cols -1)+")");
	th.setAttribute("style","min-width:100px;");
	tr.appendChild(th);
	for(var i=1;i<rows;i++){
		cell=document.getElementById("tabla").rows[i].insertCell(cols-1);
		cell.setAttribute("data-row",i);
		cell.setAttribute("data-col",(cols-1));
		cell.setAttribute("class","cellcol"+(cols-1)+" cellrow"+i);
		cell.setAttribute("ondblclick","app.edit("+i+","+(cols-1)+")");
		cell.id= "cell-"+i+"-"+(cols-1); 
	}
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
app.removeRow = function(row){
	app.store();
	if(app.editing)addCommand("delRow("+row+");");
	$(".row").each(function(index){
			if(index>row){
			var cols = document.getElementById("tabla").rows[row].cells.length;
			nindex=index-1;
			$(".editrow"+index).addClass("editrow"+nindex);
			$(".editrow"+index).removeClass("editrow"+index);
			$("#rowindex"+index).html(nindex);
			$("#rowindex"+index).attr("data-row",nindex);
			$("#rowindex"+index).attr('ondblclick',"").unbind('dblclick');
			$("#rowindex"+index).attr('ondblclick',"app.editrow("+nindex+")");
			$("#rowindex"+index).attr("id","rowindex"+nindex);
			for(var i =0;i<cols;i++){
			$("#cell-"+index+"-"+i).attr("data-row",nindex);
			$("#cell-"+index+"-"+i).addClass("cellrow"+nindex);
			$("#cell-"+index+"-"+i).removeClass("cellrow"+index);
			$("#cell-"+index+"-"+i).attr('ondblclick',"").unbind('dblclick');
			$("#cell-"+index+"-"+i).attr('ondblclick',"app.edit("+nindex+","+i+")");
			$("#cell-"+index+"-"+i).attr("id","cell-"+nindex+"-"+i);
			}
			$("#row"+index).attr("id","row"+nindex);
			}


	});
	document.getElementById("tabla").deleteRow(row);



}
app.editcol = function(col){
	if(app.editcollist.indexOf(col)>-1){
		app.editcollist.splice(app.editcollist.indexOf(col),1);
	}else{
		app.editcollist.push(col);
	}
}
app.removeCol= function(col){
	app.store();
	if(app.editing)addCommand("delCol("+col+");");
	rlength= document.getElementById("tabla").rows.length;
	var cols = document.getElementById("tabla").rows[0].cells.length;
	for(var i=0;i<rlength;i++){
		document.getElementById("tabla").rows[i].deleteCell(col);
	}
	var cols = document.getElementById("tabla").rows[0].cells.length;
	for(var i=1;i<cols;i++){
		var th = document.getElementById("tabla").rows[0].cells[i+1];
		if(typeof th != "undefined"){
			if(i>0)th.innerHTML=dropdownizer(i);
			th.id = "col"+i;
			$(th).css("background-color","lightgrey");
			$(th).attr('ondblclick',"").unbind('click');
			$(th).attr('ondblclick',"app.editcol("+i+")");
			$(th).attr("data-col",i);
			$(th).attr("class","cellcol"+i);
			$(th).attr("style","min-width: 150px;");

			$('#columnas'+i).tagsinput({
trimValue: true
});
$("#columnas"+i).on("itemAdded", function(event) {
console.log(event);
val = $(event.currentTarget).val();
col = event.currentTarget.dataset.col;
		app.setColumn(col,val);
		});
$("#columnas"+i).on("itemRemoved", function(event) {
val = $(event.currentTarget).val();
col = event.currentTarget.dataset.col;
		app.setColumn(col,val);
		}); 
for(var j=1;j<rlength;j++){
	var cell = document.getElementById("tabla").rows[j].cells[i];
	$(cell).attr("data-col",i);
	$(cell).attr('ondblclick',"").unbind('dblclick');
	$(cell).attr('ondblclick',"app.edit("+j+","+i+")");
	$(cell).attr("class","cellcol"+i+" cellrow"+j);
	cell.id = "cell-"+j+"-"+i;

}


}
}
$('.dropdown-toggle').on('click', function (event) {
		$(this).parent().toggleClass('open');
		});	

}
