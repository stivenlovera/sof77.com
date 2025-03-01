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
		var Company = document.form_reporte.Company.value	
		var TypeE = document.form_reporte.TypeE.value
		var CodPro = document.form_reporte.CodPro.value	
		var filtro = $('input[name=filtro]:checked').val();		
		//alert (Pro_ID_Reporte);
		if (filtro==undefined)
		{
			filtro="Vacio";
			//alert (Pro_ID_Reporte);
		}
		
		
				url = 'Reporte_horas_trabajador_preview.php?vfrom_date='+form_reporte.From_Date.value+'&vto_date='+form_reporte.To_Date.value+'&Nick_Name='+Nick_Name+'&TypeE='+TypeE+'&CodPro='+CodPro+'&Company='+Company+'&filtro='+filtro;
		getAx(url,'Div_Reporte_Result',250);		
	}		
	
	function Reporte_horas_trabajador_export() 
	{			
		var Nick_Name = document.form_reporte.Nick_Name.value	
		var Company = document.form_reporte.Company.value	
		var TypeE = document.form_reporte.TypeE.value
		var filtro = $('input[name=filtro]:checked').val();		
		//alert (Pro_ID_Reporte);
		if (filtro==undefined)
		{
			filtro="Vacio";
			//alert (Pro_ID_Reporte);
		}
		
		
		url = 'Reporte_horas_trabajador_export.php?vfrom_date='+form_reporte.From_Date.value+'&vto_date='+form_reporte.To_Date.value+'&Nick_Name='+Nick_Name+'&TypeE='+TypeE+'&Company='+Company+'&filtro='+filtro;
		
		getAx(url,'Div_Reporte_Result',250);		
	}		
	
	
function Reporte_porcentaje_complete_export() 
	{			
		var Nick_Name = document.form_reporte.Nick_Name.value	
		var Company = document.form_reporte.Company.value	
		var TypeE = document.form_reporte.TypeE.value
		var filtro = $('input[name=filtro]:checked').val();		
		//alert (Pro_ID_Reporte);
		if (filtro==undefined)
		{
			filtro="Vacio";
			//alert (Pro_ID_Reporte);
		}
		
		
		url = 'Reporte_porcentaje_complete_export.php?vfrom_date='+form_reporte.From_Date.value+'&vto_date='+form_reporte.To_Date.value+'&Nick_Name='+Nick_Name+'&TypeE='+TypeE+'&Company='+Company+'&filtro='+filtro;
		
		getAx(url,'Div_Reporte_Result',250);		
	}		
	

	
	
</script>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	    <td valign="top">
			<div id="ac_frmSearchMain">	
				<form id="form_reporte" name="form_reporte">
					<table width="267" class="moduletable" >
						<tr>
							<th colspan="3">Report TIMESHEETS</th>
						</tr>
						<tr>
							<td ><b>From Date  :</b></td>
							<td colspan="2" valign="middle">
								<input type="text" id="From_Date" name="From_Date" datepicker="true"  datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>"/>
							</td>
						</tr>
						<tr>
							<td align="left" valign="top"><b>To Date :</b>
							</td>
							<td>
								<input type="text" id="To_Date"  name="To_Date" datepicker="true"  datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>"/>
							</td>
						</tr>
                       <tr>

							<td align="left" valign="top"><p>&nbsp;</p>
							  <p><b>Nick Name:</b>
							    
						      </p>
						    <p>6=PWT / 107=K&amp;B/ 108 =DC-San Jose / 118=Peter-Trevor Company:</p>
						    <p>&nbsp;</p>
						    <p>F=Field, S=Service, O=Other FS=Subs</p>
						    <p>&nbsp;</p>
						    <p>&nbsp;</p>
					     <p>&nbsp;</p></td>

							<td valign="top">

								<p>&nbsp;							  </p>
								<p>
								  <input type="text" name="Nick_Name" id="Nick_Name" />
							  </p>
								<p>&nbsp;</p>
								<p>&nbsp;</p>
								<p>Code of Company:</p>
							  <p>
							    <input name="Company" type="text" id="Company" value="6" />
							  </p>
								<p>Type Employee:</p>
								<p>
								  <input name="TypeE" type="text" id="TypeE" value="F" />
								</p>
								<p>&nbsp;</p>
								<p>Project Code</p>
								<p>
								  <input type="text" name="CodPro" id="CodPro" />
							  </p>
							</td>							

						</tr>
                         <tr>
							<td align="left" valign="top"><b>Options :</b></td>
							<td>
								Check In Only 
								  <input type="radio" name="filtro"  id="filtro" value="Solo_Ingreso" /><br>
                                Check Out Only 
                                <input type="radio" name="filtro"  id="filtro" value="Solo_Salida" /><br>
                                Check in and out  
                                <input type="radio" name="filtro"  id="filtro" value="Ambos" /><br>
                                Total by Cost Code  
                                <input type="radio" name="filtro"  id="filtro" value="Resume" /><br>
                                Total&gt;8:Person/Date  
                                <input type="radio" name="filtro"  id="filtro" value="Date" /><br>

                                
							</td>							
						</tr>	

						<tr>
							<td colspan="2" align="center"><p><a href="#">
							  <input name="button" type="button" onclick="Reporte_horas_trabajador_preview();" value="Report" />
							  
						    </a>&nbsp;&nbsp;&nbsp;
							  
							  <a href="#">
							    
						      <input type="reset" value="Clear"  />
							  </a></p>
							  <p>&nbsp;&nbsp;&nbsp;															
							    
							    <a href="#">
						        <input name="button2" type="button" onclick="Reporte_horas_trabajador_export();" value="Export Timesheets to txt File" />
			          </a></p>
							  <p><a href="#">
							    <input name="button3" type="button" onclick="Reporte_porcentaje_complete_export();" value="Export Percentage Complete txt File" />
			                  </a>
							    </p>
               				  </p></tr>					  					  

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