<?php
    session_name("Administrador");
    session_start();
    
    if ($_SESSION["EntityID"] == "") {
        header("Location:sessionexpired.php");
    }
    require('Library/Control_Cache.php');
    require('Library/Open_Conexion.php');
    require('Library/funciones.php');
    $_SESSION["PageTitle"] = "Clientes";
    $_SESSION["Emp_ID_Aux"] = "";
    
    require('Header.php');
    
    $PUEDE_VER_OPCION_TODOS_Y_LISTA_DE_VENDEDORES=validaRol(174, $bd);
    $PUEDE_VER_OPCION_TODOS_Y_SU_NOMBRE=validaRol(175, $bd);
    $PUEDE_VER_SOLO_SU_NOMBRE=validaRol(176, $bd);
    require('funciones_php/Proyectos.php');
    require('funciones_php/funciones_generales.php');
?>
<LINK href="include/Stat.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="include/funciones.js"></script>
<script type="text/javascript" src="include/jquery-1.3.2.js"></script>
<script type="text/javascript" src="include/getAjax.js"></script> 

<link rel="stylesheet" href="css/jquery.wysiwyg.css" type="text/css" />
<script type="text/javascript" src="include/jquery.wysiwyg.js"></script>

<!-- calendar stylesheet -->
<!--<link rel="stylesheet" type="text/css" media="all" href="include/jscal/calendar-blue.css" title="blue" />-->
<!-- main calendar program -->
<!--<script type="text/javascript" src="include/jscal/calendar.js"></script>-->
<!--<script type="text/javascript" src="include/funciones.js"></script>-->
<!-- language for the calendar -->
<!--<script type="text/javascript" src="include/jscal/lang/calendar-es.js"></script>
<script type="text/javascript" src="include/jscal/calendar-setup.js"></script>-->
<script type="text/javascript" src="include/jquery.validate.js"></script>
<script type="text/javascript" src="include/cmxforms.js"></script>

<link type='text/css' href='css/demo.css' rel='stylesheet' media='screen' />	
<!-- Contact Form CSS files -->
<link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />
<script type='text/javascript' src='include/jquery.simplemodal.js'></script>

<script type="text/javascript" src="include/datepickercontrol.js"></script>
<link type="text/css" rel="stylesheet" href="css/datepickercontrol.css"/> 

<link href="css/flexigrid.pack.css" type="text/css" rel="stylesheet">	
<script src="include/flexigrid.pack.js" type="text/javascript"></script>

<link href="css/flexigrid.pack.css" type="text/css" rel="stylesheet">	
<script src="include/flexigrid.pack.js" type="text/javascript"></script>

<link rel="stylesheet" href="jwysiwyg/jquery.wysiwyg.css" type="text/css" />
<script type="text/javascript" src="jwysiwyg/jquery.wysiwyg.js"></script>



<script type="text/javascript">
$('.hora,#Co1,#Co2,#Co3,#Co4,#Co5').live('keyup', function() {
    var hora = $(".hora").val() || 0;
    var Co1 = $("#Co1").val() || 0;
    var Co2 = $("#Co2").val() || 0;
    var Co3 = $("#Co3").val() || 0;
    var Co4 = $("#Co4").val() || 0;
    var Co5 = $("#Co5").val() || 0;

    $(".hota_total").val(parseInt(hora) + parseInt(Co1) + parseInt(Co2) + parseInt(Co3) + parseInt(Co4) +
        parseInt(Co5));
});

$('#Fecha_Inicio_Proyecto, #Fecha_Fin_Proyecto').live('keyup', function() {
    var f1 = $('#Fecha_Inicio_Proyecto').val();
    var f2 = $('#Fecha_Fin_Proyecto').val();
    $("#Fecha_Inicio_Etapa").val(f1);
    $("#Fecha_Fin_Etapa").val(f2);
});
$("td[id^='CALDAY']").live('click', function() {
    var f1 = $('#Fecha_Inicio_Proyecto').val();
    var f2 = $('#Fecha_Fin_Proyecto').val();
    $("#Fecha_Inicio_Etapa").val(f1);
    $("#Fecha_Fin_Etapa").val(f2);
});
	function Iniciar_Validacion_Proyecto_Nueva()
	{			
		$().ready(function() {
			// validate the comment form when it is submitted
			$("#Form_Proyecto_Proyecto_Nuevo").validate({
				rules: {
					Codigo:"required",
					Nombre:"required",
					Ciudad:"required",
					Calle:"required",
					Estatus_ID:{					
						required: true,
						min: 0
					},		
					Tipo_ID:{					
						required: true,
						min: 0
					},		
					Project_Manager_ID:{					
						required: true,
						min: 0
					},		
					Coordinador_Obra_ID:{					
						required: true,
						min: 0
					},		
					Manager_ID:{					
						required: true,
						min: 0
					},		
					Coordinador_ID:{					
						required: true,
						min: 0
					},
					Foreman_ID:{					
						required: true,
						min: 0
					},												
					Zip_Code: {					
						minlength: 5,
						digits: true
					},
					Numero_Etapas: {											
						digits: true,
						min:1
					}			
				},
				messages: {					
					Estatus_ID:{					
						min: "Select One"
					},
					Tipo_ID:{					
						min: "Select One"
					},
					Project_Manager_ID:{					
						min: "Select One"
					},
					Coordinador_Obra_ID:{					
						min: "Select One"
					},
					Manager_ID:{					
						min: "Select One"
					},
					Coordinador_ID:{					
						min: "Select One"
					},
					Foreman_ID:{					
						min: "Select One"
					},
					Zip_Code: {					
						minlength: "5 digits at a minimum",
						digits: "Digits Only"
					}
					,
					Numero_Etapas: {					
						digits: "Digits Only",
						min: "Value > 0"
					}
				}		
			});			
			$("#Bnt_Proyecto_Nueva").click(function() 
			{
			  if ( $("#Form_Proyecto_Proyecto_Nuevo").valid() )
			  {
					Empresas_Nuevo_Proyecto_Registrar();
			  }
			  else
			  {		  	
					alert("Complete some fields");	
			  }
			  return false;
			});
		});
	}
	
	function Iniciar_Validacion_Proyecto_Material()
	{			
		$().ready(function() {
			// validate the comment form when it is submitted
			$("#Form_Proyectos_Materiales_Nuevo").validate({
				rules: {
					Denominacion:"required",
					Unidad_Medida:"required",
					Cat_ID:{					
						required: true,
						min: 0
					},		
					Ven_ID:{					
						required: true,
						min: 0
					}		
		
				},
				messages: {					
					Cat_ID:{					
						min: "Select One"
					},
					Ven_ID:{					
						min: "Select One"
					}
				}		
			});			
			$("#Bnt_Proyecto_Material_Nuevo").click(function() 
			{
			  if ( $("#Form_Proyectos_Materiales_Nuevo").valid() )
			  {
					Proyectos_Materiales_Nuevo_Registrar(); 		
			  }
			  else
			  {		  	
					alert("Complete some fields");	
			  }
			  return false;
			});
		});
	}
	
	function Iniciar_Validacion_Proyecto_Material_Editar()
	{			
		$().ready(function() {
			// validate the comment form when it is submitted
			$("#Form_Proyectos_Materiales_Editar").validate({
				rules: {
					Denominacion:"required",
					Unidad_Medida:"required",
					Cat_ID:{					
						required: true,
						min: 0
					},		
					Ven_ID:{					
						required: true,
						min: 0
					}		
		
				},
				messages: {					
					Cat_ID:{					
						min: "Select One"
					},
					Ven_ID:{					
						min: "Select One"
					}
				}		
			});			
			$("#Bnt_Proyecto_Material_Editar").click(function() 
			{
			  if ( $("#Form_Proyectos_Materiales_Editar").valid() )
			  {
					Proyectos_Materiales_Editar_Registrar(); 		
			  }
			  else
			  {		  	
					alert("Complete some fields");	
			  }
			  return false;
			});
		});
	}
	
	function Iniciar_Validacion_Edificio_Nuevo()
	{			
		$().ready(function() {
			// validate the comment form when it is submitted
			$("#Form_Edificio_Nuevo").validate({
				rules: {
					Nombre:"required"
				}		
			});			

			$("#Bnt_Edificio_Nuevo").click(function() 
			{
			  if ( $("#Form_Edificio_Nuevo").valid() )
			  {
					Proyectos_Edificio_Nuevo_Registrar(); 		
			  }
			  else
			  {		
					alert("Complete some fields");	
			  }
			  return false;
			});

		});

	}
	
	function Iniciar_Validacion_Piso_Nuevo()
	{			
		$().ready(function() {
			// validate the comment form when it is submitted
			$("#Form_Piso_Nuevo").validate({
				rules: {
					Nombre:"required"
				}		
			});			

			$("#Bnt_Piso_Nuevo").click(function() 
			{
			  if ( $("#Form_Piso_Nuevo").valid() )
			  {
					Proyectos_Piso_Nuevo_Registrar(); 		
			  }
			  else
			  {		
					alert("Complete some fields");	
			  }
			  return false;
			});

		});

	}
	
	function Iniciar_Validacion_Piso_Editar()
	{			
		$().ready(function() {
			// validate the comment form when it is submitted
			$("#Form_Piso_Editar").validate({
				rules: {
					Nombre:"required"
				}		
			});			

			$("#Bnt_Piso_Editar").click(function() 
			{
			  if ( $("#Form_Piso_Editar").valid() )
			  {
					Proyectos_Piso_Editar_Registrar(); 		
			  }
			  else
			  {		
					alert("Complete some fields");	
			  }
			  return false;
			});

		});

	}
	
	function Iniciar_Validacion_Piso_Area_Nuevo()
	{			
		$().ready(function() {
			// validate the comment form when it is submitted
			$("#Form_Area_Nuevo").validate({
				rules: {
					Nombre:"required"
				}		
			});			

			$("#Bnt_Area_Nuevo").click(function() 
			{
			  if ( $("#Form_Area_Nuevo").valid() )
			  {
					Proyectos_Piso_Area_Nuevo_Registrar(); 		
			  }
			  else
			  {		
					alert("Complete some fields");	
			  }
			  return false;
			});
		});
	}
	
	function Iniciar_Validacion_Piso_Area_Editar()
	{			
		$().ready(function() {
			// validate the comment form when it is submitted
			$("#Form_Piso_Area_Editar").validate({
				rules: {
					Nombre:"required"
				}		
			});			

			$("#Bnt_Piso_Editar").click(function() 
			{
			  if ( $("#Form_Piso_Area_Editar").valid() )
			  {
					Proyectos_Piso_Area_Editar_Registrar(); 		
			  }
			  else
			  {		
					alert("Complete some fields");	
			  }
			  return false;
			});

		});

	}
	
	function Iniciar_Validacion_Piso_Area_Task_Nuevo()
	{			
		$().ready(function() {
			// validate the comment form when it is submitted
			$("#Form_Area_Task_Nuevo").validate({
				rules: {
					Nombre:"required"
				}		
			});			

			$("#Bnt_Area_Task_Nuevo").click(function() 
			{
			  if ( $("#Form_Area_Task_Nuevo").valid() )
			  {
					Proyectos_Piso_Area_Task_Nuevo_Registrar(); 		
			  }
			  else
			  {		
					alert("Complete some fields");	
			  }
			  return false;
			});

		});

	}
	function Iniciar_Validacion_Piso_Area_Task_Editar()
	{			
		$().ready(function() {
			// validate the comment form when it is submitted
			$("#Form_Piso_Area_Tarea_Editar").validate({
				rules: {
					Nombre:"required"
				}		
			});			

			$("#Bnt_Tarea_Editar").click(function() 
			{
			  if ( $("#Form_Piso_Area_Tarea_Editar").valid() )
			  {
					Proyectos_Piso_Area_Tarea_Editar_Registrar(); 		
			  }
			  else
			  {		
					alert("Complete some fields");	
			  }
			  return false;
			});

		});

	}

   	function clearForm(form) {   
        // iterate over all of the inputs for the form   
        // element that was passed in
        $(':input', form).each(function() {
          var type = this.type;
          var tag = this.tagName.toLowerCase(); // normalize case
          // it's ok to reset the value attr of text inputs,
          // password inputs, and textareas
          if (type == 'text' || type == 'password' || tag == 'textarea')
            this.value = "";
          // checkboxes and radios need to have their checked state cleared
          // but should *not* have their 'value' changed
          else if (type == 'checkbox' || type == 'radio')
            this.checked = false;
          // select elements need to have their 'selectedIndex' property set to -1
          // (this works for both single and multiple select elements)
          else if (tag == 'select')
            this.selectedIndex = -1;
        });
	}
	
	function Inicializar_Editor(ID_Editor)
	{
		eval( "$('#"+ID_Editor+"').wysiwyg();" );
	}			
</script>	

<style type="text/css">
/*#form_alumnos_inuevo */
label.error {
	margin-left: 10px;
	width: auto;
	display: inline;
	color:#FF0000;
	background: url('images/unchecked.gif') no-repeat;
	padding-left: 16px;
	margin-left: .3em;
}
label.valid {
		background: url('images/checked.gif') no-repeat;
		display: block;
		width: 16px;
		height: 16px;
	}

.requerido {
	color:#FF0000;
	font-family:Arial, Helvetica, sans-serif;
	font-size:25px;
	font-weight:bold;
	margin-left: 10px;		
}
p.MsoNormal {
margin:0cm;
margin-bottom:.0001pt;
font-size:12.0pt;
font-family:"Times New Roman";
}
</style>


<style type="text/css">
<!--
.style10 {
	color: #FF0000;
	font-size: medium;
}
-->
	td.betterhover, #tabletwo tbody tr:hover
	{
		background: LightCyan;
	}
</style>

<script type="text/javascript">
	// variables para tabs activos
	var tabActivo1 = "";
	var tabActivo2 = "";
	var tabActivo3 = "";
	var tabActivo4 = "";
	var tabActivo5 = "";
	var tabActivo6 = "";
	var tabActivo7 = "";
	var tabActivo8 = "";
	var	menu=0;
	
	function Activar_Tab(tab) 
	{ 
		document.getElementById("tab1").className = ""; 
		document.getElementById("tab2").className = ""; 
		document.getElementById("tab3").className = ""; 
		document.getElementById("tab4").className = ""; 
		document.getElementById("tab5").className = ""; 
		document.getElementById("tab6").className = ""; 
		document.getElementById("tab7").className = ""; 		
		
		document.getElementById("tab"+tab).className = "active"; 
		//ocultar todos los divs
		if (document.getElementById)
		{
			var inc=1;
			while (document.getElementById("dropInfo"+inc))
			{
				document.getElementById("dropInfo"+inc).style.display="none";
				inc++;
			} 
		}
		document.getElementById("dropInfo"+tab).style.display="block";
	}
	
	function makeactive(tab,Pro_ID) 
	{ 
		Activar_Tab(tab);
		//Str_Activar_Tab.replace("tab_reem",tab);	
		//eval (Str_Activar_Tab.replace("tab_reem",tab))
		switch(tab) 
		{
			case 1 : 	{
							if (tabActivo1 == "" )
							{
								Proyectos_Materiales_Lista(Pro_ID);
								//tabActivo1 = "loaded";
							}			
							break;
						}
			case 2 : 	{
							if (tabActivo2 == "" ) 
							{								
								Proyectos_Pedidos_Lista(Pro_ID);
								//tabActivo2 = "loaded";								
							}
							break;
						}		
			case 3 : 	{
							if (tabActivo3 == "" ) 
							{
								Proyectos_Area_Lista(Pro_ID);								
								//tabActivo4 = "loaded";
							}					
							break;
						}	
						
			case 4 : 	{
							if (tabActivo4 == "" ) 
							{
								Proyectos_Maquinarias_Lista(Pro_ID);
								//tabActivo4 = "loaded";
							}					
							break;
						}		
			case 5 : 	{
							if (tabActivo5 == "" ) 
							{
								reporte_cronograma_actividades_lista(Pro_ID);
								//tabActivo4 = "loaded";
							}					
							break;
						}		
			case 6 : 	{
							if (tabActivo6 == "" ) 
							{
								Proyectos_Edificio_Lista(Pro_ID);
								//Proyectos_Piso_Lista(Pro_ID);
								//tabActivo4 = "loaded";
							}					
							break;
						}
			case 7 : 	{
							if (tabActivo7 == "" ) 
							{
								//Proyectos_Piso_Lista(Pro_ID);
								//tabActivo4 = "loaded";
							}					
							break;
						}	
																												
		}
	}		
	
		function ShowSearch() 
		{
			var odiv = document.getElementById("rpt_closetab");
			if (document.getElementById("ac_frmSearchMain").style.display=="none")
			 {
				odiv.innerHTML = "<img src=\"images\\div_left.gif\" border=\"0\" width=\"12\" />";
				document.getElementById("ac_frmSearchMain").style.display="block";
			 }
			else 
			  {
				odiv.innerHTML = "<img src=\"images\\div_right.gif\" border=\"0\" width=\"12\" />";	
				document.getElementById("ac_frmSearchMain").style.display="none";	
			  }
		}	
		
		function Proyecto_Reporte() 
		{		
			$("#Div_Proyectos_Menu").html("");
			var Company = document.Form_Empresas_Lista.Company.value
			var Name = document.Form_Empresas_Lista.Name.value
			var State = document.Form_Empresas_Lista.State.value		
			var City = document.Form_Empresas_Lista.City.value	
			var Zip_Code = document.Form_Empresas_Lista.Zip_Code.value		
			var Address = document.Form_Empresas_Lista.Address.value
			var Estatus_ID = document.Form_Empresas_Lista.Estatus_ID_2.value	
			var Criterio = document.Form_Empresas_Lista.Criterio.value				
			
			url = 'Proyectos_Reporte.php?Company='+Company+'&Name='+Name+'&State='+State+'&City='+City+'&Zip_Code='+Zip_Code+'&Address='+Address+'&Estatus_ID='+Estatus_ID+'&Criterio='+Criterio;
				
			getAx(url,'basic-modal-content-espera',250);		
			$('#basic-modal-content-espera').modal(); 										
		}	
</script>
<!-- libreria select2  versionamiendo de jquery 3.6.0 solo par el uso de select2 requerido-->
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
 ></script>
  
  <script>
	   var $jq = jQuery.noConflict();
  </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/emodal@1.2.69/dist/eModal.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
	.modal-open{overflow:hidden}.modal{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1050;display:none;overflow:hidden;outline:0}.modal-open .modal{overflow-x:hidden;overflow-y:auto}.modal-dialog{position:relative;width:auto;margin:.5rem;pointer-events:none}.modal.fade .modal-dialog{transition:-webkit-transform .3s ease-out;transition:transform .3s ease-out;transition:transform .3s ease-out,-webkit-transform .3s ease-out;-webkit-transform:translate(0,-25%);transform:translate(0,-25%)}.modal.show .modal-dialog{-webkit-transform:translate(0,0);transform:translate(0,0)}.modal-dialog-centered{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;min-height:calc(100% - (.5rem * 2))}.modal-content{position:relative;display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;width:100%;pointer-events:auto;background-color:#fff;background-clip:padding-box;border:1px solid rgba(0,0,0,.2);border-radius:.3rem;outline:0}.modal-backdrop{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1040;background-color:#000}.modal-backdrop.fade{opacity:0}.modal-backdrop.show{opacity:.5}.modal-header{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:start;-ms-flex-align:start;align-items:flex-start;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;padding:1rem;border-bottom:1px solid #e9ecef;border-top-left-radius:.3rem;border-top-right-radius:.3rem}.modal-header .close{padding:1rem;margin:-1rem -1rem -1rem auto}.modal-title{margin-bottom:0;line-height:1.5}.modal-body{position:relative;-webkit-box-flex:1;-ms-flex:1 1 auto;flex:1 1 auto;padding:1rem}.modal-footer{display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:end;-ms-flex-pack:end;justify-content:flex-end;padding:1rem;border-top:1px solid #e9ecef}.modal-footer>:not(:first-child){margin-left:.25rem}.modal-footer>:not(:last-child){margin-right:.25rem}.modal-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}@media (min-width:576px){.modal-dialog{max-width:500px;margin:1.75rem auto}.modal-dialog-centered{min-height:calc(100% - (1.75rem * 2))}.modal-sm{max-width:300px}}@media (min-width:992px){.modal-lg{max-width:800px}}
	.close{padding:1rem;margin:-1rem -1rem -1rem auto}
	button.close{padding:0;background-color:transparent;border:0;-webkit-appearance:none}
	@media only screen and (min-width: 580px) {
            .modal-lg {
                max-width: 80% !important;
            }
        }

        .file-footer-buttons>.btn {
            padding: 0.625rem 1rem;
            min-width: 0 !important;
            margin-top: 1rem;
        }
</style>
<!-- English -->
<body link="#5865AF" vlink="#5865AF" alink="#5865AF" style="background:  url(images/globolines.jpg)  center no-repeat;" >
<input type="hidden" id="DPC_TODAY_TEXT" value="today">
<input type="hidden" id="DPC_BUTTON_TITLE" value="Open calendar...">
<input type="hidden" id="DPC_MONTH_NAMES" value="['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']">
<input type="hidden" id="DPC_DAY_NAMES" value="['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	    <td valign="top">		  
			<div id="ac_frmSearchMain">				  
				<form id="Form_Empresas_Lista" name="Form_Empresas_Lista">			
					<table width="267" class="moduletable" >
						<tr>
						  <th colspan="3">Search Options -Jobs </th>
						</tr>		  		 				
						  <tr>
							<td width="98">GC-Company:</td>
							<td width="157" colspan="2"><input type="text" name="Company" id="Company" size="20" value=""></td>
						  </tr>		  		
						  <tr>
							<td width="98">Name or#:</td>
							<td width="157" colspan="2"><input type="text" name="Name" id="Name" size="20" value=""></td>
						  </tr>					
						  <tr>
							<td width="98">States:</td>
							<td width="157" colspan="2"><input type="text" name="State" id="State" size="20" value=""></td>
						  </tr>		  		
						<tr>
							<td>City:</td>
							<td colspan="2"><input type="text" name="City" id="City" size="20" value=""></td>
						</tr>
						<tr>
							<td>Zipo Code:</td>
							<td colspan="2"><input type="text" name="Zip_Code" id="Zip_Code" size="20" value=""></td>
						</tr>
						<tr>
							<td>Address:</td>
							<td colspan="2"><input type="text" name="Address" id="Address" size="20" value=""></td>
						</tr>
                        <tr>
							<td>Criterio:</td>
							<td colspan="2"><input type="text" name="Criterio" id="Criterio" size="20" value=""></td>
						</tr>
						<tr>
							<td>Status:</td>
							<td colspan="2"><?php
                                    $sql = "select Estatus_ID, Nombre_Estatus FROM estatus order by Nombre_Estatus";
                                    $result=$bd->ejecutar($sql);
                                ?>
									<select size="1" name="Estatus_ID_2" id="Estatus_ID_2"  class="cuadro">      
										<option  value="">--Select Status--</option>
								<?php
                                        while (($row = mysqli_fetch_array($result))) {
                                            ?>
											<option value="<?php echo  $row["Estatus_ID"]; ?>"><?php echo $row["Nombre_Estatus"]; ?></option>
								<?php
                                        }
                                        mysqli_free_result($result);
                                ?>
									</select>
							</td>
						</tr>															 							  						  	  	  
						  <tr>
								<td colspan="3" align="center">				  	
									  <a href="#"><input type="button" value="Search" onClick="Proyectos_Lista();" /></a> 
									  <a href="#"> <input name="button" type="button" onClick="Proyecto_Reporte();" value="Print Prev" /></a>
									  <a href="#"><input type="reset" value="Clear"  /></a>								
								</td>		  		
						  </tr>						  
					</table>					
			  </form>
				<fieldset id="Botono Nuevo_Cliente" class="" >
					<legend><span id="result_box" lang="en" xml:lang="en">Register New Job </span>: </legend>
					<table width="267" class="moduletable">
						<tr>
							<td>
								<a href="#">
									<input type="button" value="New" onClick="Proyecto_Proyecto_Nuevo()" />									
								</a>		
							</td>
						</tr>
					</table>			
				</fieldset>
			</div>	    
		</td>
		<td width="12" background="images/div_bkg.gif" valign="middle" onClick="javascript:ShowSearch()">
		  	<div id="rpt_closetab">
				<img src="images/div_left.gif" border="0" width="12" />
		  	</div>	  
	  	</td>
	  	<td valign="top" width="99%">
			<table width="100%">
				<tr>
					<td colspan="2">
					<div id="basic-modal-content-espera" style="display:none"></div>					
					<div id="Div_Proyectos_Lista">
					</div>		
					</td> 
				</tr>
				<tr>
				  <td colspan=2>					
						 <div id="Div_Proyectos_Datos"></div>		
				  </td>
				</tr> 							  
				<tr>
				  <td colspan=2>					
						 <div id="Div_Proyectos_Menu"></div>		
				  </td>
				</tr>				
			</table>
		</td>
	</tr>
</table>
</body>
<?php
    require('Library/Close_Conexion.php');
?>