<script type="text/javascript">
	function Task_Master_Lista() 
	{		
		var Nombre = document.Form_Empresas_Lista.Nombre.value		
		url = 'Task_Master_Lista.php?Nombre='+Nombre;		
		getAx(url,'Div_Task_Master_Lista',250); 									
	}
	function Task_Master_Nuevo() 
	{				
		url = 'Task_Master_Nuevo.php';	
		getAx(url,'basic-modal-content-espera',450); 		
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Task_Master_Nuevo_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Task_Master_Nuevo_Registrar.php';	
		$(':input', $("#Form_Task_Master_Nuevo") ).each(function() {
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
		clearForm('Form_Task_Master_Nuevo');			
		postAx(url,datos,'div_res_new_task_master',100);
		$("#Div_Task_Master_Lista").html("");
	}	
	
	function Task_Master_Editar(Task_Master_ID) 
	{				
		url = 'Task_Master_Editar.php?Task_Master_ID='+Task_Master_ID;	
		getAx(url,'basic-modal-content-espera',450); 		
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Task_Master_Editar_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Task_Master_Editar_Registrar.php';	
		$(':input', $("#Form_Task_Master_Editar") ).each(function() {
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
		postAx(url,datos,'div_res_new_task_master',100);
	}	
	
	function Task_Master_Eliminar(Task_Master_ID) 
	{				
		if ( confirm("Confirm erase task ?"))
		{
			url = 'Task_Master_Eliminar.php?Task_Master_ID='+Task_Master_ID;
			getAx(url,'basic-modal-content-espera',200); 
			$('#basic-modal-content-espera').modal();
			return false;
		}
	}					
</script>