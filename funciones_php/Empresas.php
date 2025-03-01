<script type="text/javascript">
	function Empresas_Lista() 
	{		
		$("#Div_Empresas_Menu").html("");
		var Nombre = document.Form_Empresas_Lista.Nombre.value
		var Estado = document.Form_Empresas_Lista.Estado.value		
		var Ciudad = document.Form_Empresas_Lista.Ciudad.value	
		var Zip_Code = document.Form_Empresas_Lista.Zip_Code.value		
		var Calle = document.Form_Empresas_Lista.Calle.value
		var Telefono = document.Form_Empresas_Lista.Telefono.value							
		
		url = 'Empresas_Lista.php?Nombre='+Nombre+'&Estado='+Estado+'&Ciudad='+Ciudad+'&Zip_Code='+Zip_Code+'&Calle='+Calle+'&Telefono='+Telefono;		
		getAx(url,'Div_Empresas_Lista',250); 									
	}
	function Empresas_Nueva() 
	{				
		url = 'Empresas_Nueva.php';	
		getAx(url,'basic-modal-content-espera',450); 		
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Empresas_Nueva_Validar_Codigo(Codigo, Emp_ID)
	{				
		url = 'Empresas_Nueva_Validar_Codigo.php?Codigo='+Codigo+'&Emp_ID='+Emp_ID;	
		getAx(url,'Div_Validar_Codigo',5); 		
	}
	
	function Empresas_Nueva_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Empresas_Nueva_Registrar.php';	
		$(':input', $("#Form_Empresas_Nueva") ).each(function() {
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
		//clearForm('Form_Empresas_Nueva');			
		//alert("*"+$("#Div_Validar_Codigo").html()+"*");
		if ($("#Div_Validar_Codigo").html()=="OK")
		{
			postAx(url,datos,'div_res_new_empresa',100);
			$("#Div_Empresas_Lista").html("");
			$("#Div_Empresas_Menu").html("");
		}
		else
		{
			alert("Code Already in Use.")
		}
	}	
	
	function Empresas_Editar(Emp_ID) 
	{				
		url = 'Empresas_Editar.php?Emp_ID='+Emp_ID;	
		getAx(url,'basic-modal-content-espera',450); 		
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Empresas_Editar_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Empresas_Editar_Registrar.php';	
		$(':input', $("#Form_Empresas_Editar") ).each(function() {
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
		
		if ($("#Div_Validar_Codigo").html()=="OK")
		{
			postAx(url,datos,'div_res_new_empresa',100);		
			$("#Div_Empresas_Lista").html("");
			$("#Div_Empresas_Menu").html("");
		}
		else
		{
			alert("Code Already in Use.")
		}
	}	
		
	function Empresas_Menu(Emp_ID)
	{	
		$("#Div_Empresas_Menu").html("");		
		tabActivo1 = "";
		tabActivo2 = "";
		tabActivo3 = "";
		tabActivo4 = "";
						
		url = 'Empresas_Menu.php?Emp_ID='+Emp_ID;
		getAx(url,'Div_Empresas_Menu',100);
		menu=1; 
	}
	
	function Empresas_Lista_Empleados(Emp_ID) 
	{				
		url = 'Empresas_Lista_Empleados.php?Emp_ID='+Emp_ID;
		getAx(url,'Div_Empresas_Lista_Empleados',150); 		
	}

	function Empresas_Nuevo_Empleado(Emp_ID) 
	{				
		url = 'Empresas_Nuevo_Empleado.php?Emp_ID='+Emp_ID;
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	function Empresas_Nuevo_Empleado_Registrar(Emp_ID) 
	{		
			//alert("llegue");
			datos='';		
			url = 'Empresas_Nuevo_Empleado_Registrar.php';	
			$(':input', $("#Form_Empresas_Empleado_Nuevo") ).each(function() {
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
			datos = datos + "&Emp_ID="+Emp_ID;									
			clearForm('Form_Empresas_Empleado_Nuevo');			
			postAx(url,datos,'div_res_new_empresa',100);
	}
	
	function Empresas_Empleados_Editar(Empleado_ID, Emp_ID) 
	{				
		url = 'Empresas_Empleados_Editar.php?Emp_ID='+Emp_ID+'&Empleado_ID='+Empleado_ID;
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	function Empresas_Empleados_Editar_Registrar() 
	{		
			//alert("llegue");
			datos='';		
			url = 'Empresas_Empleados_Editar_Registrar.php';	
			$(':input', $("#Form_Empresas_Empleado_Editar") ).each(function() {
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
			postAx(url,datos,'div_res_new_empresa',100);
	}
		
	
	function Empresas_Empledos_Eliminar(Empleado_ID, Emp_ID) 
	{				
		url = 'Empresas_Empledos_Eliminar.php?Emp_ID='+Emp_ID+'&Empleado_ID='+Empleado_ID;
		getAx(url,'basic-modal-content-espera',300); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Empresas_Lista_Proyectos(Emp_ID) 
	{	
		url = 'Empresas_Lista_Proyectos.php?Emp_ID='+Emp_ID;
		getAx(url,'Div_Empresas_Lista_Proyectos',150); 		
	}

	
	function Empresas_Nuevo_Proyecto(Emp_ID) 
	{				
		url = 'Empresas_Nuevo_Proyecto.php?Emp_ID='+Emp_ID;
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Empresas_Nuevo_Proyecto_Validar_Codigo(Codigo, Pro_ID)
	{				
		url = 'Empresas_Nuevo_Proyecto_Validar_Codigo.php?Codigo='+Codigo+'&Pro_ID='+Pro_ID;	
		getAx(url,'Div_Validar_Codigo',5); 		
	}
	
	
	function Empresas_Nuevo_Proyecto_Registrar() 
	{		
			//alert("llegue");
			datos='';		
			url = 'Empresas_Nuevo_Proyecto_Registrar.php';	
			$(':input', $("#Form_Empresas_Proyecto_Nuevo") ).each(function() {
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
			
			if ($("#Div_Validar_Codigo").html()=="OK")
			{
				postAx(url,datos,'div_res_new_proyecto',100);
			}
			else
			{
				alert("Code Already in Use.")
			}
	}

	function Empresas_Nuevo_Proyecto_Codigo(Tipo_ID) 
	{				
		if (Tipo_ID!='')
		{
			url = 'Empresas_Nuevo_Proyecto_Codigo.php?Tipo_ID='+Tipo_ID;
			getAx(url,'Div_Numero_proyecto',20); 
		}
	}
	
	function Empresas_Proyectos_Etapas(Pro_ID) 
	{				
		url = 'Empresas_Proyectos_Etapas.php?Pro_ID='+Pro_ID;
		getAx(url,'Div_Estapas_Proyecto',450); 
	}
	
	function Empresas_Proyectos_Etapas_Lista(Pro_ID) 
	{				
		url = 'Empresas_Proyectos_Etapas_Lista.php?Pro_ID='+Pro_ID;
		getAx(url,'Div_Empresas_Proyectos_Etapas_Lista',150); 
	}
	
	function Empresas_Proyectos_Etapas_Registrar() 
	{		
			//alert("llegue");
			datos='';		
			url = 'Empresas_Proyectos_Etapas_Registrar.php';	
			$(':input', $("#form_etapas_nuevo") ).each(function() {
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

			clearForm('form_etapas_nuevo');			
			postAx(url,datos,'Div_Empresas_Proyectos_Etapas_Lista',100);
	}	
		
		
	function Empresas_Proyectos_Etapas_RegistrarAdd() 
	{		
			//alert("llegue");
			datos='';		
			url = 'Empresas_Proyectos_Etapas_Registrar.php';	
			$(':input', $("#form_etapas_nuevo") ).each(function() {
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

			clearForm('form_etapas_nuevo');			
			postAx(url,datos,'Div_Empresas_Proyectos_Etapas_Lista',100);
	}	
		
		
		
	function Empresas_Proyecto_Etapas_Editar(Etapas_ID, Pro_ID, Nombre, Fecha_Inicio, Fecha_Fin, Horas, Note ) 
	{				
		document.form_etapas_nuevo.Etapas_ID.value = Etapas_ID;
		document.form_etapas_nuevo.Pro_ID.value = Pro_ID;
		document.form_etapas_nuevo.Nombre.value = Nombre;
		document.form_etapas_nuevo.Fecha_Inicio_Etapa.value = Fecha_Inicio;
		document.form_etapas_nuevo.Fecha_Fin_Etapa.value = Fecha_Fin;
		document.form_etapas_nuevo.Horas.value = Horas;
			document.form_etapas_nuevo.Note.value = Note;
		$("#span_bnt_save").show();
		$("#span_bnt_New").hide();
		//$("#Div_Datos_Material").html("");	 
	}
	
	function Empresas_Proyectos_Etapas_Editar_Cancelar() 
	{				
		document.form_etapas_nuevo.Etapas_ID.value = "";
		document.form_etapas_nuevo.Pro_ID.value = "";
		document.form_etapas_nuevo.Nombre.value = "";
		document.form_etapas_nuevo.Fecha_Inicio_Etapa.value = "";
		document.form_etapas_nuevo.Fecha_Fin_Etapa.value = "";
		document.form_etapas_nuevo.Horas.value = "";
		$("#span_bnt_save").hide();
		$("#span_bnt_New").show();	
	}
	
	function Empresas_Proyectos_Etapas_Editar_Guardar() 
	{		
			//alert("llegue");
			datos='';		
			url = 'Empresas_Proyectos_Etapas_Editar_Guardar.php';	
			$(':input', $("#form_etapas_nuevo") ).each(function() {
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

			clearForm('form_etapas_nuevo');			
			postAx(url,datos,'Div_Empresas_Proyectos_Etapas_Lista',100);
			/*$("#span_bnt_save").hide();
			$("#span_bnt_New").show();*/
	}	
	
	function Empresas_Proyecto_Etapas_Eliminar(Etapas_ID, Pro_ID) 
	{		
		if ( confirm("Esta seguro de Eliminar esta etapa ?"))
		{		
			url = 'Empresas_Proyecto_Etapas_Eliminar.php?Etapas_ID='+Etapas_ID+'&Pro_ID='+Pro_ID;	
			getAx(url,'Div_Empresas_Proyectos_Etapas_Lista',150); 
		}			
	}
	function Proyecto_Empleados_Empresa(Emp_ID) 
	{	
		if	(Emp_ID!="")
		{
			url = 'Proyecto_Empleados_Empresa.php?Emp_ID='+Emp_ID;		
			getAx(url,'Div_Proyecto_Empleados_Empresa',50); 
			$('#Div_Proyecto_Proyecto_Nuevo_Datos').show();								
		}
		else
		{
			$('#Div_Proyecto_Proyecto_Nuevo_Datos').hide();	
		}
	}		
	
	function Empresas_Proyecto_Editar(Emp_ID, Pro_ID) 
	{				
		url = 'Empresas_Proyecto_Editar.php?Emp_ID='+Emp_ID+"&Pro_ID="+Pro_ID;
		getAx(url,'basic-modal-content-espera',200); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}	
	
	function Empresas_Proyecto_Editar_Registrar() 
	{		
			//alert("llegue");
			datos='';		
			url = 'Empresas_Proyecto_Editar_Registrar.php';	
			$(':input', $("#Form_Empresas_Proyecto_Editar") ).each(function() {
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
			//clearForm('Form_Empresas_Proyecto_Nuevo');			
			
			if ($("#Div_Validar_Codigo").html()=="OK")
			{
				postAx(url,datos,'div_res_new_proyecto',100);
			}
			else
			{
				alert("Code Already in Use.")
			}
	}
	
	function Empresas_Eliminar(Emp_ID) 
	{				
		if ( confirm("Confirm erase company ?"))
		{
			url = 'Empresas_Eliminar.php?Emp_ID='+Emp_ID;
			getAx(url,'basic-modal-content-espera',200); 
			$('#basic-modal-content-espera').modal();
			return false;
		}
	}
		
	function Empresas_Proyecto_Eliminar(Emp_ID, Pro_ID) 
	{				
		if ( confirm("Confirm erase Job ?"))
		{
			url = 'Empresas_Proyecto_Eliminar.php?Emp_ID='+Emp_ID+'&Pro_ID='+Pro_ID;
			getAx(url,'basic-modal-content-espera',200); 
			$('#basic-modal-content-espera').modal();
			return false;
		}
	}					
</script>