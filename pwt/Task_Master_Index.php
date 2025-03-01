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

	$_SESSION["PageTitle"] = "Task Master";	

	$_SESSION["Emp_ID_Aux"] = "";	

	

	require('Header.php');	

	

	$PUEDE_VER_OPCION_TODOS_Y_LISTA_DE_VENDEDORES=validaRol(174,$bd);

	$PUEDE_VER_OPCION_TODOS_Y_SU_NOMBRE=validaRol(175,$bd);

	$PUEDE_VER_SOLO_SU_NOMBRE=validaRol(176,$bd);	

	require('funciones_php/Task_Master.php');	

	require('funciones_php/funciones_generales.php');			

?>

<LINK href="include/Stat.css" type="text/css" rel="stylesheet">

<script type="text/javascript" src="include/jquery-1.3.2.js"></script>

<script type="text/javascript" src="include/getAjax.js"></script> 

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

          

<script type="text/javascript">

	function Iniciar_Validacion_Task_Nuevo()
	{			
		$().ready(function() {
			// validate the comment form when it is submitted
			$("#Form_Task_Master_Nuevo").validate({
				rules: {
					Nombre:"required"
				}		
			});			

			$("#Bnt_Task_Master_Nuevo").click(function() 
			{
			  if ( $("#Form_Task_Master_Nuevo").valid() )
			  {
					Task_Master_Nuevo_Registrar(); 		
			  }
			  else
			  {		
					alert("Complete some fields");	
			  }
			  return false;
			});

		});

	}
	
	function Iniciar_Validacion_Task_Editar()
	{			
		$().ready(function() {
			// validate the comment form when it is submitted
			$("#Form_Task_Master_Editar").validate({
				rules: {
					Nombre:"required"
				}		
			});			

			$("#Bnt_Task_Master_Editar").click(function() 
			{
			  if ( $("#Form_Task_Master_Editar").valid() )
			  {
					Task_Master_Editar_Registrar(); 		
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



<!-- English -->
<body link="#5865AF" vlink="#5865AF" alink="#5865AF" style="background: url(images/globolines.jpg) center no-repeat;" >
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

						  	<th colspan="3">Task Master  </th>
						</tr>		  		 				
						<tr>
							<td width="70">Name:</td>
							<td width="157" colspan="2">
								<input type="text" name="Nombre" id="Nombre" size="20" value="">								
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">				  	
								  <a href="#"><input type="button" value="Search" ID="Find" Name="Find" onClick="Task_Master_Lista();"  />
								  </a> &nbsp;&nbsp;&nbsp;
								  <a href="#"><input type="reset" value="Clear"  />
								  </a>								
							</td>		  		
						</tr>						  

					</table>

			  </form>

				<fieldset id="Botono Nuevo_Cliente" class="" >

					<legend><span id="result_box" lang="en" xml:lang="en">Register New Task </span>: </legend>

					<table width="267" class="moduletable">

						<tr>

							<td>

								<a href="#">

									<input type="button" value="New" onClick="Task_Master_Nuevo();" />

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
						<div id="basic-modal-content-espera" style="display:none">Hola es un demo</div>
						<div id="Div_Task_Master_Lista">
						</div>		
					</td> 
				</tr>				
			</table>
		</td>
	</tr>
</table>

<?php

	require('Library/Close_Conexion.php');	

?>