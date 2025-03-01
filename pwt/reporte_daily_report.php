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

<script type="text/javascript" >

function reporte_daily_send($pro_ID,$email)

	{				
		url = 'reporte_daily_report_email_send.php?vfrom_date='+form_reporte.From_Date.value+'&vto_date='+form_reporte.To_Date.value+'&Pro_ID_Reporte='+Pro_ID_Reporte;		
		getAx(url,'basic-modal-content-espera',250);		
		$('#basic-modal-content-espera').modal(); 											
	}



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
	function reporte_daily_report_preview() 
	{				
		var Pro_ID_Reporte = $('input[name=Pro_ID_Reporte]:checked').val();		
		//alert (Pro_ID_Reporte);
		if (Pro_ID_Reporte==undefined)
		{
			Pro_ID_Reporte=-33;
			//alert (Pro_ID_Reporte);
		}
		
		url = 'reporte_daily_report_preview.php?vfrom_date='+form_reporte.From_Date.value+'&vto_date='+form_reporte.To_Date.value+'&Pro_ID_Reporte='+Pro_ID_Reporte;		
		getAx(url,'basic-modal-content-espera',250);		
		$('#basic-modal-content-espera').modal(); 											
	}	
	// INLCLUIDO POR FABIOLA
	
	////
	//INLCUIDO POR FABIOLA 
	//***********************************
	function reporte_daily_report_email() 
	{				
		var Pro_ID_Reporte = $('input[name=Pro_ID_Reporte]:checked').val();		
		//alert (Pro_ID_Reporte);
		if (Pro_ID_Reporte==undefined)
		{
			Pro_ID_Reporte=-33;
			//alert (Pro_ID_Reporte);
		}
		
		url = 'reporte_daily_report_email.php?vfrom_date='+form_reporte.From_Date.value+'&vto_date='+form_reporte.To_Date.value+'&Pro_ID_Reporte='+Pro_ID_Reporte;		
		getAx(url,'basic-modal-content-espera',250);		
		$('#basic-modal-content-espera').modal(); 											
	}	
	// INLCLUIDO POR FABIOLA
	
	function Inicializar_Editor(ID_Editor)
	{
		eval( "$('#"+ID_Editor+"').wysiwyg();" );
	}
		
		function Proyectos_Reporte_Actividad_Copiar() 
	{	
		$('#wysiwyg').val( $("#Div_Reporte_Email").html());			
		//$('#wysiwyg').val("hola");	
		Inicializar_Editor("wysiwyg");	
	}
	
		
	function Proyectos_Repoprte_Actividad_email_send() 
	{		
		//alert("llegue");
		datos='';		
		url = 'Proyectos_Repoprte_Actividad_email_send.php';	
		$(':input', $("#Form_Proyecto_Pedidos_Email_Send") ).each(function() {
			if ( (this.type!='submit') && ( this.type!='button') && ( this.type!='reset') && (this.type!='radio') )
			{
				cad=jQuery.trim(this.name);											
				cad1=jQuery.trim(this.value);				
				if (datos=='')					
					datos=datos+cad+'='+cad1;				
				else
					datos=datos+'&'+cad+'='+cad1;									
			}
		});	
		
		datos=datos+'&Contenido='+escape($('#wysiwyg').val());
		postAx(url,datos,'Div_Reporte_Email',100);
	}		

	//////////
	
function Reporte_Actividades_lista_Proyectos() 
	{		
		var Company = document.form_reporte.Company.value
		var Nombre = document.form_reporte.Nombre.value		
		
		url = 'Reportes_lista_Proyectos.php?Company='+Company+'&Nombre='+Nombre;		
		getAx(url,'lista_proyectos',50); 
		$("#div_res_nueva_actividad").hide();									
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
							<th colspan="3">Opciones de Busqueda</th>
						</tr>		  		 																													 
						
						<tr>
							<td ><b>From Date  :</b></td>					
							<td colspan="2" valign="middle">
								<input type="text" id="From_Date" name="From_Date" datepicker="true"  datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>"/>							</td>
						</tr>
						<tr>
							<td align="left" valign="top"><b>To Date :</b>							</td>
							<td>
								<input type="text" id="To_Date"  name="To_Date" datepicker="true"  datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>"/>							</td>							
						</tr>						
					  <tr>
							<td width="98"><strong>GC-Company:</strong></td>
							<td ><input type="text" name="Company" id="Company" size="20" value=""></td>
					</tr>
					<tr>
						<td><b>Job:</b> </td>
						<td><input type="text" name="Nombre" id="Nombre" size="12" value="" /><img src="images/buscar.jpg" onclick="Reporte_Actividades_lista_Proyectos();" />						</td>
					</tr>
					<tr>
							<td colspan="2">
								<div id="lista_proyectos"></div>							</td>
					</tr>
					<tr>
							<td colspan="2" align="center"><a href="#">
							  <input name="button2" type="button" onclick="reporte_daily_report_preview();" value="Print Prev" />
							</a>&nbsp;&nbsp;&nbsp;
                                
                            <a href="#">
						    <input name="button" type="button" onclick="reporte_daily_report_email();" value="Email" />
							</a>&nbsp;&nbsp;&nbsp;
                                
                                
                              
								  <a href="#">
					  <input type="reset" value=" Clear "  /></a>					  </tr>					  					  
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