<?php

	session_name("Administrador");

	session_start();

	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');	

	require('pdf/fpdf.php');
	$pdf=new FPDF('P','mm','Legal');
	$pdf->AddPage();

	// DEFINICION DE FUNCIONES DE CABEZERA DE SUBCUEPO

	$pdf->SetMargins(15,20,15,15);
	$pdf->SetTextColor(51, 51, 51);
	//$pdf->SetTextColor(0, 51, 102);
	$pdf->SetDrawcolor(51,51,51);
	//$pdf->SetDrawcolor(0,51,102);
	$pdf->SetFont('Arial','',7);
	$pdf->SetLineWidth(0.5); 
	//$pdf->Setfillcolor(237,243,120);
	//$pdf->Setfillcolor(237,243,120);
	
	
		
	
	function membrete(&$pdf)
	{
		//ENCABEZADO
		$pdf->SetFont('Arial','',7);
		$pdf->Image('images/Logo.jpg',5,5,30,10,"jpg");		
	}	

	function encabezado(&$pdf, $Unidad)
	{
		$pdf->SetY(10);
		$pdf->Multicell(0,5,"",0,'L',false);
		$pdf->Multicell(0,5,"PLANILLA DE FICHAS ".$Unidad,0,'C',false);
		//$pdf->Multicell(0,5,"Periodo: " . $_GET['fecha_desde'] . " al " . $_GET['fecha_hasta'],0,'C',false);
		$pdf->Multicell(0,5,"Periodo: 01 al 30 de Septiembre ",0,'C',false);
		
		//$pdf->Multicell(0,5,"",0,'L',false);
		// titulo del detall	  
		$aux=$pdf->GetY();
		$pdf->SetX(8);
		$pdf->Multicell(10,5,"Nro.",0,'L',false);
		
		$pdf->SetY($aux);
		$pdf->SetX(13);
		$pdf->Multicell(20,5,"Fecha",0,'C',false);
		
		$pdf->SetY($aux);
		$pdf->SetX(30);
		$pdf->Multicell(10,5,"Ficha",0,'C',false);
		
		$pdf->SetY($aux);
		$pdf->SetX(40);
		$pdf->Multicell(30,5,"Nombre",0,'C',false);	 
		
		$pdf->SetY($aux);
		$pdf->SetX(70);
		$pdf->Multicell(10,5,"Hora Inicio",0,'C',false);
		$aux7=$pdf->GetY();
		
		$pdf->SetY($aux);
		$pdf->SetX(80);
		$pdf->Multicell(10,5,"Hora Fin",0,'C',false);
		
		$pdf->SetY($aux);
		$pdf->SetX(90);
		$pdf->Multicell(10,5,"Movil",0,'C',false);
		
		$pdf->SetY($aux);
		$pdf->SetX(100);
		$pdf->Multicell(35,5,"Origen",0,'C',false);
		
		$pdf->SetY($aux);
		$pdf->SetX(135);
		$pdf->Multicell(35,5,"Destino",0,'C',false);
			  		 
		$pdf->SetY($aux);
		$pdf->SetX(170);
		$pdf->Multicell(30,5,"Detalle",0,'C',false);
		
		$pdf->SetY($aux);
		$pdf->SetX(200);
		$pdf->Multicell(10,5,"Monto",0,'C',false);
		
		//$aux7=$pdf->GetY();
		$pdf->line(7,$pdf->GetY()-5,209,$pdf->GetY()-5);
		$pdf->line(7,$aux7,209,$aux7);
		$pdf->SetY($aux7+1);
	}

	// titulo del reporte
	membrete($pdf);
	//encabezado($pdf);	
	//$aux=$pdf->GetY();  

	$empresa_id=$_GET['empresa_id'];	
	$Unidad_ID=$_GET['Unidad_ID'];	
	$Usuario=$_GET['Usuario'];
	//$Mes=$_GET['fecha_desde'];
	
	$fecha_desde=ConvertDateToMysqlFormat($_GET['fecha_desde']);
	$fecha_hasta=ConvertDateToMysqlFormat($_GET['fecha_hasta']);
	
	/*$consulta = "SELECT e.nombre AS Nombre_Empresa, e.Razon_Social, f.*, eu.Nombre_Unidad 
							FROM fichas_utilizadas f INNER JOIN empresa e ON f.empresa_id=e.empresa_id INNER JOIN empresa_unidades eu ON f.Unidad_ID=eu.Unidad_ID WHERE Fecha>='".$fecha_desde." 00:00:00' AND Fecha<='".$fecha_hasta." 23:59:59'";*/
	
	$consulta = "SELECT e.nombre AS Nombre_Empresa, e.Razon_Social, f.*, eu.Nombre_Unidad 
							FROM fichas_utilizadas f INNER JOIN empresa e ON f.empresa_id=e.empresa_id INNER JOIN empresa_unidades eu ON f.Unidad_ID=eu.Unidad_ID ";
							
							//WHERE Fecha_Registro>='".$fecha_desde." 00:00:00' AND Fecha_Registro<='".$fecha_hasta." 23:59:59'";
	
	//$consulta = "SELECT e.nombre AS Nombre_Empresa, e.Razon_Social, f.*, eu.Nombre_Unidad 
	//						FROM fichas_utilizadas f INNER JOIN empresa e ON f.empresa_id=e.empresa_id INNER JOIN empresa_unidades eu ON f.Unidad_ID=eu.Unidad_ID WHERE Fecha_Registro>='".$fecha_desde." 00:00:00' AND Fecha_Registro<='".$fecha_hasta." 23:59:59'";
	
	if ( $_GET['tipo'] == "R"  )
			$consulta = $consulta." WHERE Fecha_Registro>='".$fecha_desde." 00:00:00' AND Fecha_Registro<='".$fecha_hasta." 23:59:59' "; 
		else
			$consulta = $consulta." WHERE Fecha>='".$fecha_desde." 00:00:00' AND Fecha<='".$fecha_hasta." 23:59:59' "; 
			
	
	if ( $_GET['empresa_id'] != ""  )
		$consulta = $consulta." AND e.empresa_id=".$empresa_id."  ";     
		
	if ($_GET['Unidad_ID'] != ""  )
		$consulta = $consulta." AND f.Unidad_ID='".$_GET['Unidad_ID']."'  " ; 
		
	//$consulta = $consulta." AND (f.Unidad_ID=20 OR f.Unidad_ID=21) " ;
	
	if ($_GET['Usuario'] != ""  )
		$consulta = $consulta." AND Usuario like '%".$_GET['Usuario']."%' ";	    			

	$consulta = $consulta." ORDER BY f.Fecha, f.Numero";		

	//echo $consulta;
	$contador=1;
	$Total=0;
	$tono=240;
	
	$result=$bd->ejecutar($consulta);	
    while($row=mysqli_fetch_array($result))
	{
		$Ficha_Usada_ID = $row["Ficha_Usada_ID"];
		$Razon_Social = $row["Razon_Social"];
		
		//$Unidad = $row["Unidad"];
		
		$Unidad = $row["Nombre_Unidad"];
		$Nombre_Empresa = $row["Nombre_Empresa"];
		$Unidad_ID = $row["Unidad_ID"];
		$Numero = $row["Numero"];
		$Nombre = $row["Usuario"];	
		$Hora_Inicio = $row["Hora_Inicio"];	
		$Hora_Fin = $row["Hora_Fin"];						
		$Fecha = $row["Fecha"];
		$Fecha_Registro = $row["Fecha_Registro"];				
		$Movil = $row["Movil"];
		$Origen = $row["Origen"];
		$Destino = $row["Destino"];
		$Observaciones = $row["Observaciones"];
		$Monto = $row["Monto"];		
		$Total=$Total+$Monto;	
		
		$Nombre_Fichero = str_replace(" ", "_",$Nombre_Empresa . "_" . $Unidad);
		
		if ($Hora_Fin =='00:00:00')
			$Hora_Fin = '';
		
		if ($Numero==0)
			$Numero="";
		
		if ($contador==1)
		{
			encabezado($pdf,$Unidad);	  						  
			$aux=$pdf->GetY();
		}
		$tono = ($tono==240) ? 200 : 240;
		$pdf->SetFillColor($tono);
		
		//$aux=$pdf->GetY();
		//$pdf->SetX(5);		
		//$pdf->Rect(10, $aux, 340,10,'F'); 
				
		$pdf->SetY($aux);
		$pdf->SetX(5);
		$pdf->Multicell(10,5,$contador,0,'R',false);
		$Mayor_Y=$pdf->GetY();
		
		$pdf->SetY($aux);
		$pdf->SetX(15);
		$pdf->Multicell(15,5,FormatDateTime($Fecha, 7),0,'L',false);
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		
		$pdf->SetY($aux);
		$pdf->SetX(27);
		$pdf->Multicell(13,5,$Numero,0,'R',false);
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}
		//echo $Nombre."<br>";
		$pdf->SetY($aux);
		$pdf->SetX(40);
		$pdf->Multicell(30,5,utf8_decode($Nombre),0,'L',false);	
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}			
		
		$pdf->SetY($aux);
		$pdf->SetX(70);
		$pdf->Multicell(10,5,FormatDateTime($Hora_Inicio,8),0,'C',false);
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		
		$pdf->SetY($aux);
		$pdf->SetX(80);
		$pdf->Multicell(10,5,FormatDateTime($Hora_Fin,8),0,'C',false);
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		
		$pdf->SetY($aux);
		$pdf->SetX(90);
		$pdf->Multicell(10,5,$Movil,0,'R',false);
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		
		$pdf->SetY($aux);
		$pdf->SetX(100);
		$pdf->Multicell(35,5,utf8_decode($Origen),0,'L',false);
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		
		$pdf->SetY($aux);
		$pdf->SetX(135);
		$pdf->Multicell(35,5,utf8_decode($Destino),0,'L',false);	
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}			
		  
		$pdf->SetY($aux);
		$pdf->SetX(170);
		$pdf->Multicell(30,5,utf8_decode($Observaciones),0,'C',false);
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		
		$pdf->SetY($aux);
		$pdf->SetX(198);
		$pdf->Multicell(11,5,$Monto,0,'R',false);
		$Nuevo_Mayor_Y=$pdf->GetY();	
		if ($Nuevo_Mayor_Y>$Mayor_Y)
		{
			$Mayor_Y=$Nuevo_Mayor_Y;
		}	
		
		$aux7=$Mayor_Y;	
		$pdf->line(7,$aux7,209,$aux7);
		if($aux7>=300)
		{
			$pdf->line(7, 25,7,$aux7);
			$pdf->line(15, 25,15,$aux7);
			$pdf->line(30, 25,30,$aux7);
			$pdf->line(40 ,25,40,$aux7);
			$pdf->line(70,25,70,$aux7);
			$pdf->line(80,25,80,$aux7);
			$pdf->line(90,25,90,$aux7);
			$pdf->line(100,25,100,$aux7);
			$pdf->line(135,25,135,$aux7);
			$pdf->line(175,25,175,$aux7);
			$pdf->line(200,25,200,$aux7);
			$pdf->line(209,25,209,$aux7);
			
			$pdf->AddPage();
			membrete($pdf);
			encabezado($pdf,$Unidad);				
			$aux=$pdf->GetY()+2;
		}
		else
		{			  
			  $aux=$aux7;			  
		}
		$contador++;		
	}
	mysqli_free_result($result);

	$pdf->line(7, 25,7,$aux7);
	$pdf->line(15, 25,15,$aux7);
	$pdf->line(30, 25,30,$aux7);
	$pdf->line(40 ,25,40,$aux7);
	$pdf->line(70,25,70,$aux7);
	$pdf->line(80,25,80,$aux7);
	$pdf->line(90,25,90,$aux7);
	$pdf->line(100,25,100,$aux7);
	$pdf->line(135,25,135,$aux7);
	$pdf->line(175,25,175,$aux7);
	$pdf->line(200,25,200,$aux7);
	$pdf->line(209,25,209,$aux7);
	
	$pdf->SetFont('Arial','',9);
	
	$pdf->SetY($aux+5);
	$pdf->SetX(158);
	$pdf->Multicell(50,5,"Total  ".number_format($Total, 2, '.', ','),0,'R',false);
	
	//$pdf->Multicell(50,5,"",0,'R',false);
	//$pdf->Multicell(50,5,"",0,'R',false);
	$pdf->Multicell(50,5,"",0,'R',false);
	$pdf->SetX(60);
	$aux=$pdf->GetY();
	$pdf->Multicell(80,5,"Cristian Tomas Frias Sotomayor",0,'C',false);
	
	$pdf->SetX(60);
	$pdf->Multicell(80,5,"Gerente Radio Taxi Cordial",0,'C',false);
	
	$pdf->line(60,$aux,140,$aux);	
		
	$pdf->Output("ficheros/" . $Nombre_Fichero . ".pdf","F");

	?>
	<a href="#" onclick="fichas_reporte_envio_email(<?php echo $Unidad_ID;?>);">Enviar por email: </a>
	<div id="div_envio_email">ff</div>
	<embed src="ficheros/<?php echo $Nombre_Fichero; ?>.pdf#toolbar=1&navpanes=0&scrollbar=1" width="1300" height="760"></embed>

    <?

	require('Library/Close_Conexion.php');	

?>







