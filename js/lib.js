function completeCol(col,startrow){
var anno=getVal(startrow,col);
for(i=startrow+1;i<getrows();i++){
if(getVal(i,col).length>0){
anno=getVal(i,col);
}
setVal(i,col,anno);
}

}

function delRowsFrom(row){
for(var i=getrows()-1;i>=row;i--)delRow(i);

}
