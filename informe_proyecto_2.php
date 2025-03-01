<?php
	session_name("Administrador");
	session_start();
	
	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	
	require('Library/funciones.php');	
	$_SESSION["PageTitle"] = "Informe";	
	$_SESSION["Emp_ID_Aux"] = "";
	
	$PUEDE_VER_OPCION_TODOS_Y_LISTA_DE_VENDEDORES=validaRol(174,$bd);
	$PUEDE_VER_OPCION_TODOS_Y_SU_NOMBRE=validaRol(175,$bd);
	$PUEDE_VER_SOLO_SU_NOMBRE=validaRol(176,$bd);	
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

<link rel="stylesheet" href="jwysiwyg/jquery.wysiwyg.css" type="text/css" />
<script type="text/javascript" src="jwysiwyg/jquery.wysiwyg.js"></script>
          
<script type="text/javascript">
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
			var Criterio = document.Form_Empresas_Lista.Criterio.value			
			
			url = 'informe_proyectos_Lista.php?Company='+Company+'&Name='+Name+'&State='+State+'&City='+City+'&Zip_Code='+Zip_Code+'&Address='+Address+'&Estatus_ID='+Estatus_ID+'&Criterio='+Criterio;		
				
			getAx(url,'Div_Proyectos_Lista',250); 	
											
		}
		
	function informe_proyecto_nuevo(Pro_ID) 
	{				
		url = 'informe_proyecto_nuevo.php?Pro_ID='+Pro_ID;	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		//$('#basic-modal-content-espera').show();
		return false;						
	}
	
	function informe_proyecto_nuevo_registrar(Pro_ID) 
	{		
		//if ( $("#Form_Proyecto_Proyecto_Nuevo").valid() )
		//{
			datos='';		
			url = 'informe_proyecto_nuevo_registrar.php';	
			$(':input', $("#Form_Informe_Proyecto_Nuevo") ).each(function() {
				if ( (this.type!='submit') && ( this.type!='button') && ( this.type!='reset') && (this.type!='radio') && (this.type!='checkbox') )
				{
					cad=jQuery.trim(this.name);											
					cad1=jQuery.trim(this.value);				
					if (datos=='')					
						datos=datos+cad+'='+cad1;				
					else
						datos=datos+'&'+cad+'='+cad1;									
				}
				else
				{
					if (this.type=='checkbox')
					{
						cad=jQuery.trim(this.name);											
						cad1=this.checked;				
						if (datos=='')					
							datos=datos+cad+'='+cad1;				
						else
							datos=datos+'&'+cad+'='+cad1;		
					}					
				}
			});	
			
			
			datos=datos+'&YesNo='+$('input[name=YesNo]:checked', '#Form_Informe_Proyecto_Nuevo').val();				
			datos=datos+'&rate='+$('input[name=rate]:checked', '#Form_Informe_Proyecto_Nuevo').val();	
			datos=datos+'&substrates='+$('input[name=substrates]:checked', '#Form_Informe_Proyecto_Nuevo').val();	
			datos=datos+'&Drywall='+$('input[name=Drywall]:checked', '#Form_Informe_Proyecto_Nuevo').val();	
			
			datos=datos+'&Pro_ID='+Pro_ID;			
	
			postAx(url,datos,'Res_Informe',100);
			
			//$('#basic-modal-content-espera').hide();
		/*}
		else
		{		  	
			alert("Complete some fields");	
		}	*/	
	}	
			
	function informe_proyecto_Menu(Pro_ID,Nombre) 
	{		
		url = 'informe_proyecto_Menu.php?Pro_ID='+Pro_ID+"&Nombre="+Nombre;			
		getAx(url,'Div_Proyectos_Menu',250); 	
										
	}
	
	function Proyecto_Proyecto_Nuevo() 
	{				
		url = 'Proyecto_Proyecto_Nuevo.php';	
		getAx(url,'basic-modal-content-espera',450); 
		$('#basic-modal-content-espera').modal();
		return false;						
	}	
		
		
			
</script>

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
							<td width="98">Name:</td>
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
										while (($row = mysqli_fetch_array($result) ))							
										{								
								?>
											<option value="<?php echo  $row["Estatus_ID"];?>"><?php echo $row["Nombre_Estatus"];?></option>
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
									  <a href="#"><input type="reset" value="Clear"  /></a>
                                      <input name="Fecha_Inicio_Proyecto" type="text" id="Fecha_Inicio_Proyecto" size="20" datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>" />
										<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Inicio_Proyecto"));' />								
                                        <input type="button" value="NUevo" onClick="Proyecto_Proyecto_Nuevo();" />
								</td>		  		
						  </tr>						  
					</table>					
			  </form>				
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