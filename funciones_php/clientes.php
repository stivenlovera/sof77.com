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
			
			url = 'clientes_lista.php?nombre='+nombre+'&direccion='+direccion+'&detalle='+detalle+'&empresa='+empresa+'&telefono='+telefono+'&empresa='+empresa;
			url= url+'&inscritos_desde='+inscritos_desde+'&inscritos_hasta='+inscritos_hasta;
			url= url+'&llamadas_desde='+llamadas_desde+'&llamadas_hasta='+llamadas_hasta+'&inscrito='+inscrito+'&llamadas='+llamadas;
			//confirm(url);	
			my_url=url;		
			
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
	function alumnos_inuevo() 
	{				
		url = 'alumnos_inuevo.php';	
		getAx(url,'cliente_nuevo',450); 
		$("#ListaClientes").html("");
		$("#Menu_Cliente").html("");
		$("#Div_Datos_Cliente").html("");						
	}	
	
	function alumnos_nuevo() 
	{		
			//alert("llegue");
			datos='';		
			url = 'alumnos_registrar_nuevo.php';	
			$(':input', $("#form_alumnos_inuevo") ).each(function() {
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
			
			var bachiller='';
			var universitario='';
			var trabaja='';	
			bachiller=$('input[name=bachiller]:checked').val();
			universitario=$('input[name=universitario]:checked').val();
			trabaja=$('input[name=trabaja]:checked').val();	
			
			datos=datos+'&bachiller='+bachiller+'&universitario='+universitario+'&trabaja='+trabaja;				
			clearForm('form_alumnos_inuevo');			
			postAx(url,datos,'cliente_nuevo',100);
	}
	function clientes_editar_datos(Cli_ID,Cli_Nombre) 
	{				
		url = 'clientes_editar_datos.php?Cli_ID='+Cli_ID;	
		getAx(url,'Mod_Datos_Cliente',450); 
	}

	function alumnos_carreras_lista(Cli_ID)
	{				
		url = 'alumnos_carreras_lista.php?Cli_ID='+Cli_ID;	
		getAx(url,'alumnos_lista_carreras',450); 
	}
		
	function alumnos_carrera_inueva(Cli_ID)
	{				
		url = 'alumnos_carrera_inueva.php?Cli_ID='+Cli_ID;	
		getAx(url,'alumnos_lista_carreras_t',450);
		//alert(url); 
	}
	
	function alumnos_carrera_nueva()
	{		
			//alert("llegue");
			datos='';		
			url = 'alumnos_carrera_nueva.php';	
			$(':input', $("#form_alumnos_carreras_inuevo") ).each(function() {
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
			clearForm('form_alumnos_carreras_inuevo');			
			postAx(url,datos,'alumnos_lista_carreras_t',100);
	}
		
	function clientes_guardar() 
	{		
			//alert("llegue");
			datos='';		
			url = 'clientes_editar_guardar.php';	
			$(':input', $("#form_clientes_editar") ).each(function() {
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
							
			clearForm('form_clientes_editar');			
			postAx(url,datos,'Mod_Datos_Cliente',100);
	}

	function alumnos_kardex(Cli_ID, Cli_Nombre) 
	{		
			datos='';		
			//tipo_kardex= jQuery('#form_tipo_kardex input:radio:tipo_kardex:checked').val();		

			tipo_kardex=$('input[name=tipo_kardex]:checked').val();
			
			//alert (tipo_kardex);
			if (tipo_kardex=='a')
				url = 'alumnos_kardex_academico.php';	
			else
				url = 'alumnos_kardex_economico.php';
			
			//alert(	$('[name="cod_carrera_kardex3355"]:checked').val() );			
			//alert(jQuery('#form_tipo_kardex cod_carrera_kardex33:checked').val());
			
			/*radios2= $("#cod_carrera_kardex") ;
			for (i = 0; i < radios2.length; i++) {
				radio = radios2[i];
				if (radio.checked == true) {
					var cod_carrera = radio.value;
				}
			}*/	
			
			var cod_carrera=$('input[name=cod_carrera_kardex]:checked').val();
				
			datos='Cli_ID='+Cli_ID+'&Cli_Nombre='+Cli_Nombre+'&cod_carrera='+cod_carrera;	
			//alert(datos+"****");						
			postAx(url,datos,'kardex_aca_eco',100);
			//BuscarCliente();  		
	}
	function alumnos_toma_materias(opcion) 
	{					
			datos='';		
						
			if (opcion=='new')
				url = 'alumnos_toma_materias.php';	
			else
				url = 'alumnos_toma_materias_modificar.php';	
								
			$(':input', $("#form_toma_materias_1") ).each(function() {
				if ( (this.type!='submit') && ( this.type!='button') && ( this.type!='reset') && (this.type!='radio') && (this.type!='checkbox') )
				{
					cad=jQuery.trim(this.name);											
					cad1=jQuery.trim(this.value);				
				
					if (datos=='')					
						datos=datos+cad+'='+cad1;				
					else
						datos=datos+'&'+cad+'='+cad1;									
				}
			});
			/*var radios2= $("#cod_carrera_toma") ;
			for (i = 0; i < radios2.length; i++) {
				radio2 = radios2[i];
				if (radio2.checked == true) {
					var cod_carrera_toma = radio2.value;
				}
			}*/
			
			var cod_carrera=$('input[name=cod_carrera_toma]:checked').val();
															
			datos=datos+'&cod_carrera_toma='+cod_carrera;				
			
			//alert(datos+"****");						
			postAx(url,datos,'div_toma_materias',100);
	}
	
	function alumnos_toma_materias_eliminar(cod_computacion) 
	{					
			url = 'alumnos_toma_materias_eliminar.php';	
			
			datos='cod_computacion='+cod_computacion;				
			
			//alert(datos+"****");						
			postAx(url,datos,'div_toma_materias',100);
	}
	
	function alumnos_toma_materias_registrar(cod_materia_habilitada,ci,cod_periodo_toma,Cli_ID) 
	{	
		url = 'alumnos_toma_materias_registrar.php?cod_materia_habilitada='+cod_materia_habilitada+'&ci='+ci+'&cod_periodo_toma='+cod_periodo_toma+'&Cli_ID='+Cli_ID;	
		getAx(url,'div_toma_materias',450); 
	}
	
	function alumnos_nuevo_plan_inversion() 
	{					
			datos='';		
			url = 'alumnos_registro_plan_pago.php';	
			$(':input', $("#form_RegistroPlanPago") ).each(function() {
				if ( (this.type!='submit') && ( this.type!='button') && ( this.type!='reset') )
				{
					cad=jQuery.trim(this.name);											
					cad1=jQuery.trim(this.value);				
					if (datos=='')					
						datos=datos+cad+'='+cad1;				
					else
						datos=datos+'&'+cad+'='+cad1;									
				}
			});
			postAx(url,datos,'cliente_nuevo',100);
			//BuscarCliente();  		
	}
	
	function IModCliente(Cli_ID) 
	{	
		url = 'IModCliente_pre.php?Cli_ID='+Cli_ID;
		getAx(url,'IModClientexxx',450); 	
							
	}
	function DatosCliente(Cli_ID) 
	{	
		url = 'DatosCliente.php?Cli_ID='+Cli_ID;
		getAx(url,'Div_Datos_Cliente',450); 						
	}
	function Inuevos_Telefonos() 
	{	
		url = 'Inuevos_Telefonos_pre.php';
		getAx(url,'telefonos',450); 
		ultima_fila=1						
	}
	function Imod_Telefonos(Cli_ID) 
	{	
		url = 'Imod_Telefonos_pre.php?Cli_ID='+Cli_ID;
		//alert (url);
		getAx(url,'telefonos',450); 						
	}
	
	function datos_pre(opcion)
	{	
		if (opcion=='CallShop')
		{
			document.getElementById("Div_datos_CallShop").style.display="block" 
			//document.getElementById("Div_Referidos").style.display="none" 		
			//document.getElementById("telefonos").style.display="none" 			
		}
		else
		{
			document.getElementById("Div_datos_CallShop").style.display="none" 
			//document.getElementById("Div_Referidos").style.display="block" 		
			//document.getElementById("telefonos").style.display="block" 	
		}				
	}	
	
		
	function eliminar_cliente(Cli_ID)
	{
		if (confirm("Esta seguro de eliminar este cliente...") )
		{
			getAx('pre_BorrarPreregistro.php?cli_id='+Cli_ID,'idBorrar',100);
		}
	} 
	
		
		function CancelarIModCliente(tab) 
		{	
			document.getElementById("IModClientexxx").innerHTML="";
			document.getElementById("telefonos").innerHTML="";
			tabActivo4=""
		}
		function ModCliente() 
		{													
			i=0;
			var xx=0
			var srt="Los siguientes campos son Requeridos debe ingresar un valor para ellos:\n\n";					
			if (document.IModCliente_datos.Cli_Nombre.value=="") 
			{		
				srt=srt+"    Nombre           : Debe ingresar el nombre del cliente\n";	
				xx=1;
			}		
			if (document.IModCliente_datos.Cli_Apellido.value=="") 
			{		
				srt=srt+"    Apellido           : Debe ingresar el apellido del cliente\n";	
				xx=1;
			}			
				
			if (document.IModCliente_datos.Age_ID.value=="NO" )
			{		
				srt=srt+"    Agente           : Debe elegir un agente\n";	
				xx=1;
			}		
			if (document.IModCliente_datos.Cli_telefono.value=="" )
			{		
				srt=srt+"    Telefono           : Debe elegir un telefono de contacto\n";	
				xx=1;
			}										
					
			if (xx==0)
			{			
				url = "ModCliente_pre.php?";
				while (i<document.IModCliente_datos.length)
				{
					//alert(document.IModCliente.length);
					cad=Trim(document.IModCliente_datos.elements[i].name);				
					cad1=Trim(document.IModCliente_datos.elements[i].value);				
					if (i==0)
						url=url+cad+'='+cad1;				
					else
					{
						if ((cad!='tipo') && (cad!='nota_venta') && (cad!='certificado_garantia') && (cad!='croquis') && (cad!='letrero') )
						{
							url=url+'&'+cad+'='+cad1;				
						}											
					}
					i++;				
				}		
					
				denominacion="";
				numeros="";
				tel_id="";
				if ( (document.getElementById('telefonos').innerHTML!='') && (document.IModTelefonos.denominacion!=undefined))
				{
					ii=0;					
					if (document.IModTelefonos.denominacion.length!=undefined)
					{
						while (ii<document.IModTelefonos.denominacion.length)
						{
							if ( (document.IModTelefonos.denominacion[ii].value!='') && (document.IModTelefonos.numeros[ii].value!='') )
							{
								if (ii==0)
								{
									denominacion=denominacion+document.IModTelefonos.denominacion[ii].value;				
									numeros=numeros+document.IModTelefonos.numeros[ii].value;
									tel_id=tel_id+document.IModTelefonos.tel_id[ii].value;	
								}
								else
								{
									denominacion=denominacion+'|'+document.IModTelefonos.denominacion[ii].value;				
									numeros=numeros+'|'+document.IModTelefonos.numeros[ii].value;
									tel_id=tel_id+'|'+document.IModTelefonos.tel_id[ii].value;	
								}						
							}		
							//alert(tel_id+"  "+ii);
							ii++;
						}
					}
					else
					{
						if ( (document.IModTelefonos.denominacion.value!='') && (document.IModTelefonos.numeros.value!='') )
						{
							denominacion=document.IModTelefonos.denominacion.value;				
							numeros=document.IModTelefonos.numeros.value;
							tel_id=document.IModTelefonos.tel_id.value;									
						}								
					}				
				}	
				
				
				url=url+'&denominacion='+denominacion;	
				url=url+'&numeros='+numeros;
				url=url+'&tel_id='+tel_id;									
				
				var tipo='';			
				var xi=0;			
				if (document.IModCliente_datos.tipo.length!= undefined)
				{
					while (xi<document.IModCliente_datos.tipo.length )
					{
						//alert (document.IModCliente_datos.tipo[xi].value+' ** '+document.IModCliente_datos.tipo[xi].checked );
						if (document.IModCliente_datos.tipo[xi].checked == true) 
						{
							tipo = document.IModCliente_datos.tipo[xi].value;
						}
						xi++;
					}		
				}
				else
				{
					tipo='R';
				}				
				url=url+'&tipo='+tipo;	
				
				var nota_venta='';			
				xi=0;							
				while (xi<document.IModCliente_datos.nota_venta.length )
				{
						//alert (document.IModCliente_datos.tipo[xi].value+' ** '+document.IModCliente_datos.tipo[xi].checked );
						if (document.IModCliente_datos.nota_venta[xi].checked == true) 
						{
							nota_venta = document.IModCliente_datos.nota_venta[xi].value;
						}
						xi++;
				}						
				url=url+'&nota_venta='+nota_venta;	

				var certificado_garantia='';			
				xi=0;							
				while (xi<document.IModCliente_datos.certificado_garantia.length )
					{
						//alert (document.IModCliente_datos.tipo[xi].value+' ** '+document.IModCliente_datos.tipo[xi].checked );
						if (document.IModCliente_datos.certificado_garantia[xi].checked == true) 
						{
							certificado_garantia = document.IModCliente_datos.certificado_garantia[xi].value;
						}
						xi++;
				}		
				url=url+'&certificado_garantia='+certificado_garantia;	

				var croquis='';			
				xi=0;			
				while (xi<document.IModCliente_datos.croquis.length )
				{
						//alert (document.IModCliente_datos.tipo[xi].value+' ** '+document.IModCliente_datos.tipo[xi].checked );
						if (document.IModCliente_datos.croquis[xi].checked == true) 
						{
							croquis = document.IModCliente_datos.croquis[xi].value;
						}
						xi++;
				}								
				url=url+'&croquis='+croquis;	

				var letrero='';			
				xi=0;			
				while (xi<document.IModCliente_datos.letrero.length )
				{
						//alert (document.IModCliente_datos.tipo[xi].value+' ** '+document.IModCliente_datos.tipo[xi].checked );
						if (document.IModCliente_datos.letrero[xi].checked == true) 
						{
							letrero = document.IModCliente_datos.letrero[xi].value;
						}
						xi++;
				}									
				url=url+'&letrero='+letrero;	
				
				//alert(url);
				getAx(url,'IModClientexxx',100); 
				tabActivo4=""
				tabActivo6 = "";
				//document.getElementById("telefonos").innerHTML="";
			}
			else
			{
				alert (srt);						
			}
		}
		
		function verificarlc_CallType() 
		{   
		   if (document.form_referido.lc_CallType.value == "Suscrito Recomendacion (Quien)") {
				document.getElementById("ba_SearchandAddClientBlock").style.display="block" 
		   }
		   else
		   {
				document.getElementById("ba_SearchandAddClientBlock").style.display="none" 
				document.form_referido.Hidden_BillingAccountID.value = "";
				document.form_referido.lc_Detail.value= "";
		   }
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