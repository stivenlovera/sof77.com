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
		$pdf->Multicell(0,5,"Export file Detail of Hours by employee (Timesheet) ",0,C,false);
		$pdf->Multicell(0,5,"from:".$f1." to:".$f2,0,C,false);
		$pdf->Multicell(0,5,"",0,L,false);
	 //   $aux7=$pdf->GetY();
	//    $pdf->line(5,$pdf->GetY(),340,$pdf->GetY());

	  // titulo del detall	
	  
/*		$pdf->SetFont('Arial','',12);
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
	  $pdf->line(5,$pdf->GetY()-10,340,$pdf->GetY()-10); */
  	  $aux7=$pdf->GetY();
//  	  $pdf->line(5,$aux7,340,$aux7); 
	  $pdf->SetY($aux7+2);	  

	}
	
	function encabezado2(&$pdf)
	{
		global $filtro;
		$pdf->SetFont('Arial','',12);	
		$pdf->Multicell(0,5,"",0,L,false);
	  
		$pdf->SetFont('Arial','',12);
		$aux=$pdf->GetY();
		$pdf->SetX(3);
//		$pdf->Multicell(22,5,"Employee        #",0,L,false);
		$pdf->Multicell(22,5,"              ",0,L,false);
		$pdf->SetY($aux);
		$pdf->SetX(6);
		$pdf->Multicell(60,5,"Employee#    N a m e ",0,L,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(87);
		$pdf->Multicell(25,5,"Job # ",0,L,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(105);
		$pdf->Multicell(45,5,"Job Name ",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(154);
		$pdf->Multicell(45,5,"Area-CostCode Description ",0,L,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(207);
		$pdf->Multicell(25,5,"Date",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(240);
		$pdf->Multicell(20,5,"Hours",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(256);
		if ($filtro=="Resume")
			$pdf->Multicell(25,5," ",0,C,false);
		else
			$pdf->Multicell(20,5,"$ Gas /Week",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(273);
		$pdf->Multicell(30,5,"$ Due Extra Miles",0,C,false);

		$pdf->SetY($aux);
		$pdf->SetX(302);
		$pdf->Multicell(20,5,"$ Parking Help",0,C,false);

		$pdf->SetY($aux);
		$pdf->SetX(322);
		$pdf->Multicell(20,5,"$ Total Benefits",0,C,false);
	
/*
		$pdf->SetY($aux);
		$pdf->SetX(215);
		$pdf->Multicell(15,5,"Hours TM",0,C,false);	
		
		$pdf->SetY($aux);
		$pdf->SetX(230);
		$pdf->Multicell(20,5,"Hour In",0,C,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(250);
		$pdf->Multicell(20,5,"Picture In",0,C,false);	

		
		$pdf->SetY($aux);
		$pdf->SetX(280);
		$pdf->Multicell(20,5,"Hour Out",0,C,false);

		$pdf->SetY($aux);
		$pdf->SetX(300);
		$pdf->Multicell(20,5,"Picture Out",0,C,false);	*/

	  $aux7=$pdf->GetY();
	  $pdf->line(5,$pdf->GetY()-10,340,$pdf->GetY()-10);
  	  $pdf->line(5,$aux+10,340,$aux+10);
	  $pdf->SetY($aux7+5);	  

	}	

function pie(&$pdf,$Total_Horas_Contract, $Total_Horas_TM,$Total_Gas,$BenefitA,$BenefitB,$Total_MilePay,$Total_ParkHelp,$Total_Bene)
	{
	  
		$aux7=$pdf->GetY();
		$pdf->line(5,$pdf->GetY(),340,$pdf->GetY());
  	  	//$pdf->line(5,$aux+5,340,$aux+5);
	  	//$pdf->SetY($aux7+1);	  
		
				$pdf->SetFont('Arial','',12);
		$aux=$pdf->GetY();
		$pdf->SetX(170);
		$pdf->Multicell(20,5,"Totals: ",0,R,false);	
		
		$pdf->SetY($aux);
		$pdf->SetX(239);
		$Total_Horas_Contract=number_format ($Total_Horas_Contract,2);
		$pdf->Multicell(15,5,$Total_Horas_Contract,0,R,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(257);
		$Total_Gas=number_format ($Total_Gas,2);
		$pdf->Multicell(15,5,"$".$Total_Gas,0,R,false);
		

		$pdf->SetY($aux);
		$pdf->SetX(275);
		$xa=number_format($Total_MilePay,2);
		$pdf->Multicell(20,5,"$".$xa,0,R,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(299);
		$xa=number_format ($Total_ParkHelp,2);
		$pdf->Multicell(20,5,"$".$xa,0,R,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(320);
		$xa=number_format ($Total_Bene,2);
		$pdf->Multicell(20,5,"$".$xa,0,R,false);
		
		
	
	  	$aux7=$pdf->GetY();
	  	$pdf->SetY($aux7+3);
		$aux=$aux7+3;
	
		$pdf->SetY($aux);
		$pdf->SetX(250);
		$pdf->Multicell(20,5,"Notes:",0,R,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(265);
		$pdf->Multicell(70,5,$BenefitA."//".$BenefitB,0,R,false);

/*		$pdf->SetY($aux);
		$pdf->SetX(244);
		$Total_Horas_TM=number_format($Total_Horas_TM,2);
		$pdf->Multicell(12,5,$Total_Horas_TM,0,R,false);		
*/
	  $aux7=$pdf->GetY();
	  $pdf->SetY($aux7+3);
	  $pdf->line(5,$pdf->GetY(),340,$pdf->GetY());
  	  //$pdf->line(5,$aux+5,340,$aux+5);
	  $pdf->SetY($aux7+3);	  
	  $aux7=$aux7+4;

	}
	
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

	$filename='payroll '.$vmes."-".$vdia."-".$vano." to ";

	$vdia=substr($vto_date,3,2);
	$vmes=substr($vto_date,0,2);
	$vano=substr($vto_date,8,2);
	$af2="20".$vano."-".$vmes."-".$vdia;
	
	$filename=$filename.$vmes."-".$vdia."-".$vano.".csv";
	$copyarchi=$filename;
	$filename='../payroll/'.$filename;
	
	
	$expfile = fopen($filename, "w");
	
	//$txt = "A,B,C,D,E,F,G,H,I,J,K,L\n";
	//fwrite($expfile, $txt);
	//$txt = "Jane Doe,Edu tore,15.5,35,125,89\n";
	//fwrite($expfile, $txt);
//	fclose($expfile); close the export file 
	
	
	//////////  emal
	$from_name="MOO";
	$from_mail="molmos@precisionwall.com";
	$replyto="molmos@precisionwall.com";
	$to="mario.olmos@precisionwall.com";
	$subject="prueba de envio file ";
	$message="esta es una prueba 99999999999";
		 $fileatt_type = "csv";
		 $myfile = $filename;
	     $file_size = filesize($myfile);
	     $handle = fopen($myfile, "r");
         $content = fread($handle, $file_size);
         fclose($handle);
         $content = chunk_split(base64_encode($content));
        $message = "<html>
<head>
  <title>Payroll export file </title>
</head>
<body><table><tr><td>MAKE</td></tr></table></body></html>";

        $uid = md5(uniqid(time()));

        $header = "From: ".$from_name." <".$from_mail.">\r\n";
        $header .= "Reply-To: ".$replyto."\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
        $header .= "This is a multi-part message in MIME format.\r\n";
        $header .= "--".$uid."\r\n";
        $header .= "Content-type:text/html; charset=iso-8859-1\r\n";
        $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $header .= $message."\r\n\r\n";
        $header .= "--".$uid."\r\n";
        $header .= "Content-Type: text/csv; name=\"".$myfile."\"\r\n"; // use diff. tyoes here
        $header .= "Content-Transfer-Encoding: base64\r\n";
        $header .= "Content-Disposition: attachment; filename=\"".$myfile."\"\r\n\r\n";
        $header .= $content."\r\n\r\n";
        $header .= "--".$uid."--";
// echo $to."/1/".$subject."/2/".$message."/3/".$header."<br>";

mail($to, $subject, $message, $header);
	
	
	///email
	
			
	membrete($pdf);
	encabezado($pdf,$af1,$af2);
	encabezado2($pdf,$af1,$af2);
		

		
			$sql = "delete from reports where a1 is not null";														
				$result=$bd->ejecutar($sql);
				 		
				mysqli_free_result($result);	
		
		///////////
		$sql="SELECT ap.*,rda.*,a.*,rd.*,p.*,t.*,ap.Empleado_ID AS EmpleadoIDx,p.Extra_Mon1,p.Extra_Mon2,p.Benefit1,p.Benefit2,p.Nombre AS Nombre_Empleado,p.Numero AS NumEmp, pr.Pro_ID,pr.Codigo, pr.Nombre AS Proyecto,pr.Miles_Pay,pr.Park_Help,rd.Hora_Ingreso,rd.Hora_Salida,t.NumAct AS CosCod,t.ActAre,t.ActTas,Tas_IDT AS TasIDT,ac.Fecha, rda.Horas_Contract AS HorasCont,rda.Horas_TM as HorasTM,";
		if ($filtro=="Resume")
			$sql=$sql."sum(rda.Horas_Contract) as SumHoras,";
		$sql=$sql."ap.HContract as HContract,ap.HTM as HTM,ap.Note as apNote,t.Nombre as TNombre FROM actividad_personal ap INNER JOIN actividades ac ON ac.Actividad_ID=ap.Actividad_ID INNER JOIN proyectos pr ON ac.Pro_ID=pr.Pro_ID INNER JOIN personal p ON p.Empleado_ID=ap.Empleado_ID ";
		if ($Nick_Name!="")
			{	
			$sql = $sql . " AND ((p.Nick_Name like '%$Nick_Name%') or (p.Nombre like '%$Nick_Name%' )) ";	
			}
			
			if ($Company!="")
			$sql = $sql . " AND (p.Emp_ID=".$Company.") ";	
		
		if ($TypeE!="")
			$sql = $sql . " AND (p.Aux5='".$TypeE."') ";	
			
			
		$sql=$sql." LEFT JOIN registro_diario rd ON rd.Empleado_ID=ap.Empleado_ID AND rd.Actividad_Id=ac.Actividad_ID LEFT JOIN registro_diario_actividad rda ON rd.Reg_ID=rda.Reg_ID LEFT JOIN task t ON rda.Task_ID=t.Task_ID LEFT JOIN area_control a ON t.Area_ID=a.Area_ID LEFT JOIN floor f ON f.Floor_ID=a.Floor_ID LEFT JOIN edificios e ON e.Edificio_ID=f.Edificio_ID";
		$sql=$sql." WHERE 1=1 AND substring(pr.Codigo,1,4)<990 AND ac.Fecha BETWEEN '".$af1."' AND '".$af2."' ";
		
		///////////
		
	
		if ($filtro =="Solo_Ingreso") {	
			$sql = $sql . " AND (Hora_Ingreso!='00:00:01' AND Hora_Ingreso!='00:00:00') AND (Hora_Salida='00:00:00' OR Hora_Salida='00:00:01') ";	}		
		
		if ($filtro=="Solo_Salida")	{
			$sql = $sql . " AND (Hora_Ingreso='00:00:00' OR Hora_Ingreso='00:00:01') AND (Hora_Salida!='00:00:00' AND Hora_Salida!='00:00:01') ";	}
			
		if ($filtro=="Ambos")	{
			$sql = $sql . " AND (Hora_Ingreso!='00:00:00' AND Hora_Ingreso!='00:00:01') AND (Hora_Salida!='00:00:00' AND Hora_Salida!='00:00:01') ";	}
		if ($filtro=="Resume")	
			$sql = $sql ."Group by CONCAT(pr.Codigo,t.Task_ID)";
		 else			
			$sql = $sql . " ORDER BY NumEmp,EmpleadoIDx,ac.Fecha ";			
		
	//	echo $sql."<br>";													
		//echo "1st. part:".substr($sql,1,300)."<br>";													
		//echo "2nd.part:".substr($sql,301,950)."<br>";													
		echo "->!!!! <br>";													
		$result77=$bd->ejecutar($sql); 		
		$RDA_ID=-1;
		$Fila=1;
		$Empleado_ID = "";
		
		$Empleado_ID_Ant = -77;
		$BenefitAnt="";
		$BenefitBnt="";
		$Total_Horas_Contract=0;
		$Total_Horas_TM=0;
		$Total_Nowage=0;
		$Total_Horasx=0;
		$Total_Gas=0;
		$Horasx=0;
		$SumHorasTot=0;
		$Total_MilePay=0;
		$Total_ParkHelp=0;
		$Total_Bene=0;


		
		while (($row77 = mysqli_fetch_array($result77) ))	
		{
			
						
			$ProIDx=$row77["Pro_ID"];
			$Aux1=$row77["Aux1"];
			$Codigo=$row77["Codigo"];
			$Proyecto=substr(($row77["Proyecto"]."            "),0,40);
			//$Task_ID=$row77["Task_ID"];
			$Tas_IDT=$row77["TasIDT"];
			$CosCod=$row77["CosCod"];
			$NumAct=$row77["CosCod"];
			$ActAre=$row77["ActAre"];
			$ActTas=$row77["ActTas"];
			$TNombre=$row77["TNombre"];
			
			//echo $TNombre ." t nombre "."<br>";
			//echo $CosCod." coscod ".$TNombre."<br>";
			//echo $Tas_IDT." tas idt  ".$TNombre."<br>";
			$Area_ID=$row77["Area_ID"];
			$Are_IDT=$row77["Are_IDT"];
			
/*			if ($Tas_IDT==$CosCod)
			  {
				$Codigo_Costo=rtrim($Are_IDT)." ".rtrim($Tas_IDT)." ".substr($TNombre,0,50);
				$codexp=" ".rtrim($Are_IDT).","." ".rtrim($Tas_IDT);
			  }
			else		
			{
				$Codigo_Costo=rtrim($CosCod).rtrim($Are_IDT)." ".rtrim($Tas_IDT)." ".substr($TNombre,0,50);
				$codexp=" ".rtrim($CosCod).rtrim($Are_IDT).",".rtrim($Tas_IDT);
			} */
			
			$Codigo_Costo=$NumAct." ".substr($TNombre,0,50);		
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
			
			//$codexp=substr($NumAct,0,5).",".substr($NumAct,5,11);
			//echo $codexp."  codigo export "."<br>";
				
			//echo $Codigo_Costo."<br>";
			// to print new format since 051520 
			$Floor_ID=$row77["Floor_ID"];
			$Edificio_ID=$row77["Edificio_ID"];		
			$Fecha=$row77["Fecha"];
			$FechaOri=$Fecha;
			$Fechasql=$Fecha;
			$Fecha=FormatDateTime($row77["Fecha"], 8);		
			$Horas_Contract=$row77["HorasCont"];
			$SumHoras=$row77["SumHoras"];
			$SumHorasTot=$SumHorasTot+$SumHoras;
			$Horas_TM=$row77["HorasTM"];
			$Detalles=$row77["Detalles"];
			$RDA_ID=$row77["RDA_ID"];
			$Nombre_Empleado=substr(($row77["Nombre_Empleado"]."             "),0,25);
			$Apellido_Paterno=$row77["Apellido_Paterno"];
			$Apellido_Materno=$row77["Apellido_Materno"];
			$Nick_Name=$row77["Nick_Name"];
			$Empleado_ID=$row77["EmpleadoIDx"];	
			$Gas_Week=$row77["Extra_Mon1"];	
			$Ext_Mon2=$row77["Extra_Mon2"];
			$BenefitA=$row77["Benefit1"];
			$BenefitB=$row77["Benefit2"];
			$MilePay=$row77["Miles_Pay"];
			$HContract=$row77["HContract"];
			$HTM=$row77["HTM"];
			$apNote=$row77["apNote"];
			$NumEmp=$row77["NumEmp"];
			$NoteHrs="";
			if (substr($Nick_Name,0,3)=="NR.")
			{
				$Gas_Week=0;	
				$Ext_Mon2=0;
				$MilePay=0;
//				echo substr($Nick_Name,0,3)."<br>";			
			}

			
			if ($Horas_Contract==0 || $Horas_Contract=='' || $Horas_Contract==NULL)
			{
			  $NoteHrs=" <-Hours set up by Adm.//";
			  $Horas_Contract=$HContract;
			 // $TNombre=$apNote;
			  $Codigo_Costo=$apNote;
			  if ($Codigo_Costo=="G.H.S.UP")
			  	$Codigo_Costo="";
			}
			

			if ($HContract<1)
				$MilePay=0;
				
			$ParkHelp=$row77["ParkHelp"];
			$SubTotaBene=0;

			
			$Hora_Ingreso=substr($row77["Hora_Ingreso"],0,5);
			//if ($Hora_Ingreso=="01:01")
			//	$Hora_Ingreso="";
				
			$Hora_Salida=substr($row77["Hora_Salida"],0,5);
			//if ($Hora_Salida=="01:01")
			//	$Hora_Salida="";
				
			$Verificado_Foreman=$row77["Verificado_Foreman"];
			$Reg_ID=$row77["Reg_ID"];
			$Foto_Ingreso=$row77["Foto_Ingreso"];
			$Foto_Salida=$row77["Foto_Salida"];
			
			$Horas_aux=$row["Horas"];
			
			if ($Empleado_ID_Ant ==-77)
			{
				$Empleado_ID_Ant = $Empleado_ID;
				$BenefitAnt=$BenefitA;
				$BenefitBnt=$BenefitB;
			}
			
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
			
			if ($Hora_Ingreso=="00:00"){						
				$Hora_Ingreso="No Check In";}
				
			if ($Hora_Salida=="00:00"){								
				$Hora_Salida="No Check Out";}
			
			$Se_Saco_FotoI="Y";		
			if ($Foto_Ingreso==""){								
				$Se_Saco_FotoI="N";}

			$Se_Saco_FotoS="Y";		
			if ($Foto_Salida==""){								
				$Se_Saco_FotoS="N";}

				
			$codigo_Costo="";	
			if ($Edificio_ID!=-1)
			{
				$sql = "select Edificio_ID, Nombre FROM edificios WHERE Edificio_ID=".$Edificio_ID;														
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
				
				$sql = "select Are_IDT,Area_ID, Nombre FROM area_control WHERE Area_ID=".$Area_ID;														
				$result=$bd->ejecutar($sql); 		
				if (($row = mysqli_fetch_array($result) ))	
				{	
					$Area=$row["Nombre"];
					$Are_IDT=$row["Are_IDT"];								
				}
				mysqli_free_result($result);
				
				$sql = "select Task_ID,Tas_IDT,Nombre FROM area_control WHERE Task_ID=".$Task_ID;														
				$result=$bd->ejecutar($sql); 		
				if (($row = mysqli_fetch_array($result) ))	
				{	
					$Tarea=$row["Nombre"];								
					$Tas_IDT=$row["Tas_IDT"];								
				}
				mysqli_free_result($result);
				$codigo_Costo=$Edificio."-".$Piso."-".$Area."-".$Tarea;
			}
			
			if ($Fila>14)
			{
				//echo " nueva pagina due 14 <br>";
				$pdf->AddPage();
				membrete($pdf);
				encabezado($pdf,$af1,$af2);
				encabezado2($pdf,$af1,$af2);
				$Fila=5;
			}							
				
			if ($Empleado_ID_Ant!=$Empleado_ID AND $filtro!="Resume")
			{
				
				pie($pdf,$Total_Horas_Contract, $Total_Horas_TM,$Total_Gas,$BenefitAnt,$BenefitBnt);
				//echo $Empleado_ID_Ant." /".$Empleado_ID. "  neuva pagiana due new employee <br>";
				$pdf->AddPage();
				membrete($pdf);
				encabezado($pdf,$af1,$af2);
				encabezado2($pdf);
				$Fila=5;
				$Total_Horas_Contract=number_format ($Total_Horas_Contract,2);
				$Total_Horas_TM=number_format($Total_Horas_TM,2);				
								
				$Total_Horas_Contract=0;
				$Total_Horas_TM=0;
				$Total_Nowage=0;
				$Total_Horasx=0;
				$Total_Gas=0;
				$Horasx=0;
				$BenefitA="";
				$BenefitB="";
			
								
			}
			
			$pdf->SetFont('Arial','',10);	
			$aux=$pdf->GetY();
			$pdf->SetX(8);
			$pdf->Multicell(20,5,$NumEmp,0,L,false);
			
			$txt = $NumEmp.",";
			fwrite($expfile, $txt);
			
			
			$pdf->SetY($aux);
			$pdf->SetX(27);
			if ($filtro=="Resume")
			  {
				$text="Sub";
				$pdf->Multicell(60,5,$text,0,L,false);
			  }
			 else 
				$pdf->Multicell(60,5,$Nombre_Empleado. " ".$Apellido_Paterno. " ".$Apellido_Materno,0,L,false);
			
			$pdf->SetY($aux);
			$pdf->SetX(85);
			$pdf->Multicell(25,5,$Codigo,0,L,false);
			
			
			$txt = $Codigo.",";
			fwrite($expfile, $txt);
			
			
			
			$pdf->SetY($aux);
			$pdf->SetX(110);
			$pdf->Multicell(45,5,$Proyecto,0,L,false);
			
			if ($Reg_ID!=-1)
			{
				$pdf->SetY($aux);
				$pdf->SetX(152);
				//$Cod_Costx= substr($Codigo_Costo,0,5 );
				//$pdf->Multicell(50,5,$Cod_Costx,0,L,false);
				
				//$pdf->SetY($aux);
				//$pdf->SetX(165);
				//$lon=strlen($Codigo_Costo);
				
				//echo $Cod_costx."<br>";
				//$Cod_Costx= substr($Codigo_Costo,5,$lon);
				$Cod_Costx= substr($Codigo_Costo,0,50);
				$pdf->Multicell(50,5,$Cod_Costx,0,L,false);
				
				$txt = $codexp.",";
				fwrite($expfile, $txt);
				
				
				
				//$pdf->Multicell(30,5,'  '.$CosCod,0,L,false);
				$pdf->SetY($aux);
				$pdf->SetX(200);
				$pdf->Multicell(45,5,$Fecha,0,L,false);
				
				$txt = $FechaOri.",";
				fwrite($expfile, $txt); 
				
				$pdf->SetY($aux);
				$pdf->SetX(242);
				$Horasx=$Horas_Contract;
				$Horas_Contract=number_format($Horas_Contract,2);
				if ($filtro=="Resume")
					$pdf->Multicell(12,5,$SumHoras,0,R,false);
				else
				{
				  $pdf->Multicell(12,5,$Horas_Contract,0,R,false);
				  
				  $txt = $Horas_Contract.",";
				  fwrite($expfile, $txt);
				  
				  
				}
				//benefits
				$tipo=rtrim($Codigo);
				//echo "tipo proy ".$tipo;
				$tipo=substr($tipo,-1);
				$NumProy3=substr($Codigo,0,3);
				//if ($NumProy3>800) $tipo=3;
				//echo " //tipo proy ".$tipo."<br>";
				//echo " /Gas Benefit ".$BenefitA."<br>";
				//echo "TNW ".$Total_Nowage." ini<br>";
				$Gas=0;
				if ($tipo<>"3" and $tipo<>"9")
				{
					$Total_Nowage=$Total_Nowage+$Horasx;
					//echo "TNW ".$Total_Nowage."<br>";
					if ($Total_Nowage > 40)
					{
						$Horasx=40-($Total_Nowage-$Horasx);
						$Total_Nowage=$Total_Nowage+$Horasx;
						//echo " //tipo proy ".$Gas_Week." ////dd";
					}
					$Gas=$Gas_Week/40*$Horasx;
					if ($Gas<0) $Gas=0;
					
					
				}
				$pdf->SetY($aux);
				$pdf->SetX(257);
				$xa=$Gas;
				$xa=number_format($xa,2);
				$pdf->Multicell(15,5,"$".$xa,0,R,false);

				$gasaux=$xa;
				
				////////////////
				$ExGas=0;
				if ($tipo<>"4" and $tipo<>"9")
				{
					$Total_Horasx=$Total_Horasx+$Horasx;
					//echo "TNW ".$Total_Horasx."<br>";
					if ($Total_Horasx > 40)
					{
						$Horasx=40-($Total_Horasx-$Horasx);
						$Total_Horasx=$Total_Horasx+$Horasx;
						//echo " //tipo proy ".$Gas_Week." ////dd";
						//echo ".";
					}
					//echo $BenefitB."<br>";
					$ExGas=$Ext_Mon2/40*$Horasx;
					//echo $Empleado_ID."  :".$Ext_Mon2." be".$BenefitB." Horas".$Horasx." Total Horas ".$Total_Horasx." ExtGas:".$ExGas."<br>";
					echo "-";
					if ($ExGas<0) $ExGas=0;

					
				}
				
				$xa=$ExGas;
				$xa=number_format($xa,2);
				//$Total_ExGas=$Total_ExGas+$ExGas;
//			exit ();
				///////////
				
				
				echo "///*/ "; // error 
				////////////////////////////
								$sql2 = "SELECT p.empleado_id,sum(rda.Horas_Contract) as HorDia FROM `registro_diario_actividad` rda inner join registro_diario rd on rd.Reg_ID=rda.reg_id inner join actividades a on a.Actividad_ID=rd.Actividad_Id inner join personal p on p.empleado_id=rd.Empleado_ID where a.Pro_ID=".$ProIDx." and a.Fecha='".$Fechasql."' and p.empleado_Id=".$Empleado_ID;
		//echo $sql2."<br>";
		$result_2=$bd->ejecutar($sql2);	
		while($row2=mysqli_fetch_array($result_2))
		{
			$HorDia=$row2["HorDia"];
		}
		
				
				$xa=$MilePay/$HorDia*$Horas_Contract;
				$pdf->SetY($aux);				
				$pdf->SetX(280);
				$MilePay=$xa;
				$xa=round($xa,2);
				$pdf->Multicell(15,5,"$".$xa,0,R,false);
				$Total_MilePay=$Total_MilePay+$xa;

				
				///////////////////////
				
				$xa=round($gasaux+$MilePay+$ExGas,2);
				$txt =$xa.",Transportation/Gas,";
				fwrite($expfile, $txt);
				
				
				//$txt =$xa.",Transportation/Gas,";
				//fwrite($expfile, $txt);
				$xa=0; // only due we are including the extra bonus on the gas moneay 
				
				$txt ="0,Night work bonus,";
				$txt=$txt.$xa.",Extra bonus\n";
				fwrite($expfile, $txt);

				$pdf->SetY($aux);
				$pdf->SetX(257);
				$xa=$Gas;
				$xa=number_format($xa,2);
				$pdf->Multicell(15,5,"$".$xa,0,R,false);
				$Total_Gas=$Total_Gas+$Gas;
				
				
				
				
				
				$pdf->SetY($aux);
				$pdf->SetX(303);
				$xa=$ParkHelp;
				$xa=number_format($xa,2);
				$pdf->Multicell(15,5,"$".$xa,0,R,false);
				$Total_ParkHelp=$Total_ParkHelp+$xa;
				
				$SubTotaBene=$Gas+$MilePay+$ParkHelp;
				
				$pdf->SetY($aux);
				$pdf->SetX(324);
				$xa=$SubTotaBene;
				$xa=number_format($xa,2);
				$pdf->Multicell(15,5,"$".$xa,0,R,false);
				$Total_Bene=$Total_Bene+$xa;
				
				//echo "TotalGas ".$Total_Gas."  Benefit:".$BenefitA;
				//fin benefit
				
				/*$pdf->SetY($aux);
				$pdf->SetX(290);
				$pdf->Multicell(60,5,$NoteHrs,0,L,false);	*/
				
				
				
				
			/*	
				$pdf->SetY($aux);
				$pdf->SetX(217);
				$Horas_TM=number_format($Horas_TM,2);
				$pdf->Multicell(10,5,$Horas_TM,0,R,false);	
			
				$pdf->SetY($aux);
				$pdf->SetX(232);
				$pdf->Multicell(20,5,$Hora_Ingreso,0,C,false);				
				
				$pdf->SetY($aux);
				$pdf->SetX(245);
				$pdf->Multicell(15,5,$Se_Saco_FotoI,0,C,false);
				
				$pdf->SetY($aux);
				$pdf->SetX(260);
				$pdf->Multicell(20,5,$Hora_Salida,0,C,false);
				
				
				$pdf->SetY($aux);
				$pdf->SetX(300);
				$pdf->Multicell(15,5,$Se_Saco_FotoI,0,C,false);
				*/
				
								
			}
			$pdf->SetY($aux+10);
	?>
	<!--
			<tr>
				<td><?php echo $NumEmp; ?></td>
				<td><?php echo $Nombre_Empleado. " ".$Apellido_Paterno. " ".$Apellido_Materno; ?></td>
                <td><?php echo $Codigo; ?></td>
                <td><?php echo $Proyecto; ?></td>				
				<td><?php echo $Cod_Costx; ?></td>
                <td><?php echo $Fecha; ?></td>	                    		
				<td align='right'><?php echo $Horas_Contract; ?></td>		
				<td align='right'><?php echo $Horas_TM; ?></td>				
                <td><?php echo $Hora_Ingreso; ?></td>
                <td align="center"><?php echo $Se_Saco_FotoI; ?></td>
				<td><?php echo $Hora_Salida; ?></td>				
                <td align="center"><?php echo $Se_Saco_FotoS; ?></td>
			</tr>  -->
	<?php
				$sql21 = "INSERT INTO reports (a1,a2,a3,a4,a5,a6) VALUES ('".$Nombre_Empleado.$Apellido_Paterno."','".$Codigo."','".$Proyecto."','".$CosCod."','".$Fecha."','".$Horas_Contract."')";
				//echo $sql21."<br>";
				$result21=$bd->ejecutar($sql21); 		
				mysqli_free_result($result21);	


			$Empleado_ID_Ant=$Empleado_ID;
			$BenefitAnt=$BenefitA;
			$BenefitBnt=$BenefitB;
			$Total_Horas_Contract=$Total_Horas_Contract+$Horas_Contract;
			$Total_Horas_TM=$Total_Horas_TM+$Horas_TM;
			$Fila++;
			
		}
		mysqli_free_result($result77);	
		if ($Fila>14)
		{
			$pdf->AddPage();		
		}
		if ($filtro=="Resume")
			$Total_Horas_Contract=$SumHorasTot;
			
		pie($pdf,$Total_Horas_Contract, $Total_Horas_TM,$Total_Gas,$BenefitA,$BenefitB,$Total_MilePay,$Total_ParkHelp,$Total_Bene);

		fclose($expfile);  // close the export file 
		
		
	///// abrir el file exportado 	/////////////


//echo '<div style="font-size:1.25em;color:#0e3c68;font-weight:bold;">PRECIO DIGITAL: <span style="font-size:1.25em;color:#0e3c68;font-weight:bold;">'.$precio_digital.'</span></div>';

echo '<td><a href="'.$filename.'">'.'<div style="font-size:1.25em;color:#2471A3;font-weight:bold;">Download export file: <span style="font-weight:bold;">'.substr($filename,-32).'</span></div></a></td>';

//echo '<td><a href="'.$filename.'">'."dowload file:".$filename.'</a></td>';


		////////   fin abrir file exportado
			
		
 
	
		$pdf->Output("dato1.pdf");
		

?>		
	<!--	<tr>
        	<td colspan=6 align="right">TOTAL:</td><td><?php echo $Total_Horas_Contract;?></td><td><?php echo $Total_Horas_TM;?></td>
        </tr>	-->


<br>
      <embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="1190" height="570"></embed> 
      
      
      
      
      
      <?php
	require('Library/Close_Conexion.php');	
?>
    </p>
	