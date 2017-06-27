String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};
var app={};
app.editcelllist = [];
app.editrowlist = [];
app.editcollist = [];
app.editing=true;
function dropdownizer(i){
dropdown ='<div class="dropdown"><button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">'+i+'<span class="caret"></span></button>    <ul class="dropdown-menu">      <li><a href="#">Per&iacute;odo</a></li>      <li><a href="#">A&ntilde;o</a></li>      <li><a href="#">Pa&iacute;s</a></li><li><a href="#">Regi&oacute;n</a></li><li><a href="#">Provincia</a></li><li><a href="#">Comuna</a></li>       </ul>  </div>';
return dropdown;
}


app.removeRows= function(){
	app.editrowlist.sort(function(a, b){return b-a});
	for(var e in app.editrowlist){
		app.removeRow(app.editrowlist[e]);
	}
	app.editrowlist = [];
}

app.removeCols= function(){
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
	$("#cell-"+row+"-"+col).html("<input maxlength='20' onblur='app.noeditcell("+row+","+col+")' class='cell' id='input-"+row+"-"+col+"' value='"+val+"'/>").focus();
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
	if(app.editing)addCommand("setVal("+row+","+col+',"'+val+'");');
	$("#cell-"+row+"-"+col).html(val);
}
app.getVal= function(row,col){
	return $("#cell-"+row+"-"+col).html();
}
app.replace= function(row,col,val,val2){
	if(app.editing)addCommand("replace("+row+","+col+',"'+val+'","'+val2+'");');
	text=$("#cell-"+row+"-"+col).html();
	text = text.replaceAll(val,val2);
	text=$("#cell-"+row+"-"+col).html(text);
}

app.addrow = function(){
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
	 if(app.editing)addCommand("addcol();");
	rows = document.getElementById("tabla").rows.length;
	cols=document.getElementById("tabla").rows[0].cells.length;
	console.log(cols);
	var tr = document.getElementById('tabla').tHead.children[0],
	    th = document.createElement('th');
	th.innerHTML =dropdownizer(cols-1);
			th.setAttribute("ondblclick","app.editcol("+(cols -1)+")");
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
		$("#row"+row).css("background-color","inherit");
	}else{
		$("#row"+row).css("background-color","#716D67");
		app.editrowlist.push(row);
	}
}
app.removeRow = function(row){
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
		$(".cellcol"+col).css("background-color","inherit");
		app.editcollist.splice(app.editcollist.indexOf(col),1);
	}else{
		$(".cellcol"+col).css("background-color","#716D67");
		app.editcollist.push(col);
	}
}
app.removeCol= function(col){
	 if(app.editing)addCommand("delCol("+col+");");
	rlength= document.getElementById("tabla").rows.length;
	var cols = document.getElementById("tabla").rows[0].cells.length;
	for(var i=1;i<=cols;i++){
		if(i>=col){
			newi=i-1;
			$("#col"+i).css("background-color","inherit");
			$("#col"+i).attr('ondblclick',"").unbind('click');
			$("#col"+i).attr('ondblclick',"app.editcol("+newi+")");
			$("#col"+i).addClass("cellcol"+newi);
			$("#col"+i).removeClass("cellcol"+i);
			$("#col"+i).html(dropdownizer(newi));
			$("#col"+i).attr('id',"col"+newi);
			for(var j=0;j<rlength;j++){
			$("#cell-"+j+"-"+i).attr("data-col",newi);
			$("#cell-"+j+"-"+i).addClass("cellcol"+newi);
			$("#cell-"+j+"-"+i).removeClass("cellcol"+i);
			$("#cell-"+j+"-"+i).attr('ondblclick',"").unbind('dblclick');
			$("#cell-"+j+"-"+i).attr('ondblclick',"app.edit("+j+","+newi+")");
			$("#cell-"+j+"-"+i).attr("id","cell-"+j+"-"+newi);

			}
		}
	}
	for(var i=0;i<rlength;i++){
		document.getElementById("tabla").rows[i].deleteCell(col);
	}

}
