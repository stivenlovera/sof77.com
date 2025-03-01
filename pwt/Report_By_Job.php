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

	$_SESSION["PageTitle"] = "Moviles";	

	$_SESSION["Cond_ID_Aux"] = "";	

		

	require('Header.php');

	$mes= date('n');

	$ano= date('y');	



	require('funciones_php/Actividades.php');	

		

?>

<LINK href="include/Stat.css" type="text/css" rel="stylesheet">

<link rel="STYLESHEET" type="text/css" href="include/estilo_reporte.css">

<script type="text/javascript" src="include/jquery-1.3.2.js"></script>

<script type="text/javascript" src="include/getAjax.js"></script> 

<script type="text/javascript" src="include/funciones.js"></script>

<script type="text/javascript" src="include/jquery.columnhover.js" ></script>	

<!-- Contact Form CSS files -->

<link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />

<script type='text/javascript' src='include/jquery.simplemodal.js'></script>



<script type="text/javascript" src="include/datepickercontrol.js"></script>

<link type="text/css" rel="stylesheet" href="css/datepickercontrol.css"/> 



<link href="css/flexigrid.pack.css" type="text/css" rel="stylesheet">	

<script src="include/flexigrid.pack.js" type="text/javascript"></script>	

    

<style type="text/css">

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



<script type="text/javascript" >

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

	

	function Report_By_Person_Lista() 

	{		

		var Fecha_Inicio_Busqueda = document.form_reporte.Fecha_Inicio_Busqueda.value

		var Fecha_Fin_Busqueda = document.form_reporte.Fecha_Fin_Busqueda.value	

		

		var Pro_ID_Reporte = $('input[name=Pro_ID_Reporte]:checked').val();		

		//alert (Pro_ID_Reporte);

		if (Pro_ID_Reporte==undefined)

		{

			Pro_ID_Reporte=-33;

			//alert (Pro_ID_Reporte);

		}

		

		if(form_reporte.radio[0].checked==true)

		{

			//alert(form_reporte.From_Date.value);			

			url = 'Report_By_Job_Lista_Preview.php?Fecha_Inicio_Busqueda='+Fecha_Inicio_Busqueda+'&Fecha_Fin_Busqueda='+Fecha_Fin_Busqueda+'&Pro_ID_Reporte='+Pro_ID_Reporte;		

			getAx(url,'basic-modal-content-espera',250);		

			$('#basic-modal-content-espera').modal(); 									

		}

		

		if(form_reporte.radio[1].checked==true)

		{

			//alert(form_reporte.radio[0].checked);

			url = 'Report_By_Job_Total_Preview.php?Fecha_Inicio_Busqueda='+Fecha_Inicio_Busqueda+'&Fecha_Fin_Busqueda='+Fecha_Fin_Busqueda+'&Pro_ID_Reporte='+Pro_ID_Reporte;		

			getAx(url,'basic-modal-content-espera',250);		

			$('#basic-modal-content-espera').modal(); 									

		}

	}	

	

	function Reporte_Actividades_lista_Proyectos() 

	{		

		var Company = document.form_reporte.Company.value

		var Nombre = document.form_reporte.Nombre.value		

		

		url = 'Reportes_lista_Proyectos.php?Company='+Company+'&Nombre='+Nombre;		

		getAx(url,'lista_proyectos',50); 

		$("#div_res_nueva_actividad").hide();									

	}			

</script>

<body link="#5865AF" vlink="#5865AF" alink="#5865AF" style="background: url(images/globolines.jpg) center no-repeat;" >

<table width="100%" cellpadding="0" cellspacing="0" border="0">

	<tr>

	    <td valign="top">		  

			<div id="ac_frmSearchMain">				  			  

			  <form id="form_reporte" name="form_reporte">			

					<table width="267" class="moduletable" >

						<tr>

							<th colspan="3">Hours by Job </th>

						</tr>		  		 																													 

						<tr>

							<td width="93" ><b>Start Date :</b></td>					

							<td width="162" colspan="2" valign="middle">

								<input type="text" name="Fecha_Inicio_Busqueda" id="Fecha_Inicio_Busqueda" size="12" datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>" />

								<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Inicio_Busqueda"));' />	

						  </td>

						</tr>

						<tr>

							<td align="left" valign="top"><b>End Date :</b>

							</td>

							<td>

								<input type="text" name="Fecha_Fin_Busqueda" id="Fecha_Fin_Busqueda" size="12" datepicker="true" datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>" />

								<img src="images/spacer.gif" onload='DatePickerControl.createButton(document.getElementById("Fecha_Fin_Busqueda"));' />

							</td>							

						</tr>	

						<tr>

						  <td align="center"></td>

						  <td align="center">

                            <label>

						    Detail<input type="radio" name="radio" id="por" value="detalle" checked="checked" />

						    </label>                          

                            <label>

						    <input type="radio" name="radio" id="por" value="gral" />

						    Totals</label>   
						</td>                       

				      </tr>

					   <tr>

							<td width="98"><strong>GC-Company:</strong></td>

							<td ><input type="text" name="Company" id="Company" size="20" value=""></td>

					</tr>

					<tr>

						<td><b>Job:</b> </td>

						<td><input type="text" name="Nombre" id="Nombre" size="12" value="" /><img src="images/buscar.jpg" onClick="Reporte_Actividades_lista_Proyectos();" />

						</td>

					</tr>

					<tr>

							<td colspan="2">

								<div id="lista_proyectos"></div>

							</td>

					</tr>

						<tr>

							<td colspan="2" align="center"><a href="#">

							  <input name="button" type="button" onClick="Report_By_Person_Lista();" value="Print Prev" />

							</a>&nbsp;&nbsp;&nbsp;

								  <a href="#">

							<input type="reset" value="Clear"  /></a>	
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

					<div id="basic-modal-content-espera" style="display:none">Hola es un demo</div>

					<div id="Div_Reporte_Lista">

					</div>							

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