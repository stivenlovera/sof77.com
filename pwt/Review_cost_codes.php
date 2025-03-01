

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
	require('funciones_php/foreman.php');

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

	

	//INLCUIDO POR FABIOLA 

	//***********************************

	function Review_cost_codes_ini() 
	{	
		var Nick_Name = document.form_reporte.Nick_Name.value
		var prNombre =	document.form_reporte.prNombre.value
		var Criterio = document.form_reporte.Criterio.value
		var Hrscon=	document.form_reporte.Hrscon.value		
		
		var filtro = $('input[name=filtro]:checked').val();		
		//alert (Pro_ID_Reporte);
		//alert (Criterio);
		if (filtro==undefined)
		{
			filtro="Vacio";
			//alert (Pro_ID_Reporte);
		}
		
		
		url = 'Review_cost_codes_table.php?vfrom_date='+form_reporte.From_Date.value+'&vto_date='+form_reporte.To_Date.value+'&Nick_Name='+Nick_Name+'&filtro='+filtro+'&Criterio='+Criterio+'&Hrscon='+Hrscon+'&prNombre='+prNombre;
		getAx(url,'Div_Reporte_Result',350);	
		
		
			
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

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	    <td valign="top">
			<div id="ac_frmSearchMain">	
				<form id="form_reporte" name="form_reporte">
					<table width="292" class="moduletable" >
						<tr>
							<th colspan="3">Review cost codes / Hours worked</th>
						</tr>
                        <tr>
							<td width="104" ><b>From Date  :</b></td>
							<td width="176" colspan="2" valign="middle">
								<input type="text" id="From_Date" name="From_Date" datepicker="true"  datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>"/>
							</td>
						</tr>
                                          
                        						
					  <tr>
							<td align="left" valign="top"><b>to Date :</b>
							</td>
							<td>
								<input type="text" id="To_Date"  name="To_Date" datepicker="true"  datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>"/>
							</td>
						</tr>
                       <tr>

							<td align="left" valign="top"><b>Nick Name :</b>

							</td>

							<td>

								<input type="text" name="Nick_Name" id="Nick_Name" />

							</td>							

						</tr>
                        
                      
                       
                       
                        
                        
					<tr>

						<td><b>Job:</b> </td>

						<td><input type="text" name="prNombre" id="prNombre"  /></td>

					</tr>
                       
                        
                       
                         <tr>
							<td height="20" align="left" valign="bottom"><p><b>Options :</b></p>
							  <p>&nbsp;</p>
						    <p>Hours &gt;8 or &lt;0:</p></td>
							<td>
							  <p>
							    <!--	Check In only * 
								  <input type="radio" name="filtro"  id="filtro" value="Solo_Ingreso" /><br>
                                Check Out only 
                                <input type="radio" name="filtro"  id="filtro" value="Solo_Salida" /><br>
                                Check In and Out 
                                <input type="radio" name="filtro"  id="filtro" value="Ambos" /><br>
                                No check In No Out 
                                <input type="radio" name="filtro"  id="filtro" value="Sin" />
                                -->
							    
							    Records with No Cost Code 
							    and Hours=8
							    <input type="radio" name="filtro"  id="filtro" value="No CostCode" />
							  </p>
							  <p><br>
							    
							    
							    <input name="Hrscon" type="text" id="Hrscon" value="" />
					       </p></td>							
					  </tr>		
 <tr>

						<td><p>&nbsp;</p>
					    <p>Area CostCode:</p></td>

						<td><p>&nbsp;</p>
						  <p>Ex: FL03  21.120</p>
						  <p>
                            <input name="Criterio" type="text" id="Criterio" value="" />
			  </p></td>

					</tr>
					  <tr>
							<td colspan="2" align="center"><a href="#">
							  <input name="button" type="button" onclick="Review_cost_codes_ini();" value="Review" />

							</a>&nbsp;&nbsp;&nbsp;

							  <a href="#">

							<input type="reset" value="Clear"  />
							  </a></tr>					  					  

				</table>

			  </form>	

                                                            

			

			</div>

		</td>

		<td width="12" background="images/div_bkg.gif" valign="middle" onclick="javascript:ShowSearch()">

		  	<div id="rpt_closetab">

				<img src="images/div_left.gif" border="0" width="12" />

		  	</div>	  

	  	</td>

  	  	<td valign="top" width="99%">

			<table width="100%">

				<tr>

					<td colspan="2">

					<div id="basic-modal-content-espera" style="display:none"></div>

					<div id="Div_Reporte_Result" ></div>					

					</td> 

				</tr>						 

			</table>			

		</td>

	</tr>

</table>



<?php



	require('Library/Close_Conexion.php');	

?>
 
