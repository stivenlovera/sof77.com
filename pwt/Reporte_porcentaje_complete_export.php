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
	
	
	$Empleado_ID=$_SESSION["Empleado_ID"];		
	$vfrom_date=$_GET["vfrom_date"];
	$vto_date=$_GET["vto_date"];
	$Company=$_GET["Company"];
	$TypeE=$_GET["TypeE"];
	$Nick_Name=$_GET["Nick_Name"];
	$Pro_ID_Reporte=$_GET["Pro_ID_Reporte"];	
	$filtro=$_GET["filtro"];
	
	$Estilo="";
	
	$vdia=substr($vfrom_date,3,2);
	$vmes=substr($vfrom_date,0,2);
	$vano=substr($vfrom_date,8,2);
	$af1="20".$vano."-".$vmes."-".$vdia;	

	$filename='Pcompleted '.$vmes."-".$vdia."-".$vano." to ";

	$vdia=substr($vto_date,3,2);
	$vmes=substr($vto_date,0,2);
	$vano=substr($vto_date,8,2);
	$af2="20".$vano."-".$vmes."-".$vdia;
	
	$filename=$filename.$vmes."-".$vdia."-".$vano.".csv";
	$copyarchi=$filename;
	$filename='../payroll/'.$filename;
	
	
	$expfile = fopen($filename, "w");
	
		
		////***
		
		$sql = "SELECT pc.*,p.Pro_ID,p.Codigo,p.Nombre,t.Pro_ID,t.ActAre,t.ActTas,t.NumAct FROM `percentage_complete` pc inner join proyectos p on pc.Pro_ID=p.Pro_ID INNER join task t on (t.Pro_ID=pc.Pro_ID and t.Task_ID=pc.Task_ID) where pc.Date_Recorded BETWEEN '".$af1."' AND '".$af2."' ";
		
		//echo $sql."<br>";	
		//echo $filename.	"<br>";											
		//exit ();
		$result77=$bd->ejecutar($sql); 		
		
		while (($row77 = mysqli_fetch_array($result77) ))	
		{
			
						
			$Codigo=$row77["Codigo"];
			$CosCod=$row77["NumAct"];
			$ActAre=$row77["ActAre"];
			$ActTas=$row77["ActTas"];
			$PCRec=$row77["Per_Recorded"];
			$PCNote=$row77["Note"];
			$PCDate=$row77["Date_Recorded"];

		
			$x1=substr(ltrim($NumAct),0,1).":";
			//echo $x1."<br>";
			if ($x1==".:")
			{
				//$codexp="     ,".substr($NumAct,5,11);
				$codexp=$ActAre.",".$ActTas;
				//echo $x1."<br>";
			}
			 else
				//$codexp=substr($NumAct,0,5).",".substr($NumAct,5,11);
				$codexp=$ActAre.",".$ActTas;

			$txt = $Codigo.",";
			fwrite($expfile, $txt);

			$txt = $codexp.",";
			fwrite($expfile, $txt);
				
			$txt = $PCDate.",";
			fwrite($expfile, $txt); 
			
			$txt = $PCRec.",";
			fwrite($expfile, $txt); 


			$txt = $PCNote."\n";
			fwrite($expfile, $txt); 
				
		}
mysqli_free_result($result77);	
fclose($expfile);  // close the export file 

	///// abrir el file exportado 	/////////////
		
echo '<td><a href="'.$filename.'">'.'<div style="font-size:1.25em;color:#2471A3;font-weight:bold;">Download export file: <span style="font-weight:bold;">'.substr($filename,-35).'</span></div></a></td>';

	require('Library/Close_Conexion.php');	
?>
	