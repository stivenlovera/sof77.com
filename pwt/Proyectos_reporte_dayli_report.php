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

	function Proyectos_reporte_dayli_report() 

	{			
		var PmName = document.form_reporte.PmName.value;			
		var Pro_ID_Reporte = $('input[name=Pro_ID_Reporte]:checked').val();		

		//alert (Pro_ID_Reporte);
		$rep=0;
		if (form_reporte.radio[0].checked==true)
		{
				Tipo="Detalle";								
		}
		if (form_reporte.radio[1].checked==true)
				{
					Tipo="Totales";
				}
		if (form_reporte.radio[2].checked==true)
				{
					Tipo="Area";
				}
				
	 	if (form_reporte.radio[3].checked==true)
				{
			     	Tipo="Stru";								
				}
	 	if (form_reporte.radio[4].checked==true)
				{
					 Tipo="Current";
					 $rep=1;
				}
		if (form_reporte.radio[5].checked==true)
				 {
				 	Tipo="Coming";
					$rep=1;
				 }
	

	if ((!(Pro_ID_Reporte==undefined) && ($rep==0)) || ((Pro_ID_Reporte==undefined) && ($rep==1)))
	{
		
			url = 'Proyectos_reporte_dayli_report_1.php?vfrom_date='+form_reporte.From_Date.value+'&vto_date='+form_reporte.To_Date.value+'&Pro_ID_Reporte='+Pro_ID_Reporte+'&Tipo='+Tipo+'&PmName='+PmName;		

			getAx(url,'basic-modal-content-espera',250);		

			$('#basic-modal-content-espera').modal(); 	

		}		
  if ((Pro_ID_Reporte==undefined) && ($rep==0))
		{
			alert("You must choose a Job, Please Select one");
		}


		

		

		

		

	}	

	// INLCLUIDO POR FABIOLA



	

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

	

	function Proyectos_reporte_dayli_report_GC()

	{		

		var Company = document.form_reporte.Company.value



		url = 'Proyectos_reporte_dayli_report_GC.php?Company='+Company

		getAx(url,'basic-modal-content-espera',250);		

		$('#basic-modal-content-espera').modal(); 	

	}

	

	function Proyectos_reporte_dayli_report_GC_Asignar(Emp_ID, Codigo, Nombre)

	{		

		document.form_reporte.Company.value=Codigo+"-"+Nombre; 													

		document.form_reporte.Emp_ID.value=Emp_ID; 			

	}				



	function Proyectos_reporte_dayli_report_Lista_Job() 

	{		

		var Company = document.form_reporte.Company.value

		var Emp_ID = document.form_reporte.Emp_ID.value

		var Nombre = document.form_reporte.Nombre.value				



		url = 'Proyectos_reporte_dayli_report_Lista_Job.php?Emp_ID='+Emp_ID+'&Company='+Company+'&Nombre='+Nombre;		

		getAx(url,'lista_proyectos',50); 

		$("#div_res_nueva_actividad").hide();									

	}			



</script>


<table width="100%" cellpadding="0" cellspacing="0" border="0">

	<tr>

	    <td valign="top">		  

			<div id="ac_frmSearchMain">				  

				<form id="form_reporte" name="form_reporte">			

					<table width="267" class="moduletable" >

						<tr>

							<th colspan="3">Report: Job by levels</th>

						</tr>		  		 																													 

						

						<tr>

							<td ><b>From   :</b></td>					

							<td width="186" colspan="2" valign="middle">

								<input type="text" id="From_Date" name="From_Date" datepicker="true"  datepicker_format="MM-DD-YYYY" value="<?php	echo date('m-d-Y', strtotime('-1460 days'));?>"/>							</td>

						</tr>

						<tr>

							<td align="left" valign="top"><b>To Date :</b>							</td>

							<td>

								<input type="text" id="To_Date"  name="To_Date" datepicker="true"  datepicker_format="MM-DD-YYYY" value="<?php echo date('m-d-Y');?>"/>							</td>							

						</tr>										

						<tr>

						  <td align="left">Type of report:</td>

						  <td align="left">

                            <p>
                              <label>
                                
                                <input type="radio" name="radio" id="por" value="detalle"  />
                                
                                Detail</label>
                              
                              <label>
                                
                                <br />
                                <input type="radio" name="radio" id="por" value="gral" />
                                
                                Totals by task<br />
                              </label>
                             <label>
                               <input type="radio" name="radio" id="por" value="gral" />
                                
                                Totals by Area<br />
                              </label>
                             
                              <label>
                                
                                <input type="radio" name="radio" id="por" value="stru" />
                                
                                Structure</label>
                            and or to gather %completed<br />	
                              
                              <label>
                                
                                <input type="radio" name="radio" id="por" value="Current" checked="checked" />
                                
                                Totals all Current Jobs</label>
                           by Area<br />
                              <label>
                                
                                <input type="radio" name="radio" id="por" value="Coming" />
                                
                                Totals all Jobs Coming up </label>
                          </p></td>	 

                                                   

				      </tr>					 

					<tr>

							<td width="69" valign="top"><strong>By GC:</strong></td>

					  <td ><p>
							  <input type="text" name="Company" id="Company" size="20" value="">
							  <img src="images/buscar.jpg" onclick="Proyectos_reporte_dayli_report_GC();" />
							  
							  <input type="hidden" name="Emp_ID" id="Emp_ID" size="20" value="-33">							
							  </p>
							  <p>&nbsp;</p></td>

					</tr>

					<tr>

						<td valign="top"><p>PWT-PM</p>
					    <p><b>By Job:</b></p></td>

						<td valign="top"><p>
						  <input type="text" name="PmName" id="PmName" />
						  </p>
						  <p>
						    <input type="text" name="Nombre" id="Nombre" size="12" value="" />
					    <img src="images/buscar.jpg" onclick="Proyectos_reporte_dayli_report_Lista_Job();" /></p></td>

					</tr>

					<tr>

							<td colspan="2">

								<div id="lista_proyectos" style="overflow:scroll; height:300">								</div>							</td>

					</tr>

						<tr>

							<td colspan="2" align="center"><a href="#">

							  <input name="button" type="button" onclick="Proyectos_reporte_dayli_report();" value="Print Prev" />

							</a>&nbsp;&nbsp;&nbsp;

								  <a href="#">

							<input type="reset" value="Clear"  /></a>							</td>														

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