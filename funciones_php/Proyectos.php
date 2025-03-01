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
		var Estatus_ID = document.Form_Empresas_Lista.Estatus_ID_2.value							
		
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
	function Proyecto_Nuevo_Proyecto_Codigo(Tipo_ID) 
	{				
		if (Tipo_ID!='')
		{
			url = 'Empresas_Nuevo_Proyecto_Codigo.php?Tipo_ID='+Tipo_ID;
			getAx(url,'Div_Numero_proyecto',20); 
		}
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
			//clearForm('Form_Proyecto_Proyecto_Nuevo');						
			
			if ($("#Div_Validar_Codigo").html()=="OK")
			{
				postAx(url,datos,'div_res_new_proyecto',100);
			}
			else
			{
				alert("Code Already in Use.")
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




		
	function Empresas_Proyecto_Etapas_Editar(Etapas_ID, Pro_ID, Nombre, Fecha_Inicio, Fecha_Fin, Horas ) 
	{				
		document.form_etapas_nuevo.Etapas_ID.value = Etapas_ID;
		document.form_etapas_nuevo.Pro_ID.value = Pro_ID;
		document.form_etapas_nuevo.Nombre.value = Nombre;
		document.form_etapas_nuevo.Fecha_Inicio_Etapa.value = Fecha_Inicio;
		document.form_etapas_nuevo.Fecha_Fin_Etapa.value = Fecha_Fin;
		document.form_etapas_nuevo.Horas.value = Horas;
		
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
	
	function Proyecto_Editar(Pro_ID) 
	{				
		url = 'Proyecto_Editar.php?Pro_ID='+Pro_ID;
		getAx(url,'basic-modal-content-espera',200); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}	
	
	function Proyecto_Editar_Registrar() 
	{		
			//alert("llegue");
			datos='';		
			url = 'Empresas_Proyecto_Editar_Registrar.php';	
			$(':input', $("#Form_Proyecto_Editar") ).each(function() {
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
				postAx(url,datos,'div_res_new_proyecto',50);
				Proyectos_Lista();
			}
			else
			{
				alert("Code Already in Use.")
			}
	}
	
		
	function Proyecto_Eliminar( Pro_ID) 
	{				
		if ( confirm("Confirm erase Job ?"))
		{
			url = 'Proyecto_Eliminar.php?Pro_ID='+Pro_ID;
			getAx(url,'basic-modal-content-espera',200); 
			$('#basic-modal-content-espera').modal();
			return false;
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
						datos=datos+cad+'='+escape(cad1);				
					else
						datos=datos+'&'+cad+'='+escape(cad1);									
				}
			});											
			//clearForm($("#Form_Proyectos_Materiales_Nuevo"));			
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
						datos=datos+cad+'='+escape(cad1);				
					else
						datos=datos+'&'+cad+'='+escape(cad1);									
				}
			});											
			//clearForm($("#Form_Proyectos_Materiales_Editar"));			
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
					datos=datos+cad+'='+escape(cad1);				
				else
					datos=datos+'&'+cad+'='+escape(cad1);									
			}
		});											
		//clearForm($("#Form_Proyectos_Pedidos_Nuevo"));			
		postAx(url,datos,'div_res_new_pedido',100);		
		$("#div_btn_new_pedido").hide();
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
		//clearForm($("#form_pedidos_nuevo_item"));			
		postAx(url,datos,'div_pedido_lista_items',50);
	}	
	
	function Proyectos_Pedidos_Items_Lista(Ped_ID) 
	{	
		//alert ("Llego");	
		url = 'Proyectos_Pedidos_Items_Lista.php?Ped_ID='+Ped_ID;		
		getAx(url,'div_pedido_lista_items',50); 									
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
					datos=datos+cad+'='+escape(cad1);				
				else
					datos=datos+'&'+cad+'='+escape(cad1);									
			}
		});											
		//clearForm($("#form_pedidos_nuevo_item"));			
		postAx(url,datos,'div_res_new_pedido',50);
	}
	
	function Proyectos_Pedidos_Eliminar(Ped_ID,Pro_ID) 
	{		
		if ( confirm("Confirm erase Order ?"))
		{
			url = 'Proyectos_Pedidos_Eliminar.php?Ped_ID='+Ped_ID+'&Pro_ID='+Pro_ID;		
			getAx(url,'Div_Proyectos_Materiales_Lista',100); 									
		}
	}
	
		
	function Proyectos_Pedidos_Datos_Material(Pro_ID) 
	{	
		url = 'Proyectos_Pedidos_Datos_Material.php?Pro_ID='+Pro_ID;		
		getAx(url,'Div_Datos_Material',50); 									
	}
	

	function Proyectos_Pedidos_Item_Editar(Ped_Mat_ID, Ped_ID, Mat_ID, Cantidad, item_detalle)			 
	{	
		//alert(Ped_Mat_ID);
		document.form_pedidos_nuevo_item.Ped_Mat_ID.value = Ped_Mat_ID;
		document.form_pedidos_nuevo_item.Ped_ID_Item.value = Ped_ID;		
		$("#Mat_ID_Pedido").val(Mat_ID);	
		document.form_pedidos_nuevo_item.Cantidad.value = Cantidad;
		document.form_pedidos_nuevo_item.item_detalle.value = item_detalle;
		$("#span_bnt_save").show();
		$("#span_bnt_New").hide();
		//$("#Div_Datos_Material").html("");	
		//Proyectos_Pedidos_Datos_Material(Mat_ID); 											
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
	
	function Proyectos_Pedidos_Item_Eliminar(Ped_Mat_ID,Ped_ID) 
	{			
		url = 'Proyectos_Pedidos_Item_Eliminar.php?Ped_Mat_ID='+Ped_Mat_ID+'&Ped_ID='+Ped_ID;		
		getAx(url,'Div_Proyectos_Materiales_Lista',100);  									
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
	
	function Proyectos_Pedidos_Items_Email(Ped_ID) 
	{	
		//alert ("Llego");	
		url = 'Proyectos_Pedidos_Items_Email.php?Ped_ID='+Ped_ID;		
		getAx(url,'div_pedido_lista_items',250); 									
	}
	
	function Proyectos_Pedidos_Items_Copiar() 
	{	
		$('#wysiwyg').val( $("#Div_Orden_Email").html()	);	
		//$('#wysiwyg').val("hola");	
		Inicializar_Editor("wysiwyg");
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
		url = 'Proyectos_Pedidos_Email_Send.php';	
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
		
		datos=datos+'&Contenido='+escape($('#wysiwyg').val());
		postAx(url,datos,'div_pedido_lista_items',100);
		$('#btn_send_email').attr('disabled');
	}
	
	function Proyectos_Edificio_Expandir(Pro_ID,Edificio_ID) 
	{	
		$('#icon_tree_open_'+Edificio_ID).hide();
		$('#icon_tree_close_'+Edificio_ID).show();
		$('#Div_Pisos_'+Edificio_ID).show();
		
		url = 'Proyectos_Edificio_Piso_Lista.php?Pro_ID='+Pro_ID+'&Edificio_ID='+Edificio_ID;		
		getAx(url,'Div_Pisos_'+Edificio_ID,50); 	
	}
	
	function Proyectos_Edificio_Contraer(Edificio_ID) 
	{	
		$('#icon_tree_open_'+Edificio_ID).show();
		$('#icon_tree_close_'+Edificio_ID).hide(); 									
		$('#Div_Pisos_'+Edificio_ID).hide();
	}	
	
	
	function Proyectos_Piso_Expandir(Floor_ID) 
	{	
		$('#icon_tree_open_'+Floor_ID).hide();
		$('#icon_tree_close_'+Floor_ID).show();
		$('#Div_Areas_'+Floor_ID).show();
		
		url = 'Proyectos_Piso_Area_Lista.php?Floor_ID='+Floor_ID;		
		getAx(url,'Div_Areas_'+Floor_ID,50); 	
	}
	
	function Proyectos_Piso_Contraer(Floor_ID) 
	{	
		$('#icon_tree_open_'+Floor_ID).show();
		$('#icon_tree_close_'+Floor_ID).hide(); 									
		$('#Div_Areas_'+Floor_ID).hide();
	}	
	
	function Proyectos_Piso_Area_Expandir(Area_ID) 
	{	
		$('#icon_tree_open_area_'+Area_ID).hide();
		$('#icon_tree_close_area_'+Area_ID).show();
		$('#Div_tareas_'+Area_ID).show();
		
		url = 'Proyectos_Piso_Area_Tareas_Lista.php?Area_ID='+Area_ID;		
		getAx(url,'Div_tareas_'+Area_ID,50); 	
	}
	
	function Proyectos_Piso_Area_Contraer(Area_ID) 
	{	
		$('#icon_tree_open_area_'+Area_ID).show();
		$('#icon_tree_close_area_'+Area_ID).hide(); 									
		$('#Div_tareas_'+Area_ID).hide();
	}
		
	function Proyectos_Edificio_Lista(Pro_ID) 
	{	
		//alert ("Llego");	
		url = 'Proyectos_Edificio_Lista.php?Pro_ID='+Pro_ID;		
		getAx(url,'Div_Proyectos_Edificio_Lista',250); 									
	}
	
	function Proyectos_Piso_Lista(Pro_ID) 
	{	
		//alert ("Llego");	
		url = 'Proyectos_Piso_Lista.php?Pro_ID='+Pro_ID;		
		getAx(url,'Div_Proyectos_Piso_Lista',250); 									
	}
	
	function Proyectos_Edificio_Nuevo(Pro_ID) 
	{				
		url = 'Proyectos_Edificio_Nuevo.php?Pro_ID='+Pro_ID;	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}	
	
	
	function Project_Levels(Pro_ID) 
	{				
		url = 'Project_Levels.php?Pro_ID='+Pro_ID;	
	}	
	
	
	
	
	function Proyectos_Edificio_Nuevo_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Edificio_Nuevo_Registrar.php';	
		$(':input', $("#Form_Edificio_Nuevo") ).each(function() {
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
		postAx(url,datos,'Div_Proyecto_Piso_Nuevo',100);
	}
	
	function Proyectos_Piso_Nuevo(Pro_ID,Edificio_ID) 
	{				
		url = 'Proyectos_Piso_Nuevo.php?Pro_ID='+Pro_ID+'&Edificio_ID='+Edificio_ID;	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	function Proyectos_Piso_Nuevo_Registrar() 
	{		
		alert("llegue");
		datos='';		
		url = 'Proyectos_Piso_Nuevo_Registrar.php';	
		$(':input', $("#Form_Piso_Nuevo") ).each(function() {
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
		postAx(url,datos,'Div_Proyecto_Piso_Area_Nueva',100);
	}
	
	function Proyectos_Piso_Area_Nuevo_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Piso_Area_Nuevo_Registrar.php';	
		$(':input', $("#Form_Area_Nuevo") ).each(function() {
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
		postAx(url,datos,'Div_Proyecto_Piso_Area_Task_Nueva',100);
	}
	
	function Proyectos_Piso_Area_Task_Nuevo_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Piso_Area_Task_Nuevo_Registrar.php';	
		$(':input', $("#Form_Area_Task_Nuevo") ).each(function() {
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
		postAx(url,datos,'Div_Proyecto_Piso_Area_Task_res_Nueva',100);
	}	

	function Proyectos_Piso_Area_Nuevo(Floor_ID) 
	{				
		url = 'Proyectos_Piso_Area_Nuevo.php?Floor_ID='+Floor_ID;	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	function Proyectos_Piso_Area_Tarea_Nuevo(Area_ID) 
	{				
		url = 'Proyectos_Piso_Area_Tarea_Nuevo.php?Area_ID='+Area_ID;	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Proyectos_Piso_Area_Tarea_Nuevo_Copiar_Task(valores)
	{
		var split = valores.split('|');
		document.Form_Area_Task_Nuevo.Nombre.value = split[0];
		document.Form_Area_Task_Nuevo.Horas_Estimadas.value	 = split[2];
		document.Form_Area_Task_Nuevo.Material_Estimado.value = split[3];
		document.Form_Area_Task_Nuevo.Aux1.value = split[4];
		document.Form_Area_Task_Nuevo.Aux2.value	 = split[5];
		document.Form_Area_Task_Nuevo.Aux3.value = split[6];
		document.Form_Area_Task_Nuevo.Aux4.value = split[7];
		document.Form_Area_Task_Nuevo.Aux5.value = split[8];
		document.Form_Area_Task_Nuevo.Aux6.value = split[9];
		document.Form_Area_Task_Nuevo.Porcentaje.value = split[0];
	}
	
	function Proyectos_Piso_Editar(Floor_ID) 
	{				
		url = 'Proyectos_Piso_Editar.php?Floor_ID='+Floor_ID;	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Proyectos_Piso_Editar_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Piso_Editar_Registrar.php';	
		$(':input', $("#Form_Piso_Editar") ).each(function() {
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
		postAx(url,datos,'div_res_edit_piso',100);
	}
	
	function Proyectos_Piso_Eliminar(Floor_ID, Pro_ID) 
	{	
		//alert ("Floor_ID");	
		if (confirm("Are you Sure Deleted this Record"))
		{
			url = 'Proyectos_Piso_Eliminar.php?Pro_ID='+Pro_ID+'&Floor_ID='+Floor_ID;		
			getAx(url,'Div_Proyectos_Piso_Lista',250); 									
		}
	}
	
	
	function Proyectos_Edificio_Eliminar(Edificio_ID, Pro_ID) 
	{	
		//alert ("Floor_ID");	
		if (confirm("Are you Sure to Delete this Record"))
		{
			url = 'Proyectos_Edificio_Eliminar.php?Pro_ID='+Pro_ID+'&Edificio_ID='+Edificio_ID;		
			getAx(url,'Div_Proyectos_Piso_Lista',250); 									
		}
	}
	
	
	
	function Proyectos_Piso_Area_Editar(Area_ID) 
	{				
		url = 'Proyectos_Piso_Area_Editar.php?Area_ID='+Area_ID;	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Proyectos_Piso_Area_Editar_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Piso_Area_Editar_Registrar.php';	
		$(':input', $("#Form_Piso_Area_Editar") ).each(function() {
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
		postAx(url,datos,'div_res_edit_piso_area',100);
	}
	
	function Proyectos_Piso_Area_Eliminar(Area_ID, Floor_ID) 
	{	
		//alert ("Floor_ID");	
		if (confirm("Are you Sure Deleted this Record"))
		{
			url = 'Proyectos_Piso_Area_Eliminar.php?Area_ID='+Area_ID+'&Floor_ID='+Floor_ID;		
			getAx(url,'Div_Areas_'+Floor_ID,250); 									
		}
	}
	function Proyectos_Piso_Area_Tarea_Eliminar(Task_ID, Area_ID) 
	{	
		//alert ("Llego");	
		if (confirm("Are you Sure Deleted this Record"))
		{
			url = 'Proyectos_Piso_Area_Tarea_Eliminar.php?Task_ID='+Task_ID+'&Area_ID='+Area_ID;		
			getAx(url,'Div_tareas_'+Area_ID,250); 									
		}
	}
	
	function Proyectos_Piso_Area_Tarea_Editar(Task_ID) 
	{				
		url = 'Proyectos_Piso_Area_Tarea_Editar.php?Task_ID='+Task_ID;	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Proyectos_Piso_Area_Tarea_Editar_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Piso_Area_Tarea_Editar_Registrar.php';	
		$(':input', $("#Form_Piso_Area_Tarea_Editar") ).each(function() {
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
		postAx(url,datos,'div_res_edit_piso_area_tarea',100);
	}
	
	
	function Proyectos_Area_Lista(Pro_ID) 
	{	
		//alert ("Llego");	
		url = 'Proyectos_Area_Lista.php?Pro_ID='+Pro_ID;		
		getAx(url,'Div_Proyectos_Area_Lista',250); 									
	}	
	
	function Proyectos_Area_Nuevo(Pro_ID) 
	{				
		url = 'Proyectos_Area_Nuevo.php?Pro_ID='+Pro_ID;	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Proyectos_Area_Nuevo_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Area_Nuevo_Registrar.php';	
		$(':input', $("#Form_Proyectos_Area_Nuevo") ).each(function() {
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
		postAx(url,datos,'div_res_new_area',100);
	}
	
	function Proyectos_Area_Editar(Area_ID,Pro_ID) 
	{			
		url = 'Proyectos_Area_Editar.php?Area_ID='+Area_ID+'&Pro_ID='+Pro_ID;		
		getAx(url,'basic-modal-content-espera',100); 
		$('#basic-modal-content-espera').modal();
		return false;	 									
	}
	
	function Proyectos_Area_Editar_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Area_Editar_Registrar.php';	
		$(':input', $("#Form_Proyectos_Area_Editar") ).each(function() {
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
		postAx(url,datos,'div_res_new_area',50);
	}	
	
	function Proyectos_Area_Eliminar(Area_ID,Pro_ID) 
	{		
		if (confirm("Are you Sure Deleted this Record"))
		{
			url = 'Proyectos_Area_Eliminar.php?Area_ID='+Area_ID+'&Pro_ID='+Pro_ID;		
			getAx(url,'Div_Proyectos_Area_Lista',100); 									
		}
	}
	
	function Proyectos_Maquinarias_Lista(Pro_ID) 
	{	
		//alert ("Llego");	
		url = 'Proyectos_Maquinarias_Lista.php?Pro_ID='+Pro_ID;		
		getAx(url,'Div_Proyectos_Maquinaria_Lista',250); 									
	}	
	
	function Proyectos_Maquinarias_Nuevo(Pro_ID) 
	{				
		url = 'Proyectos_Maquinarias_Nuevo.php?Pro_ID='+Pro_ID;	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Proyectos_Maquinarias_Nuevo_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Maquinarias_Nuevo_Registrar.php';	
		$(':input', $("#Form_Proyectos_Maquinarias_Nuevo") ).each(function() {
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
		postAx(url,datos,'div_res_new_maquinaria',100);
	}
	
	function reporte_cronograma_actividades_lista(Pro_ID) 
	{	
		//alert ("Llego");	
		url = 'Proyectos_Actividades_Lista.php?From_Date=01-01-0&To_Date=01-01-2050&Proyecto=&Pro_ID='+Pro_ID;		
		getAx(url,'Div_Proyectos_Actividades_Lista',250); 									
	}	
	
	function Actividades_Asignar_Personal(Actividad_ID, Fecha) 
	{				
		url = 'Actividades_Asignar_Personal.php?Actividad_ID='+Actividad_ID+'&Fecha='+Fecha;	
		getAx(url,'basic-modal-content-espera',100); 
		$('#basic-modal-content-espera').modal();
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
		getAx(url,'Actividad_Personal_Disponible',100); 
	}	
	function Actividades_Personal_Eliminar(Empleado_ID, Actividad_ID, Fecha) 
	{				
		url = 'Actividades_Personal_Eliminar.php?Empleado_ID='+Empleado_ID+'&Actividad_ID='+Actividad_ID+'&Fecha='+Fecha;		
		getAx(url,'Actividad_Personal_Disponible',100); 
	}	
	
	function Proyectos_Actividades_Nuevo(Pro_ID) 
	{				
		url = 'Proyectos_Actividades_Nuevo.php?Pro_ID='+Pro_ID;	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}
	
	function Proyectos_Actividades_Nuevo_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Actividades_Nuevo_Registrar.php';	
		$(':input', $("#Form_Proyectos_Actividades_Nuevo") ).each(function() {
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
		postAx(url,datos,'div_res_new_Actividades',100);
	}
	
	function Proyectos_Actividades_Editar(Actividad_ID,Pro_ID) 
	{			
		url = 'Proyecto_Actividades_Editar.php?Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID;		
		getAx(url,'basic-modal-content-espera',100); 
		$('#basic-modal-content-espera').modal();
		return false;	 									
	}
	
	function Proyectos_Actividades_Editar_Registrar() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Actividades_Editar_Registrar.php';	
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
		//clearForm($("#form_pedidos_nuevo_item"));			
		postAx(url,datos,'div_res_new_Actividades',50);
	}	
	
	function Proyectos_Actividades_Eliminar(Actividad_ID,Pro_ID) 
	{			
		url = 'Proyectos_Actividades_Eliminar.php?Actividad_ID='+Actividad_ID+'&Pro_ID='+Pro_ID;		
		getAx(url,'basic-modal-content-espera',100); 
		$('#basic-modal-content-espera').modal();
		return false;	 									
	}
	
	function Proyecto_Registrar_Estatus(Pro_ID, Estatus_ID) 
	{				
		url = 'Proyecto_Registrar_Estatus.php?Pro_ID='+Pro_ID+'&Estatus_ID='+Estatus_ID;		
		getAx(url,'Res_Status',100); 
	}	
	
		
</script>