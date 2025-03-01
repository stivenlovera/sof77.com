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
	
	$pdf->SetMargins(15,20,15,15);
	$pdf->SetFont('Arial','',10);
	$pdf->SetLineWidth(0.5); 
	$pdf->Setfillcolor(237,243,120);
	
	function membrete(&$pdf)
	{
		//ENCABEZADO
		$pdf->SetFont('Arial','',10);
		$pdf->Image('images/logo.png',5,5,30,10,"png");
		$pdf->SetFont('Arial','',10);
	}
	
	function encabezado(&$pdf,$f1,$f2)
	{
		$pdf->SetFont('Arial','',12);	
		$f1=FormatDateTime($f1, 8);
		$f2=FormatDateTime($f2, 8);
		$pdf->Multicell(0,5,"",0,L,false);
		$pdf->Multicell(0,5,"Report: Detail Hour By Job",0,C,false);
		$pdf->Multicell(0,5,"from:".$f1." to:".$f2,0,C,false);
		$pdf->Multicell(0,5,"",0,L,false);
	  // titulo del detall	
	  
		$pdf->SetFont('Arial','',12);
		$aux=$pdf->GetY();
		$pdf->SetX(5);
		$pdf->Multicell(20,5,"Nro. Employe",0,L,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(25);
		$pdf->Multicell(60,5,"Employe",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(85);
		$pdf->Multicell(25,5,"# Trabajo",0,L,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(110);
		$pdf->Multicell(45,5,"Nombre Trabajo",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(155);
		$pdf->Multicell(80,5,"Codigo Coste",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(235);
		$pdf->Multicell(25,5,"Date",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(260);
		$pdf->Multicell(20,5,"Hour Contract",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(280);
		$pdf->Multicell(15,5,"Hour TM",0,C,false);	
		
		$pdf->SetY($aux);
		$pdf->SetX(295);
		$pdf->Multicell(15,5,"Hour In",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(310);
		$pdf->Multicell(20,5,"Foto Y/N",0,C,false);	
		
		$pdf->SetY($aux);
		$pdf->SetX(330);
		$pdf->Multicell(15,5,"Hour Out",0,C,false);

	  $aux7=$pdf->GetY();
	  $pdf->line(5,$pdf->GetY()-10,340,$pdf->GetY()-10);
  	  $pdf->line(5,$aux+10,340,$aux+10);
	  $pdf->SetY($aux7+5);	  

	}
	
	function encabezado2(&$pdf)
	{
		$pdf->SetFont('Arial','',12);	
		$pdf->Multicell(0,5,"",0,L,false);
	  
		$pdf->SetFont('Arial','',12);
		$aux=$pdf->GetY();
		$pdf->SetX(5);
		$pdf->Multicell(20,5,"Nro. Employe",0,L,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(25);
		$pdf->Multicell(60,5,"Employe",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(85);
		$pdf->Multicell(25,5,"# Trabajo",0,L,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(110);
		$pdf->Multicell(45,5,"Nombre Trabajo",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(155);
		$pdf->Multicell(80,5,"Codigo Coste",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(235);
		$pdf->Multicell(25,5,"Date",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(260);
		$pdf->Multicell(20,5,"Hour Contract",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(280);
		$pdf->Multicell(15,5,"Hour TM",0,C,false);	
		
		$pdf->SetY($aux);
		$pdf->SetX(295);
		$pdf->Multicell(15,5,"Hour In",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(310);
		$pdf->Multicell(20,5,"Foto Y/N",0,C,false);	
		
		$pdf->SetY($aux);
		$pdf->SetX(330);
		$pdf->Multicell(15,5,"Hour Out",0,C,false);

	  $aux7=$pdf->GetY();
	  $pdf->line(5,$pdf->GetY()-10,340,$pdf->GetY()-10);
  	  $pdf->line(5,$aux+10,340,$aux+10);
	  $pdf->SetY($aux7+5);	  

	}	

	function pie(&$pdf,$Total_Horas_Contract, $Total_Horas_TM)
	{
	  
		$pdf->SetFont('Arial','',12);
		$aux=$pdf->GetY();
		$pdf->SetX(5);
		$pdf->Multicell(250,5,"TOTAL: ",0,R,false);	
		
		$pdf->SetY($aux);
		$pdf->SetX(260);
		$pdf->Multicell(20,5,$Total_Horas_Contract,0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(280);
		$pdf->Multicell(15,5,$Total_Horas_TM,0,C,false);		

	  $aux7=$pdf->GetY();
	  $pdf->line(5,$pdf->GetY()-5,340,$pdf->GetY()-5);
  	  $pdf->line(5,$aux+5,340,$aux+5);
	  $pdf->SetY($aux7+5);	  

	}
	
	$Empleado_ID=$_SESSION["Empleado_ID"];		
	$vfrom_date=$_GET["vfrom_date"];
	$vto_date=$_GET["vto_date"];
	$Pro_ID_Reporte=$_GET["Pro_ID_Reporte"];
	$Criterio=$_GET["Criterio"];	
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
		<td>Nro. Employe</td><td>Employe</td><td>Nro. Trabajo</td><td>Nombre Trabajo</td><td>Codigo Coste</td>
        <td>Fecha</td><td>Hour Contract</td><td>Hour TM</td><td>Hour In</td><td>Foto S/N</td><td>Hour Out</td>
	</tr>
	
	<?php
		$sql = "SELECT p.*, p.Nombre AS Nombre_Empleado, pr.Codigo, pr.Nombre AS Proyecto ";
		$sql = $sql . " FROM registro_diario rd INNER JOIN registro_diario_actividad rda ON rd.Reg_ID=rda.Reg_ID ";
		$sql = $sql . " INNER JOIN task t ON rda.Task_ID=t.Task_ID ";	
		$sql = $sql . " INNER JOIN personal p ON p.Empleado_ID=rd.Empleado_ID ";
		$sql = $sql . " INNER JOIN proyectos pr ON t.Pro_ID=pr.Pro_ID ";
		
		if ($Criterio!="")	
			$sql = $sql . " ".$Criterio;	
			
		if ($Pro_ID_Reporte!=-33)	
			$sql = $sql . " AND pr.Pro_ID=".$Pro_ID_Reporte;	
						
		$sql = $sql . " ORDER BY p.Apellido_Paterno, p.Apellido_Materno, p.Nombre ";			
		
		//echo $sql."<br>";													
		$result77=$bd->ejecutar($sql); 		
		$RDA_ID=-1;
		$Fila=1;
		$Empleado_ID = "";
		
		$Empleado_ID_Ant = -77;
		$Total_Horas_Contract=0;
		$Total_Horas_TM=0;
		
		while (($row77 = mysqli_fetch_array($result77) ))	
		{			
			$Codigo=$row77["Codigo"];
			$Proyecto=$row77["Proyecto"];			
			
			$Nombre_Empleado=$row77["Nombre_Empleado"];
			$Apellido_Paterno=$row77["Apellido_Paterno"];
			$Apellido_Materno=$row77["Apellido_Materno"];
			$Empleado_ID=$row77["Empleado_ID"];			
			
			if ($Empleado_ID_Ant ==-77)
				$Empleado_ID_Ant = $Empleado_ID;		
			
			$Empleados_ID = $Empleados_ID . $Empleado_ID . ",";			
		
			
			if ($Fila>14)
			{
				$pdf->AddPage();
				membrete($pdf);
				encabezado($pdf,$af1,$af2);
				$Fila=1;
			}							
				
			if ($Empleado_ID_Ant!=	$Empleado_ID)
			{
				pie($pdf,$Total_Horas_Contract, $Total_Horas_TM);
				encabezado2($pdf);
				$Fila+=4;
				
			
			$pdf->SetFont('Arial','',10);	
			$aux=$pdf->GetY();
			$pdf->SetX(5);
			$pdf->Multicell(20,5,$Aux1,0,L,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(25);
			$pdf->Multicell(60,5,$Nombre_Empleado. " ".$Apellido_Paterno. " ".$Apellido_Materno,0,L,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(85);
			$pdf->Multicell(25,5,$Codigo,0,L,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(110);
			$pdf->Multicell(45,5,$Proyecto,0,L,false);			
							
			}
			$pdf->SetY($aux+10);
	?>
	
			<tr>
				<td><?php echo $Aux1; ?></td>
				<td><?php echo $Nombre_Empleado. " ".$Apellido_Paterno. " ".$Apellido_Materno; ?></td>
                <td><?php echo $Codigo; ?></td>
                <td><?php echo $Proyecto; ?></td>							
			</tr>
	<?php
			$Empleado_ID_Ant=$Empleado_ID;			
			$Fila++;
			
		}
		mysqli_free_result($result77);	
		if ($Fila>14)
		{
			$pdf->AddPage();		
		}	
		pie($pdf,$Total_Horas_Contract, $Total_Horas_TM);
		
		$pdf->Output("dato.pdf");
?>			
</table>
<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="1190" height="570"></embed> 
<?php
	require('Library/Close_Conexion.php');	
?>