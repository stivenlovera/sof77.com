<script type="text/javascript">

	function empleado_registro_hora(Origen,Reg_ID) 
	{			
		if (Origen=="E")			
		{
			url = "empleado_registro_ingreso.php";			
			getAx(url,'div_registro_res',150); 								
		}
		else
		{
			//alert("empleado_registro_salida");	
			url = "empleado_registro_salida.php?Reg_ID="+Reg_ID;			
			getAx(url,'div_registro_res',150); 								
		}
	}
	
	function empleado_registro_actividad(Reg_ID) 
	{	
		url = "empleado_registro_actividad.php?Reg_ID="+Reg_ID;			
		getAx(url,'div_registro_actividad',150); 								
	}
	
		
	function empleado_registro_actividad_detalle(Reg_ID, Pro_ID) 
	{	
		url = "empleado_registro_actividad_detalle.php?Reg_ID="+Reg_ID+"&Pro_ID="+Pro_ID;			
		getAx(url,'Div_Actividad_Personal_Information',150); 								
	}
	
	
	function empleado_registro_actividad_piso(Edificio_ID,Fila, RDA_ID) 
	{	
		if (Edificio_ID!=-1)
		{
			url = "empleado_registro_actividad_piso.php?Edificio_ID="+Edificio_ID+"&Fila="+Fila+"&RDA_ID="+RDA_ID;			
			getAx(url,"div_registro_actividad_piso_"+Fila,10); 	
			$("#div_registro_actividad_area_"+Fila).html("");
			$("#div_registro_actividad_task_"+Fila).html("");
		}
		else
		{
			alert("You Have Select one Bulding...");
		}
	}
	
	function empleado_registro_actividad_area(Floor_ID, Fila, RDA_ID) 
	{	
		if (Floor_ID!=-1)
		{
			url = "empleado_registro_actividad_area.php?Floor_ID="+Floor_ID+"&Fila="+Fila+"&RDA_ID="+RDA_ID;			
			getAx(url,"div_registro_actividad_area_"+Fila,10);
			$("#div_registro_actividad_task_"+Fila).html(""); 	
		}
		else
		{
			alert("You Have Select one Bulding...");
		}							
	}
	
	
	function empleado_registro_actividad_task(Area_ID, Fila, RDA_ID) 
	{	
		if (Area_ID!=-1)
		{
			url = "empleado_registro_actividad_task.php?Area_ID="+Area_ID+"&Fila="+Fila+"&RDA_ID="+RDA_ID;			
			getAx(url,"div_registro_actividad_task_"+Fila,10); 
		}
		else
		{
			alert("You Have Select one Area...");
		}									
	}
	
	function empleado_registro_actividad_registrar(Pro_ID,Reg_ID) 
	{
		
		//alert("You rich empregactreg function .");
		Edificio_ID_1=document.getElementById('Edificio_ID_1').value;
		//alert(Edificio_ID_1);
		Floor_ID_1=document.getElementById('Floor_ID_1').value;
		//alert(Floor_ID_1);
		Area_ID_1=document.getElementById('Area_ID_1').value;
		//alert(Area_ID_1);
		Task_ID_1=document.getElementById('Task_ID_1').value;
		//alert(Task_ID_1);
		Horas_Contract_1=document.getElementById('Horas_Contract_1').value;
		Horas_TM_1=document.getElementById('Horas_TM_1').value;	
		Detalle_1=document.getElementById('Detalle_1').value;	
		RDA_ID_1=document.getElementById('RDA_ID_1').value;	
				
		//alert("You rich empregactreg function 1");
		
		Edificio_ID_2=document.getElementById('Edificio_ID_2').value;
		//alert(Edificio_ID_2);
		Floor_ID_2=document.getElementById('Floor_ID_2').value;
		Area_ID_2=document.getElementById('Area_ID_2').value;
		//alert(Area_ID_2);
		Task_ID_2=document.getElementById('Task_ID_2').value;
		//alert(Task_ID_2);
		Horas_Contract_2=document.getElementById('Horas_Contract_2').value;
		Horas_TM_2=document.getElementById('Horas_TM_2').value;	
		Detalle_2=document.getElementById('Detalle_2').value;	
		RDA_ID_2=document.getElementById('RDA_ID_2').value;	
		//alert(RDA_ID_2);
		//alert("You rich empregactreg function 2");
		
		Edificio_ID_3=document.getElementById('Edificio_ID_3').value;
		Floor_ID_3=document.getElementById('Floor_ID_3').value;
		Area_ID_3=document.getElementById('Area_ID_3').value;
		Task_ID_3=document.getElementById('Task_ID_3').value;
		//alert(Task_ID_3);
		Horas_Contract_3=document.getElementById('Horas_Contract_3').value;
		Horas_TM_3=document.getElementById('Horas_TM_3').value;	
		Detalle_3=document.getElementById('Detalle_3').value;	
		RDA_ID_3=document.getElementById('RDA_ID_3').value;	
		//alert(RDA_ID_3);
		//alert("You rich empregactreg function 3");
		
		//alert("You rich empregactreg function middle.");
		url = "empleado_registro_actividad_registrar.php?Pro_ID="+Pro_ID+"&Reg_ID="+Reg_ID+"&Edificio_ID_1="+Edificio_ID_1+"&Floor_ID_1="+Floor_ID_1+"&Area_ID_1="+Area_ID_1+"&Task_ID_1="+Task_ID_1+"&Horas_Contract_1="+Horas_Contract_1+"&Horas_TM_1="+Horas_TM_1+"&Detalle_1="+Detalle_1+"&RDA_ID_1="+RDA_ID_1+"&Edificio_ID_2="+Edificio_ID_2+"&Floor_ID_2="+Floor_ID_2+"&Area_ID_2="+Area_ID_2+"&Task_ID_2="+Task_ID_2+"&Horas_Contract_2="+Horas_Contract_2+"&Horas_TM_2="+Horas_TM_2+"&Detalle_2="+Detalle_2+"&RDA_ID_2="+RDA_ID_2+"&Edificio_ID_3="+Edificio_ID_3+"&Floor_ID_3="+Floor_ID_3+"&Area_ID_3="+Area_ID_3+"&Task_ID_3="+Task_ID_3+"&Horas_Contract_3="+Horas_Contract_3+"&Horas_TM_3="+Horas_TM_3+"&Detalle_3="+Detalle_3+"&RDA_ID_3="+RDA_ID_3;			
		getAx(url,'div_registro_actividad_registrar',10); 
	//	alert("You rich empregactreg function end .");								
	}	
	
	function empleado_registro_actividad_lista(Reg_ID) 
	{			
		url = "empleado_registro_actividad_lista.php?Reg_ID="+Reg_ID;			
		getAx(url,'Tabla_Lista_Actividades',10); 									
	}
	
	function empleado_registro_actividad_asistencia(Reg_ID, Pro_ID) 
	{			
		url = "empleado_registro_actividad_asistencia.php?Reg_ID="+Reg_ID+"&Pro_ID="+Pro_ID;			
		getAx(url,'Div_Actividad_Personal_Information',10); 									
	} 
	
	function empleado_registro_actividad_asistencia_reg(Empleado_ID, Nombre_Empleado) 
	{			
		url = "empleado_registro_actividad_asistencia_reg.php?Empleado_ID="+Empleado_ID;			
		getAx(url,'basic-modal-content-espera',250); 		
		//$('#basic-modal-content-espera').modal();
		//$('#basic-modal-content-espera').resize(200, 200);
		$('#basic-modal-content-espera').dialog({width: 850,height:380,title:Nombre_Empleado})
		return false;											
	} 
	
	function empleado_registro_actividad_asistencia_hora(Tipo,Empleado_ID,Reg_ID,P, R) 
	{		
		RU=document.getElementById("Respuesta").value;	
		url = "empleado_registro_actividad_asistencia_hora.php?Tipo="+Tipo+"&Empleado_ID="+Empleado_ID+"&Reg_ID="+Reg_ID+"&R="+R+"&P="+P+"&RU="+RU;			
		getAx(url,'div_asistencia_reg',10); 		
	}  
	
	function empleado_registro_actividad_asistencia_foto(Tipo,Empleado_ID,Reg_ID) 
	{		
		//Foto=document.getElementById("Foto").value;	
		Foto=$("#Foto").html();	
		//url = "foreman_registro_actividad_asistencia_foto.php?Tipo="+Tipo+"&Empleado_ID="+Empleado_ID+"&Reg_ID="+Reg_ID+"&Foto="+Foto;	
		url = "empleado_registro_actividad_asistencia_foto.php";	
		
		datos="Tipo="+Tipo+"&Empleado_ID="+Empleado_ID+"&Reg_ID="+Reg_ID+"&Foto="+Foto;	
	
		postAx(url,datos,'div_asistencia_reg',100);
					
		//getAx(url,'div_asistencia_reg',10); 		
	}
	
	function empleado_registro_actividad_detalle_x(Reg_ID, Pro_ID) 
	{	
		url = "empleado_registro_actividad_detalle.php?Reg_ID="+Reg_ID+"&Pro_ID="+Pro_ID;			
		getAx(url,'Div_Actividad_Personal_Information_x',150); 								
	}
	

	

	

</script>