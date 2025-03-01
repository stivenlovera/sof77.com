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
<link rel="stylesheet" href="jwysiwyg/jquery.wysiwyg.css" type="text/css" />
<script type="text/javascript" src="jwysiwyg/jquery.wysiwyg.js"></script>
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

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	    <td valign="top">		  
			<div id="ac_frmSearchMain">				  
				<form enctype="multipart/form-data" action="Proyectos_Importar_Upload.php" method="POST">			
				    <input type="hidden" name="MAX_FILE_SIZE" value="512000" />
					<table width="267" class="moduletable" >
						<tr>

							<th colspan="3">Import Projects</th>
						</tr>		  		 					
						<tr>
							<td ><b>File  ::</b></td>					
							<td colspan="2" valign="middle">
								<input type="file" name="UserFile" id="UserFile" />
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<a href="#"><input name="button" type="submit" value="Import" /></a>&nbsp;&nbsp;&nbsp;
							  	<a href="#"><input type="reset" value=" Clear "  /></a>		
							</td>													
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
					<div id="Div_Actividades_del_dia" ></div>					
					</td> 
				</tr>					 
			</table>			
		</td>
	</tr>
</table>
<?php
	require('Library/Close_Conexion.php');	
?>