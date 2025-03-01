<script type="text/javascript">

	function Actividades_Lista(Fecha, Pro_ID) 

	{				

		url = 'Actividades_Lista.php?Fecha='+Fecha+'&Pro_ID='+Pro_ID;			

		getAx(url,'Div_Actividades_Lista',150); 									

	}

	

	function Actividad_Nueva(Fecha, Pro_ID) 

	{				

		url = 'Actividad_Nueva.php?Fecha='+Fecha+'&Pro_ID='+Pro_ID;	

		getAx(url,'basic-modal-content-espera',150); 

		$('#basic-modal-content-espera').modal();

		return false;						

	}	

	

	function Actividad_del_Dia(Fecha) 

	{				

		url = 'Actividad_del_Dias.php?Fecha='+Fecha;	

		getAx(url,'basic-modal-content-espera',450); 

		$('#basic-modal-content-espera').modal();

		return false;						

	}

	

	function reporte_cronograma_actividades_lista() 

	{				

		Proyecto=document.form_reporte.Proyecto.value;

		From_Date=document.form_reporte.From_Date.value;

		To_Date=document.form_reporte.To_Date.value;

		

		url = 'reporte_cronograma_actividades_lista.php?From_Date='+From_Date+'&To_Date='+To_Date+'&Proyecto='+Proyecto+'&Pro_ID=';

		getAx(url,'Div_Actividades_del_dia',300); 

		

		$('#Div_Datos_de_Proyecto').html('');

		$('#Div_Actividad_Material_Information').html('');

		$('#Div_Actividad_Task_Information').html('');

		$('#Div_Actividad_Personal_Information').html('');	

		$('#Div_Actividad_Re_Scheduling').html('');

					

		$('#Div_New_Actividades_del_dia').html('');		

	}		

	

		function setuphours() 

	{				

		Proyecto=document.form_reporte.Proyecto.value;

		From_Date=document.form_reporte.From_Date.value;

		To_Date=document.form_reporte.To_Date.value;

		

		url = 'setuphours.php?From_Date='+From_Date+'&To_Date='+To_Date+'&Proyecto='+Proyecto+'&Pro_ID=';

		getAx(url,'Div_Actividades_del_dia',300); 

		

		$('#Div_Datos_de_Proyecto').html('');

		$('#Div_Actividad_Material_Information').html('');

		$('#Div_Actividad_Task_Information').html('');

		$('#Div_Actividad_Personal_Information').html('');	

		$('#Div_Actividad_Re_Scheduling').html('');

					

		$('#Div_New_Actividades_del_dia').html('');		

	

		}

	

	function Reporte_Actividad_Nuevo() 

	{				

		url = 'Reporte_Actividad_Nuevo.php';	

		/*getAx(url,'basic-modal-content-espera',150); 

		$('#basic-modal-content-espera').modal();	*/	

		$("#div_res_nueva_actividad").hide();			

		//return false;							

		getAx(url,'Div_New_Actividades_del_dia',150); 

		

		$('#Div_Datos_de_Proyecto').html('');

		$('#Div_Actividad_Material_Information').html('');

		$('#Div_Actividad_Task_Information').html('');

		$('#Div_Actividad_Personal_Information').html('');	

		$('#Div_Actividad_Re_Scheduling').html('');

	}	

	function Reporte_Actividades_lista_Proyectos() 

	{		

		var Company = document.form_reporte_proyecto.Company.value

		var Nombre = document.form_reporte_proyecto.Nombre.value

		

		url = 'Reporte_Actividades_lista_Proyectos.php?Company='+Company+'&Nombre='+Nombre;		

		getAx(url,'lista_proyectos',50); 

		$("#div_res_nueva_actividad").hide();									

	}	



	function Reporte_Actividad_Datos_Nueva(Pro_ID, Codigo, Nombre) 

	{				

		$("#div_titulo_nuevo").html(Codigo+":"+Nombre);		

		$("#Pro_ID").val(Pro_ID)

		$("#div_res_nueva_actividad").show();		

	}	

	

	function Reporte_Actividades_Nuevo_Registrar() 

	{		

		//alert("llegue");

		datos='';		

		url = 'Reporte_Actividades_Nuevo_Registrar.php';	

		$(':input', $("#Form_Actividad_Nueva") ).each(function() {

			if ( (this.type!='submit') && ( this.type!='button') && ( this.type!='reset') && (this.type!='radio') )

			{

				cad=jQuery.trim(this.name);											

				cad1=jQuery.trim(this.value);				

				if (datos=='')					

					datos=datos+cad+'='+cad1;				

				else

					datos=datos+'&'+cad+'='+cad1;									

			}

		});											

		//clearForm($("#Form_Actividad_Nueva"));			

		postAx(url,datos,'div_res_nueva_actividad',100);

	}



	

	function Actividad_Nueva_Registrar() 

	{		

		//alert("llegue");

		datos='';		

		url = 'Actividad_Nueva_Registrar.php';	

		$(':input', $("#Form_Actividad_Nueva") ).each(function() {

			if ( (this.type!='submit') && ( this.type!='button') && ( this.type!='reset') && (this.type!='radio') )

			{

				cad=jQuery.trim(this.name);											

				cad1=jQuery.trim(this.value);				

				if (datos=='')					

					datos=datos+cad+'='+cad1;				

				else

					datos=datos+'&'+cad+'='+cad1;									

			}

		});											

		//clearForm($("#Form_Actividad_Nueva"));			

		postAx(url,datos,'div_res_nueva_actividad',100);

	}

	function Actividades_Editar(Actividad_ID, Hora, Tipo_Actividad_ID, Descripcion, Aux1, Aux2, Aux3) 

	{				

		document.Form_Actividad_Nueva.Actividad_ID.value = Actividad_ID;

		$("#Tipo_Actividad_ID").val(Tipo_Actividad_ID)

		document.Form_Actividad_Nueva.Hora.value = Hora;

		document.Form_Actividad_Nueva.Descripcion.value = Descripcion;

		document.Form_Actividad_Nueva.Aux1.value = Aux1;

		document.Form_Actividad_Nueva.Aux2.value = Aux2;

		document.Form_Actividad_Nueva.Aux3.value = Aux3;

		$("#span_bnt_save").show();		

	}

		

	function Actividades_Editar_Guardar() 

	{		

		//alert("llegue");

		datos='';		

		url = 'Actividades_Editar_Guardar.php';	

		$(':input', $("#Form_Actividad_Nueva") ).each(function() {

			if ( (this.type!='submit') && ( this.type!='button') && ( this.type!='reset') && (this.type!='radio') )

			{

				cad=jQuery.trim(this.name);											

				cad1=jQuery.trim(this.value);				

				if (datos=='')					

					datos=datos+cad+'='+cad1;				

				else

					datos=datos+'&'+cad+'='+cad1;									

			}

		});											

		//clearForm($("#Form_Actividad_Nueva"));			

		$("#span_bnt_save").hide();

		postAx(url,datos,'div_res_nueva_actividad',1);

	}		

	

	function Actividades_Editar_Reporte_Guardar() 

	{		

		//alert("llegue");

		datos='';		

		url = 'Actividades_Editar_Reporte_Guardar.php';	

		$(':input', $("#Form_Proyectos_Actividades_Editar") ).each(function() {

			if ( (this.type!='submit') && ( this.type!='button') && ( this.type!='reset') && (this.type!='radio') )

			{

				cad=jQuery.trim(this.name);											

				cad1=jQuery.trim(this.value);				

				if (datos=='')					

					datos=datos+cad+'='+cad1;				

				else

					datos=datos+'&'+cad+'='+cad1;									

			}

		});											

		postAx(url,datos,'div_res_nueva_actividad',100);

	}	

	

	function Actividades_Editar_Cancelar() 

	{			

		clearForm($("#Form_Actividad_Nueva"));			

		$("#span_bnt_save").hide();

	}	

	function Actividades_Eliminar(Actividad_ID, Pro_ID, Fecha) 

	{					

		url = 'Actividades_Eliminar.php';

		datos =	'Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID+'&Fecha='+Fecha;		

		if (confirm("Esta Seguro de Eliminar esta Actividad?"))	

			postAx(url,datos,'div_res_nueva_actividad',1);

	}

	

	function Actividades_Eliminar_Reporte(Actividad_ID) 

	{					

		url = 'Actividades_Eliminar_Reporte.php';

		datos =	'Actividad_ID='+Actividad_ID;		

		if (confirm("Esta Seguro de Eliminar esta Actividad?"))	

		{

			postAx(url,datos,'Div_Actividades_del_dia',100);

			$('#Div_New_Actividades_del_dia').html('');			

		}

	}

	

	function Actividades_Editar_Reporte(Actividad_ID, Pro_ID) 

	{				

		url = 'Actividades_Editar_Reporte.php?Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID;	

		getAx(url,'basic-modal-content-espera',100); 

		$('#basic-modal-content-espera').modal();

		

		$('#Div_New_Actividades_del_dia').html('');		

		

		$('#Div_Datos_de_Proyecto').html('');

		$('#Div_Actividad_Material_Information').html('');

		$('#Div_Actividad_Task_Information').html('');

		$('#Div_Actividad_Personal_Information').html('');	

		$('#Div_Actividad_Re_Scheduling').html('');

			

		return false;						

	}





	function Actividades_Asignar_Personal(Actividad_ID, Fecha) 

	{				

		url = 'Actividades_Asignar_Personal.php?Actividad_ID='+Actividad_ID+'&Fecha='+Fecha;	

		getAx(url,'basic-modal-content-espera',100); 

		$('#basic-modal-content-espera').modal();

		

		$('#Div_New_Actividades_del_dia').html('');		

		

		$('#Div_Datos_de_Proyecto').html('');

		$('#Div_Actividad_Material_Information').html('');

		$('#Div_Actividad_Task_Information').html('');

		$('#Div_Actividad_Personal_Information').html('');	

		$('#Div_Actividad_Re_Scheduling').html('');

		

		return false;						

	}

	

	function Actividades_Personal_Lista(Actividad_ID) 

	{				

		url = 'Actividades_Personal_Lista.php?Actividad_ID='+Actividad_ID;	

		getAx(url,'Actividad_Personal',100); 

	}

	

	function Actividades_Personal_a_Asignar(Actividad_ID, Fecha) 

	{				

		url = 'Actividades_Personal_a_Asignar.php?Fecha='+Fecha+'&Actividad_ID='+Actividad_ID;	

		getAx(url,'Actividad_Personal_Disponible',100); 

		$('#Div_New_Actividades_del_dia').html('');			

	}	

		

	function Actividades_Asignar_Personal_Registrar(Empleado_ID, Actividad_ID, Fecha) 

	{				

		url = 'Actividades_Asignar_Personal_Registrar.php?Empleado_ID='+Empleado_ID+'&Actividad_ID='+Actividad_ID+'&Fecha='+Fecha;	

		//getAx(url,'Actividad_Personal_Disponible',100);
		getAx(url,'Div_Res_Personal_Asignar',100);  

	}	



	function Actividades_Personal_Eliminar(Empleado_ID, Actividad_ID, Fecha) 

	{				

		url = 'Actividades_Personal_Eliminar.php?Empleado_ID='+Empleado_ID+'&Actividad_ID='+Actividad_ID+'&Fecha='+Fecha;		

		//getAx(url,'Actividad_Personal_Disponible',100); 
		
		getAx(url,'Div_Res_Personal',100); 

	}		

	

	function Actividades_Datos_Proyecto(Actividad_ID, Pro_ID) 

	{				

		url = 'Actividades_Datos_Proyecto.php?Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID;		

		getAx(url,'Div_Datos_de_Proyecto',50); 		

	}

	function Atividades_Reporte_Diario(Actividad_ID, Pro_ID) 

	{				

		Actividades_Datos_Proyecto(Actividad_ID, Pro_ID); 

		

		url = 'Actividad_Material_Information.php?Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID;		

		getAx(url,'Div_Actividad_Material_Information',100); 

		

		url = 'Actividad_Task_Information.php?Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID;		

		getAx(url,'Div_Actividad_Task_Information',100); 

		

		url = 'Actividad_Personal_Information.php?Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID;		

		getAx(url,'Div_Actividad_Personal_Information',100); 

		

		url = 'Actividad_Re_Scheduling.php?Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID;		

		getAx(url,'Div_Actividad_Re_Scheduling',100); 	

		

		$('#Div_New_Actividades_del_dia').html('');			

	}

	function Atividades_Reporte_Diario_Material(ID_Editable) 

	{

		eval( "$('#"+ID_Editable+"').editable('Atividades_Reporte_Diario_Material.php');" );		 			 

	}		

	

	function Atividades_Reporte_Diario_Task(ID_Editable) 

	{

		//eval( "$('#"+ID_Editable+"').editable('Atividades_Reporte_Diario_Task.php', {type: 'textarea', submit  : 'OK'});" );		 			 

		eval( "$('#"+ID_Editable+"').editable('Atividades_Reporte_Diario_Task.php', {type: 'textarea', submit  : 'OK', height : 50});" );		 			 

	}	

	

	function Atividades_Reporte_Diario_Personal(ID_Editable) 

	{

		eval( "$('#"+ID_Editable+"').editable('Atividades_Reporte_Diario_Personal.php');" );		 			 

	}	



	function Atividades_Reporte_Diario_Personal_Respuesta(id, Pro_ID, Empleado_ID, Actividad_ID, value, Total) 

	{

		eval(" $('#Div_Total_Horas-"+Empleado_ID+"-"+Actividad_ID+"').html('"+Total+"');");

		Actividades_Datos_Proyecto(Actividad_ID, Pro_ID);

		eval(" $('#"+id+"').html('"+value+"');");

	}	

	

	function Atividades_Reporte_Diario_Personal_8_horas(Actividad_ID, Pro_ID) 

	{				

		url = 'Atividades_Reporte_Diario_Personal_8_horas.php?Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID;		

		getAx(url,'Div_Set_to_8_horas',5); 		

	}

	

	function Actividad_Re_Scheduling_Registrar() 

	{				

		datos='';		

		url = 'Actividad_Re_Scheduling_Registrar.php';	

		$(':input', $("#Form_Re_Scheduling") ).each(function() {

			if ( (this.type!='submit') && ( this.type!='button') && ( this.type!='reset') && (this.type!='radio') )

			{

				cad=jQuery.trim(this.name);											

				cad1=jQuery.trim(this.value);				

				if (datos=='')					

					datos=datos+cad+'='+cad1;				

				else

					datos=datos+'&'+cad+'='+cad1;									

			}

		});											

		postAx(url,datos,'Div_Res_Res_Scheduling',10);	

	}	

	

	function Actividad_Global_Re_Scheduling_Registrar() 

	{				

		datos='';		

		url = 'Actividad_Global_Re_Scheduling_Registrar.php';	

		$(':input', $("#Form_Global_Re_Scheduling") ).each(function() {

			if ( (this.type!='submit') && ( this.type!='button') && ( this.type!='reset') && (this.type!='radio') )

			{

				cad=jQuery.trim(this.name);											

				cad1=jQuery.trim(this.value);				

				if (datos=='')					

					datos=datos+cad+'='+cad1;				

				else

					datos=datos+'&'+cad+'='+cad1;									

			}

		});											

		postAx(url,datos,'Div_Res_Global_Scheduling',10);	

	}	

	

	function Actividad_Material_Information_Maximizar(Actividad_ID, Pro_ID) 

	{				

		url = 'Actividad_Material_Information_max.php?Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID;			

		getAx(url,'basic-modal-content-espera',100); 		

		//$('#basic-modal-content-espera').html(  $('#Div_Actividad_Material_Information').html()  );

		

		$('#basic-modal-content-espera').modal();		

		return false;						

	}	

	

	function Proyecto_Registrar_Estatus(Pro_ID, Estatus_ID) 

	{				

		url = 'Proyecto_Registrar_Estatus.php?Pro_ID='+Pro_ID+'&Estatus_ID='+Estatus_ID;		

		getAx(url,'Res_Status',100); 

	}	
	
	function Foreman_Atividades_Reporte_Diario(Actividad_ID, Pro_ID) 

	{				

		//Actividades_Datos_Proyecto(Actividad_ID, Pro_ID); 

		

		/*url = 'Actividad_Material_Information.php?Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID;		

		getAx(url,'Div_Actividad_Material_Information',100); 

		

		url = 'Actividad_Task_Information.php?Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID;		

		getAx(url,'Div_Actividad_Task_Information',100); */

		

		url = 'Actividad_Personal_Information.php?Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID;		

		getAx(url,'Div_Actividad_Personal_Information',100); 

		

		/*url = 'Actividad_Re_Scheduling.php?Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID;		

		getAx(url,'Div_Actividad_Re_Scheduling',100); 	*/

		

		$('#Div_New_Actividades_del_dia').html('');			

	}

</script>