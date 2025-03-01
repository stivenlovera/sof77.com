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

	

	//INLCUIDO POR FABIOLA 

	//***********************************

	function Reporte_horas_trabajador_preview() 
	{	
		var Nick_Name = document.form_reporte.Nick_Name.value
		var prNombre =	document.form_reporte.prNombre.value
		var Criterio1 = document.form_reporte.Criterio1.value				
		var Criterio2 = document.form_reporte.Criterio2.value				
		var Criterio3 = document.form_reporte.Criterio3.value				
		
		var filtro = $('input[name=filtro]:checked').val();		
		//alert (Pro_ID_Reporte);
		if (filtro==undefined)
		{
			filtro="Vacio";
			//alert (Pro_ID_Reporte);
		}
		
		
		url = 'Reporte_historico_preview.php?vfrom_date='+form_reporte.From_Date.value+'&vto_date='+form_reporte.To_Date.value+'&Nick_Name='+Nick_Name+'&filtro='+filtro+'&prNombre='+prNombre+'&Criterio1='+Criterio1+'&Criterio2='+Criterio2+'&Criterio3='+Criterio3;
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
					<table width="291" class="moduletable" >
						<tr>
							<th colspan="3">Report of records / Historic</th>
						</tr>
                        <tr>
							<td width="92" ><b>From Date  :</b></td>
							<td width="208" colspan="2" valign="middle">
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
							<td height="114" align="left" valign="top"><b>Options :</b></td>
							<td>
								Check In only * 
								  <input type="radio" name="filtro"  id="filtro" value="Solo_Ingreso" /><br>
                                Check Out only 
                                <input type="radio" name="filtro"  id="filtro" value="Solo_Salida" /><br>
                                Check In and Out 
                                <input type="radio" name="filtro"  id="filtro" value="Ambos" /><br>
                                No check In No Out 
                                <input type="radio" name="filtro"  id="filtro" value="No_in_No_out" /><br>
                                
                                No Cost Code 
                                <input type="radio" name="filtro"  id="filtro" value="No_CostCode" /><br>
                                
                                
						   No Check In 
                           <input type="radio" name="filtro"  id="filtro2" value="No_check_in" /></td>									
					  </tr>		
 <tr>

						<td><b>sql condition :</b> </td>

						<td><p>example w/pr.nombre pr.codigo</p>
                      
                        
						  <p>
<input name="Criterio1" type="text" id="Criterio1" value="" /> 
AND
</textarea>
<input name="Criterio2" type="text" id="Criterio2" value="" />
					      AND
						    <input name="Criterio3" type="text" id="Criterio3" value="" />
					      pr.codigo&lt;&gt;'023.19.3'  </p>
						  <p>No show:</p>
						  <p>t.Tas_IDT='VACNOSHOW'</p>
						  <p>Late: ac.Hora&lt;rd.hora_Ingreso</p>
			  <p>&nbsp; </p></td>

					</tr>
					  <tr>
							<td colspan="2" align="center"><a href="#">
							  <input name="button" type="button" onclick="Reporte_horas_trabajador_preview();" value="Report" />

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