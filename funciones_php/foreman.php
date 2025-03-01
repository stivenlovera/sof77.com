<script type="text/javascript">

	var tabActivo1 = "";
	var tabActivo2 = "";
	
	var Fila=0;
	
	function foreman_registro_hora(Origen,Reg_ID) 
	{			
		if (Origen=="E")			
		{
			url = "foreman_registro_ingreso.php";			
			getAx(url,'div_registro_res',150); 								
		}
		else
		{
			//alert("foreman_registro_salida");	
			url = "foreman_registro_salida.php?Reg_ID="+Reg_ID;			
			getAx(url,'div_registro_res',150); 								
		}
	}
	
	function foreman_registro_actividad(Reg_ID) 
	{	
		url = "foreman_registro_actividad.php?Reg_ID="+Reg_ID;			
		getAx(url,'div_registro_actividad',150); 								
	}
	
		
	function foreman_registro_actividad_detalle(Reg_ID, Pro_ID) 
	{	
		url = "foreman_registro_actividad_detalle.php?Reg_ID="+Reg_ID+"&Pro_ID="+Pro_ID;			
		getAx(url,'Div_Reporte',150); 								
	}
	
	function foreman_registro_actividad_detalle2(Pro_ID, Fecha) 
	{	
		Reg_ID=-55;
		url = "../foreman_registro_actividad_detalle.php?Reg_ID="+Reg_ID+"&Pro_ID="+Pro_ID+"&Fecha="+Fecha;			
		//alert ("Lllego");
		getAx(url,'Div_Actividades',150); 								
	}
	
	
	function foreman_registro_actividad_piso(Edificio_ID,Fila, RDA_ID) 
	{	
		if (Edificio_ID!=-1)
		{
			url = "foreman_registro_actividad_piso.php?Edificio_ID="+Edificio_ID+"&Fila="+Fila+"&RDA_ID="+RDA_ID;			
			getAx(url,"div_registro_actividad_piso_"+Fila,10); 	
			$("#div_registro_actividad_area_"+Fila).html("");
			$("#div_registro_actividad_task_"+Fila).html("");
		}
		else
		{
			alert("You Have Select one Bulding...");
		}
	}
	
	function foreman_registro_actividad_area(Floor_ID, Fila, RDA_ID) 
	{	
		if (Floor_ID!=-1)
		{
			url = "foreman_registro_actividad_area.php?Floor_ID="+Floor_ID+"&Fila="+Fila+"&RDA_ID="+RDA_ID;			
			getAx(url,"div_registro_actividad_area_"+Fila,10);
			$("#div_registro_actividad_task_"+Fila).html(""); 	
		}
		else
		{
			alert("You Have Select one Bulding...");
		}							
	}
	
	
	function foreman_registro_actividad_task(Area_ID, Fila, RDA_ID) 
	{	
		if (Area_ID!=-1)
		{
			url = "foreman_registro_actividad_task.php?Area_ID="+Area_ID+"&Fila="+Fila+"&RDA_ID="+RDA_ID;			
			getAx(url,"div_registro_actividad_task_"+Fila,10); 
		}
		else
		{
			alert("You Have Select one Area...");
		}									
	}
	
	function foreman_registro_actividad_registrar(Pro_ID, Filas) 
	{
		Hora_Ingreso = "";
		Hora_Salida = "";
		Edificio_ID = "";
		Floor_ID = "";
		Area_ID = "";
		Task_ID = "";
		Horas_Contract = "";
		Horas_TM = "";
		Detalle = "";
		RDA_ID = "";
		Empleado_ID = "";
		Verificado_Foreman="";
		Reg_ID = "";
		
		i=1;
		Filas=Fila;
		//alert ("LLego");
		//alert (Filas);
		
		
		
		while (i<Filas)
		{
			//alert (i);
			
			if (i==1)
			{
				eval("Hora_Ingreso = Hora_Ingreso + document.getElementById('Hora_Ingreso_"+i+"').value; ");
				eval("Hora_Salida = Hora_Salida + document.getElementById('Hora_Salida_"+i+"').value; ");
				eval("Edificio_ID = Edificio_ID + document.getElementById('Edificio_ID_"+i+"').value; ");
				eval("Floor_ID = Floor_ID + document.getElementById('Floor_ID_"+i+"').value; ");
				eval("Area_ID = Area_ID + document.getElementById('Area_ID_"+i+"').value; ");
				eval("Task_ID = Task_ID + document.getElementById('Task_ID_"+i+"').value; ");
				eval("Horas_Contract = Horas_Contract + document.getElementById('Horas_Contract_"+i+"').value; ");			
				eval("Horas_TM = Horas_TM + document.getElementById('Horas_TM_"+i+"').value; ");
				eval("Detalle = Detalle + document.getElementById('Detalle_"+i+"').value; ");
				eval("RDA_ID = RDA_ID + document.getElementById('RDA_ID_"+i+"').value; ");
				eval("Reg_ID = Reg_ID + document.getElementById('Reg_ID_"+i+"').value; ");
				eval("Empleado_ID = Empleado_ID + document.getElementById('Empleado_ID_"+i+"').value; ");	
				eval("Verificado_Foreman = Verificado_Foreman + $('input[name=Verificado_Foreman_"+i+"]').is(':checked'); ");	
			}
			else
			{
				eval("Hora_Ingreso = Hora_Ingreso + '|' + document.getElementById('Hora_Ingreso_"+i+"').value;");
				eval("Hora_Salida = Hora_Salida + '|' + document.getElementById('Hora_Salida_"+i+"').value;");
				eval("Edificio_ID = Edificio_ID + '|' + document.getElementById('Edificio_ID_"+i+"').value;");
				eval("Floor_ID = Floor_ID + '|' + document.getElementById('Floor_ID_"+i+"').value;");
				eval("Area_ID = Area_ID + '|' + document.getElementById('Area_ID_"+i+"').value;");
				
				//eval ("Task_IDx = Task_IDx + '|' + document.getElementById('Task_ID_"+i+"').value;");
				//alert (Task_IDx);
				
				eval("Task_ID = Task_ID + '|' + document.getElementById('Task_ID_"+i+"').value;");
				eval("Horas_Contract = Horas_Contract + '|' + document.getElementById('Horas_Contract_"+i+"').value; ");			
				eval("Horas_TM = Horas_TM + '|' + document.getElementById('Horas_TM_"+i+"').value; ");
				eval("Detalle = Detalle + '|' + document.getElementById('Detalle_"+i+"').value; ");
				eval("RDA_ID = RDA_ID + '|' + document.getElementById('RDA_ID_"+i+"').value; ");
				eval("Reg_ID = Reg_ID + '|' + document.getElementById('Reg_ID_"+i+"').value; ");
				eval("Empleado_ID = Empleado_ID + '|' + document.getElementById('Empleado_ID_"+i+"').value; ");	
				eval("Verificado_Foreman = Verificado_Foreman + '|' + $('input[name=Verificado_Foreman_"+i+"]').is(':checked'); ");	
			}					
			i++;
		}	
		//alert (Filas);
		url = "foreman_registro_actividad_registrar.php?Pro_ID="+Pro_ID+"&Edificio_ID="+Edificio_ID+"&Floor_ID="+Floor_ID+"&Area_ID="+Area_ID+"&Task_ID="+Task_ID+"&Horas_Contract="+Horas_Contract+"&Horas_TM="+Horas_TM+"&Detalle="+Detalle+"&RDA_ID="+RDA_ID+"&Reg_ID="+Reg_ID+"&Empleado_ID="+Empleado_ID+"&Verificado_Foreman="+Verificado_Foreman+"&Hora_Ingreso="+Hora_Ingreso+"&Hora_Salida="+Hora_Salida;		
					
		getAx(url,'div_registro',10); 								
	}	
	
	function foreman_registro_actividad_lista(Reg_ID) 
	{			
		url = "foreman_registro_actividad_lista.php?Reg_ID="+Reg_ID;			
		getAx(url,'Tabla_Lista_Actividades',10); 									
	}
	
	
	
	function Activar_Tab(tab) 
	{ 
		document.getElementById("tab1").className = ""; 
		document.getElementById("tab2").className = ""; 		
		
		document.getElementById("tab"+tab).className = "active"; 
		//ocultar todos los divs
		if (document.getElementById)
		{
			var inc=1;
			while (document.getElementById("dropInfo"+inc))
			{
				document.getElementById("dropInfo"+inc).style.display="none";
				inc++;
			} 
		}
		document.getElementById("dropInfo"+tab).style.display="block";
	}
	
	function makeactive(tab, Reg_ID,Actividad_ID,Pro_ID)
	{ 
		Activar_Tab(tab);
		switch(tab) 
		{
			case 1 : 	{
							if (tabActivo1 == "" )
							{
								foreman_registro_actividad_asistencia(Reg_ID,Actividad_ID, Pro_ID);	
								$('#Div_Reporte').html("");															
							}			
							break;
						}
			case 2 : 	{
							if (tabActivo2 == "" ) 
							{								
								//foreman_registro_actividad_detalle(Reg_ID, Pro_ID);															
								foreman_password(Reg_ID, Pro_ID);		
							}
							break;
						}													
		}
	}
	
	function foreman_password(Reg_ID, Pro_ID) 
	{			
		url = "foreman_password.php?Reg_ID="+Reg_ID+"&Pro_ID="+Pro_ID;			
		getAx(url,'Div_Reporte',10); 									
	}   
	
	function foreman_menu(Reg_ID,Actividad_ID,Pro_ID) 
	{			
		url = "foreman_menu.php?Reg_ID="+Reg_ID+"&Actividad_ID="+Actividad_ID+"&Pro_ID="+Pro_ID;			
		getAx(url,'Div_Actividad_Personal_Information',10); 									
	}   
		
	function foreman_registro_actividad_asistencia(Reg_ID,Actividad_ID,Pro_ID) 
	{			
		url = "foreman_registro_actividad_asistencia.php?Reg_ID="+Reg_ID+"&Actividad_ID="+Actividad_ID+"&Pro_ID="+Pro_ID;			
		getAx(url,'Div_Registro',10); 									
	} 
	
	function foreman_registro_actividad_asistencia_reg(Empleado_ID, Nombre_Empleado) 
	{			
		url = "foreman_registro_actividad_asistencia_reg.php?Empleado_ID="+Empleado_ID;			
		getAx(url,'basic-modal-content-espera',250); 		
		//$('#basic-modal-content-espera').modal();
		//$('#basic-modal-content-espera').resize(200, 200);
		$('#basic-modal-content-espera').dialog({width: 650,height:380,title:Nombre_Empleado})
		return false;											
	} 
	
	function foreman_registro_actividad_asistencia_hora(Tipo,Empleado_ID,Reg_ID,P, R) 
	{	
		RU=document.getElementById("Respuesta").value;	
		url = "foreman_registro_actividad_asistencia_hora.php?Tipo="+Tipo+"&Empleado_ID="+Empleado_ID+"&Reg_ID="+Reg_ID+"&R="+R+"&P="+P+"&RU="+RU+"&Latitud="+Latitud+"&Longitud="+Longitud;			
		getAx(url,'div_asistencia_reg',10); 
		
				
	}  
	
	function foreman_registro_actividad_asistencia_foto(Tipo,Empleado_ID,Reg_ID) 
	{		
		//Foto=document.getElementById("Foto").value;	
		Foto=$("#Foto").html();	
		//url = "foreman_registro_actividad_asistencia_foto.php?Tipo="+Tipo+"&Empleado_ID="+Empleado_ID+"&Reg_ID="+Reg_ID+"&Foto="+Foto;	
		url = "foreman_registro_actividad_asistencia_foto.php";	
		
		datos="Tipo="+Tipo+"&Empleado_ID="+Empleado_ID+"&Reg_ID="+Reg_ID+"&Foto="+Foto;	
	
		postAx(url,datos,'div_asistencia_reg',100);
					
		//getAx(url,'div_asistencia_reg',10); 		
	}
	function empleado_registro_actividad_detalle_x(Reg_ID, Pro_ID) 
	{	
		url = "empleado_registro_actividad_detalle.php?Reg_ID="+Reg_ID+"&Pro_ID="+Pro_ID;			
		getAx(url,'Div_Actividad_Personal_Information_x',150); 								
	}
	
	function Poner_Foto(stringPixels)
	{
		var gCtx = null;
		var gCanvas = null;
	
		var imageData = null;
		var ii=0;
		var jj=0;
		var c=0;

	
		gCanvas = document.getElementById("canvas_test");
		var w = 320;
		var h = 240;
		gCanvas.style.width = w + "px";
		gCanvas.style.height = h + "px";
		gCanvas.width = w;
		gCanvas.height = h;
		gCtx = gCanvas.getContext("2d");
		gCtx.clearRect(0, 0, w, h);
		imageData = gCtx.getImageData( 0,0,320,240);
		
		var coll = stringPixels.split("-");
	
		//for(var i=0;i<320;i++) { 
		for(var i=0;i<coll.length;i++) { 
			var intVal = parseInt(coll[i]);
			r = (intVal >> 16) & 0xff;
			g = (intVal >> 8) & 0xff;
			b = (intVal ) & 0xff;
			imageData.data[c+0]=r;
			imageData.data[c+1]=g;
			imageData.data[c+2]=b;
			imageData.data[c+3]=255;
			c+=4;
		} 
		gCtx.putImageData(imageData, 0,0);	
	}
	   
	function Nueva_Fila(MiFila) 
	{				
		var fila="";					
		//eval("fila=$('#"+id+"').html();");
		fila=$('#aux_div_res').html();
		n=fila.split("|"); 
		fila=n[0];					
		
		//$('#mitabla tr:first').after(fila); 
		$('#mitabla tr:nth-child('+MiFila+')').after(fila);
		
		$('#aux_div_res').html("");
	}	
		
	function foreman_registro_actividad_clonar(Empleado_ID, Nombre_Empleado,Hora_Ingreso,Hora_Salida,Pro_ID,Reg_ID,RDA_ID, MiFila) 
	{			
		url = "foreman_registro_actividad_clonar.php?Empleado_ID="+Empleado_ID+"&Nombre_Empleado="+Nombre_Empleado+"&Hora_Ingreso="+Hora_Ingreso+"&Hora_Salida="+Hora_Salida+"&Pro_ID="+Pro_ID+"&Fila="+Fila+"&Reg_ID="+Reg_ID+"&RDA_ID="+RDA_ID+"&MiFila="+MiFila;			
		getAx(url,'aux_div_res',150);													
	} 
	
	function foreman_registro_actividad_borrarr(RDA_ID, Reg_ID ,Pro_ID, MiFila) 
	{			
		url = "foreman_registro_actividad_borrarr.php?RDA_ID="+RDA_ID+"&Reg_ID="+Reg_ID+"&Pro_ID="+Pro_ID+"&MiFila="+MiFila;			
		getAx(url,'div_registro_borrar_'+MiFila,150);													
	} 

</script>

