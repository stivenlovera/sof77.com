<script type="text/javascript">
	function addNewRow()
	{
		var TABLE = document.getElementById("base");
		var TROW = document.getElementById("example");				
		var newRow = TABLE.insertRow(-1);
		newRow.className = TROW.attributes['class'].value;
		var newRow2 = TABLE.insertRow(-1);
		newRow2.className = TROW.attributes['class'].value;
		copyRow(content,newRow2);
	}
	function addNewRow1()
	{	
		var TABLE = document.getElementById("base");
		//var TROW = document.getElementById("example");		
		//var content = TROW.getElementsByTagName("td");
		//alert(TABLE.rows.length+"   "+ultima_fila);
		var newRow = TABLE.insertRow(-1);
		//newRow.className = TROW.attributes['class'].value;		
		copyRow(newRow);		
		/*alert(TABLE.rows.length+"   "+ultima_fila);
		document.IModTelefonos.denominacion[ultima_fila-1].value='';
		document.IModTelefonos.numeros[ultima_fila-1].value='';
		document.IModTelefonos.tel_id[ultima_fila-1].value='';
		//document.IModTelefonos.num_fila[ultima_fila-1].value=ultima_fila;*/				
		ultima_fila++;
	}
	function removeLastRow() 
	{
		var TABLE = document.getElementById("base");
		if(TABLE.rows.length > 1) 
		{
			TABLE.deleteRow(TABLE.rows.length-1);
			//TABLE.deleteRow(TABLE.rows.length-1);
			ultima_fila--;
		}
	}	
	function removeRow(evento,row) 
	{
		//alert(row);		
		var TABLE = document.getElementById("base");
		//alert (TABLE.rows[row].cells[2].innerHTML);
		if(TABLE.rows.length > 1) 
		{
			TABLE.deleteRow(row);
			//TABLE.deleteRow(row);
			ultima_fila--;
			i=row
			while ( i < ultima_fila) 
			{
				TABLE.rows[i].cells[2].innerHTML="<img src='../imagenes/icon_contraer.gif' name='icono_eliminar' onClick='removeRow(event,"+(i)+")' alt='Remover Numero "+(i)+"'>";
				i++
			}
		}
	}		
	function copyRow(Trow) 
	{
		/*var cnt = 0;
		for (; cnt < content.length-1; cnt++) 
		{
			appendCell(Trow, content[cnt].innerHTML);
		}*/
		appendCell(Trow, "<input name='denominacion' type='text' size='30' id='deno_id' value=''>"	);
		appendCell(Trow, "<input name='numeros' type='text' size='13' id='numero_id' value=''><input name='tel_id' type='hidden' size='13' id='tel_id_id' value='-3'>");		
		appendCell(Trow, "<img src='../imagenes/icon_contraer.gif' name='icono_eliminar' onClick='removeRow(event,"+(ultima_fila)+")' alt='Remover Numero "+(ultima_fila)+"'>");
	}
	function appendCell(Trow, txt) 
	{
		var newCell = Trow.insertCell(Trow.cells.length)
		newCell.innerHTML = txt
	}
	//remarca la fila sobre la que este el puntero del raton
function enciende(fila_origen,indice) 
{
    //alert(fila_origen+"    "+indice);
   	var fila = fila_origen+indice
   	if ( eval(indice+'!='+fila_origen+'_click') )
	{   
	   if (document.getElementById) { 
		  objeto_fila = document.getElementById( fila ) 
	   } else if (document.all) { 
		  objeto_fila = document.all[ fila ]
	   }
	   objeto_fila.style.background = '#EDF1D5'	   
	}
}
//desmarca la fila al salir el puntero de ella
function apaga(fila_origen,indice ) 
{   

   	var fila = fila_origen+indice
   	if ( eval(indice+'!='+fila_origen+'_click') )
	{  
		if ( (indice%2)==0 )
			color_backup='#EBEEF1';
		else
			color_backup='White';
			
	   if (document.getElementById) { 
		  objeto_fila = document.getElementById( fila ) 
	   } else if (document.all) { 
		  objeto_fila = document.all[ fila ] 
	   }
	   objeto_fila.style.background = color_backup
	   objeto_fila.style.color = '#000000' 
	}
}
function click_en_fila(fila_origen,indice) 
{	
	var fila = fila_origen+indice		
	var fila_anterior=0
   	if (document.getElementById) 
	{ 
		  objeto_fila = document.getElementById( fila ) 
	} 
	else if (document.all) 
	{ 
		  objeto_fila = document.all[ fila ]
	}
	objeto_fila.style.background = '#89A3D1'	
	objeto_fila.style.color = '#FFFFFF'
	
	eval('fila_anterior='+fila_origen+'_click');	   
	eval(fila_origen+'_click='+indice);
	if (fila_anterior!=-1)
		apaga(fila_origen,fila_anterior );	

}

</script>