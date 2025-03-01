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
		clearForm('Form_Empresas_Nueva');			
		postAx(url,datos,'div_res_new_empresa',100);
		$("#Div_Empresas_Lista").html("");
		$("#Div_Empresas_Menu").html("");
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
		postAx(url,datos,'div_res_new_empresa',100);
		$("#Div_Empresas_Menu").html("");
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
		getAx(url,'basic-Div_Empresas_Lista_Empleados-content-espera',150); 		
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
		
	function Empresas_Nuevo_Proyecto(Emp_ID) 
	{				
		url = 'Empresas_Nuevo_Proyecto.php?Emp_ID='+Emp_ID;
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	function Empresas_Nuevo_Proyecto_Registrar(Emp_ID) 
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
			datos = datos + "&Emp_ID="+Emp_ID;									
			clearForm('Form_Empresas_Proyecto_Nuevo');			
			postAx(url,datos,'div_res_new_proyecto',100);
	}

	function Empresas_Proyectos_Etapas(Pro_ID) 
	{				
		url = 'Empresas_Proyectos_Etapas.php?Pro_ID='+Pro_ID;
		getAx(url,'Div_Estapas_Proyecto',450); 
	}
	
	function Empresas_Proyectos_Etapas_Lista(Pro_ID) 
	{				
		url = 'Empresas_Proyectos_Etapas_Lista.php?Pro_ID='+Pro_ID;
		getAx(url,'Div_Empresas_Proyectos_Etapas_Lista',450); 
	}
	
	function Empresas_Proyectos_Etapas_Registrar(Pro_ID) 
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
			datos = datos + "&Pro_ID="+Pro_ID;									
			clearForm('form_etapas_nuevo');			
			postAx(url,datos,'Div_Empresas_Proyectos_Etapas_Lista',100);
	}
	
	function Empresas_Proyecto_Editar(Emp_ID) 
	{				
		url = 'Empresas_Nuevo_Proyecto.php?Emp_ID='+Emp_ID;
		getAx(url,'basic-modal-content-espera',200); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}	
	
	function Empresas_Eliminar(Emp_ID) 
	{				
		if ( confirm("Esta seguro de Eliminar esta empresa ?"))
		{
			url = 'Empresas_Eliminar.php?Emp_ID='+Emp_ID;
			getAx(url,'basic-modal-content-espera',200); 
			$('#basic-modal-content-espera').modal();
			return false;
		}
	}				
</script>