<script type="text/javascript">
	function BuscarCliente(origen) 
	{		
			CancelarDiv('Menu_Cliente');				
			var nombre = document.rpt_SerchLoggedClienteMain.nombre.value
			var direccion = document.rpt_SerchLoggedClienteMain.direccion.value		
			var telefono = document.rpt_SerchLoggedClienteMain.telefono.value	
			var detalle = document.rpt_SerchLoggedClienteMain.detalle.value		
			var empresa = document.rpt_SerchLoggedClienteMain.empresa.value							
			var inscritos_desde = document.rpt_SerchLoggedClienteMain.inscritos_desde.value	
			var inscritos_hasta = document.rpt_SerchLoggedClienteMain.inscritos_hasta.value
			var llamadas_desde = document.rpt_SerchLoggedClienteMain.llamadas_desde.value	
			var llamadas_hasta = document.rpt_SerchLoggedClienteMain.llamadas_hasta.value	
			var inscrito = document.rpt_SerchLoggedClienteMain.inscrito.checked			
			var llamadas = document.rpt_SerchLoggedClienteMain.llamadas.checked					
			
			url = 'clientes_lista.php?nombre='+nombre+'&direccion='+direccion+'&detalle='+detalle+'&empresa='+empresa+'&telefono='+telefono;
			url= url+'&inscritos_desde='+inscritos_desde+'&inscritos_hasta='+inscritos_hasta;
			url= url+'&llamadas_desde='+llamadas_desde+'&llamadas_hasta='+llamadas_hasta+'&inscrito='+inscrito+'&llamadas='+llamadas;
			//confirm(url);	
			
			getAx(url,'ListaClientes',250); 						
			
			$("#Div_Datos_Cliente").html("");
			$("#cliente_nuevo").html("");			
			datos_cliente = "";
	}
	function datos_generales_cliente(Cli_ID)
	{	
		//alert("datos");		
		if ( (datos_cliente == "") || (cli_id_ant!=Cli_ID))
		{
			url_1 = "clientes_datos.php?Cli_ID="+Cli_ID;
			div_destino="Div_Datos_Cliente";						
			getAx(url_1,div_destino,100);					
			cli_id_ant=Cli_ID;						
			datos_cliente = "loaded";			
			$("#cliente_nuevo").html("");
		}
	}
	function clientes_lista_telefonos(Cli_ID)
	{	
		//alert("telefonos");
		url = "clientes_lista_telefonos.php?Cli_ID="+Cli_ID;
		div_destino="Div_lista_Telefonos";						
		getAx(url,div_destino,20);												
		$("#cliente_nuevo").html("");
	}
	function cliente_registrar_telefono(Cli_ID)
	{	
		Nuevo_Telefono=document.getElementById('Nuevo_Telefono').value;
		Nuevo_Telefono_Descripcion=document.getElementById('Nuevo_Telefono_Descripcion').value;
		if (Nuevo_Telefono=! "")
		{
			url = "cliente_registrar_telefono.php?Cli_ID="+Cli_ID+"&Nuevo_Telefono="+Nuevo_Telefono+"&Nuevo_Telefono_Descripcion="+Nuevo_Telefono_Descripcion;
			div_destino="Div_Mensage_Nuevo_Telefono";						
			getAx(url,div_destino,20);	
			document.getElementById('Boton_Nuevo_Telefono').disabled='disabled';											
		}
		else
		{
			alert ("Debe ingresar un Numero");
			document.getElementById('Boton_Nuevo_Telefono').disabled='disabled';
		}
	}
	
	function Cliente_Telefono_Registrado(telefono)
	{	
		if (confirm("Telefono Pertenec e a Otro Cliente\nSi Preciona aceptar: El numero sera registrado al actual Cliente\n y todas las llamadas ya registradas se asignaran al cliente actual"))
		{
			document.getElementById('Boton_Nuevo_Telefono').disabled='';
		}
		else
		{
			document.getElementById('Boton_Nuevo_Telefono').disabled='disabled';
		}
	}
	function clientes_compromisos_lista(Cli_ID) 
	{					

		url = 'clientes_compromisos_lista.php?Cli_ID='+Cli_ID;				
		getAx(url,'div_clientes_compromisos_lista',50); 						
	}

	function clientes_compromisos_editar(Comp_ID) 
	{					
		//alert ("Llego");
		url = 'clientes_compromisos_editar.php?Comp_ID='+Comp_ID;				
		getAx(url,'basic-modal-content-espera',50); 						
	}
	
	function clientes_compromisos_editar_guardar(Comp_ID) 
	{	
		var Nombre_Contratante = document.form_clientes_compromisos_editar.Nombre_Contratante.value
		var Direccion_Origen = encodeURIComponent(document.form_clientes_compromisos_editar.Direccion_Origen.value)		
		var Direccion_Destino = encodeURIComponent(document.form_clientes_compromisos_editar.Direccion_Destino.value)
		var Activo = document.form_clientes_compromisos_editar.Activo.checked			
		
		var Detalle = document.form_clientes_compromisos_editar.Detalle.value		
		var Fecha_Inicio = document.form_clientes_compromisos_editar.Fecha_Inicio.value							
		var Fecha_Fin = document.form_clientes_compromisos_editar.Fecha_Fin.value	
		var Hora = document.form_clientes_compromisos_editar.Hora.value
		var Numero_Pasajeros = document.form_clientes_compromisos_editar.Numero_Pasajeros.value	
		var Telefonos_Pasajeros = document.form_clientes_compromisos_editar.Telefonos_Pasajeros.value
		var Telefonos_de_Referencia = document.form_clientes_compromisos_editar.Telefonos_de_Referencia.value			
		
		var lunes = document.form_clientes_compromisos_editar.lunes.checked			
		var martes = document.form_clientes_compromisos_editar.martes.checked			
		var miercoles = document.form_clientes_compromisos_editar.miercoles.checked			
		var jueves = document.form_clientes_compromisos_editar.jueves.checked			
		var viernes = document.form_clientes_compromisos_editar.viernes.checked			
		var sabado = document.form_clientes_compromisos_editar.sabado.checked			
		var domingo = document.form_clientes_compromisos_editar.domingo.checked			
		
		url = 'clientes_compromisos_editar_guardar.php?Comp_ID='+Comp_ID+'&Nombre_Contratante='+Nombre_Contratante;
		url= url+'&Direccion_Origen='+Direccion_Origen+'&Direccion_Destino='+Direccion_Destino;	
		url= url+'&Activo='+Activo+'&Detalle='+Detalle+'&Fecha_Inicio='+Fecha_Inicio+'&Telefonos_de_Referencia='+Telefonos_de_Referencia;
		url= url+'&Fecha_Fin='+Fecha_Fin+'&Hora='+Hora+'&Numero_Pasajeros='+Numero_Pasajeros+'&Telefonos_Pasajeros='+Telefonos_Pasajeros;	
		url= url+'&lunes='+lunes+'&martes='+martes+'&miercoles='+miercoles+'&jueves='+jueves+'&viernes='+viernes+'&sabado='+sabado+'&domingo='+domingo;			
		getAx(url,'div_res_editar_compromiso',50); 						
		//alert (url);
	}
	function clientes_compromisos_eliminar(Comp_ID) 
	{			
		if (confirm("Esta Seguro de Eliminar este Compromiso!!!!!!!!!!"))
		{
			url = 'clientes_compromisos_eliminar.php?Comp_ID='+Comp_ID;			
			getAx(url,'basic-modal-content-espera',50); 						
			//alert (url);
		}
	}
	function clientes_compromisos_nuevo(Cli_ID) 
	{			
		url = 'clientes_compromisos_nuevo.php?Cli_ID='+Cli_ID;			
		getAx(url,'basic-modal-content-espera',50); 						
	}
	
	function clientes_compromisos_nuevo_guardar(Cli_ID) 
	{	
		var Nombre_Contratante = document.form_clientes_compromisos_editar.Nombre_Contratante.value
		var Direccion_Origen = encodeURIComponent(document.form_clientes_compromisos_editar.Direccion_Origen.value)		
		var Direccion_Destino = encodeURIComponent(document.form_clientes_compromisos_editar.Direccion_Destino.value)
		var Activo = document.form_clientes_compromisos_editar.Activo.checked			
		
		var Detalle = document.form_clientes_compromisos_editar.Detalle.value		
		var Fecha_Inicio = document.form_clientes_compromisos_editar.Fecha_Inicio.value							
		var Fecha_Fin = document.form_clientes_compromisos_editar.Fecha_Fin.value	
		var Hora = document.form_clientes_compromisos_editar.Hora.value
		var Numero_Pasajeros = document.form_clientes_compromisos_editar.Numero_Pasajeros.value	
		var Telefonos_Pasajeros = document.form_clientes_compromisos_editar.Telefonos_Pasajeros.value
		var Telefonos_de_Referencia = document.form_clientes_compromisos_editar.Telefonos_de_Referencia.value			
		var Monto_recorrido = document.form_clientes_compromisos_editar.Monto_recorrido.value	
		
		var lunes = document.form_clientes_compromisos_editar.lunes.checked			
		var martes = document.form_clientes_compromisos_editar.martes.checked			
		var miercoles = document.form_clientes_compromisos_editar.miercoles.checked			
		var jueves = document.form_clientes_compromisos_editar.jueves.checked			
		var viernes = document.form_clientes_compromisos_editar.viernes.checked			
		var sabado = document.form_clientes_compromisos_editar.sabado.checked			
		var domingo = document.form_clientes_compromisos_editar.domingo.checked			
		
		url = 'clientes_compromisos_nuevo_guardar.php?Cli_ID='+Cli_ID+'&Nombre_Contratante='+Nombre_Contratante;
		url= url+'&Direccion_Origen='+Direccion_Origen+'&Direccion_Destino='+Direccion_Destino;	
		url= url+'&Activo='+Activo+'&Detalle='+Detalle+'&Fecha_Inicio='+Fecha_Inicio+'&Telefonos_de_Referencia='+Telefonos_de_Referencia;
		url= url+'&Fecha_Fin='+Fecha_Fin+'&Hora='+Hora+'&Numero_Pasajeros='+Numero_Pasajeros+'&Telefonos_Pasajeros='+Telefonos_Pasajeros+'&Monto_recorrido='+Monto_recorrido;	
		url= url+'&lunes='+lunes+'&martes='+martes+'&miercoles='+miercoles+'&jueves='+jueves+'&viernes='+viernes+'&sabado='+sabado+'&domingo='+domingo;			
		getAx(url,'div_res_nuevo_compromiso',50); 						
		//alert (url);
	}
	
	
	

		
		/*********************************/
		//SubmitTask utilizado en AddRecomended Clients
		function ba_SearchandAddClients() 
		{		
			var cCompany=escape(document.form_referido.cCompany.value)
			var cLastname=document.form_referido.cLastname.value
			var cName=document.form_referido.cName.value
			var cAccountID=document.form_referido.cAccountID.value
					
			url = 'ba_SearchandAddRecomendedList.asp?cCompany='+cCompany+'&cLastname='+cLastname+'&cName='+cName+'&cAccountID='+cAccountID;			
			getAx(url,'ba_SearchClientsResult',150); 
		}

</script>