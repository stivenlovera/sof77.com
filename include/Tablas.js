function Objeto_Tabla (ID, Nombre, Color_Fila_Par, Color_Texto_Fila_Par, Color_Fila_Impar,  Color_Texto_Fila_Impar , Color_Fila_Click, Color_Texto_Fila_Click, Color_Fila_Move, Color_Texto_Fila_Move) 
	{
	    this.ID = ID;
    	this.Nombre = Nombre;
		this.Color_Fila_Par = Color_Fila_Par;		
		this.Color_Texto_Fila_Par = Color_Texto_Fila_Par;
		
		this.Color_Fila_Impar = Color_Fila_Impar;	
		this.Color_Texto_Fila_Impar = Color_Texto_Fila_Impar;
		
		this.Color_Fila_Click = Color_Fila_Click;
		this.Color_Texto_Fila_Click = Color_Texto_Fila_Click;

		this.Color_Fila_Move = Color_Fila_Move;
		this.Color_Texto_Fila_Move = Color_Texto_Fila_Move;

    	this.Indices_de_Filas_Clickeadas = new Array (1000);//Guarda los indices de la(s) fila(s) con click activo
		this.Indices_de_Filas_Clickeadas[0] = -1;
		this.Todas=false;
		this.Se_Esta_Editando=false;
		this.Cuantas_en_Edicion=0;
		
		this.Enciende_Fila_MouseMove=Enciende_Fila_MouseMove; //Pinta la Fila en la que le mouse se moueve
		this.Apaga_Fila_No_Clickeada=Apaga_Fila_No_Clickeada; //DesPinta la Fila 
		this.Apagar_Todas_Las_Filas_Clickeadas=Apagar_Todas_Las_Filas_Clickeadas; //DesPinta Todas Fila 		
		this.Enciende_Fila_MouseClick=Enciende_Fila_MouseClick; //Pinta la Fila Clickeada	
		this.Esta_Fila_Esta_Clickeada=Esta_Fila_Esta_Clickeada;
		this.Apagar_Cualquier_Fila=Apagar_Cualquier_Fila;
		this.Ultima_Fila_Clickeadas=Ultima_Fila_Clickeadas;
		this.Averiguar_Evento=Averiguar_Evento;	
		this.Marcar_Todas=Marcar_Todas;	
		this.setDataType=setDataType;
		this.sortTable=sortTable;
	} ;	
	function Marcar_Todas(valor)
	{
		//alert("llego");
		var y1=1;
		var yx1=0;
		if (valor)
		{
			while (y1<this.Indices_de_Filas_Clickeadas.length)
			{
					fila = this.ID+"_"+y1;
					if (document.getElementById) 
					{ 
						  objeto_fila = document.getElementById( fila ) ;
					} 
					else if (document.all) 
					{ 
						  objeto_fila = document.all[ fila ];
					}	
					if (objeto_fila!= undefined)
					{
						//alert("pintando fila : "+y1 + "guardando numero de fila pintada en filas_clikeada posicion : "+yx1);
						objeto_fila.style.background = this.Color_Fila_Click;
						objeto_fila.style.color = this.Color_Texto_Fila_Click;
						this.Indices_de_Filas_Clickeadas[yx1]=y1;		
						yx1++;
					}
					y1++;						
				}					
		}
		else
		{			
			this.Apagar_Todas_Las_Filas_Clickeadas();  			
		}
	}
	function Esta_Fila_Esta_Clickeada(indice)
	{
		var xi=0;
		var estoy_clickeado= false;
		while (xi<this.Indices_de_Filas_Clickeadas.length)
		{
			if (indice==this.Indices_de_Filas_Clickeadas[xi]) 
			{
				estoy_clickeado=true;
				//alert(indice+"  ****  "+xi+"  ***  "+this.Indices_de_Filas_Clickeadas[xi]);
			}
			xi++;
		}
		return estoy_clickeado;
	}
	function Enciende_Fila_MouseMove(indice) 
	{
		var fila = this.ID+"_"+indice;	
		if (!this.Esta_Fila_Esta_Clickeada(indice) )
		{   
		   if (document.getElementById) 
		   { 
			  objeto_fila = document.getElementById( fila ) 
		   } 
		   else if (document.all) 
		   { 
			  objeto_fila = document.all[ fila ];
		   }
		   objeto_fila.style.background = this.Color_Fila_Move;
		   objeto_fila.style.color = this.Color_Texto_Fila_Move;		   
		}
	}	
	function Apaga_Fila_No_Clickeada(indice) 
	{   	
		var fila = this.ID+"_"+indice;				
		//alert(indice+"  ****  "+this.Esta_Fila_Esta_Clickeada(indice));
		if (!this.Esta_Fila_Esta_Clickeada(indice) )
		{   				
		   this.Apagar_Cualquier_Fila(indice); 
		}
	}
	function Apagar_Cualquier_Fila(indice) 
	{   	
		var fila = this.ID+"_"+indice;				
		//alert(indice+"  ****  "+this.Esta_Fila_Esta_Clickeada(indice));
	   if (document.getElementById) 
	   { 
		  objeto_fila = document.getElementById( fila ); 
	   } 
	   else if (document.all) 
	   { 
		  objeto_fila = document.all[ fila ]; 
	   }
	   if (objeto_fila!= undefined)
	   {
		   //alert("apagando fila: "+indice);
		   if ( (indice%2)==0 )
		   {
			   objeto_fila.style.background = this.Color_Fila_Par;
			   objeto_fila.style.color = this.Color_Texto_Fila_Par; 
		   }
		   else
		   {
			   objeto_fila.style.background = this.Color_Fila_Impar;
			   objeto_fila.style.color = this.Color_Texto_Fila_Impar; 			   
		   }		   
	   }

	}
	
	function Apagar_Todas_Las_Filas_Clickeadas() 
	{   
		var xi=0;
		while (xi<this.Indices_de_Filas_Clickeadas.length)
		{
			if ( (this.Indices_de_Filas_Clickeadas[xi]!= undefined ) && (this.Indices_de_Filas_Clickeadas[xi]!='') )
			{
				if (this.Indices_de_Filas_Clickeadas[xi]!=-1)
				{
					this.Apagar_Cualquier_Fila(this.Indices_de_Filas_Clickeadas[xi]);
					this.Indices_de_Filas_Clickeadas[xi]= '';
				}
			}	
			xi++;
		}
		this.Indices_de_Filas_Clickeadas[0]=-1;
	}
	function Averiguar_Evento(e)
	{
		var ctrlPressed=0;
		var altPressed=0;
		var shiftPressed=0;		
		if (parseInt(navigator.appVersion)>3) 
		{			
			  var evt = navigator.appName=="Netscape" ? e:event;			
			  if (navigator.appName=="Netscape" && parseInt(navigator.appVersion)==4) 
			  {
				  // NETSCAPE 4 CODE
				  var mString =(e.modifiers+32).toString(2).substring(3,6);
				  shiftPressed=(mString.charAt(0)=="1");
				  ctrlPressed =(mString.charAt(1)=="1");
				  altPressed  =(mString.charAt(2)=="1");				 
			  }
			  else 
			  {
				  // NEWER BROWSERS [CROSS-PLATFORM]
				  shiftPressed=evt.shiftKey;
				  altPressed  =evt.altKey;
				  ctrlPressed =evt.ctrlKey;				 
			  }
			  if (shiftPressed )
			  {
					 return "Shift"; 
			  }
			  else		  
				  if (ctrlPressed)
				  {
						return "Ctrl";
				  }
				  else
					  if (altPressed)
					  {
							return "Alt";
					  }
					  else
					  {
						  	return "";
					  }				  
		}
	}
	function Ultima_Fila_Clickeadas() 
	{   
		var xi=0;
		var ultima=-1
		while (xi<this.Indices_de_Filas_Clickeadas.length)
		{
			if ( (this.Indices_de_Filas_Clickeadas[xi]!= undefined ) && (this.Indices_de_Filas_Clickeadas[xi]!='') )
			{
				if (this.Indices_de_Filas_Clickeadas[xi]!=-1)
				{
					//ultima=this.Indices_de_Filas_Clickeadas[xi];
					ultima=xi;
				}
			}	
			xi++;
		}
		return ultima;
	}
	
	function Enciende_Fila_MouseClick(indice,e) 
	{			
		if ( ( ( !this.Se_Esta_Editando) && ( !this.Esta_Fila_Esta_Clickeada(indice) )  ) || ( (this.Cuantas_en_Edicion==0) && (!this.Esta_Fila_Esta_Clickeada(indice)) )  )
		{
			//alert(this.Esta_Fila_Esta_Clickeada(indice));
			var fila = this.ID+"_"+indice;			
			objeto_check = document.getElementById( "Tabla_Lista_ANIS_check_todos" ) ;			
			if (objeto_check!= undefined)
			{	
				if (objeto_check.checked)
				{			
					objeto_check.checked=false;				
				}
			}						
			
			objeto_fila = document.getElementById( fila ) ;			
			if (objeto_fila!= undefined)
			{		
				var ultima=this.Ultima_Fila_Clickeadas();			
				if (this.Indices_de_Filas_Clickeadas[ultima]!=-1)
				{				
					evento=this.Averiguar_Evento(e);				
					if (evento=="Shift")
					{
						var y1=this.Indices_de_Filas_Clickeadas[ultima];
						
						var yx1=ultima+1;  //aumenta a la seleccionya existente
						
						//var yx1=0;    //limpia y marca una nueva selecion
						//this.Apagar_Todas_Las_Filas_Clickeadas();					
						
						if (y1<=indice)
						{
							y1=y1+1
							while (y1<=indice)
							{
								fila = this.ID+"_"+y1;
								objeto_fila = document.getElementById( fila ) ;								
								if (objeto_fila!= undefined)
								{
									//alert("pintando fila : "+y1 + "guardando numero de fila pintada en filas_clikeada posicion : "+yx1);
									objeto_fila.style.background = this.Color_Fila_Click;
									objeto_fila.style.color = this.Color_Texto_Fila_Click;
									this.Indices_de_Filas_Clickeadas[yx1]=y1;		
									yx1++;
								}
								y1++;						
							}					
						}
						else
						{
							y1=y1-1
							while (y1>=indice)
							{							
								fila = this.ID+"_"+y1;
								if (document.getElementById) 
								{ 
									  objeto_fila = document.getElementById( fila ) ;
								} 
								else if (document.all) 
								{ 
									  objeto_fila = document.all[ fila ];
								}	
								if (objeto_fila!= undefined)
								{						
									objeto_fila.style.background = this.Color_Fila_Click;
									objeto_fila.style.color = this.Color_Texto_Fila_Click;
									this.Indices_de_Filas_Clickeadas[yx1]=y1;		
									yx1++;
								}
								y1--;
							}
						}
					}
					else
					{
						if (evento=="Ctrl")
						{
							ultima++;
							fila = this.ID+"_"+indice;
							if (document.getElementById) 
							{ 
								  objeto_fila = document.getElementById( fila ) ;
							} 
							else if (document.all) 
							{ 
								  objeto_fila = document.all[ fila ];
							}	
							if (objeto_fila!= undefined)
							{
								objeto_fila.style.background = this.Color_Fila_Click;
								objeto_fila.style.color = this.Color_Texto_Fila_Click;
								this.Indices_de_Filas_Clickeadas[ultima]=indice;		
							}			
						}
						else
						{	
							objeto_fila.style.background = this.Color_Fila_Click;
							objeto_fila.style.color = this.Color_Texto_Fila_Click;
							this.Apagar_Todas_Las_Filas_Clickeadas(); 
							this.Indices_de_Filas_Clickeadas[0]=indice;
						}	
					}
				}
				else
				{					
					objeto_fila.style.background = this.Color_Fila_Click;
					objeto_fila.style.color = this.Color_Texto_Fila_Click;						
					this.Apagar_Todas_Las_Filas_Clickeadas();  
					this.Indices_de_Filas_Clickeadas[0]=indice;				
				}
			}
		}
	}
  function setDataType(cValue)
  {
    // THIS FUNCTION CONVERTS DATES AND NUMBERS FOR PROPER ARRAY
    // SORTING WHEN IN THE SORT FUNCTION
    var isDate = new Date(cValue);
    if (isDate == "NaN")
      {
        if (isNaN(cValue))
          {
            // THE VALUE IS A STRING, MAKE ALL CHARACTERS IN
            // STRING UPPER CASE TO ASSURE PROPER A-Z SORT
            cValue = cValue.toUpperCase();
            return cValue;
          }
        else
          {
            // VALUE IS A NUMBER, TO PREVENT STRING SORTING OF A NUMBER
            // ADD AN ADDITIONAL DIGIT THAT IS THE + TO THE LENGTH OF
            // THE NUMBER WHEN IT IS A STRING
            var myNum;
            myNum = String.fromCharCode(48 + cValue.length) + cValue;
            return myNum;
          }
        }
  else
      {
        // VALUE TO SORT IS A DATE, REMOVE ALL OF THE PUNCTUATION AND
        // AND RETURN THE STRING NUMBER
        //BUG - STRING AND NOT NUMERICAL SORT .....
        // ( 1 - 10 - 11 - 2 - 3 - 4 - 41 - 5  etc.)
        var myDate = new String();
        myDate = isDate.getFullYear() + " " ;
        myDate = myDate + isDate.getMonth() + " ";
        myDate = myDate + isDate.getDate(); + " ";
        myDate = myDate + isDate.getHours(); + " ";
        myDate = myDate + isDate.getMinutes(); + " ";
        myDate = myDate + isDate.getSeconds();
        //myDate = String.fromCharCode(48 + myDate.length) + myDate;
        return myDate ;
      }
  }
  function sortTable(col)
  {
	tableToSort = document.getElementById(this.ID);
	if (tableToSort!= undefined)
	{
			var iCurCell = col + tableToSort.cols;
			var totalRows = tableToSort.rows.length;
			var bSort = 0;
			var colArray = new Array();
			var oldIndex = new Array();
			var indexArray = new Array();
			var bArray = new Array();
			var newRow;
			var newCell;
			var i;
			var c;
			var j;
			// ** POPULATE THE ARRAY colArray WITH CONTENTS OF THE COLUMN SELECTED
			for (i=1; i < tableToSort.rows.length; i++)
			  {
				colArray[i - 1] = setDataType(tableToSort.cells(iCurCell).innerText);
				iCurCell = iCurCell + tableToSort.cols;
			  }
			// ** COPY ARRAY FOR COMPARISON AFTER SORT
			for (i=0; i < colArray.length; i++)
			  {
				bArray[i] = colArray[i];
			  }
			// ** SORT THE COLUMN ITEMS
			//alert ( colArray );
			colArray.sort();
			//alert ( colArray );
			for (i=0; i < colArray.length; i++)
			{ // LOOP THROUGH THE NEW SORTED ARRAY
				indexArray[i] = (i+1);
				for(j=0; j < bArray.length; j++)
				  { // LOOP THROUGH THE OLD ARRAY
					if (colArray[i] == bArray[j])
					  {  // WHEN THE ITEM IN THE OLD AND NEW MATCH, PLACE THE
						// CURRENT ROW NUMBER IN THE PROPER POSITION IN THE
						// NEW ORDER ARRAY SO ROWS CAN BE MOVED ....
						// MAKE SURE CURRENT ROW NUMBER IS NOT ALREADY IN THE
						// NEW ORDER ARRAY
						for (c=0; c<i; c++)
						  {
							if ( oldIndex[c] == (j+1) )
							{
							  bSort = 1;
							}
							  }
							  if (bSort == 0)
								{
								  oldIndex[i] = (j+1);
								}
								  bSort = 0;
								}
				  }
			}
			 // ** SORTING COMPLETE, ADD NEW ROWS TO BASE OF TABLE ....
			for (i=0; i<oldIndex.length; i++)
			{
				newRow = tableToSort.insertRow();
				for (c=0; c<tableToSort.cols; c++)
				{
					newCell = newRow.insertCell();
					newCell.innerHTML = tableToSort.rows(oldIndex[i]).cells(c).innerHTML;
				 }
			}
			//MOVE NEW ROWS TO TOP OF TABLE ....
			for (i=1; i<totalRows; i++)
			{
			  tableToSort.moveRow((tableToSort.rows.length -1),1);
			}
			//DELETE THE OLD ROWS FROM THE BOTTOM OF THE TABLE ....
			for (i=1; i<totalRows; i++)
			{
			  tableToSort.deleteRow();
			}
	  }
  }
	
