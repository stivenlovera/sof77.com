<script type="text/javascript">
	function Proyectos_Lista() 
	{		
		$("#Div_Proyectos_Menu").html("");
		var Company = document.Form_Empresas_Lista.Company.value
		var Name = document.Form_Empresas_Lista.Name.value
		var State = document.Form_Empresas_Lista.State.value		
		var City = document.Form_Empresas_Lista.City.value	
		var Zip_Code = document.Form_Empresas_Lista.Zip_Code.value		
		var Address = document.Form_Empresas_Lista.Address.value
		var Estatus_ID = document.Form_Empresas_Lista.Estatus_ID.value							
		
		url = 'Proyectos_Lista.php?Company='+Company+'&Name='+Name+'&State='+State+'&City='+City+'&Zip_Code='+Zip_Code+'&Address='+Address+'&Estatus_ID='+Estatus_ID;		
		getAx(url,'Div_Proyectos_Lista',250); 									
	}	
	
	function Proyecto_Proyecto_Nuevo() 
	{				
		url = 'Proyecto_Proyecto_Nuevo.php';	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Proyecto_Empleados_Empresa(Emp_ID) 
	{	
		if	(Emp_ID!="")
		{
			url = 'Proyecto_Empleados_Empresa.php?Emp_ID='+Emp_ID;		
			getAx(url,'Div_Proyecto_Empleados_Empresa',250); 
			$('#Div_Proyecto_Proyecto_Nuevo_Datos').show();								
		}
		else
		{
			$('#Div_Proyecto_Proyecto_Nuevo_Datos').hide();	
		}
	}	
	function Empresas_Nuevo_Proyecto_Registrar() 
	{		
			//alert("llegue");
			datos='';		
			url = 'Empresas_Nuevo_Proyecto_Registrar.php';	
			$(':input', $("#Form_Proyecto_Proyecto_Nuevo") ).each(function() {
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
			clearForm('Form_Proyecto_Proyecto_Nuevo');			
			postAx(url,datos,'div_res_new_proyecto',100);
	}
		
	function Proyectos_Menu(Pro_ID)
	{	
		$("#Div_Proyectos_Menu").html("");		
		tabActivo1 = "";
		tabActivo2 = "";
		tabActivo3 = "";
		tabActivo4 = "";
						
		url = 'Proyectos_Menu.php?Pro_ID='+Pro_ID;
		getAx(url,'Div_Proyectos_Menu',100);
		menu=1; 
	}	

	function Proyectos_Materiales_Nuevo(Pro_ID) 
	{				
		url = 'Proyectos_Materiales_Nuevo.php?Pro_ID='+Pro_ID;	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Proyectos_Materiales_Lista(Pro_ID) 
	{		
		url = 'Proyectos_Materiales_Lista.php?Pro_ID='+Pro_ID;		
		getAx(url,'Div_Proyectos_Materiales_Lista',250); 									
	}	
	function Proyectos_Materiales_Nuevo_Registrar() 
	{		
			//alert("llegue");
			datos='';		
			url = 'Proyectos_Materiales_Nuevo_Registrar.php';	
			$(':input', $("#Form_Proyectos_Materiales_Nuevo") ).each(function() {
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
			clearForm($("#Form_Proyectos_Materiales_Nuevo"));			
			postAx(url,datos,'div_res_new_material',100);
	}
	
	function Proyectos_Materiales_Editar(Mat_ID, Pro_ID) 
	{		
		url = 'Proyectos_Materiales_Editar.php?Mat_ID='+Mat_ID+'&Pro_ID='+Pro_ID;		
		getAx(url,'basic-modal-content-espera',100); 
		$('#basic-modal-content-espera').modal();
		return false;									
	}
	
	function Proyectos_Materiales_Eliminar(Mat_ID,Pro_ID) 
	{		
		url = 'Proyectos_Materiales_Eliminar.php?Mat_ID='+Mat_ID+'&Pro_ID='+Pro_ID;		
		getAx(url,'Div_Proyectos_Materiales_Lista',100); 									
	}
	
	function Proyectos_Materiales_Editar_Registrar() 
	{		
			//alert("llegue");
			datos='';		
			url = 'Proyectos_Materiales_Editar_Registrar.php';	
			$(':input', $("#Form_Proyectos_Materiales_Editar") ).each(function() {
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
			clearForm($("#Form_Proyectos_Materiales_Editar"));			
			postAx(url,datos,'div_res_new_material',100);
	}
	
	function Proyectos_Pedidos_Lista(Pro_ID) 
	{		
		url = 'Proyectos_Pedidos_Lista.php?Pro_ID='+Pro_ID;		
		getAx(url,'Div_Proyectos_Pedidos_Lista',250); 									
	}	
	
	function Proyectos_Pedidos_Nuevo(Pro_ID) 
	{				
		url = 'Proyectos_Pedidos_Nuevo.php?Pro_ID='+Pro_ID;	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}	
	
	function Proyectos_Pedidos_Nuevo_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Pedidos_Nuevo_Registrar.php';	
		$(':input', $("#Form_Proyectos_Pedidos_Nuevo") ).each(function() {
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
		//clearForm($("#Form_Proyectos_Pedidos_Nuevo"));			
		postAx(url,datos,'div_res_new_pedido',100);
	}
	
	function Proyectos_Pedidos_Editar(Ped_ID, Pro_ID) 
	{		
		url = 'Proyectos_Pedidos_Editar.php?Ped_ID='+Ped_ID+'&Pro_ID='+Pro_ID;		
		getAx(url,'basic-modal-content-espera',100); 
		$('#basic-modal-content-espera').modal();
		return false;									
	}
	function Proyectos_Pedidos_Nuevo_Item_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Pedidos_Nuevo_Item_Registrar.php';	
		$(':input', $("#form_pedidos_nuevo_item") ).each(function() {
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
		clearForm($("#form_pedidos_nuevo_item"));			
		postAx(url,datos,'div_pedido_lista_items',100);
	}	
	
	function Proyectos_Pedidos_Items_Lista(Ped_ID) 
	{	
		//alert ("Llego");	
		url = 'Proyectos_Pedidos_Items_Lista.php?Ped_ID='+Ped_ID;		
		getAx(url,'div_pedido_lista_items',250); 									
	}
	
	function Proyectos_Pedidos_Editar(Ped_ID,Pro_ID) 
	{			
		url = 'Proyectos_Pedidos_Editar.php?Ped_ID='+Ped_ID+'&Pro_ID='+Pro_ID;		
		getAx(url,'basic-modal-content-espera',100); 
		$('#basic-modal-content-espera').modal();
		return false;	 									
	}
	
	function Proyectos_Pedidos_Editar_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Pedidos_Editar_Registrar.php';	
		$(':input', $("#Form_Proyectos_Pedidos_Nuevo") ).each(function() {
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
		//clearForm($("#form_pedidos_nuevo_item"));			
		postAx(url,datos,'div_res_new_pedido',50);
	}	
	function Proyectos_Pedidos_Datos_Material(Mat_ID) 
	{	
		//alert ("Llego");	
		if (Mat_ID!="")
		{
			url = 'Proyectos_Pedidos_Datos_Material.php?Mat_ID='+Mat_ID;		
			getAx(url,'Div_Datos_Material',50); 									
		}
		else
		{
			$("#Div_Datos_Material").html("");		
		}
	}
	

	function Proyectos_Pedidos_Item_Editar(Ped_Mat_ID, Ped_ID, Mat_ID, Cantidad)			 
	{	
		//alert(Ped_Mat_ID);
		document.form_pedidos_nuevo_item.Ped_Mat_ID.value = Ped_Mat_ID;
		document.form_pedidos_nuevo_item.Ped_ID_Item.value = Ped_ID;		
		$("#Mat_ID_Pedido").val(Mat_ID);	
		document.form_pedidos_nuevo_item.Cantidad.value = Cantidad;
		$("#span_bnt_save").show();
		$("#span_bnt_New").hide();
		//$("#Div_Datos_Material").html("");	
		Proyectos_Pedidos_Datos_Material(Mat_ID); 											
	}
	
	function Proyectos_Pedidos_Items_Editar_Guardar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Pedidos_Items_Editar_Guardar.php';	
		$(':input', $("#form_pedidos_nuevo_item") ).each(function() {
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
		//clearForm($("#Proyectos_Pedidos_Items_Guardar"));			
		postAx(url,datos,'div_pedido_lista_items',100);
	}
	
	function Proyectos_Pedidos_Items_Cancelar() 
	{			
		clearForm($("#form_pedidos_nuevo_item"));			
		$("#span_bnt_save").hide();
		$("#span_bnt_New").show();
		
	}	
	
	function Proyectos_Pedidos_Preview(Ped_ID,Pro_ID) 
	{			
		url = 'Proyectos_Pedidos_Preview.php?Ped_ID='+Ped_ID+'&Pro_ID='+Pro_ID;		
		getAx(url,'basic-modal-content-espera',100); 
		$('#basic-modal-content-espera').modal();
		return false;	 									
	}
			
	function Proyectos_Pedidos_Items_Preview(Ped_ID) 
	{	
		//alert ("Llego");	
		url = 'Proyectos_Pedidos_Items_Preview.php?Ped_ID='+Ped_ID;		
		getAx(url,'div_pedido_lista_items',250); 									
	}
	
	function Proyectos_Pedidos_Email(Ped_ID, Pro_ID, Ven_ID) 
	{			
		url = 'Proyectos_Pedidos_Email.php?Ped_ID='+Ped_ID+'&Pro_ID='+Pro_ID+'&Ven_ID='+Ven_ID;		
		getAx(url,'basic-modal-content-espera',100); 
		$('#basic-modal-content-espera').modal();
		return false;	 									
	}
	
	function Proyectos_Pedidos_Email_Send() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Pedidos_Items_Editar_Guardar.php';	
		$(':input', $("#Form_Proyecto_Pedidos_Email_Send") ).each(function() {
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
		postAx(url,datos,'div_pedido_lista_items',100);
	}
	
	
		
</script>