 <script type="text/javascript">
	function Maquinaria_Lista() 
	{		
		$("#Div_Maquinaria_Menu").html("");
		var Name = document.Form_Maquinaria_Lista.Nombre.value
		var Activo = document.Form_Maquinaria_Lista.Activo.value		
		
		url = 'Maquinaria_Lista.php?Name='+Name+'&Activo='+Activo;		
		getAx(url,'Div_Maquinaria_Lista',250); 									
	}	
	
	function Maquinaria_Nuevo() 
	{				
		url = 'Maquinaria_Nuevo.php';	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Maquinaria_Nuevo_Registrar() 
	{		
			//alert("llegue");
			datos='';		
			url = 'Maquinaria_Nuevo_Registrar.php';	
			$(':input', $("#Form_Maquinaria_Nuevo") ).each(function() {
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
			
			//clearForm('Form_Maquinaria_Nuevo');			
			postAx(url,datos,'div_res_new_maquinaria',100);
	}		
	
	function Maquinaria_Editar(Maq_ID) 
	{		
		url = 'Maquinaria_Editar.php?Maq_ID='+Maq_ID;		
		getAx(url,'basic-modal-content-espera',100); 
		$('#basic-modal-content-espera').modal();
		return false;									
	}
	function Maquinaria_Editar_Registrar() 
	{		
			//alert("llegue");
			datos='';		
			url = 'Maquinaria_Editar_Registrar.php';	
			$(':input', $("#Form_Maquinaria_Editar") ).each(function() {
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
			//clearForm($("#Form_Proyectos_Materiales_Editar"));			
			//alert($('[name="Estado_Radio"]:checked').val());
			Activo=$('[name="Estado_Radio"]:checked').val();	
			datos=datos+'&Activo='+Activo;	
			
			postAx(url,datos,'div_res_new_maquinaria',100);
	}
	
	function Maquinaria_Eliminar(Maq_ID) 
	{		
		if (confirm("Are You sure Delete This Record?"))
		{
			url = 'Maquinaria_Eliminar.php?Maq_ID='+Maq_ID;		
			getAx(url,'basic-modal-content-espera',100); 
			$('#basic-modal-content-espera').modal();
			return false;									
		}
	}		
</script>