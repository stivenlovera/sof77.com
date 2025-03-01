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
	function reporte_cronograma_trabajo_lista() 
	{		
		var nuevo_mes = document.form_reporte.nuevo_mes.value
		var nuevo_ano = document.form_reporte.nuevo_ano.value		
		
		url = 'reporte_cronograma_trabajo_lista.php?nuevo_mes='+nuevo_mes+'&nuevo_ano='+nuevo_ano;		
		getAx(url,'Div_Reporte_Lista',250); 									
	}	
	
	
	function reporte_cronograma_main_schedule_pdf() 
	{		
		var nuevo_mes = document.form_reporte.nuevo_mes.value
		var nuevo_ano = document.form_reporte.nuevo_ano.value		
		
		url = 'reporte_cronograma_main_schedule_pdf.php?nuevo_mes='+nuevo_mes+'&nuevo_ano='+nuevo_ano;		
		getAx(url,'Div_Reporte_Lista',250); 									
	}	

function reporte_cronograma_18months() 
	{		
		var nuevo_mes = document.form_reporte.nuevo_mes.value
		var nuevo_ano = document.form_reporte.nuevo_ano.value		
		
		url = 'reporte_cronograma_18months.php?nuevo_mes='+nuevo_mes+'&nuevo_ano='+nuevo_ano;		
		
		getAx(url,'Div_Reporte_Lista',250); 									
	}	

	
	
	
	
	function reporte_cronograma_trabajo_lista_2(nuevo_mes, nuevo_ano) 
	{		
		url = 'reporte_cronograma_trabajo_lista.php?nuevo_mes='+nuevo_mes+'&nuevo_ano='+nuevo_ano;		
		getAx(url,'Div_Reporte_Lista',250); 									
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

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	    <td valign="top">		  
			<div id="ac_frmSearchMain">				  
				<form id="form_reporte" name="form_reporte">			
					<table width="267" class="moduletable" >
						<tr>
							<th colspan="3">Monthly Report </th>
						</tr>		  		 																													 
						<tr>
							<td ><b>Month :</b></td>					
							<td colspan="2" valign="middle">
								<select name=nuevo_mes>
									<option value="1" <?php if ($mes==1) echo "selected";?> >January</option>
									<option value="2" <?php if ($mes==2) echo "selected";?> >February</option>
									<option value="3" <?php if ($mes==3) echo "selected";?> >March</option>
									<option value="4" <?php if ($mes==4) echo "selected";?> >April</option>
									<option value="5" <?php if ($mes==5) echo "selected";?> >May</option>
									<option value="6" <?php if ($mes==6) echo "selected";?> >June</option>
									<option value="7" <?php if ($mes==7) echo "selected";?> >July</option>
									<option value="8" <?php if ($mes==8) echo "selected";?> >August</option>
									<option value="9" <?php if ($mes==9) echo "selected";?> >September</option>
									<option value="10" <?php if ($mes==10) echo "selected";?> >October</option>
									<option value="11" <?php if ($mes==11) echo "selected";?> >November</option>
									<option value="12" <?php if ($mes==12) echo "selected";?> >December</option>
								</select>
							</td>
						</tr>
						<tr>
							<td align="left" valign="top"><b>Year:</b>
							</td>
							<td>
								<select name=nuevo_ano>
								<?php
									//este bucle se podría hacer dependiendo del número de año que se quiera mostrar
									//yo voy a mostar 10 años atrás y 10 adelante de la fecha mostrada en el calendario
									for ($anoactual=$ano-10; $anoactual<=$ano+10; $anoactual++){
										echo '<option value="' . $anoactual . '" ';
										if ($ano==$anoactual) {
											echo "selected";
										}
										echo '>' . $anoactual . '</option>';
									}
								?>
								</select>
							</td>							
						</tr>	
						<tr>
							<td colspan="2" align="center"><a href="#">
							  
							</a>&nbsp;&nbsp;&nbsp;
								  <a href="#">
							
							 
							  </a>															
					              <a href="#">
					              <input name="button2" type="button" onclick="reporte_cronograma_main_schedule_pdf();" value="Projection det.PDF a month" />
					              <input name="button3" type="button" onclick="reporte_cronograma_18months();" value="  24 Months Projection  " />
                                  <input type="reset" value=" .  Reset . "  />
                                  
                                  <input name="button" type="button" onclick="reporte_cronograma_trabajo_lista();" value="__?" />
                                  
					              </a></tr>					  					  
					</table>
			  </form>	
			  
			  <!--<form id="form_reporte_fechas" name="form_reporte_fechas">			
					<table width="267" class="moduletable" >
						<tr>
							<th colspan="3">Report Between Dates</th>
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
							<td colspan="2" align="center"><a href="#">
							  <input name="button" type="button" onclick="reporte_cronograma_trabajo_lista();" value="Buscar" />
							</a>&nbsp;&nbsp;&nbsp;
								  <a href="#">
							<input type="reset" value="Limpiar"  /></a>															
					  </tr>					  					  
					</table>
			  </form>	-->			
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
					<div id="basic-modal-content-espera" style="display:none">Hola es un demo</div>
					<div id="Div_Reporte_Lista">
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