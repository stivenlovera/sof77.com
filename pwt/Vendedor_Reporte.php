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
	$pdf->SetFont('Arial','',10);
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
		$pdf->Multicell(0,5,"Detail of Vendors",0,C,false);
		$pdf->Multicell(0,5,"",0,L,false);
		// titulo del detall	  
		$aux=$pdf->GetY();
		$pdf->SetX(20);
		$pdf->Multicell(30,5,"Code",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(50);
		$pdf->Multicell(50,5,"Name",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(100);
		$pdf->Multicell(30,5,"Address",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(130);
		$pdf->Multicell(30,5,"General Manager",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(170);
		$pdf->Multicell(20,5,"Phone",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(200);
		$pdf->Multicell(20,5,"Fax",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(220);
		$pdf->Multicell(20,5,"Web",0,C,false);
		$pdf->SetY($aux);
		$pdf->SetX(240);
		$pdf->Multicell(30,5,"Email",0,C,false);	  
		$pdf->SetY($aux);
		$pdf->SetX(270);
		$pdf->Multicell(20,5,"Industry",0,C,false);	  
		$pdf->SetY($aux);
		$pdf->SetX(280);
		$pdf->Multicell(40,5,"Detail",0,C,false);
		$aux7=$pdf->GetY();
		$pdf->line(10,$pdf->GetY()-7,350,$pdf->GetY()-7);
		$pdf->line(10,$aux+5,350,$aux+5);
		$pdf->SetY($aux7);
	}

	// titulo del reporte
	membrete($pdf);
	encabezado($pdf);	  

	$Nombre=$_GET['Nombre'];	
	$Estado=$_GET['Estado'];	
	$Ciudad=$_GET['Ciudad'];	
	$Zip_Code=$_GET['Zip_Code'];	
	$Calle=$_GET['Calle'];
	$Telefono=$_GET['Telefono'];	
	
	$consulta = "SELECT * FROM vendedor WHERE ";	
	
	if ( $_GET['Nombre'] != ""  )
	$consulta = $consulta." Nombre like '%".$_GET['Nombre']."%'  AND";     
		
	if ($_GET['Estado'] != ""  )
		$consulta = $consulta." Estado like '%".$_GET['Estado']."%'  AND" ; 
	
	if ($_GET['Ciudad'] != ""  )
		$consulta = $consulta." Ciudad like '%".$_GET['Ciudad']."%' AND";
	
	if ($_GET['Calle'] != ""  )
		$consulta = $consulta." Calle like '%".$_GET['Calle']."%' AND";
			
	if ($_GET['Zip_Code'] != ""  )
		$consulta = $consulta." Zip_Code like '%".$_GET['Zip_Code']."%' AND";
		
	if ($_GET['Telefono'] != ""  )
		$consulta = $consulta." Telefono='".$_GET['Telefono']."' AND" ;    			

	$consulta = $consulta." 1=1 ORDER BY Nombre";		

	//echo $consulta;
	
	$result_0=$bd->ejecutar($consulta);	
    while($row0=mysqli_fetch_array($result_0))
	{
		$Ven_ID = $row0["Ven_ID"];
		$Codigo = $row0["Codigo"];	
		$Nombre = $row0["Nombre"];
		$Estado = $row0["Estado"];	
		$Ciudad = $row0["Ciudad"];
		$Zip_Code = $row0["Zip_Code"];			
		$Calle = $row0["Calle"];
		$Numero=$row0["Numero"];
		$Gerente_General=$row0["Gerente_General"];
		$Telefono=$row0["Telefono"];
		$Fax=$row0["Fax"];
		$Web=$row0["Web"];
		$email=$row0["email"];
		$Rubro=$row0["Rubro"];
		$Detalles=$row0["Detalles"];							  

		$tono = ($tono==240) ? 200 : 240;
		$pdf->SetFillColor($tono);
		
		$aux=$pdf->GetY();
		$pdf->SetX(20);
		
		$pdf->Rect(10, $aux, 340,10,F); 
		$pdf->Multicell(30,5,$Codigo,0,L,false);
		$Mayor_Y=$pdf->GetY();
		
		$pdf->SetY($aux);
		$pdf->SetX(50);
		$pdf->Multicell(50,5,$Nombre,0,L,false);
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		
		$pdf->SetY($aux);
		$pdf->SetX(100);
		$pdf->Multicell(30,5,$Numero." ".$Calle.", ".$Ciudad.", ".$Estado." ".$Zip_Code ,0,L,false);
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		
		$pdf->SetY($aux);
		$pdf->SetX(130);
		$pdf->Multicell(20,5,$Gerente_General,0,C,false);
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		
		$pdf->SetY($aux);
		$pdf->SetX(170);
		$pdf->Multicell(30,5,$Telefono,0,L,false);
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		
		$pdf->SetY($aux);
		$pdf->SetX(200);
		$pdf->Multicell(20,5,$Fax,0,C,false);
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		
		$pdf->SetY($aux);
		$pdf->SetX(220);
		$pdf->Multicell(20,5,$Web,0,C,false);
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		
		$pdf->SetY($aux);
		$pdf->SetX(240);
		$pdf->Multicell(30,5,$email,0,C,false);	
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		  
		$pdf->SetY($aux);
		$pdf->SetX(270);
		$pdf->Multicell(20,5,$Rubro,0,C,false);	
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		  
		$pdf->SetY($aux);
		$pdf->SetX(280);
		$pdf->Multicell(50,5,$Detalles,0,C,false);
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







