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

	function Reporte_Bonus_Preview() 
	{	
		var Codigo_Bono = document.form_reporte.Codigo_Bono.value	
		var To_Date = document.form_reporte.To_Date.value	
		
		if (Codigo_Bono!="")
		{
			url = 'Reporte_Bonus_Preview.php?Codigo_Bono='+Codigo_Bono+'&To_Date='+To_Date;
			getAx(url,'Div_Reporte_Result',250);		
		}
		else
		{
			alert("You must enter a value !!!!");
		}
	}

</script>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	    <td valign="top">
			<div id="ac_frmSearchMain">	
				<form id="form_reporte" name="form_reporte">
					<table width="267" class="moduletable" >
						<tr>
							<th colspan="3">Report Bonus</th>
						</tr>					
                       <tr>
							<td align="left" ><b>Bonus Code:</b>
							</td>
							<td>
								<input type="text" name="Codigo_Bono" id="Codigo_Bono" />
							</td>
						</tr>
                        
                        
                       <tr>
							<td align="left" ><b>Hires Before :</b>
							</td>
							<td>

								<input type="text" id="To_Date"  name="To_Date" datepicker="true"  datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>"/>							</td>
					  </tr> 
                        
                        
                        
						<tr>
							<td colspan="2" align="center"><p><a href="#">
							  <input name="button" type="button" onclick="Reporte_Bonus_Preview();" value="Report" />
							  
						    </a>&nbsp;&nbsp;&nbsp;
							  
							  <a href="#">
							    
						      <input type="reset" value="Clear"  />
						      </a>															
							  
							  </p>
							  <p><b>Before 3 months of the bonus period</b> (if bonus is AprMayJun the date should be before 01/01/yyyy)</p>
			          </tr>					  					  

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