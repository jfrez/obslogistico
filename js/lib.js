function completeCol(col,startrow){
app.store();
	var anno=getVal(startrow,col);
	for(i=startrow+1;i<getrows();i++){
		if(getVal(i,col).length>0){
			anno=getVal(i,col);
		}
		setVal(i,col,anno);
	}

}

function delRowsFrom(row){
app.store();
	for(var i=getrows()-1;i>=row;i--)delRow(i);

}

function crop(irows,icols,rows,cols){
app.store();
	for(i=getrows()-1;i>0;i--){
	if(i>rows)delRow(i);
	if(i<irows)delRow(i);
	}
	for(j=getcols()-1;j>0;j--){
	if(j>cols)delCol(j);
	if(j<icols)delCol(j);
	}
}
function transpose(irows,icols,rows,cols){
app.store();
	var arr=[];
	var jj=0;
	var ii=0;
	for(j=irows;j<=rows;j++){
		arr[jj]=[];
		for(i=icols;i<=cols;i++){
			val = (getVal(j,i));
			$("#cell-"+j+"-"+i).html(val);	
			arr[jj][ii] = val;
			ii++;
		}
		jj++;
		ii=0;
	}
var arr2 = arr[0].map(function(col, i) { 
			return arr.map(function(row) { 
					return row[i] 
					}).reverse();
			});
                $("[id^=cell]").removeClass("selected2");
selected=Array();

	var jj=0;
	var ii=0;
	for(j=irows;j<irows+arr2.length;j++){
		for(i=icols;i<icols+arr2[0].length;i++){
			if(j>getrows())addrow();
			if(i>getcols())addcol();
			$("#cell-"+j+"-"+i).html(arr2[jj][ii]);	
                        $("#cell-"+j+"-"+i).addClass("selected2");
                selected.push($("#cell-"+j+"-"+i));
			downend=document.getElementById("#cell-"+j+"-"+i);
			ii++;
		}
		jj++;
		ii=0;
	}
}

