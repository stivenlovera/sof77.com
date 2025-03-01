<?php

	session_name("Administrador");

	session_start();

	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');	

	require('pdf/fpdf.php');
	$pdf=new FPDF('L','mm','Legal');
	$pdf->AddPage();

	// DEFINICION DE FUNCIONES DE CABEZERA DE SUBCUEPO

	$pdf->SetMargins(15,20,15,15);
	$pdf->SetFont('Arial','',8);
	$pdf->SetLineWidth(0.5); 
	$pdf->Setfillcolor(237,243,120);	

	function membrete(&$pdf)
	{
		//ENCABEZADO
		$pdf->SetFont('Arial','',8);
		$pdf->Image('images/logo.png',5,5,30,10,"png");		
	}	

	function encabezado(&$pdf)
	{
		$pdf->Multicell(0,5,"",0,L,false);
		$pdf->Multicell(0,5,"Details of Jobs",0,C,false);
		$pdf->Multicell(0,5,"",0,L,false);
		// titulo del detall	  
		$aux=$pdf->GetY();
		$pdf->SetX(10);
		$pdf->Multicell(30,5,"Project",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(25);
		$pdf->Multicell(30,5,"Name Project",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(65);
		$pdf->Multicell(30,5,"GC - Company",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(90);
		$pdf->Multicell(20,5,"Status",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(110);
		$pdf->Multicell(20,5,"Type",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(125);
		$pdf->Multicell(30,5,"Address",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(165);
		$pdf->Multicell(20,5,"Start Date",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(195);
		$pdf->Multicell(20,5,"End Dat",0,C,false);	  
		$pdf->SetY($aux);
		$pdf->SetX(215);
		$pdf->Multicell(20,5,"Time",0,C,false);	  
		$pdf->SetY($aux);
		$pdf->SetX(230);
		$pdf->Multicell(20,5,"Price",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(245);
		$pdf->Multicell(20,5,"Project Manager",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(265);
		$pdf->Multicell(20,5,"Superintendent",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(285);
		$pdf->Multicell(20,5,"Project Manager PWT",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(305);
		$pdf->Multicell(20,5,"Project Coordinator PWT",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(325);
		$pdf->Multicell(20,5,"Foreman PWT",0,C,false);		
		
		$aux7=$pdf->GetY();
		$pdf->line(10,$pdf->GetY()-10,350,$pdf->GetY()-10);
		$pdf->line(10,$aux+10,350,$aux+10);
		$pdf->SetY($aux7+3);
	}

	// titulo del reporte
	membrete($pdf);
	encabezado($pdf);	  

	$Company=$_GET['Company'];	
	$Name=$_GET['Name'];	
	$State=$_GET['State'];	
	$City=$_GET['City'];	
	$Zip_Code=$_GET['Zip_Code'];	
	$Address=$_GET['Address'];	
	
	/*$consulta = "SELECT p.*, e.Nombre as Company FROM proyectos p INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID WHERE ";	*/
	
	$consulta = "SELECT p.*, t.Nombre_Tipo, e.Nombre_Estatus,  em.Nombre as Company, ";
	
	$consulta = $consulta . " CONCAT(em1.Nombre, ' ', em1.Apellido_Paterno, ' ',  em1.Apellido_Materno) as Foreman, ";
	$consulta = $consulta . " CONCAT(em2.Nombre, ' ',  em2.Apellido_Paterno, ' ',  em2.Apellido_Materno) as Cordinador, ";
	$consulta = $consulta . " CONCAT(em3.Nombre, ' ',  em3.Apellido_Paterno, ' ',  em3.Apellido_Materno) as Manager, ";
	$consulta = $consulta . " CONCAT(em4.Nombre, ' ',  em4.Apellido_Paterno, ' ',  em4.Apellido_Materno) as Project_Manager, ";
	$consulta = $consulta . " CONCAT(em5.Nombre, ' ',  em5.Apellido_Paterno, ' ',  em5.Apellido_Materno) as Coordinador_Obra  FROM proyectos p ";
	$consulta = $consulta . " LEFT JOIN tipo_proyecto t ON p.Tipo_ID=t.Tipo_ID  ";
	$consulta = $consulta . " INNER JOIN empresas em ON p.Emp_ID=em.Emp_ID ";		
	$consulta = $consulta . " LEFT JOIN estatus e ON p.Estatus_ID=e.Estatus_ID ";		
	
	$consulta = $consulta . " LEFT JOIN personal em1 ON em1.Empleado_ID=p.Foreman_ID ";		
	$consulta = $consulta . " LEFT JOIN personal em2 ON em2.Empleado_ID=p.Coordinador_ID ";		
	$consulta = $consulta . " LEFT JOIN personal em3 ON em3.Empleado_ID=p.Manager_ID ";	
	
	$consulta = $consulta . " LEFT JOIN personal em4 ON em4.Empleado_ID=p.Project_Manager_ID ";		
	$consulta = $consulta . " LEFT JOIN personal em5 ON em5.Empleado_ID=p.Coordinador_Obra_ID WHERE ";	
	
	
	if ( $_GET['Name'] != ""  )
	$consulta = $consulta." p.Nombre like '%".$_GET['Name']."%'  AND";   
	
	if ( $_GET['Company'] != ""  )
	$consulta = $consulta." em.Nombre like '%".$_GET['Company']."%'  AND";     
		
	if ($_GET['State'] != ""  )
		$consulta = $consulta." p.Estado like '%".$_GET['State']."%'  AND" ; 
	
	if ($_GET['City'] != ""  )
		$consulta = $consulta." p.Ciudad like '%".$_GET['City']."%' AND";
		
	if ($_GET['Zip_Code'] != ""  )
		$consulta = $consulta." p.Zip_Code like '%".$_GET['Zip_Code']."%' AND";		
	
	if ($_GET['Estatus_ID'] != ""  )
		$consulta = $consulta." p.Estatus_ID=".$_GET['Estatus_ID']." AND";		
		
	

	$consulta = $consulta." 1=1 ORDER BY p.Nombre";			

	//echo $consulta;
	
	$result_0=$bd->ejecutar($consulta);	
    while($row2=mysqli_fetch_array($result_0))
	{
		$Pro_ID = $row2["Pro_ID"];
		$Codigo = $row2["Codigo"];
		$Nombre = $row2["Nombre"];
		$Nombre_Estatus=$row2["Nombre_Estatus"];
		$Nombre_Tipo=$row2["Nombre_Tipo"];
		$Estado = $row2["Estado"];	
		$Ciudad = $row2["Ciudad"];	
		$Zip_Code = $row2["Zip_Code"];			
		$Calle = $row2["Calle"];
		$Numero=$row2["Numero"];
						
		$Contratista_General=$row2["Contratista_General"];
		$Fecha_Inicio=$row2["Fecha_Inicio"];
		$Fecha_Fin=$row2["Fecha_Fin"];
		$Horas=$row2["Horas"];
		$Precio=$row2["Precio"];
		$Project_Manager=$row2["Project_Manager"];
		$Coordinador_Obra=$row2["Coordinador_Obra"];
		
		$Foreman=$row2["Foreman"];
		$Cordinador=$row2["Cordinador"];
		$Manager=$row2["Manager"];
		$Company=$row2["Company"];								  
		
		$tono = ($tono==240) ? 200 : 240;
		$pdf->SetFillColor($tono);
		
		$aux=$pdf->GetY();
		$pdf->SetX(10);
		
		$pdf->Rect(10, $aux, 340,10,F);  
		$pdf->Multicell(15,5,$Codigo,0,L,false);				
		
		$Mayor_Y=$pdf->GetY();	
		
		$pdf->SetY($aux);
		$pdf->SetX(25);
		$pdf->Multicell(35,5,$Nombre,0,L,false);
		
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		
		$pdf->SetY($aux);
		$pdf->SetX(60);
		$pdf->Multicell(35,5,$Company,0,L,false);
		
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
			
		$pdf->SetY($aux);
		$pdf->SetX(95);
		$pdf->Multicell(15,5,$Nombre_Estatus ,0,L,false);
		
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}		
		$pdf->SetY($aux);
		$pdf->SetX(110);
		$pdf->Multicell(15,5,$Nombre_Tipo,0,C,false);
		
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}
		$pdf->SetY($aux);
		$pdf->SetX(125);
		$pdf->Multicell(40,5,$Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code,0,L,false);
		
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}
		$pdf->SetY($aux);
		$pdf->SetX(165);
		$pdf->Multicell(30,5,FormatDateTime($Fecha_Inicio, 8),0,C,false);
		
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}
		$pdf->SetY($aux);
		$pdf->SetX(195);
		$pdf->Multicell(25,5,FormatDateTime($Fecha_Fin, 8),0,C,false);
		
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}
		$pdf->SetY($aux);
		$pdf->SetX(220);
		$pdf->Multicell(10,5,$Horas,0,C,false);	  
		
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}
		$pdf->SetY($aux);
		$pdf->SetX(230);
		$pdf->Multicell(15,5,$Precio,0,C,false);	  
		
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}
		$pdf->SetY($aux);
		$pdf->SetX(245);
		$pdf->Multicell(20,5,$Project_Manager,0,C,false);
		
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}
		$pdf->SetY($aux);
		$pdf->SetX(265);
		$pdf->Multicell(20,5,$Coordinador_Obra,0,C,false);
		
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}
		$pdf->SetY($aux);
		$pdf->SetX(285);
		$pdf->Multicell(20,5,$Manager,0,C,false);
		
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}
		$pdf->SetY($aux);
		$pdf->SetX(305);
		$pdf->Multicell(20,5,$Cordinador,0,C,false);
		
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}
		$pdf->SetY($aux);
		$pdf->SetX(325);
		$pdf->Multicell(25,5,$Foreman,0,L,false);
		
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}
	
		$aux7=$Mayor_Y;							
		if($aux7>=180)
		{
			$pdf->AddPage();
			membrete($pdf);
			encabezado($pdf);				
			$aux=$pdf->GetY()+2;
		}
		else
		{			  
			  $aux=$aux7;
		}		
	}
	mysqli_free_result($result_0);

	$pdf->Output("dato.pdf");

	?>

	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=1" width="990" height="770"></embed>

    <?

	require('Library/Close_Conexion.php');	

?>







