<script type="text/javascript">
	function Vendedor_Lista() 
	{		
		$("#Div_Empresas_Menu").html("");
		var Nombre = document.Form_Empresas_Lista.Nombre.value
		var Estado = document.Form_Empresas_Lista.Estado.value		
		var Ciudad = document.Form_Empresas_Lista.Ciudad.value	
		var Zip_Code = document.Form_Empresas_Lista.Zip_Code.value		
		var Calle = document.Form_Empresas_Lista.Calle.value
		var Telefono = document.Form_Empresas_Lista.Telefono.value							
		
		url = 'Vendedor_Lista.php?Nombre='+Nombre+'&Estado='+Estado+'&Ciudad='+Ciudad+'&Zip_Code='+Zip_Code+'&Calle='+Calle+'&Telefono='+Telefono;		
		getAx(url,'Div_Vendedor_Lista',250); 									
	}
	function Vendedor_Nuevo() 
	{				
		url = 'Vendedor_Nuevo.php';	
		getAx(url,'basic-modal-content-espera',450); 		
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Vendedor_Nuevo_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Vendedor_Nuevo_Registrar.php';	
		$(':input', $("#Form_Vendedor_Nuevo") ).each(function() {
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
		clearForm('Form_Vendedor_Nuevo');			
		postAx(url,datos,'div_res_new_vendedor',100);
		$("#Div_Vendedor_Lista").html("");
		$("#Div_Vendedor_Menu").html("");
	}	
	
	function Vendedor_Editar(Ven_ID) 
	{				
		url = 'Vendedor_Editar.php?Ven_ID='+Ven_ID;	
		getAx(url,'basic-modal-content-espera',450); 		
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Vendedor_Editar_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Vendedor_Editar_Registrar.php';	
		$(':input', $("#Form_Vendedor_Editar") ).each(function() {
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
		postAx(url,datos,'div_res_new_vendedor',100);
	}	
	
	function Vendedor_Eliminar(Ven_ID) 
	{				
		if ( confirm("Confirm erase vendor ?"))
		{
			url = 'Vendedor_Eliminar.php?Ven_ID='+Ven_ID;
			getAx(url,'basic-modal-content-espera',200); 
			$('#basic-modal-content-espera').modal();
			return false;
		}
	}					
</script>