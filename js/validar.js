var validador = {};


validador.exec=function(col,tabla){
	$.ajax({
			'url':'/?/Prep/getTable/SYS_'+tabla,
			dataType:"json",
			success:function(table){
			if(tabla.indexOf("periodos")>=0)$("#cell-"+1+"-"+col).html("periodo");
			if(tabla.indexOf("PAIS")>=0)$("#cell-"+1+"-"+col).html("pais");
			if(tabla.indexOf("REGION")>=0)$("#cell-"+1+"-"+col).html("region");
			if(tabla.indexOf("PROVINCIA")>=0)$("#cell-"+1+"-"+col).html("provincia");
			if(tabla.indexOf("COMUNA")>=0)$("#cell-"+1+"-"+col).html("periodo");
			var errors = false;
			for(var i=2;i<getrows();i++){
        		  var val = getVal(i,col);
		          var rowerror=true;
			  for(var j =0;j<table.length;j++){
			    if(val.trim()==table[j].original){
				$("#cell-"+i+"-"+col).html(table[j].print);
				rowerror=false;
			    }
			  }
			if(rowerror){
			  addError(i,col,tabla);	
			  $("#cell-"+i+"-"+col).addClass("error");
			  $("#cell-"+i+"-"+col).removeClass("correct");
			}else{
			  $("#cell-"+i+"-"+col).addClass("correct");
			  $("#cell-"+i+"-"+col).removeClass("error");
			}
			}
		}
	});
}

validador.anno=function(col,tabla){
				$("#cell-"+1+"-"+col).html("anno");
		validador.numeric(col,tabla);

}
validador.numeric=function(col,tabla){
			for(var i=2;i<getrows();i++){
        		  var val = getVal(i,col);
			if(!$.isNumeric( val ) ){
				console.log(val);
			  addError(i,col,tabla);	
			  $("#cell-"+i+"-"+col).addClass("error");
			}else{
			  $("#cell-"+i+"-"+col).addClass("correct");
			}
}

}




