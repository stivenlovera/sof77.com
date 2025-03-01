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
	
	require('pdf/fpdf.php');
	$pdf=new FPDF('l','mm','legal');
	$pdf->AddPage();
	
	// DEFINICION DE FUNCIONES DE CABEZERA DE SUBCUEPO

	$pdf->SetMargins(15,20,15,15);
	$pdf->SetFont('Arial','',10);
	$pdf->SetLineWidth(0.5); 
	$pdf->Setfillcolor(237,243,120);
	
	function membrete(&$pdf)
	{
		//ENCABEZADO
		$pdf->SetFont('Arial','',8);
		$pdf->Image('images/logo.png',5,5,30,10,"png");
		$pdf->SetFont('Arial','',8);
	}
	
	function encabezado(&$pdf,$f1,$f2)
	{
		$pdf->SetFont('Arial','',10);	
		$f1=FormatDateTime($f1, 8);
		$f2=FormatDateTime($f2, 8);
		$pdf->Multicell(0,5,"",0,L,false);
//		$pdf->Multicell(0,5,"Report: History Records Check in and Out by Job By Person",0,C,false);
		$pdf->Multicell(0,5,"Report: History Records Check in and Out by Job or Employee ",0,C,false);
		$pdf->Multicell(0,5,"from:".$f1." to:".$f2,0,C,false);
		$pdf->Multicell(0,5,"",0,L,false);
	  // titulo del detall	
	  
		$pdf->SetFont('Arial','',7);
		$aux=$pdf->GetY();
		$pdf->SetX(5);
		//$pdf->Multicell(15,5,"Employee #",0,L,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(18);
		$pdf->Multicell(32,5,"Name or Nickname/# ",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(50);
		$pdf->Multicell(15,5,"Job # ",0,L,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(65);
		$pdf->Multicell(30,5,"Job Name ",0,L,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(95);
		$pdf->Multicell(60,5,"Cost Code",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(155);
		$pdf->Multicell(15,5,"Date",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(170);
		$pdf->Multicell(15,5,"Hour Worked",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(185);
//		$pdf->Multicell(10,5,"Hour TM",0,C,false);	
		$pdf->Multicell(10,5,"--",0,C,false);	
			
		$pdf->SetY($aux);
		$pdf->SetX(195);
		$pdf->Multicell(20,5,"Check In",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(217);
		$pdf->Multicell(10,5,"Picture In",0,L,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(228);
		$pdf->Multicell(10,5,"Pwd In",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(238);
		$pdf->Multicell(20,5,"Check Out ",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(260);
		$pdf->Multicell(10,5,"Picture Out",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(272);
		$pdf->Multicell(10,5,"Pwd Out",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(285);
//		$pdf->Multicell(30,5,"Notes",0,C,false);
		
		/*$pdf->SetY($aux);
		$pdf->SetX(275);
		//$pdf->Multicell(30,5,"GPS In ",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(310);
		//$pdf->Multicell(30,5,"GPS Out",0,C,false);*/

	  $aux7=$pdf->GetY();
	  $pdf->line(5,$pdf->GetY()-10,340,$pdf->GetY()-10);
  	  $pdf->line(5,$aux+10,340,$aux+10);
	  $pdf->SetY($aux7+10);	  

	}

	$conpan=0;
	$Empleado_ID=$_SESSION["Empleado_ID"];		
	$vfrom_date=$_GET["vfrom_date"];
	$vto_date=$_GET["vto_date"];
	$Nick_Name=$_GET["Nick_Name"];
	$prNombre=$_GET["prNombre"];
	$filtro=$_GET["filtro"];
	$Criterio1=$_GET["Criterio1"];
	$Criterio2=$_GET["Criterio2"];
	$Criterio3=$_GET["Criterio3"];
	
	
	$Estilo="";
	
	$vdia=substr($vfrom_date,3,2);
	$vmes=substr($vfrom_date,0,2);
	$vano=substr($vfrom_date,8,2);
	$af1="20".$vano."-".$vmes."-".$vdia;	
	
	$vdia=substr($vto_date,3,2);
	$vmes=substr($vto_date,0,2);
	$vano=substr($vto_date,8,2);
	$af2="20".$vano."-".$vmes."-".$vdia;
	
	
	membrete($pdf);
	encabezado($pdf,$af1,$af2);
		
	
?> 
<table border="1" cellpadding="0" cellspacing="0" id="mitabla" width="100%">
	<tr align="center">
		
	  <td width="100">Name or Nickname/#</td>
		<td width="35">Job #</td>
		<td width="150"> Job Name </td>
 		<td width="100">Area-CostCode </td>
        <td width="35">Date</td>
        <td width="30"> Worked Hours</td>
        <td width="20">T&amp;M Hours</td><td width="50">Hour In</td><td width="80">Foto In</td>
        <td width="70">Password In</td>
        <td width="50">Hour Out</td>
        <td width="80">Foto Out</td>
        <td width="70">Password Out</td>
        <td>--- In</td>
        <td>--- Out</td>
        <td width=100>   Notes</td>
	</tr>
	<?php
	$contanombre=0;
echo "filtro: ". $filtro."<br>"."prnombre".$prNombre." criterio:".$Criterio."///  ";
	if ($filtro!="NNN")
	{
		$sql="SELECT *,ap.HContract as HCap,ap.Empleado_ID AS EmpleadoIDx,p.Extra_Mon1,p.Benefit1,p.Benefit2,p.Nombre AS Nombre_Empleado, pr.Codigo, pr.Nombre AS Proyecto, rd.Hora_Ingreso,rd.Hora_Salida,t.NumAct AS CosCod,t.Nombre as TNombre,t.Tas_IDT,ac.Fecha, rda.Horas_Contract AS HorasCont,rda.Horas_TM as HorasTM,rda.Detalles FROM actividad_personal ap INNER JOIN actividades ac ON ac.Actividad_ID=ap.Actividad_ID INNER JOIN proyectos pr ON ac.Pro_ID=pr.Pro_ID";
		
		$sql=$sql." INNER JOIN personal p ON p.Empleado_ID=ap.Empleado_ID ";
		
		if ($Nick_Name!="")
			{	
			$sql = $sql . " AND p.Nick_Name like '%$Nick_Name%' ";	
			}
		$sql=$sql." LEFT JOIN registro_diario rd ON rd.Empleado_ID=ap.Empleado_ID AND rd.Actividad_Id=ac.Actividad_ID LEFT JOIN registro_diario_actividad rda ON rd.Reg_ID=rda.Reg_ID LEFT JOIN task t ON rda.Task_ID=t.Task_ID LEFT JOIN area_control a ON t.Area_ID=a.Area_ID LEFT JOIN floor f ON f.Floor_ID=a.Floor_ID LEFT JOIN edificios e ON e.Edificio_ID=f.Edificio_ID";
		$sql=$sql." WHERE 1=1 AND (left(pr.Codigo,3)< 800) AND ac.Fecha BETWEEN '".$af1."' AND '".$af2."' ";

if ($prNombre!="")
	$sql = $sql." AND pr.Nombre like '%".$prNombre."%' ";
		
if ($filtro=="Solo_Ingreso")	
				$sql = $sql . " AND (rd.Hora_Ingreso!='00:00:01' AND rd.Hora_Ingreso!='00:00:00') AND (rd.Hora_Salida='00:00:01' OR rd.Hora_Salida='00:00:00' OR rd.Hora_Salida IS NULL) ";			
			
			if ($filtro=="Solo_Salida")	
				$sql = $sql . " AND (rd.Hora_Ingreso='00:00:01' OR rd.Hora_Ingreso='00:00:00' OR rd.Hora_Ingreso is NULL) AND (rd.Hora_Salida!='00:00:00' AND rd.Hora_Salida!='00:00:01') ";	
				
			if ($filtro=="Ambos")	
				$sql = $sql . " AND (rd.Hora_Ingreso!='00:00:00' AND rd.Hora_Ingreso!='00:00:01') AND (rd.Hora_Salida!='00:00:00' AND rd.Hora_Salida!='00:00:01') ";
				
			if ($filtro=="No_in_No_out")	
				$sql = $sql . " AND (rd.Hora_Ingreso='00:00:00' OR rd.Hora_Ingreso='00:00:01' OR rd.Hora_Ingreso is NULL) AND (rd.Hora_Salida='00:00:01' OR rd.Hora_Salida='00:00:00' OR rd.Hora_Salida IS NULL) ";
				
			if ($filtro=="No_CostCode")
				$sql = $sql ." AND (rda.Task_ID=0 OR rda.Task_ID is null) ";
				
			if ($filtro=="No_check_in")	
				$sql = $sql . " AND (rd.Hora_Ingreso='00:00:00' OR rd.Hora_Ingreso='00:00:01' OR rd.Hora_Ingreso is NULL) ";	
						
			
			if ($Criterio1!="")
				$sql = $sql ." AND ".$Criterio1." ";
			if ($Criterio2!="")
				$sql = $sql ." AND ".$Criterio2." ";
			if ($Criterio3!="")
				$sql = $sql ." AND ".$Criterio3." ";
		
		
	}
	$sql = $sql ." ORDER BY ac.Fecha,pr.Pro_ID,rd.Hora_Ingreso,pr.Nombre ";
	//$right_sql= right($sql,350);	
	//echo "before execute:  ".$sql."====<br>";
	//echo " //// ".$right_sql."<br>";													
	//exit ();													
	$result77=$bd->ejecutar($sql); 	
	if(mysqli_num_rows($result77)>0)
	{		
		$RDA_ID=-1;
		$Fila=1;
		$Empleado_ID = "";
		
		$Empleado_ID_Ant = -77;
		$Total_Horas_Contract=0;
		$Total_Horas_TM=0;
		$contanombre=0;
		while (($row77 = mysqli_fetch_array($result77) ))	
		{
			
			$Aux1=$row77["Aux1"];
			$Codigo=$row77["Codigo"];
			$Proyecto=$row77["Proyecto"];
			$Hora=$row77["Hora"];
			$Hora=date("g:i a", strtotime($Hora));
			$Proyecto=$Proyecto." ".$Hora;
			
			$Task_ID=$row77["Task_ID"];
			$Tas_IDT=$row77["Tas_IDT"];
			$Area_ID=$row77["Area_ID"];
			$Are_IDT=$row77["Are_IDT"];
			$Floor_ID=$row77["Floor_ID"];
			$Edificio_ID=$row77["Edificio_ID"];		
			$Fecha=$row77["Fecha"];
			$FechaF=date("m-d-Y", strtotime($Fecha));
			if ($Fecha=="2017-01-01")
				$FechaF="";		
			$Horas_Contract=$row77["Horas_Contract"];
			if ($Horas_Contract=="-1")
				$Horas_Contract="";
			$Horas_TM=$row77["Horas_TM"];			
			if ($Horas_TM=="-1")
				$Horas_TM="";
			$HCap=$row77["HCap"];
			$Detalles=$row77["Detalles"];
			$Notehrs=$Detalles;
			if ($Horas_Contract==0 || $Horas_Contract=='' || $Horas_Contract==NULL)
			{
				$Horas_Contract=$HCap;
				if ($HCap>0)
					$Notehrs=' <-Hrs set up by Admin./'.$Detalles;
				};
			$RDA_ID=$row77["RDA_ID"];
			$Nombre_Empleado=$row77["Nombre_Empleado"];
			$Apellido_Paterno=$row77["Apellido_Paterno"];
			$Apellido_Materno=$row77["Apellido_Materno"];
			$Number_Emp=$Apellido_Materno;
			$contanombre=$contanombre+1;
			$Nick_Name=$contanombre.".-".$row77["Nick_Name"];
			$Empleado_ID=$row77["Empleado_ID"];
			$CosCod=$row77["CosCod"];
			$TNombre=$row77["TNombre"];
			//echo $CosCod."  ".$TNombre."<br>";
			if ($Tas_IDT=$CosCod)
				$Codigo_Costo=rtrim($Are_IDT)." ".rtrim($Tas_IDT)." ".substr($TNombre,0,50);				
			else		
				$Codigo_Costo=rtrim($CosCod).rtrim($Are_IDT)." ".rtrim($Tas_IDT)." ".substr($TNombre,0,50);
			
			
			$Hora_Ingreso=substr($row77["Hora_Ingreso"],0,8);
			$Hora_Salida=substr($row77["Hora_Salida"],0,8);
			/*if ($Hora_Ingreso=="01:01")
				$Hora_Ingreso="";
				else
					$Hora_Ingreso=date("g:i a", strtotime($Hora_Ingreso));
				
			
			if ($Hora_Salida=="01:01")
				$Hora_Salida="";
				else 
				$Hora_Salida=date("g:i a", strtotime($Hora_Salida));*/
				
			$Verificado_Foreman=$row77["Verificado_Foreman"];
			$Reg_ID=$row77["Reg_ID"];	
			if ($Hora_Ingreso=="00:00"){						
				$Hora_Ingreso="No Check In";}
				
			if ($Hora_Salida=="00:00"){								
				$Hora_Salida="No Check Out";}
						
					
			
			$Foto_Ingreso=$row77["Foto_Ingreso"];
			if ( ($Foto_Ingreso=="") || (is_null($Foto_Ingreso)) || ($Foto_Ingreso=="-1")  )
			  {
				$Foto_Ingreso="norecord.jpeg";
			  }
				else
					{
						// checking whether file exists or not 
							$file_pointer = "fotos/".$Foto_Ingreso;
  							if (file_exists($file_pointer))  
							{ 
								$xfoto="The file $file_pointer exists"; 
							} 
							else 
							{ 
								//echo "The file".$file_pointer." does 	 not exists"; 
								$Foto_Ingreso="archivefoto.jpeg";
								//echo "The file:".$Foto_Ingreso." does  not exists"; 
								
							} 
						}
				
			$Foto_Salida=$row77["Foto_Salida"];
			if ( ($Foto_Salida=="") || (is_null($Foto_Salida)) || ($Foto_Salida=="-1")  )
			{
				$Foto_Salida="norecord.jpeg";
			}
				else
					{
						// checking whether file exists or not 
							$file_pointer = "fotos/".$Foto_Salida;
  							if (file_exists($file_pointer))  
							{ 
								$xfoto="The file $file_pointer exists"; 
							} 
							else 
							{ 
								//echo "The file:".$file_pointer."  does  not exists"; 
								$Foto_Salida="archivefoto.jpeg";
								//echo "The file:".$Foto_Salida." does  not exists"; 
							} 
						}
			
			$Latitud_Ingreso=$row77["Latitud_Ingreso"];
			if ($Latitud_Ingreso=="-1")
				$Latitud_Ingreso="";
				
			$Latitud_Salida=$row77["Latitud_Salida"];
			if ($Latitud_Salida=="-1")
				$Latitud_Salida="";
			
			$Longitud_Ingreso=$row77["Longitud_Ingreso"];
			if ($Longitud_Ingreso=="-1")
				$Longitud_Ingreso="";
			$Longitud_Salida=$row77["Longitud_Salida"];
			if ($Longitud_Salida=="-1")
				$Longitud_Salida="";
			
			$Pregunta_IN=$row77["Pregunta_IN"];
			$Pregunta_OUT=$row77["Pregunta_OUT"];
			
			$Clave_Digitada_In=$row77["Clave_Digitada_In"];
			//echo "Clave digitada in:".$Clave_Digitada_In." <br>";
			if ($Clave_Digitada_In=="-1")
				$Clave_Digitada_In="";
			$Clave_Digitada_Out=$row77["Clave_Digitada_Out"];
			if ($Clave_Digitada_Out=="-1")
				$Clave_Digitada_Out="";

			
			$Horas_aux=$row["Horas"];
			
			if ($Empleado_ID_Ant ==-77)
				$Empleado_ID_Ant = $Empleado_ID;
			
			
			$array = preg_split(":", $Horas_aux);
			
			if ( $array[1]<31 )
				$Horas=$array[0]+0.5;
			else
				$Horas=$array[0]+1;	
			
			
			$Empleados_ID = $Empleados_ID . $Empleado_ID . ",";
						
			$_SESSION["RDA_ID"]=$RDA_ID;
			
			$estado_foreman="";
			if ( ($Verificado_Foreman=="1") || ($Verificado_Foreman==true))
			{
				//echo $Verificado_Foreman."<br>";
				$estado_foreman="checked='checked'";
			}		
			
			//echo $Hora_Ingreso."H ing<br>";
			if (($Hora_Ingreso=="00:00:00")	|| ($Hora_Ingreso=="00:00:01") || ($Hora_Ingreso=="") || ($Hora_Ingreso==NULL))						
				$Hora_Ingreso="No check In";
				
			if (($Hora_Salida=="00:00:00")	|| ($Hora_Salida=="00:00:01") || ($Hora_Salida=="") || ($Hora_Salida==NULL))								
				$Hora_Salida="No check out";
			
			$Se_Saco_Foto="S";		
			if (is_null($Foto_Ingreso))								
				$Se_Saco_Foto="N";	
			
			$codigo_Costo="";	
			/*if ($Edificio_ID!=-1)
			{
				$sql = "select Edificio_ID, Nombre FROM edificios WHERE Edificio_ID=".$Edificio_ID;	
				//echo $sql."<br>";														
				$result=$bd->ejecutar($sql); 		
				if (($row = mysqli_fetch_array($result) ))	
				{	
					$Edificio=$row["Nombre"];
				}
				mysqli_free_result($result);	
				
				$sql = "select Floor_ID, Nombre FROM floor WHERE Floor_ID=".$Floor_ID;														
				$result=$bd->ejecutar($sql); 		
				if (($row = mysqli_fetch_array($result) ))	
				{	
					$Piso=$row["Nombre"];								
				}
				mysqli_free_result($result);	
				
				$sql = "select Area_ID, Nombre FROM area_control WHERE Area_ID=".$Area_ID;														
				$result=$bd->ejecutar($sql); 		
				if (($row = mysqli_fetch_array($result) ))	
				{	
					$Area=$row["Nombre"];								
				}
				mysqli_free_result($result);
				
				$sql = "select Task_ID, NumAct,Nombre FROM task WHERE Task_ID=".$Task_ID;
				//echo "Task ID:".$Task_ID."<td>";
				//echo "sql:".$sql."<td>";
				$result=$bd->ejecutar($sql); 		
				if (($row = mysqli_fetch_array($result) ))	
				{	
					$Tarea=$row["Nombre"];		
					$CosCod=$row["NumAct"];						
				}
				mysqli_free_result($result);
				
				//$codigo_Costo=$CosCod." ".$Edificio."-".$Piso."-".$Area."-".$Tarea;	
				$codigo_Costo=$CosCod."-".$Tarea;	
			}*/
			
			
			
			
			
			if ($Fila>10)
			{
				$pdf->AddPage();
				membrete($pdf);
				encabezado($pdf,$af1,$af2);
				$Fila=1;
			}
			//if ( ($Nombre_Empleado!="") AND ( !(is_null($Nombre_Empleado)) ) )
			if (1==1)
			{
				$pdf->SetFont('Arial','',7);	
				$aux=$pdf->GetY();
				$pdf->SetX(5);
				$pdf->Multicell(15,5,$Aux1,0,L,false);
				
				$pdf->SetY($aux);
				$pdf->SetX(18);
				//$pdf->Multicell(32,5,$Nombre_Empleado. " ".$Apellido_Paterno. " ".$Apellido_Materno,0,L,false);
				$pdf->Multicell(32,5,$Nick_Name. "/ ".$Apellido_Materno,0,L,false);
				
				$pdf->SetY($aux);
				$pdf->SetX(50);
				$pdf->Multicell(15,5,$Codigo,0,L,false);
				
				$pdf->SetY($aux);
				$pdf->SetX(65);
				$pdf->Multicell(30,5,$Proyecto,0,L,false);
				
				if ($Reg_ID!=-1)
				{
					$pdf->SetY($aux);
					$pdf->SetX(100);
					$pdf->Multicell(52,5,$Codigo_Costo,0,L,false);
					
					$pdf->SetY($aux);
					$pdf->SetX(155);
					$pdf->Multicell(15,5,$FechaF,0,C,false);
					
					$pdf->SetY($aux);
					$pdf->SetX(170);
					$pdf->Multicell(15,5,$Horas_Contract,0,C,false);
					
					$pdf->SetY($aux);
					$pdf->SetX(185);
					
					//$pdf->Multicell(10,5,$Horas_TM,0,C,false);	
					$pdf->Multicell(10,5,"->",0,C,false);	
					
					$pdf->SetY($aux);
					$pdf->SetX(195);
					$pdf->Multicell(20,5,$Hora_Ingreso,0,C,false);
			
					if ($Foto_Ingreso!="-1")
						$pdf->Image('fotos/'.$Foto_Ingreso,217,$aux,10,10,"jpeg");
					
					$pdf->SetY($aux);
					$pdf->SetX(229);
					$pdf->Multicell(10,5,$Clave_Digitada_In,0,C,false);
					
					
					$pdf->SetY($aux);
					$pdf->SetX(240);
					$pdf->Multicell(20,5,$Hora_Salida,0,C,false);
					
					//echo "**".$Foto_Salida."**<br>";
					if ($Foto_Salida!="-1")
						$pdf->Image('fotos/'.$Foto_Salida,261,$aux,10,10,"jpeg");
					
					$pdf->SetY($aux);
					$pdf->SetX(272);
					$pdf->Multicell(10,5,$Clave_Digitada_Out,0,C,false);
					
					$pdf->SetY($aux);
					$pdf->SetX(283);
					//$pdf->Multicell(50,5,$Notehrs,0,L,false);
					
					/*$pdf->SetY($aux);
					$pdf->SetX(275);
					//$pdf->Multicell(30,5,$Latitud_Ingreso.",".$Longitud_Ingreso,0,C,false);

					
					$pdf->SetY($aux);
					$pdf->SetX(310);
					//$pdf->Multicell(30,5,$Latitud_Salida.",".$Longitud_Salida,0,C,false);
					*/
				}
					$pdf->SetY($aux+11);
		
		if ($conpan<35)
		{
			$conpan++;		
		?>
		
				
                <tr align="center">
                	
					
					<td><?php echo $Nick_Name;//$Nombre_Empleado. " ".$Apellido_Paterno. " ".$Apellido_Materno; ?></td>
					<td><?php echo $Codigo; ?></td>
					<td><?php echo $Proyecto; ?></td>
                   	<td ><?php echo $Codigo_Costo;?></td>
					<td><?php echo $FechaF."  "; ?></td>	                    		
					<td ><?php echo $Horas_Contract; ?></td>		
                 
					<td ><?php echo $Horas_TM; ?></td>				
					<td><?php echo $Hora_Ingreso; ?></td>
					<td><img src="fotos/<?php echo $Foto_Ingreso; ?>" height="50" width="55" /></td>
					<td><?php echo $Clave_Digitada_In; ?></td>
					                             
						   
					<td><?php echo $Hora_Salida; ?></td>				
					<td><img src="fotos/<?php echo $Foto_Salida; ?>" height="50" width="55" /></td>
					<td><?php echo $Clave_Digitada_Out; ?></td>
                    <td><a href="http://maps.google.com?q=<?php echo $Latitud_Ingreso.",".$Longitud_Ingreso; ?>" target="_blank"><?php echo $Latitud_Ingreso.",".$Longitud_Ingreso; ?></a></td>  
					<td><a href="http://maps.google.com?q=<?php echo $Latitud_Salida.",".$Longitud_Salida; ?>" target="_blank"><?php echo $Latitud_Salida.",".$Longitud_Salida; ?></a></td>
                   <td><?php echo $Aux1." ".$Notehrs; ?></td>
					
				</tr>
		<?php
		}
			}
			$Empleado_ID_Ant=$Empleado_ID;
			$Total_Horas_Contract=$Total_Horas_Contract+$Horas_Contract;
			$Total_Horas_TM=$Total_Horas_TM+$Horas_TM;
			$Fila++;			
		}
	
	}
	mysqli_free_result($result77);

	$pdf->Output("dato.pdf");
?>
</table>
<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="1190" height="570"></embed> 
	
<?php	
	require('Library/Close_Conexion.php');	
?>