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

	require('funciones_php/Dayli_Rerport.php');	
		
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
<script type="text/javascript" src="include/flexigrid.pack.js"></script>	
<script type="text/javascript" src="include/jquery.jeditable.js"></script>

<!--************************ INICIO SELECTOR DE COLOR ************-->
<script type="text/javascript" src="color/jscolor.js"></script>
<!--************************ FIN SELECTOR DE COLOR ************-->
    
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
	function reporte_cronograma_trabajo_lista() 
	{		
		var nuevo_mes = document.form_reporte.nuevo_mes.value
		var nuevo_ano = document.form_reporte.nuevo_ano.value		
		
		url = 'reporte_cronograma_trabajo_lista.php?nuevo_mes='+nuevo_mes+'&nuevo_ano='+nuevo_ano;		
		getAx(url,'Div_Reporte_Lista',250); 
		
											
	}	
	
	function reporte_cronograma_actividades_color(Color, Actividad_ID ) 
	{		
		url = 'reporte_cronograma_actividades_color.php?Color='+Color+'&Actividad_ID='+Actividad_ID;		
		getAx(url,'basic-modal-content-espera',250); 											
	}	
	
	function reporte_cronograma_trabajo_lista_2(nuevo_mes, nuevo_ano) 
	{		
		url = 'reporte_cronograma_trabajo_lista.php?nuevo_mes='+nuevo_mes+'&nuevo_ano='+nuevo_ano;		
		getAx(url,'Div_Reporte_Lista',250); 									
	}	
	function clearForm(form) 
	{   
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

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	    <td valign="top">		  
			<div id="ac_frmSearchMain">				  
				<form id="form_reporte" name="form_reporte">			
					<table width="275" class="moduletable" >
				  <tr>
							<th colspan="3"> Daily Report/New Activity/Schedule</th>
						</tr>		  		 																													 
						<tr>
							<td width="89" ><b>Job :</b></td>					
					  <td width="174" colspan="2" valign="middle">
					<input type="text" id="Proyecto" name"Proyecto" value=""/>
							</td>
					  </tr>
						<tr>
							<td ><b>From Date:</b></td>					
							<td colspan="2" valign="middle">
								<input type="text" id="From_Date"  datepicker="true"  datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>"/>
							</td>
						</tr>
						<tr>
							<td align="left" valign="top"><b>To Date :</b>
							</td>
							<td>
								<input type="text" id="To_Date"  datepicker="true"  datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>"/>
							</td>							
						</tr>	
						<tr>
							<td colspan="2" align="center"><a href="#">
							  <input name="button" type="button" onclick="Dayli_Report_Lista();" value="Search" />
							</a>&nbsp;&nbsp;&nbsp;
								  <a href="#">
							<input type="reset" value="Clear"  /></a>															
					  </tr>					  					  
					</table>
			  </form>				
			</div>			
			<fieldset id="Botono Nuevo_Cliente" class="" >
				<legend><span id="result_box" lang="en" xml:lang="en">New Activity </span>: </legend>
				<table width="267" class="moduletable">
					<tr>
						<td>
							<a href="#">
								<input type="button" value="New" onclick="Reporte_Actividad_Nuevo()" />									
							</a>		
						</td>
					</tr>
				</table>			
			</fieldset>	    
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
					<div id="basic-modal-content-espera" style="display:none">Hola es un demo</div>
					<div id="Div_Actividades_del_dia" ></div>					
					</td> 
				</tr>
				<tr>
					<td>
						<div id="Div_New_Actividades_del_dia" ></div>		
					</td>
				</tr>
				<tr>
					<td>
						<div id="Div_Datos_de_Proyecto"></div>
					</td>						 
				</tr>				
				<tr>
					<td>
						<table width="100%">
							<tr>
								<td width="50%" valign="top">
									<div id="Div_Actividad_Task_Information"></div>
								</td>
								<td width="50%" valign="top">
									<div id="Div_Actividad_Personal_Information"></div>
									<div id="Div_Actividad_Re_Scheduling"></div>								
								</td>
							</tr>
						</table>
					</td>						 
				</tr>
				<!--<tr>
					<td>
						<table width="100%">
							<tr>
								<td width="50%">
									<div id="Div_Actividad_Task_Information"></div>								
								</td>
								<td width="50%" valign="top">
									<div id="Div_Actividad_Re_Scheduling"></div>								
								</td>
							</tr>
						</table>
					</td>						 
				</tr>-->
				<tr>
					<td>
						<div id="Div_Dayli_Information"></div>														
					</td>						 
				</tr>				
			</table>			
		</td>
	</tr>
</table>
<?php
	require('Library/Close_Conexion.php');	
?>