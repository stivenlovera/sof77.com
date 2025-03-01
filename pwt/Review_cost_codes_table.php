<script type="text/javascript">
	function Pwt_foreman_registro_actividad_registrar(Pro_ID, Filas) 
	{
		Hora_Ingreso = "";
		Hora_Salida = "";
		Edificio_ID = "";
		Floor_ID = "";
		Area_ID = "";
		Task_ID = "";
		Horas_Contract = "";
		Horas_TM = "";
		Detalle = "";
		RDA_ID = "";
		Empleado_ID = "";
		Verificado_Foreman="";
		Reg_ID = "";
		
		i=1;
		
		//alert ("LLego");
		//alert (Filas);
		
		Filas=Fila;
		while (i<Filas)
		{
			if (i==1)
			{
				eval("Hora_Ingreso = Hora_Ingreso + document.getElementById('Hora_Ingreso_"+i+"').value; ");
				eval("Hora_Salida = Hora_Salida + document.getElementById('Hora_Salida_"+i+"').value; ");
				eval("Edificio_ID = Edificio_ID + document.getElementById('Edificio_ID_"+i+"').value; ");
				eval("Floor_ID = Floor_ID + document.getElementById('Floor_ID_"+i+"').value; ");
				eval("Area_ID = Area_ID + document.getElementById('Area_ID_"+i+"').value; ");
				eval("Task_ID = Task_ID + document.getElementById('Task_ID_"+i+"').value; ");
				eval("Horas_Contract = Horas_Contract + document.getElementById('Horas_Contract_"+i+"').value; ");			
				eval("Horas_TM = Horas_TM + document.getElementById('Horas_TM_"+i+"').value; ");
				eval("Detalle = Detalle + document.getElementById('Detalle_"+i+"').value; ");
				eval("RDA_ID = RDA_ID + document.getElementById('RDA_ID_"+i+"').value; ");
				eval("Reg_ID = Reg_ID + document.getElementById('Reg_ID_"+i+"').value; ");
				eval("Empleado_ID = Empleado_ID + document.getElementById('Empleado_ID_"+i+"').value; ");	
				eval("Verificado_Foreman = Verificado_Foreman + $('input[name=Verificado_Foreman_"+i+"]').is(':checked'); ");	
			}
			else
			{
				eval("Hora_Ingreso = Hora_Ingreso + '|' + document.getElementById('Hora_Ingreso_"+i+"').value;");
				eval("Hora_Salida = Hora_Salida + '|' + document.getElementById('Hora_Salida_"+i+"').value;");
				eval("Edificio_ID = Edificio_ID + '|' + document.getElementById('Edificio_ID_"+i+"').value;");
				eval("Floor_ID = Floor_ID + '|' + document.getElementById('Floor_ID_"+i+"').value;");
				eval("Area_ID = Area_ID + '|' + document.getElementById('Area_ID_"+i+"').value;");
				eval("Task_ID = Task_ID + '|' + document.getElementById('Task_ID_"+i+"').value;");
				eval("Horas_Contract = Horas_Contract + '|' + document.getElementById('Horas_Contract_"+i+"').value; ");			
				eval("Horas_TM = Horas_TM + '|' + document.getElementById('Horas_TM_"+i+"').value; ");
				eval("Detalle = Detalle + '|' + document.getElementById('Detalle_"+i+"').value; ");
				eval("RDA_ID = RDA_ID + '|' + document.getElementById('RDA_ID_"+i+"').value; ");
				eval("Reg_ID = Reg_ID + '|' + document.getElementById('Reg_ID_"+i+"').value; ");
				eval("Empleado_ID = Empleado_ID + '|' + document.getElementById('Empleado_ID_"+i+"').value; ");	
				eval("Verificado_Foreman = Verificado_Foreman + '|' + $('input[name=Verificado_Foreman_"+i+"]').is(':checked'); ");	
			}					
			i++;
		}	
		
		url = "Pwt_foreman_registro_actividad_registrar.php?Pro_ID="+Pro_ID+"&Edificio_ID="+Edificio_ID+"&Floor_ID="+Floor_ID+"&Area_ID="+Area_ID+"&Task_ID="+Task_ID+"&Horas_Contract="+Horas_Contract+"&Horas_TM="+Horas_TM+"&Detalle="+Detalle+"&RDA_ID="+RDA_ID+"&Reg_ID="+Reg_ID+"&Empleado_ID="+Empleado_ID+"&Verificado_Foreman="+Verificado_Foreman+"&Hora_Ingreso="+Hora_Ingreso+"&Hora_Salida="+Hora_Salida;		
					
		getAx(url,'div_registro',10); 								
	}	
</script>



<?php

	session_name("Administrador");
	session_start();
//////////////  este es el que pasa parametros 
//$idletime=2700;//after x seconds the user gets logged out 
//$secon=time()-$_SESSION['timestamp'];
//echo $secon,"  ".$idletime."  ".$_SESSION['timestamp']."  ".time();

 /////////////
	
	
	
	
	//echo 	$_SESSION["EntityID"]."<br>";
	//echo $_SESSION["Nick_Name"]."<br>";

/*	if ($_SESSION["EntityID"] == "" && $_SESSION["Nick_Name"] != "SuperUser")
	{

		echo "<script>alert('Not autorized option')</script>";
		echo "<script> window.location.href = 'https://www.sof77.com';</script>";
		//header("Location:sessionexpired.php"); 
	}	*/

	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');
	
	
	///////////////
	$Empleado_ID=$_SESSION["Empleado_ID"];		
	$vfrom_date=$_GET["vfrom_date"];
	$vto_date=$_GET["vto_date"];
	$Nick_Name=$_GET["Nick_Name"];
	$prNombre=$_GET["prNombre"];
	$filtro=$_GET["filtro"];
	$Criterio=$_GET["Criterio"];
	$Hrscon=$_GET["Hrscon"];
	//echo $Criterio."<br>";
	$Criterio=str_replace(' ','',$Criterio);
	//echo $Criterio."<br>";
	$Criterio2=$_GET["Criterio2"];
	$Criterio3=$_GET["Criterio3"];

	$vdia=substr($vfrom_date,3,2);
	$vmes=substr($vfrom_date,0,2);
	$vano=substr($vfrom_date,8,2);
	$af1="20".$vano."-".$vmes."-".$vdia;	
	
	$vdia=substr($vto_date,3,2);
	$vmes=substr($vto_date,0,2);
	$vano=substr($vto_date,8,2);
	$af2="20".$vano."-".$vmes."-".$vdia;
	
	///////////////
	
	
	
	$Empleado_ID=$_SESSION["Empleado_ID"];
	$Actividad_ID=$_SESSION["Actividad_ID"];		
	$UserNick=$_SESSION["Nick_Name"];



	//echo "Actividad ID:".$Actividad_ID."  Foreman review and approve the hours:";

	$Pro_ID=$_GET["Pro_ID"];
	$_SESSION["Pro_ID"]=$Pro_ID;
	$Reg_ID=$_GET["Reg_ID"];	
	$Estilo="";
	
		
	if ( isset($_GET["Fecha"]) )
		$Date_Work=$_GET["Fecha"];
	else
		$Date_Work=$_SESSION["Date_Work"];

	$Estado="";
	if ($_SESSION["EntityID"] == "Foreman")
	{
		$Estado=" readonly ";
	}
	
/*$Pro_ID=274;
$Date_Work='2020-05-28';
$Date_Top='2020-05-30';
$Actividad_ID=41713; */


	//echo $Estado."<br>";
	
	
	
	
?> 
<!--<a href="empleado_registro_actividad_detalle.php">empleado_registro_actividad_detalle</a>  -->

<table border="1" cellpadding="0" cellspacing="0" id="mitabla">
	<tr align="center">
		<td  width="20" align="center">Line/Date</td>
		<td>:Employee Nick Name::</td>
		<td>Job#, Job Name Check In<br />
		/Check Out</td><td width="15">Title Level 0</td><td width="15">Building</td>
		<td width="15">Code=Floor or Area</td>
		<td width="15">Code=Area or Task</td>
		<td width="10">Hours Worked</td>
		<td>--*</td>
		<td width="25">Notes</td><td width="10">Check by Foreman</td><td></td><td></td>
	</tr>
	
	<?php
		$sql = "SELECT *,rd.Fecha,ac.Fecha as FecWor,ac.Hora,ac.Pro_ID as ProID,pj.Nombre as ProNom,pj.Codigo,p.Nick_Name,Hora_Ingreso, Hora_Salida,Fecha_Hingreso,Fecha_Hsalida, TIMEDIFF(Hora_Salida,Hora_Ingreso) AS Horas ";
		$sql = $sql . " FROM registro_diario rd INNER JOIN registro_diario_actividad rda ON rd.Reg_ID=rda.Reg_ID " ;
		$sql = $sql . " LEFT JOIN task t ON rda.Task_ID=t.Task_ID ";
		$sql = $sql . " LEFT JOIN area_control a ON t.Area_ID=a.Area_ID ";
		$sql = $sql . " LEFT JOIN floor f ON f.Floor_ID=a.Floor_ID ";
		$sql = $sql . " LEFT JOIN edificios e ON e.Edificio_ID=f.Edificio_ID ";
		$sql = $sql . " LEFT JOIN personal p ON p.Empleado_ID=rd.Empleado_ID  ";
		$sql = $sql . " LEFT JOIN actividades ac ON rd.Actividad_ID=ac.Actividad_ID ";
		$sql = $sql . " LEFT JOIN proyectos pj ON pj.Pro_ID=ac.Pro_ID ";
		
		$sql = $sql . " WHERE  (substring(pj.Codigo,1,3)<900 or '".$prNombre."'<>'')  AND ac.Fecha BETWEEN '".$af1."' AND '".$af2."' ";
		

/////////////////
if ($Nick_Name!="")
			{	
			$sql = $sql . " AND p.Nick_Name like '%$Nick_Name%' ";	
			}

if ($prNombre!="")
	$sql = $sql." AND (pj.Nombre like '%".$prNombre."%' OR pj.Codigo like '%".$prNombre."%') ";
		
/*if ($filtro=="Solo_Ingreso")	
				$sql = $sql . " AND (rd.Hora_Ingreso!='00:00:01' AND rd.Hora_Ingreso!='00:00:00') AND (rd.Hora_Salida='00:00:01' OR rd.Hora_Salida='00:00:00' OR rd.Hora_Salida IS NULL) ";			
			
			if ($filtro=="Solo_Salida")	
				$sql = $sql . " AND (rd.Hora_Ingreso='00:00:01' OR rd.Hora_Ingreso='00:00:00' OR rd.Hora_Ingreso is NULL) AND (rd.Hora_Salida!='00:00:00' AND rd.Hora_Salida!='00:00:01') ";	
				
			if ($filtro=="Ambos")	
				$sql = $sql . " AND (rd.Hora_Ingreso!='00:00:00' AND rd.Hora_Ingreso!='00:00:01') AND (rd.Hora_Salida!='00:00:00' AND rd.Hora_Salida!='00:00:01') ";
				
			if ($filtro=="No_in_No_out")	
				$sql = $sql . " AND (rd.Hora_Ingreso='00:00:00' OR rd.Hora_Ingreso='00:00:01' OR rd.Hora_Ingreso is NULL) AND (rd.Hora_Salida='00:00:01' OR rd.Hora_Salida='00:00:00' OR rd.Hora_Salida IS NULL) "; 
							if ($filtro=="No_check_in")	
				$sql = $sql . " AND (rd.Hora_Ingreso='00:00:00' OR rd.Hora_Ingreso='00:00:01' OR rd.Hora_Ingreso is NULL) ";	

				 */
				
			if ($filtro=="No CostCode")
				$sql = $sql ." AND (rda.Task_ID=0 OR rda.Task_ID is null OR (rda.Horas_Contract=0 and t.Tas_IDT<>'VACNOSHOW' )) ";
			
			if ($Criterio !="")
				$sql = $sql ." AND REPLACE(t.NumAct,' ','')='".$Criterio."' ";
			if ($Criterio2!="")
				$sql = $sql ." AND ".$Criterio2." ";
			if ($Criterio3!="")
				$sql = $sql ." AND ".$Criterio3." ";
				
			if ($Hrscon!="")
				$sql = $sql ." AND rda.Horas_Contract".$Hrscon." ";
				
		$sql = $sql ." ORDER BY rd.Fecha,rd.Pro_ID,rd.Actividad_ID,p.Nick_Name ";

////////////////
		
		
		//echo $filtro."  Primera: ".$sql."<br>";
		//echo $Criterio."<br>";
		echo " Review Area CODE and COST CODE  /  Write [Erase] in Note to delete the record if it need  "."<br>";	
		//echo $sql."<br>";												
		$result77=$bd->ejecutar($sql); 		
		$RDA_ID=-1;
		$Fila=1;
		$Empleados_ID = "-777";
		$AuxEmpleado_ID="-1";
		$Conta_Emp=0;
		$Hworked=0;
		//exit ();
		while (($row77 = mysqli_fetch_array($result77) ))	
		{
			$Task_ID=$row77["Task_ID"];
			$Area_ID=$row77["Area_ID"];
			$Floor_ID=$row77["Floor_ID"];
			$Edificio_ID=$row77["Edificio_ID"];				
			$Horas_Contract=$row77["Horas_Contract"];
			$Horas=$row77["Horas"];
			$Horas_TM=$row77["Horas_TM"];
			$Detalles=$row77["Detalles"];
			$RDA_ID=$row77["RDA_ID"];
			$Nombre=$row77["Nombre"];
			$Apellido_Paterno=$row77["Apellido_Paterno"];
			$Apellido_Materno=$row77["Apellido_Materno"];
			$Nick_Name=$row77["Nick_Name"];
			$Empleado_ID=$row77["Empleado_ID"];
			$ProCod=$row77["Codigo"];
			$ProNom=$row77["ProNom"];
			//$FecWor=date("m-d-y",strtotime($row77["FecWor"]));
			$FecWor=FormatDateTime($row77["FecWor"], 8);
			$Hora=$row77["Hora"];
			$Pro_ID=$row77["ProID"];
			$_SESSION["Pro_ID"]=$Pro_ID;
			$_SESSION["Date_Work"]=$row77["Fecha"];
			$Hworked=$Hworked+$Horas_Contract;
			if ($Empleado_ID != $AuxEmpleado_ID)
			{
				$AuxEmpleado_ID=$Empleado_ID;
				$Conta_Emp++;
				$Hworked=$Hworked;
			}
			 
						
			$Hora_Ingreso=$row77["Hora_Ingreso"];
			//echo "1er. while HI:".$Hora_Ingreso." Horas:".$Horas;
			$Hora_Salida=$row77["Hora_Salida"];
			$Verificado_Foreman=$row77["Verificado_Foreman"];
			$Reg_ID=$row77["Reg_ID"];
			$Fecha_Hingreso=$row77["Fecha_Hingreso"];
			$Fecha_Hsalida=$row77["Fecha_Hsalida"];



			

			$Horas_aux=0;			
			if ($Fecha_Hingreso+1==$Fecha_Hsalida)
			{
					$Horas_aux=$row77["Horas"]+24;
			}
					
			if ($Fecha_Hingreso == $Fecha_Hsalida)
			  {
					$Horas_aux=$row77["Horas"];
			  }
	
	
			//echo $sql; 
			
			//En nuestro ejemplo
			
			
			
			$array = explode(":", $Horas_aux);
			
				
			if ( $array[1]<47 && $array[1]>31 )
			{
				$Horas=$array[0]+0.5;
			}
			else
				if ( $array[1]<32 )
				{
					$Horas=$array[0]+0;
				}
				 else
					if ( $array[1]>46 )
					{
						$Horas=$array[0]+1;	
					}	
			if ($Horas==8.5)
				$Horas=8;
					
					
			if ($Horas_Contract == 0 && $Task_ID=="")
					$Horas_Contract = $Horas;
				
			$Empleados_ID = $Empleados_ID .",". $Empleado_ID ;
						
			$_SESSION["RDA_ID"]=$RDA_ID;
			
			$estado_foreman="";
			if ( ($Verificado_Foreman=="1") || ($Verificado_Foreman==true))
			{
				//echo $Verificado_Foreman."<br>";
				$estado_foreman="checked='checked'";
			}
			
			$Nombre_Empleado=$Nombre. " ".$Apellido_Paterno. " ".$Apellido_Materno;	
			
			if ($Hora_Ingreso=="00:00:00" || $Hora_Ingreso=="00:00:01")						
//				$Hora_Ingreso="00:00:01";
				$Hora_Ingreso="No check in";
				
			if ($Hora_Salida=="00:00:00" || $Hora_Salida=="00:00:01")								
				//$Hora_Salida="00:00:01";
				$Hora_Salida="No check out";
					
	?>
	
			<tr>
				<td width="45" align="center"><?php echo $Fila.": ".$FecWor." /T.H:".$Hworked; ?></td>
				<td width="45" align="center"><?php echo $Nick_Name."/TH:".$Hworked; ?></td>
				<td>	<?php echo $ProCod." ".$ProNom." ".$Hora."<br>"; ?>	
                   <input name="Hora_Ingreso_<?php echo $Fila; ?>" id="Hora_Ingreso_<?php echo $Fila; ?>" type="text" value="<?php echo $Hora_Ingreso; ?>" size="12" <?php echo $Estado; ?>><br />   
     				<input name="Hora_Salida_<?php echo $Fila; ?>" id="Hora_Salida_<?php echo $Fila; ?>" type="text" value="<?php echo $Hora_Salida; ?>" size="12" <?php echo $Estado; ?>>
				</td>
				<td width="15">			
					<?php	
						$Cantidad=0;
						$sql = "select COUNT(*) AS Cantidad FROM edificios WHERE Pro_ID=".$Pro_ID;														
						$result=$bd->ejecutar($sql); 		
						if (($row = mysqli_fetch_array($result) ))	
						{
							$Cantidad=$row["Cantidad"];
						}
						mysqli_free_result($result);
						//echo $sql."<br>"; 	
						//echo $Cantidad."<br>"; 
						
						if ($Cantidad>1)
						{
							$eligio="No";	
					?>		
							<select name="Edificio_ID_<?php echo $Fila; ?>" size="1"  class="cuadro" id="Edificio_ID_<?php echo $Fila; ?>" onchange="foreman_registro_actividad_piso(this.value,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);"> 
							<option value="-1">Select one</option>   
					<?php		
							$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
							$result=$bd->ejecutar($sql); 		
							while (($row = mysqli_fetch_array($result) ))	
							{	
								if ($Edificio_ID==$row["Edificio_ID"])
								{
									$estado="selected='selected'";
									$eligio="Si";
								}
								else
									$estado="";
					?>
								<option value="<?php echo $row["Edificio_ID"];?>"  <?php echo $estado;?> ><?php echo $row["Nombre"];?></option>  
					<?php
							}
							mysqli_free_result($result);	
					?>					
							</select> 
							<?php
							if ($eligio=="Si")
							{
						?>		
								<img src="images/spacer.gif" onload="foreman_registro_actividad_piso(<?php echo $Edificio_ID;?>,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);" />
						<?php
							}							
					
						}
						else
						{					   
							$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
							$result=$bd->ejecutar($sql); 		
							if (($row = mysqli_fetch_array($result) ))	
							{	
								$_SESSION["RDA_ID"]=-1;
					?>
								<input type="text" value="<?php echo $row["Nombre"];?>" size="10" />
								<input type="hidden" id="Edificio_ID_<?php echo $Fila; ?>" name="Edificio_ID_<?php echo $Fila; ?>" value="<?php echo $row["Edificio_ID"];?>" />
								<img src="images/spacer.gif" onload="foreman_registro_actividad_piso(<?php echo $row["Edificio_ID"];?>,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);" />	 
								
					<?php
							}
							mysqli_free_result($result);	
					
						}
					?>				</td>				
				<td width="10">	
			  <div id="div_registro_actividad_piso_<?php echo $Fila; ?>"></div>				</td>
				<td width="12">	
					<div id="div_registro_actividad_area_<?php echo $Fila; ?>"></div>				</td>
				<td width="12">	
					<div id="div_registro_actividad_task_<?php echo $Fila; ?>"></div>				</td>			
				<td width="15"><input name="Horas_Contract_<?php echo $Fila; ?>" id="Horas_Contract_<?php echo $Fila; ?>" value="<?php echo $Horas_Contract; ?>" size="5" /></td>		
				<td width="10"><input type="hidden" name="Horas_TM_<?php echo $Fila; ?>" id="Horas_TM_<?php echo $Fila; ?>"   value="<?php echo $Horas_TM; ?>"  size="5" /></td>
				<td width="45"><textarea name="Detalle_<?php echo $Fila; ?>" id="Detalle_<?php echo $Fila; ?>"><?php echo $Detalles; ?></textarea>
								<input type="hidden" name="Reg_ID_<?php echo $Fila; ?>" id="Reg_ID_<?php echo $Fila; ?>" value="<?php echo $Reg_ID; ?>" />
								<input type="hidden" name="RDA_ID_<?php echo $Fila; ?>" id="RDA_ID_<?php echo $Fila; ?>" value="<?php echo $RDA_ID; ?>" />
								<input type="hidden" name="Empleado_ID_<?php echo $Fila; ?>" id="Empleado_ID_<?php echo $Fila; ?>" value="<?php echo $Empleado_ID; ?>" />				
				</td>
				<td width="10"><input type="checkbox" name="Verificado_Foreman_<?php echo $Fila; ?>" id="Verificado_Foreman_<?php echo $Fila; ?>" <?php echo $estado_foreman; ?> /></td>
				<td>
					<img src="images/copy_16.gif" width="32" height="32" onclick="foreman_registro_actividad_clonar(<?php echo $Empleado_ID; ?>,'<?php echo $Nick_Name; ?>','<?php echo $Hora_Ingreso; ?>','<?php echo $Hora_Salida; ?>',<?php echo $Pro_ID; ?>,<?php echo $Reg_ID; ?>,-1,<?php echo $Fila; ?>)" />                    
				</td>
                 
                <td>
                	<div id="div_registro_borrar_<?php echo $Fila; ?>">
	                	<img src="images/icon_delete.jpg" onClick="foreman_registro_actividad_borrarr(<?php echo $RDA_ID; ?>,<?php echo $Reg_ID; ?>,<?php echo $Pro_ID; ?>,<?php echo $Fila; ?>);">
    				</div>
                </td> 
			</tr>
	<?php
			$Fila++;

	
			
				
			
		}
		mysqli_free_result($result77);
		
	
		
		
		$consulta = "SELECT pr.Pro_ID, p.Nombre, p.Nick_Name, p.Apellido_Paterno, p.Apellido_Materno, p.Empleado_ID ";		
		$consulta = $consulta . " FROM actividades a ";		
		$consulta = $consulta . " INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID AND ((a.Fecha='".$Date_Work."') OR a.Fecha='2013-01-01') ";
		$consulta = $consulta . " INNER JOIN proyectos pr ON pr.Pro_ID=a.Pro_ID AND ( pr.Pro_ID= ".$Pro_ID." ) ";
		$consulta = $consulta . " INNER JOIN actividad_personal ap ON ap.Actividad_ID=a.Actividad_ID ";
		$consulta = $consulta . " INNER JOIN personal p ON p.Empleado_ID=ap.Empleado_ID AND (  p.Empleado_ID NOT IN (".$Empleados_ID.")   )";				
		$consulta = $consulta . " ORDER BY p.Nick_Name,pr.Pro_ID,a.Tipo_Actividad_ID,a.Fecha, Hora";	
		
		//echo $consulta."<br>";													
		$result77=$bd->ejecutar($consulta); 		
		$RDA_ID=-1;		
		
		while (($row77 = mysqli_fetch_array($result77) ))	
		{			
			$Nombre=$row77["Nombre"];
			$Nick_Name=$row77["Nick_Name"];
			$Apellido_Paterno=$row77["Apellido_Paterno"];
			$Apellido_Materno=$row77["Apellido_Materno"];
			$Empleado_ID=$row77["Empleado_ID"];
			$Nombre_Empleado=$Nombre. " ".$Apellido_Paterno. " ".$Apellido_Materno;		
			
			$Reg_ID=-1;
			$consulta = "SELECT rd.Fecha,rd.Pro_ID,rd.Hora_Ingreso AS Hora_Ingreso,rd.Empleado_ID , rd.Hora_Salida as Hora_Salida, rd.Reg_ID as Reg_ID, TIMEDIFF(Hora_Salida,Hora_Ingreso) AS Horas ";		
			$consulta = $consulta . " FROM registro_diario rd LEFT JOIN registro_diario_actividad rda ON rd.Reg_ID=rda.RDA_ID ";						
			$consulta = $consulta . " WHERE rd.Empleado_ID=". $Empleado_ID . " AND rd.Fecha='".$Date_Work."' AND rd.Actividad_ID=".$Actividad_ID." ORDER BY rd.Empleado_ID";
			//echo "SEGUNDA:".$consulta."<br>";													
			$result877=$bd->ejecutar($consulta); 			
					
			while (($row77 = mysqli_fetch_array($result877) ))	
			{	
					
				$Hora_Ingreso=$row77["Hora_Ingreso"];
				//echo "<br> hI2:".$Hora_Ingreso."<br>";
				$Hora_Salida=$row77["Hora_Salida"];
				$RDA_ID=$row77["RDA_ID"];
				$Reg_ID=$row77["Reg_ID"];		
				$_SESSION["Pro_ID"]=$row77["Pro_ID"];
				$_SESSION["Date_Work"]=$row77["Fecha"];
				
				$Horas_aux=$row77["Horas"];
				$Horas_aux=0;			
				if ($Fecha_Hingreso < $Fecha_Hsalida)
					$Horas_aux=$row77["Horas"]+24;
					
				if ($Fecha_Hingreso == $Fecha_Hsalida)
					$Horas_aux=$row77["Horas"];

				if ($Horas_Contract == 0)
				$Horas_Contract = $Horas;
	
				$array = explode(":", $Horas_aux);
				
				$Empleados_ID = $Empleados_ID .",". $Empleado_ID ;
			
				if ( $array[1]<47 && $array[1]>31 )
				{
					$Horas=$array[0]+0.5;
				}
				else
					if ( $array[1]<32 )
					{
						$Horas=$array[0]+0;
					}
					 else
						if ( $array[1]>46 )
						{
							$Horas=$array[0]+1;	
						}
				$Horas_Contract=$Horas;				
							//echo "2 while  Horas:".$Horas;	
				if (is_null($Reg_ID))
					$Reg_ID=-1;	
	
				if (is_null($RDA_ID))
					$RDA_ID=-1;	
				if ($Hora_Ingreso=="00:00:00" || $Hora_Ingreso=="00:00:01")						
//				$Hora_Ingreso="00:00:01";
				$Hora_Ingreso="No check in";
				
			if ($Hora_Salida=="00:00:00" || $Hora_Salida=="00:00:01")								
				//$Hora_Salida="00:00:01";
				$Hora_Salida="No check out";				
		?>	
				<tr>
					<td align="center"><?php echo $Fila; ?></td>
					<td><?php echo $Nick_Name; ?>				</td>
					<td>
                   
                    	<input name="Hora_Ingreso_<?php echo $Fila; ?>" id="Hora_Ingreso_<?php echo $Fila; ?>" type="text" value="<?php echo $Hora_Ingreso; ?>" size="12" <?php echo $Estado; ?>><br />
						<input name="Hora_Salida_<?php echo $Fila; ?>" id="Hora_Salida_<?php echo $Fila; ?>" type="text" value="<?php echo $Hora_Salida; ?>" size="12" <?php echo $Estado; ?>>
					</td>
					<td width="15">			
						<?php	
							$Cantidad=0;
							$sql = "select COUNT(*) AS Cantidad FROM edificios WHERE Pro_ID=".$Pro_ID;														
							$result=$bd->ejecutar($sql); 		
							if (($row = mysqli_fetch_array($result) ))	
							{
								$Cantidad=$row["Cantidad"];
							}
							mysqli_free_result($result);
							//echo $sql."<br>"; 	
							//echo $Cantidad."<br>"; 
							if ($Cantidad>1)
							{	
						?>		
								<select name="Edificio_ID_<?php echo $Fila; ?>" size="1"  class="cuadro" id="Edificio_ID_<?php echo $Fila; ?>" onchange="foreman_registro_actividad_piso(this.value,<?php echo $Fila; ?>);"> 
								<option value="-1">Select One</option>   
						<?php		
								$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
								$result=$bd->ejecutar($sql); 		
								while (($row = mysqli_fetch_array($result) ))	
								{									
						?>
									<option value="<?php echo $row["Edificio_ID"];?>" ><?php echo $row["Nombre"];?></option>  
						<?php
								}
								mysqli_free_result($result);	
						?>					
								</select> 
						<?php
							}
							else
							{					   
								$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
								$result=$bd->ejecutar($sql); 		
								if (($row = mysqli_fetch_array($result) ))	
								{	
						?>
									<input type="text" value="<?php echo $row["Nombre"];?>" size="10" />
									<input type="hidden" id="Edificio_ID_<?php echo $Fila; ?>" name="Edificio_ID_<?php echo $Fila; ?>" value="<?php echo $row["Edificio_ID"];?>" />
									<img src="images/spacer.gif" onload="foreman_registro_actividad_piso(<?php echo $row["Edificio_ID"];?>,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);" />	 
									
						<?php
								}
								mysqli_free_result($result);	
						
							}
						?>				</td>				
					<td width="10">	
						<div id="div_registro_actividad_piso_<?php echo $Fila; ?>">
						<input type="hidden" id="Floor_ID_<?php echo $Fila; ?>" name="Floor_ID_<?php echo $Fila; ?>" value="-1" />
						</div>				</td>
					<td width="12">	
						<div id="div_registro_actividad_area_<?php echo $Fila; ?>">
							<input type="hidden" id="Area_ID_<?php echo $Fila; ?>" name="Area_ID_<?php echo $Fila; ?>" value="-1" />
						</div>				</td>
					<td width="12">	
						<div id="div_registro_actividad_task_<?php echo $Fila; ?>">
							<input type="hidden" id="Task_ID_<?php echo $Fila; ?>" name="Task_ID_<?php echo $Fila; ?>" value="-1" />
						</div>				</td>			
					<td width="15"><input name="Horas_Contract_<?php echo $Fila; ?>" id="Horas_Contract_<?php echo $Fila; ?>" value="<?php echo $Horas_Contract; ?>"  size="5" /></td>		
				  <td width="10"><input type="hidden" name="Horas_TM_<?php echo $Fila; ?>" id="Horas_TM_<?php echo $Fila; ?>"  size="5" /></td>
					<td width="45"><textarea name="Detalle_<?php echo $Fila; ?>" id="Detalle_<?php echo $Fila; ?>"></textarea>
									<input type="hidden" name="Reg_ID_<?php echo $Fila; ?>" id="Reg_ID_<?php echo $Fila; ?>" value="<?php echo $Reg_ID; ?>" />
									<input type="hidden" name="RDA_ID_<?php echo $Fila; ?>" id="RDA_ID_<?php echo $Fila; ?>" value="<?php echo $RDA_ID; ?>" />
									<input type="hidden" name="Empleado_ID_<?php echo $Fila; ?>" id="Empleado_ID_<?php echo $Fila; ?>" value="<?php echo $Empleado_ID; ?>" />				</td>
					<td width="10" ><input type="checkbox" name="Verificado_Foreman_<?php echo $Fila; ?>" id="Verificado_Foreman_<?php echo $Fila; ?>" /></td>
					<td><img src="images/copy_16.gif" width="32" height="32" onclick="foreman_registro_actividad_clonar(<?php echo $Empleado_ID; ?>,'<?php echo $Nick_Name; ?>','<?php echo $Hora_Ingreso; ?>','<?php echo $Hora_Salida; ?>',<?php echo $Pro_ID; ?>,<?php echo $Reg_ID; ?>,-1,<?php echo $Fila; ?>)" />					
					</td>
                    
                    <td>
                  	<div id="div_registro_borrar_<?php echo $Fila; ?>">
	                	<img src="images/icon_delete.jpg" onClick="foreman_registro_actividad_borrarr(<?php echo $RDA_ID; ?>,<?php echo $Reg_ID; ?>,<?php echo $Pro_ID; ?>,<?php echo $Fila; ?>);">
    				</div>
                    
                    </td> 
				</tr>
		<?php
				$Fila++;


			}
			mysqli_free_result($result877);			
		}
		mysqli_free_result($result77);
		
		$consulta = "SELECT pr.Pro_ID, p.Nick_Name,p.Nombre, p.Apellido_Paterno, p.Apellido_Materno, p.Empleado_ID,a.Actividad_ID";		
		$consulta = $consulta . " FROM actividades a ";
		$consulta = $consulta . " INNER JOIN tipo_actividad ta ON a.Tipo_Actividad_ID=ta.Tipo_Actividad_ID AND ((a.Fecha='".$Date_Work."') OR a.Fecha='2013-01-01') ";
		$consulta = $consulta . " INNER JOIN proyectos pr ON pr.Pro_ID=a.Pro_ID AND ( pr.Pro_ID= ".$Pro_ID." ) ";
		$consulta = $consulta . " INNER JOIN actividad_personal ap ON ap.Actividad_ID=a.Actividad_ID ";
		$consulta = $consulta . " INNER JOIN personal p ON p.Empleado_ID=ap.Empleado_ID AND (  p.Empleado_ID NOT IN (".$Empleados_ID.")   )";				
		$consulta = $consulta . " WHERE a.Actividad_ID=".$Actividad_ID." ORDER BY p.Nick_Name,pr.Pro_ID,a.Tipo_Actividad_ID,a.Fecha, Hora";	
		
		//echo "TERCERA".$consulta."<br>";													
		$result77=$bd->ejecutar($consulta); 		
		$RDA_ID=-1;		
		
		while (($row77 = mysqli_fetch_array($result77) ))	
		{			
			$Nombre=$row77["Nombre"];
			$Nick_Name=$row77["Nick_Name"];
			$Apellido_Paterno=$row77["Apellido_Paterno"];
			$Apellido_Materno=$row77["Apellido_Materno"];
			$Empleado_ID=$row77["Empleado_ID"];
			$Actividad_ID=$row77["Actividad_ID"];
			$Nombre_Empleado=$Nombre. " ".$Apellido_Paterno. " ".$Apellido_Materno;	
			//echo "<br> ingreso a tercera";
			
			//////////////////
			
			
			
			$sql= "Select *,TIMEDIFF(Hora_Salida,Hora_Ingreso) AS Horas from registro_diario rd where rd.Empleado_ID=$Empleado_ID and rd.Actividad_ID=".$Actividad_ID;
			$result77a=$bd->ejecutar($sql); 
			//echo "cuarto:".$sql;
			//echo "3 while  Horas:".$Horas;	
			$Hi="00:00:00";
			$Hs="00:00:00";
			while (($row77a = mysqli_fetch_array($result77a) ))
			{
			$Hi=$row77a["Hora_Ingreso"];									
			$Hs=$row77a["Hora_Salida"];									
			$Horas=$row77a["Horas"];
												
			}
			mysqli_free_result($result77a);
			

			
			$array = explode(":", $Horas);
			//echo "Hing".$Hi."HSal".$Hs." Horas: ".$Horas." Dif array:".$array[1];			
			if ( $array[1]<47 && $array[1]>31 )
	{
		$Horas=$array[0]+0.5;
	}
	else
		if ( $array[1]<32 )
		{
			$Horas=$array[0]+0;
		}
		 else
		    if ( $array[1]>46 )
			{
				$Horas=$array[0]+1;	
			}	
			
			
			if ($Hi=="00:00:00" || $Hi=="00:00:01")
				{
				$Hi="No Check In";
				$Horas=0;
				
				}
			if ($Hs=="00:00:00" || $Hs=="00:00:01")
				{
				$Hs="No Check Out";
				$Horas=0;
				}
	
			$Horas_Contract=$Horas;
			$RDA_ID=-1;
			$Reg_ID=-1;
			
			$Empleados_ID = $Empleados_ID .",". $Empleado_ID ;
									
		?>	
				<tr>
					<td align="center"><?php echo $Fila; ?></td>
					<td><?php echo $Nick_Name; ?>				</td>
					<td>
                    	<input name="Hora_Ingreso_<?php echo $Fila; ?>" id="Hora_Ingreso_<?php echo $Fila; ?>" type="text" value="<?php echo $Hi;?>" size="12"  <?php echo $Estado; ?>><br />
                    
                       
                                
                        
						<input name="Hora_Salida_<?php echo $Fila; ?>" id="Hora_Salida_<?php echo $Fila; ?>" type="text" value="<?php echo $Hs ;?>"  size="12"  <?php echo $Estado; ?>>
                    </td>								
					<td width="15">			
						<?php	
							$Cantidad=0;
							$sql = "select COUNT(*) AS Cantidad FROM edificios WHERE Pro_ID=".$Pro_ID;														
							$result=$bd->ejecutar($sql); 		
							if (($row = mysqli_fetch_array($result) ))	
							{
								$Cantidad=$row["Cantidad"];
							}
							mysqli_free_result($result);
							//echo $sql."<br>"; 	
							//echo $Cantidad."<br>"; 
							if ($Cantidad>1)
							{	
						?>		
								<select name="Edificio_ID_<?php echo $Fila; ?>" size="1"  class="cuadro" id="Edificio_ID_<?php echo $Fila; ?>" onchange="foreman_registro_actividad_piso(this.value,<?php echo $Fila; ?>);"> 
								<option value="-1">Select one</option>   
						<?php		
								$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
								$result=$bd->ejecutar($sql);
								//echo $sql; 		
								while (($row = mysqli_fetch_array($result) ))	
								{									
						?>
									<option value="<?php echo $row["Edificio_ID"];?>" ><?php echo $row["Nombre"];?></option>  
						<?php
								}
								mysqli_free_result($result);	
						?>					
								</select> 
						<?php
							}
							else
							{					   
								$sql = "select Edificio_ID, Nombre FROM edificios WHERE Pro_ID=".$Pro_ID." order by Nombre";														
								//echo "sql edif:".$sql;
								$result=$bd->ejecutar($sql); 		
								if (($row = mysqli_fetch_array($result) ))	
								{	
						?>
									<input type="text" value="<?php echo $row["Nombre"];?>" size="10" />
									<input type="hidden" id="Edificio_ID_<?php echo $Fila; ?>" name="Edificio_ID_<?php echo $Fila; ?>" value="<?php echo $row["Edificio_ID"];?>" />
									<img src="images/spacer.gif" onload="foreman_registro_actividad_piso(<?php echo $row["Edificio_ID"];?>,<?php echo $Fila; ?>,<?php echo $RDA_ID; ?>);" />	 
									
						<?php
								}
								mysqli_free_result($result);	
						
							}
						?></td>				
					<td width="10">	
						<div id="div_registro_actividad_piso_<?php echo $Fila; ?>">
						<input type="hidden" id="Floor_ID_<?php echo $Fila; ?>" name="Floor_ID_<?php echo $Fila; ?>" value="-1" />
						</div>				</td>
					<td width="12">	
						<div id="div_registro_actividad_area_<?php echo $Fila; ?>">
							<input type="hidden" id="Area_ID_<?php echo $Fila; ?>" name="Area_ID_<?php echo $Fila; ?>" value="-1" />
						</div>				</td>
					<td width="12">	
						<div id="div_registro_actividad_task_<?php echo $Fila; ?>">
							<input type="hidden" id="Task_ID_<?php echo $Fila; ?>" name="Task_ID_<?php echo $Fila; ?>" value="-1" />
						</div>				</td>			
					<td width="15"><input name="Horas_Contract_<?php echo $Fila; ?>" id="Horas_Contract_<?php echo $Fila; ?>" value="<?php echo $Horas_Contract; ?>"  size="5" /></td>		
				  <td width="10"><input type="hidden" name="Horas_TM_<?php echo $Fila; ?>" id="Horas_TM_<?php echo $Fila; ?>"  size="5" /></td>
					<td width="35"><textarea name="Detalle_<?php echo $Fila; ?>" id="Detalle_<?php echo $Fila; ?>"></textarea>
									<input type="hidden" name="Reg_ID_<?php echo $Fila; ?>" id="Reg_ID_<?php echo $Fila; ?>" value="<?php echo $Reg_ID; ?>" />
									<input type="hidden" name="RDA_ID_<?php echo $Fila; ?>" id="RDA_ID_<?php echo $Fila; ?>" value="<?php echo $RDA_ID; ?>" />
									<input type="hidden" name="Empleado_ID_<?php echo $Fila; ?>" id="Empleado_ID_<?php echo $Fila; ?>" value="<?php echo $Empleado_ID; ?>" />				</td>
					<td width="10"><input type="checkbox" name="Verificado_Foreman_<?php echo $Fila; ?>" id="Verificado_Foreman_<?php echo $Fila; ?>" /></td>
					<td><img src="images/copy_16.gif" alt="" width="32" height="32" onclick="foreman_registro_actividad_clonar(<?php echo $Empleado_ID; ?>,'<?php echo $Nick_Name; ?>','<?php echo $Hora_Ingreso; ?>','<?php echo $Hora_Salida; ?>',<?php echo $Pro_ID; ?>,<?php echo $Reg_ID; ?>,-1,<?php echo $Fila; ?>)" />					
					</td>
                   
                  <td>
    	<div id="div_registro_borrar_<?php echo $Fila; ?>">
	                	<img src="images/icon_delete.jpg" onClick="foreman_registro_actividad_borrarr(<?php echo $RDA_ID; ?>,<?php echo $Reg_ID; ?>,<?php echo $Pro_ID; ?>,<?php echo $Fila; ?>);">
    				</div>  
                   </td>  
				</tr>
		<?php
				$Fila++;	
									
		}
		mysqli_free_result($result77);
		
		echo "<img src='images/spacer.gif' onload='Fila=".$Fila.";' />";
	?>		
	<tr>
		<td colspan="6"></td>	
	</tr>
</table>
<?php
					$Date_Hoy= date('Y-m-d');
					//$Date_Hoy = date('Y-m-d H:i:s', strtotime($Date_Hoy.' +1 day'));
					$Date_Hoy = date('Y-m-d', strtotime($Date_Hoy.' +1 day'));
											
					// evita check in en diferente fecha
					//$Date_Hoy=$Date_Work;
					
					
					$d1=strtotime($Date_Hoy);
					$d0=strtotime($Date_Work);
					
					
					$days  = abs($d1-$d0);
					$daysa=$days/86400;// 86400 seconds in one day
// and you might want to convert to integer
					
					$days = intval($daysa);

//echo $Date_Hoy."  dates ".$Date_Work."Days:".$days."<br>";
//echo  $UserNick;
//echo $Fila." fila".$Conta_Emp."contaEmp <br>";
	
?>
<div id="div_registro">
  <table align="center">
        <tr>
            <td colspan="6" align="right">
                <button style="font-size:18px;" onclick="Pwt_foreman_registro_actividad_registrar(<?php echo $Pro_ID; ?>, <?php echo $Fila; ?>);">Save</button>			
            </td>
        
      </tr>
    </table>
  <p><a href="menu_sistema.php" class="enlaceboton">[Cancel and Exit</a>]</p>
</div>

<div id="aux_div_res"></div>

<div id="Tabla_Lista_Actividades"></div>

<!--<img src="images/spacer.gif" onload="empleado_registro_actividad_lista(<?php echo $Reg_ID; ?>);" />	-->
 
<div id="Div_Actividad_Personal_Information"></div>
	
<?php
	

	require('Library/Close_Conexion.php');
		

?>

