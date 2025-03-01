<?php
	session_name("Administrador");
	session_start();
	//*******************************************************************
	//Datos enviados por proyecto_reporte_material_0.php
	//******************************************************************	

	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');		

	// INSERTADO POR FABIOLA CARRASCO
	require('pdf/fpdf.php');
	$pdf=new FPDF();
	//$pdf->AddPage();

	// DEFINICION DE FUNCIONES DE CABEZERA DE SUBCUEPO
	$pdf->SetMargins(15,20,15,15);
	$pdf->SetFont('Arial','',10);
	$pdf->SetLineWidth(0.5); 
	$pdf->Setfillcolor(237,243,120);

	///mmmmm\
	$strSQL = "DELETE FROM bonus_summary WHERE (Nic_Nam<>' ')";	
	//echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);

	function membrete(&$pdf)
	{
		//ENCABEZADO
		$pdf->SetFont('Arial','',8);
		$pdf->Image('images/logo.png',5,5,30,10,"png");
		$pdf->SetFont('Arial','',10);
	}

	

	function encabezado(&$pdf,$Codigo_Bono,$Nick_Name,$Indice_Produccion,$numemp)
	{	 
	  $pdf->Multicell(0,5,"Production Bonus because your productive and hard work being part of PWT team",0,C,false);
  	  $pdf->Multicell(0,5,"Bonus For:".$Codigo_Bono,0,L,false);
//	  $pdf->Multicell(0,5,"Bonus #:".$Codigo_Bono.$Indice_Produccion,0,L,false);
  	  $pdf->Multicell(0,5,"Employee:".$Nick_Name." #".$numemp,0,L,false);
	  $pdf->Multicell(0,5,"",0,L,false);

  	  $aux=$pdf->GetY();
	  $pdf->SetX(20);
	  $pdf->Multicell(0,5,"# Job",0,L,false);

	  $pdf->SetY($aux);
	  $pdf->SetX(50);
	  $pdf->Multicell(20,5,"Job",0,C,false);

	  $pdf->SetY($aux);
	  $pdf->SetX(100);
	  $pdf->Multicell(20,5,"Bonus to PWT Team",0,L,false);
	  
	  $pdf->SetY($aux);
	  $pdf->SetX(125);
	  $pdf->Multicell(20,5,"Hours Worked in the job site",0,L,false);

	  $pdf->SetY($aux);
	  $pdf->SetX(150);
	  $pdf->Multicell(20,5,"Bonus by Hours Worked",0,C,false);

	  $pdf->SetY($aux);
	  $pdf->SetX(170);
	  $pdf->Multicell(30,5,"Total",0,C,false);

  	  
	  $aux7=$pdf->GetY();
	  $pdf->line(10,$pdf->GetY()-5,200,$pdf->GetY()-5);
  	  $pdf->line(10,$aux+15,200,$aux+15);
	  $pdf->SetY($aux7+15);
	}

		

	function subtotal(&$pdf,&$Parcial_HContract,&$Parcial_HTM)

	{

	  $aux=$pdf->GetY();
  	  $pdf->line(130,$pdf->GetY(),200,$pdf->GetY());
	  $pdf->SetX(100);
	  $pdf->Multicell(0,5,"Subtotal",0,L,false);
	  $pdf->SetY($aux);
	  $pdf->SetX(120);					  

	  $pdf->SetY($aux);				  

	  $pdf->SetX(140);					  

	//  $pdf->Multicell(20,5,number_format(($Parcial_HTM),2),0,R,false);

	  $pdf->SetY($aux);

	  $pdf->SetX(160);					  

	  $pdf->Multicell(20,5,"$".number_format(($Parcial_HContract+$Parcial_HTM),2),0,R,false);

			

   	  $pdf->line(130,$pdf->GetY(),200,$pdf->GetY());

   	  $pdf->Multicell(0,5,"",0,L,false);

	  $Parcial_Monto_Proyecto=0;
	  $Parcial_Monto_Total=0;

	}
	

	$Codigo_Bono=$_REQUEST["Codigo_Bono"];
	$To_Date=$_REQUEST["To_Date"];
	
	$vdia=substr($To_Date,3,2);
	$vmes=substr($To_Date,0,2);
	$vano=substr($To_Date,8,2);
	$To_Date="20".$vano."-".$vmes."-".$vdia;
	//$To_Date=date("Y-m-d",strtotime($To_Date));
	//echo $Codigo_Bono,"  // ",$To_Date."<br>";
	
	$consulta = "UPDATE proyectos SET Indice_Global='".$Indice_Global."',Totalaux=0,Totalpwt=0 WHERE Codigo_Bono='".$Codigo_Bono."'";		
		$result32=$bd->ejecutar($consulta);
	
	
	
	
	$consulta = "SELECT pr.Pro_ID, pr.Monto_Bono, SUM(Indice_Produccion*HContract) AS HContract, SUM(Indice_Produccion*HTM) AS HTM ";

	$consulta = $consulta . " FROM personal p INNER JOIN actividad_personal ap ON  p.Empleado_ID=ap.Empleado_ID AND (p.aux5 ='f' || p.aux5 ='F' || p.aux5='Adm') ";
	$consulta = $consulta . " INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID ";
	$consulta = $consulta . " INNER JOIN proyectos pr ON a.Pro_ID=pr.Pro_ID ";
	$consulta = $consulta . " WHERE (pr.Codigo_Bono='".$Codigo_Bono."' AND p.Fecha_Contratacion<'".$To_Date."' )  ";
	$consulta = $consulta . " GROUP BY pr.Codigo";
	$consulta = $consulta . " ORDER BY pr.Nombre  ";	
	//echo $consulta ;

	$result=$bd->ejecutar($consulta);
    while($row=mysqli_fetch_array($result))
	{
		$Pro_ID=$row["Pro_ID"];
		$Total_Horas=$row["HContract"]+$row["HTM"];
		$Indice_Global=$row["Monto_Bono"]/$Total_Horas;
		
		$consulta = "UPDATE proyectos SET Indice_Global='".$Indice_Global."',Totalaux=0,Totalpwt=0 WHERE Pro_ID=".$Pro_ID;		
//				$consulta = "UPDATE proyectos SET Indice_Global='".$Indice_Global."' WHERE Pro_ID=".$Pro_ID;		
		$result32=$bd->ejecutar($consulta);
		//echo $consulta;
		//echo $Total_Horas."**".$row["Monto_Bono"]."**".$consulta."<br>";
	}
	mysqli_free_result($result);
	
	$consulta = "SELECT p.Numero,p.Nick_Name,p.Fecha_Nacimiento,p.Fecha_Contratacion,p.Apellido_Materno, p.Aux5, p.Indice_Produccion, p.Empleado_ID,Nro_Bono,Spec_Bon1,Not_Bon ";
	$consulta = $consulta . " FROM personal p WHERE p.Fecha_Contratacion<'".$To_Date."' AND (p.Aux5 ='f' || p.Aux5 ='F' ||  p.Aux5='FX') ";
	$consulta = $consulta . " ORDER BY p.Apellido_Materno,p.Nick_Name ";	

	//echo $consulta ;
	$conta=0;
	$contat=0;
	$compensa=0;
	$totalpayable=0;
	$totalporhora=0;
	$result=$bd->ejecutar($consulta);
	// titulo del reporte
    if(mysqli_num_rows($result)>0) 
	{
		$total_ordenado=0;
		$total_recibido=0;
		$total_usado=0;
		$total_balance=0;
		$bandera=1;	
		$bandera_2=1;
		$Nick_Name=0;
		
		$Parcial_Monto_Proyecto=0;
		$Parcial_Monto_Total=0;
		$Parcial_montopwt=0;
		$Parcial_specbon=0;
		
		$Total_Monto_Proyecto=0;
		$Total_Monto_Total=0;
		$Total_Employee=0;
		
		$Pro_IDs="-7";
		
		
		while($row=mysqli_fetch_array($result))
		{
			
			$Nick_Name=$row["Nick_Name"];
			$FecSta=$row["Fecha_Contratacion"];
			//$FecSta=$row["Fecha_Nacimiento"];
			//$FecCont=$row["Fecha_Contratacion"];
			$numemp=$row["Numero"];
			$tipper="zz";
			if ($Nick_Name!="")
			{
				$contat++;
				$Empleado_ID=$row["Empleado_ID"];
				
				$Indice_Produccion=$row['Indice_Produccion'];
				$codbon=$row["Nro_Bono"];
				$spebon=$row["Spec_Bon1"];
				$notbon=$row["Not_Bon"];
				$tipper=$row["Aux5"];
				
				$pdf->AddPage();																	
				membrete($pdf);
				encabezado($pdf,$Codigo_Bono,$Nick_Name,$Indice_Produccion,$numemp);
				
				
				
				$consulta = "SELECT pr.Pro_ID, pr.Codigo, pr.Nombre, pr.Indice_Global, pr.Bono_General, ap.Note, a.Fecha, SUM(HContract) AS HContract, SUM(HTM) AS HTM ";
				$consulta = $consulta . " FROM actividad_personal ap INNER JOIN actividades a ON a.Actividad_ID=ap.Actividad_ID and ap.Empleado_ID=".$Empleado_ID;
				$consulta = $consulta . " INNER JOIN proyectos pr ON a.Pro_ID=pr.Pro_ID AND pr.Codigo_Bono='".$Codigo_Bono."' ";
				$consulta = $consulta . " GROUP BY pr.Codigo, pr.Nombre ";			
				//echo $consulta ;		
				$totaljob=0;
				$result99=$bd->ejecutar($consulta);			
				while($row99=mysqli_fetch_array($result99))
				{
					
					if ($row99['Pro_ID']!=0)
					{
						$aux=$pdf->GetY();
						$pdf->SetX(20);			
						$pdf->Multicell(0,5,$row99['Codigo']." |",0,L,false);
						$pdf->SetY($aux);
						$pdf->SetX(40);
						$pdf->Multicell(0,5,(substr(($row99['Nombre']),0,24)),0,L,false);
						$pdf->SetY($aux);
			
						$pdf->SetX(100);
						$monto_pwt=($row99["Bono_General"]* $Indice_Produccion);
						$pdf->Multicell(20,5,"$".$monto_pwt,0,R,false);
						$pdf->SetY($aux);
						$codproy=$row99['Pro_ID'];						
					$consultar8 = "SELECT Totalpwt FROM proyectos";
					$consultar8 = $consultar8." WHERE Pro_ID=".$codproy;
					//				echo "select:".$consultar8 ;
					$resultr8=$bd->ejecutar($consultar8);
					
					while($rowr8=mysqli_fetch_array($resultr8))
					{
					$totalpwt=$rowr8['Totalpwt'];
					}
			
						
					mysqli_free_result($resultr8);
					// echo "   //   ".$totalpwt."  --//".$monto_pwt." //  ";
					$totalpwt+=$monto_pwt;
					$consultar8 = "UPDATE proyectos SET  Totalpwt='".$totalpwt."' WHERE Pro_ID=".$codproy;		
					$resultr8=$bd->ejecutar($consultar8);
				    // echo "   +++ ".$consultar8;
						
							
						$pdf->SetX(120);
						$pdf->Multicell(20,5,number_format(($row99['HContract']+$row99['HTM']),2),0,R,false);
						

						$Monto_Proyecto= ( ($row99['HContract']+$row99['HTM'])*$Indice_Produccion ) * $row99['Indice_Global'];			
						$totaljob=$Monto_Proyecto;
						$pdf->SetY($aux);
						$pdf->SetX(150);
						$pdf->Multicell(20,5,"$".number_format($Monto_Proyecto,2)."",0,R,false);						
												
						$pdf->SetY($aux);
						$pdf->SetX(170);
						$pdf->Multicell(20,5,"|$".number_format($Monto_Proyecto+$monto_pwt,2)."|",0,R,false);
			
						//sumas parciales
						
						$Pro_IDs=$Pro_IDs.", ".$row99['Pro_ID'];
						$Proid=$row99['Pro_ID'];
						
						$Parcial_montopwt=$Parcial_montopwt+$monto_pwt;
						$Parcial_Monto_Proyecto=$Parcial_Monto_Proyecto+$Monto_Proyecto;
						$Parcial_Monto_Total=$Parcial_Monto_Total+($Monto_Proyecto+$monto_pwt);
						
						$Total_Monto_Proyecto=$Parcial_Monto_Proyecto+$Monto_Proyecto;
						$Total_Monto_Total=$Parcial_Monto_Total+$Monto_Proyecto+$monto_pwt;
						
				
				
					//   grabar total de bono efectivo
					$consultar1 = "SELECT Totalaux FROM proyectos";
					$consultar1 = $consultar1 . " WHERE Pro_ID=".$Proid;
					
					//echo $consultar1 ;
					
					$resultr1=$bd->ejecutar($consultar1);
					
					while($rowr1=mysqli_fetch_array($resultr1))
					{
					$totalaux=$rowr1['Totalaux'];
					}
					mysqli_free_result($resultr1);
					//echo "   //   ".$totalaux."  --//";
					
					$totaljob=$totalaux+$totaljob;
					$consultar1 = "UPDATE proyectos SET Totalaux=".$totaljob." WHERE Pro_ID=".$Proid;		
					$resultr1=$bd->ejecutar($consultar1);
				    //echo $consultar1 ;
					// fin total grabar total de bono efectivo
						
						
					}
					
					
					
					
				}
				
				
				mysqli_free_result($result99);
				
				$consulta = "SELECT Codigo, Nombre, Bono_General,Totalpwt,Pro_ID FROM proyectos WHERE Codigo_Bono='".$Codigo_Bono."'  ";
				$consulta = $consulta . " AND Pro_ID NOT IN (".$Pro_IDs.") order by Nombre ";
				//echo $consulta ;			
				$result99=$bd->ejecutar($consulta);
				while($row99=mysqli_fetch_array($result99))
				{
					$aux=$pdf->GetY();
					$pdf->SetX(20);					
					$pdf->Multicell(0,5,$row99['Codigo']." |",0,L,false);
					$pdf->SetY($aux);
					$pdf->SetX(40);
					$pdf->Multicell(0,5,(substr(($row99['Nombre']),0,34)),0,L,false);
					$pdf->SetY($aux); 
					
					$pdf->SetX(100);
					$monto_pwt=($row99["Bono_General"]* $Indice_Produccion);
					$pdf->Multicell(20,5,"$".number_format($monto_pwt,2),0,R,false);
					$pdf->SetY($aux);
					$codproy=$row99['Pro_ID'];	
						
					$consultar8 = "SELECT Totalpwt FROM proyectos";
					$consultar8 = $consultar8." WHERE Pro_ID=".$codproy;
					//				echo "select:".$consultar8 ;
					$resultr8=$bd->ejecutar($consultar8);
					
					while($rowr8=mysqli_fetch_array($resultr8))
					{
					$totalpwt=$rowr8['Totalpwt'];
					}
			
						
					mysqli_free_result($resultr8);
					//echo "   //   ".$totalpwt."  --".$monto_pwt." //  ";
					$totalpwt=$totalpwt+$monto_pwt;
					$consultar8 = "UPDATE proyectos SET  Totalpwt='".$totalpwt."' WHERE Pro_ID=".$codproy;		
					$resultr8=$bd->ejecutar($consultar8);
					//if ($totalpwt>50000)
				    	//	echo "   +++ ".$consultar8;

						
					$pdf->SetX(120);
					$pdf->Multicell(20,5,"0.00",0,R,false);					
					
					$pdf->SetY($aux);
					$pdf->SetX(150);
					$pdf->Multicell(20,5,"0.00",0,R,false);						
					
					$pdf->SetY($aux);
					$pdf->SetX(170);
					$pdf->Multicell(20,5,"|$".number_format($monto_pwt,2)."|",0,R,false);
					$Parcial_Monto_Total=$Parcial_Monto_Total+$monto_pwt;
				}
				mysqli_free_result($result99);
				$Pro_IDs="-7";
				
				if ($Parcial_Monto_Total<0)
				{
					$aux=$pdf->GetY();
					$pdf->SetX(20);					
					$pdf->Multicell(0,5,"PWT",0,L,false);
					$pdf->SetY($aux);
					$pdf->SetX(40);
					$pdf->Multicell(0,5,"to compensate losses",0,L,false);
					$pdf->SetY($aux);
					
										
					
					$pdf->SetY($aux);
					$pdf->SetX(170);
					$pdf->Multicell(20,5,"$". number_format(($Parcial_Monto_Total*-1),2),0,R,false);
					$compensa=$compensa + $Parcial_Monto_Total;
					$Parcial_Monto_Proyecto=$Parcial_Monto_Proyecto+($Parcial_Monto_Proyecto*-1);
					$Parcial_Monto_Total=$Parcial_Monto_Total+($Parcial_Monto_Total*-1);
				}
				if (($Codigo_Bono == $codbon) and ($spebon > 0))
				{
					$aux=$pdf->GetY()+4;
					$pdf->SetY($aux);
					$pdf->SetX(20);					
					$pdf->Multicell(0,5,"PWT:",0,L,false);
					$pdf->SetY($aux);
					$pdf->SetX(40);
					$pdf->Multicell(100,5,$notbon,0,L,false);

					$aux=$pdf->GetY();					
					$pdf->SetY($aux);
						$pdf->SetY($aux);
					$pdf->SetX(170);
					$pdf->Multicell(20,5,"|$". number_format(($spebon),2)."|",0,R,false);
					//$compensa=$compensa + $spebon;
					$Parcial_specbon=$Parcial_specbon+$spebon;
					$Parcial_Monto_Total=$Parcial_Monto_Total+($spebon);
					}
					else
					{
						$spebon=0;
						
						}
	
				$aux=$pdf->GetY();
				$pdf->line(100,$pdf->GetY(),200,$pdf->GetY());
				$pdf->SetX(115);
			//	$pdf->SetX(85);
				$pdf->Multicell(0,5,"Total Payable",0,L,false);	 
								
				$pdf->SetY($aux);
				$pdf->SetX(170);	
				$pdf->Multicell(20,5,"$".number_format($Parcial_Monto_Total,2),0,R,false);
				$totalpayable=($totalpayable+$Parcial_Monto_Total);
				if 	(($totalpayable+$Parcial_Monto_Total) > 0 )
							{$conta++;
								}

	
				$pdf->Multicell(20,5,"",0,R,false);
				$pdf->SetX(150);	
				$pdf->Multicell(40,5,"Date:". date('m-d-Y'),0,R,false);	
				
								
								///mmmmm\
								
								
					
					$spe_bon1=$spebon;
					$strSQL = "INSERT INTO bonus_summary (Empleado_ID,Nic_Nam,Tot_Bon,Indice,Spe_Bon1,Type_Per,Fec_Sta) ";	
					$strSQL = $strSQL . " values (".$Empleado_ID.",'".$Nick_Name."',".$Parcial_Monto_Total.",". $Indice_Produccion.",". $spe_bon1. ",'".$tipper."','".$FecCont."')";		
					//echo $strSQL."<br>";				
					$res1=$bd->ejecutar($strSQL);
					$Total_Employee=$Total_Employee+$Parcial_Monto_Total;
						
				$Parcial_Monto_Proyecto=0;				
				$Parcial_Monto_Total=0;			
	
	
				
	
	
				/*if($aux6>=260)
				{
					$pdf->AddPage();
					membrete($pdf);
					encabezado($pdf,$af1,$af2);
				}*/
			}
		}	
		mysqli_free_result($result);
		/*$consulta = "SELECT Codigo, Nombre, Bono_General FROM proyectos WHERE Codigo_Bono='".$Codigo_Bono."'  ";
		$consulta = $consulta . " AND Pro_ID NOT IN (".$Pro_IDs.") ";
		//echo $consulta ;			
		$result99=$bd->ejecutar($consulta);
		while($row99=mysqli_fetch_array($result99))
		{
			$aux=$pdf->GetY();
			$pdf->SetX(20);
			$fecha=FormatDateTime($row99["Fecha"], 8);
			$pdf->Multicell(0,5,$row99['Codigo'],0,L,false);
			$pdf->SetY($aux);
			$pdf->SetX(40);
			$pdf->Multicell(0,5,(substr(($row99['Nombre']),0,24)),0,L,false);
			$pdf->SetY($aux);
			
			$pdf->SetX(100);
			$pdf->Multicell(20,5,$row99["Bono_General"],0,R,false);
			$pdf->SetY($aux);
				
			$pdf->SetX(120);
			$pdf->Multicell(20,5,"0.00",0,R,false);					
			
			$pdf->SetY($aux);
			$pdf->SetX(150);
			$pdf->Multicell(20,5,"0.00",0,R,false);						
			
			$pdf->SetY($aux);
			$pdf->SetX(170);
			$pdf->Multicell(20,5,$row99["Bono_General"],0,R,false);
			$Parcial_Monto_Total=$Parcial_Monto_Total+$row99["Bono_General"];
		}
		mysqli_free_result($result99);
		
		if ($Parcial_Monto_Total<0)
		{
			$aux=$pdf->GetY();
			$pdf->SetX(20);					
			$pdf->Multicell(0,5,"PW",0,L,false);
			$pdf->SetY($aux);
			$pdf->SetX(40);
			$pdf->Multicell(0,5,"AJUSTE",0,L,false);
			$pdf->SetY($aux);
			
			$pdf->SetX(100);
			$pdf->Multicell(20,5,"0.00",0,R,false);
			$pdf->SetY($aux);
				
			$pdf->SetX(120);
			$pdf->Multicell(20,5,"0.00",0,R,false);					
			
			$pdf->SetY($aux);
			$pdf->SetX(150);
			$pdf->Multicell(20,5,($Parcial_Monto_Proyecto*-1),0,R,false);						
			
			$pdf->SetY($aux);
			$pdf->SetX(170);
			$pdf->Multicell(20,5,($Parcial_Monto_Total*-1),0,R,false);
			$Parcial_Monto_Proyecto=$Parcial_Monto_Proyecto+($Parcial_Monto_Proyecto*-1);
			$Parcial_Monto_Total=$Parcial_Monto_Total+($Parcial_Monto_Total*-1);
		}
				
		$aux=$pdf->GetY();
		$pdf->line(130,$pdf->GetY(),200,$pdf->GetY());
		$pdf->SetX(100);
		$pdf->Multicell(0,5,"Subtotal",0,L,false);	 
		
		$pdf->SetY($aux);
		$pdf->SetX(150);	
		$pdf->Multicell(20,5,$Parcial_Monto_Proyecto,0,R,false);
		
		$pdf->SetY($aux);
		$pdf->SetX(170);	
		$pdf->Multicell(20,5,$Parcial_Monto_Total,0,R,false);	*/	
	}	

	mysqli_free_result($result);
	////////// rrrrrrrrrrrrr////////
	
	$pdf->AddPage();																	
	membrete($pdf);
	
	/// Encabezado ///

	  $pdf->Multicell(0,5,"Sumary Production Bonus #".$Codigo_Bono."  / Amounts By Job ",0,C,false);
	  $pdf->Multicell(0,5,"",0,L,false);

  	  $aux=$pdf->GetY();
	  $pdf->SetX(20);
	  $pdf->Multicell(0,5,"# Job",0,L,false);

	  $pdf->SetY($aux);
	  $pdf->SetX(50);
	  $pdf->Multicell(20,5,"Job",0,C,false);

	  $pdf->SetY($aux);
	  $pdf->SetX(120);
	  $pdf->Multicell(20,5,"Total Bonus for PWT team",0,L,false);
	  
	  $pdf->SetY($aux);
	  $pdf->SetX(145);
	  $pdf->Multicell(25,5,"Total Bonus by Hours Worked in job sites",0,L,false);

	  $pdf->SetY($aux);
	  $pdf->SetX(170);
	  $pdf->Multicell(30,5,"Totals",0,C,false);

  	  
	  $aux7=$pdf->GetY();
	  $pdf->line(10,$pdf->GetY()-5,200,$pdf->GetY()-5);
  	  $pdf->line(10,$aux+20,200,$aux+20);
	  $pdf->SetY($aux7+20);

	
	
	// fin encabezado 	
				$pdf->Multicell(20,5,"",0,R,false);
				$pdf->SetX(75);	
//				$pdf->Multicell(75,5,"Total Employees w/Bonus: ".$conta." from:".$contat,0,R,false);	
					
		
	$consulta = "SELECT Codigo, Nombre, Bono_General,Monto_Bono,Indice_Global,Totalaux,Totalpwt FROM proyectos";
	$consulta = $consulta . " WHERE (Codigo_Bono='".$Codigo_Bono."')  ";
	$consulta = $consulta . " ORDER BY Nombre  ";	
	//echo $consulta ;

	$result=$bd->ejecutar($consulta);
	$aux=$pdf->GetY()+2;
	$pdf->SetY($aux);
	$gtotal=0;
	while($row=mysqli_fetch_array($result))
	{
										
					$aux=$pdf->GetY();
					$pdf->SetX(10);					
					$pdf->Multicell(0,5,$row['Codigo'],0,L,false);
					$pdf->SetY($aux);
					$pdf->SetX(25);
					$pdf->Multicell(0,5,(substr(($row['Nombre']),0,40)),0,L,false);
					$pdf->SetY($aux);
					

					//$pdf->SetX(60);
					//$pdf->Multicell(25,5,"Rate/h:".number_format($row['Indice_Global'],2),0,R,false);				
					//$pdf->SetY($aux);
					
					$r1=$row['Totalpwt'];
					$pdf->SetX(120);
					$pdf->Multicell(20,5,("$".number_format($r1,2)),0,R,false);
					//." x ".$conta." = "),0,R,false);
					
					$pdf->SetY($aux);
					
					//$r1t=($row["Bono_General"]*$conta);
					//$pdf->SetY($aux);
					//$pdf->SetX(120);
					//$pdf->Multicell(20,5,"$".number_format($r1t,2),0,R,false);
				
					$pdf->SetY($aux);
					$pdf->SetX(145);
					$pdf->Multicell(20,5,"$".number_format($row["Totalaux"],2),0,R,false);
					
					$pdf->SetY($aux);
					$pdf->SetX(160);
					$pdf->Multicell(30,5,"$".number_format(($row["Totalpwt"]+$row["Totalaux"]),2),0,R,false);					
					$gtotal=$gtotal+($row["Totalpwt"]+$row["Totalaux"]);
					//$pdf->SetY($aux);
					//$pdf->SetX(190);
					//$pdf->Multicell(20,5,"0.00",0,R,false);						
					
					
					$aux=($pdf->GetY()+2);
					$pdf->SetY($aux);
					
					
		
		//echo $Total_Horas."**".$row["Monto_Bono"]."**".$consulta."<br>";
	}
	mysqli_free_result($result);
	$pdf->SetY($aux);
	$pdf->SetX(25);	
	//$pdf->Multicell(70,5,"PWT to compensate losses   ",0,L,false);  comented due no igqual
	
	$compensa=$Total_Employee-$gtotal-$Parcial_specbon;
	
	//echo $compensa."//--  ".$Total_Employee." //--".$gtotal." //*".$Parcial_specbon;
	
	$pdf->SetY($aux);
	$pdf->SetX(160);
//	$pdf->Multicell(30,5,"$".number_format($compensa,2),0,R,false);  comented due no igqual
	
	//mmm  special bonus 
	$aux=($pdf->GetY()+2);
	$pdf->SetY($aux);
	mysqli_free_result($result);
	$pdf->SetY($aux);
	$pdf->SetX(25);	
	$pdf->Multicell(70,5,"PWT Special bonus (some employees)  ",0,L,false);
	
	$pdf->SetY($aux);
	$pdf->SetX(160);
	//$pdf->Multicell(30,5,"$".number_format($Parcial_specbon,2),0,R,false);  comented due no igqual 
//	$pdf->Multicell(30,5,"$".number_format($gtotal-$Parcial_specbon+$compensa,2),0,R,false);
	$pdf->Multicell(30,5,"$".number_format($Parcial_specbon+$compensa,2),0,R,false);
	
	
	///fin mm
	
	
	
	
				$gtotal= $gtotal+($compensa)+$Parcial_specbon;
	
	
				$aux=$pdf->GetY()+5;
				$pdf->SetY($aux);
				$pdf->line(100,$pdf->GetY(),200,$pdf->GetY());
				$aux=$pdf->GetY()+2;
				$pdf->SetY($aux);
				$pdf->SetX(115);
				$pdf->Multicell(0,5,"Total Payable",0,L,false);	 
				
				//$pdf->SetY($aux);
				//$pdf->SetX(150);	
				//$pdf->Multicell(20,5,number_format($Parcial_Monto_Proyecto,2),0,R,false);
				
				$pdf->SetY($aux);
				$pdf->SetX(170);	
				$pdf->Multicell(20,5,number_format($gtotal,2),0,R,false);
				
					$aux=$pdf->GetY()+5;
				$pdf->SetY($aux);
				$pdf->line(100,$pdf->GetY(),200,$pdf->GetY());
				
	
				$pdf->Multicell(20,5,"",0,R,false);
				$pdf->SetX(150);	
				$pdf->Multicell(40,5,"Date:". date('m-d-Y'),0,R,false);	
//// just to verify the amounts TOTAL PAYABLE 
		/*		$aux=$pdf->GetY()+5;
				$pdf->SetY($aux);
				$pdf->SetX(150);	
				$pdf->Multicell(20,5,"Grand Total ".number_format($totalpayable,2),0,R,false);
				
			    $aux=$pdf->GetY()+5;
				$pdf->SetY($aux);
				$pdf->SetX(150);	
				$pdf->Multicell(20,5,"Total por hora ".number_format($totalporhora,2),0,R,false); */
	
	
	
	
	///mmmmm  impresion por empleado resumen
	
		
	$pdf->AddPage();																	
	membrete($pdf);
	
	  $pdf->Multicell(0,5,"Sumary Production Bonus #".$Codigo_Bono."  / Amounts By Employee ",0,C,false);
	  $pdf->Multicell(0,5,"",0,L,false);

	/// Encabezado ///

	//  $pdf->Multicell(0,5,"Summary by Employee, Production Bonus #".$Codigo_Bono,0,C,false);
	  $pdf->Multicell(0,5,"",0,L,false);

  	  $aux=$pdf->GetY();
	  $pdf->SetX(20);
	  $pdf->Multicell(45,5,"PWT#  Nick Name/Only Hires before:".date("m-d-Y", strtotime($To_Date)),0,L,false);
	  
	  
	  $pdf->SetY($aux);
	  $pdf->SetX(65);
	  $pdf->Multicell(0,5,"Started on",0,L,false);
	  

	  $pdf->SetY($aux);
	  $pdf->SetX(84);
	  $pdf->Multicell(20,5,"Index",0,C,false);

	  $pdf->SetY($aux);
	  $pdf->SetX(120);
	  $pdf->Multicell(25,5,"Bonus from Projects",0,L,false);
	  
	  $pdf->SetY($aux);
	  $pdf->SetX(145);
	  $pdf->Multicell(25,5,"Special Bonus ",0,L,false);

	  $pdf->SetY($aux);
	  $pdf->SetX(170);
	  $pdf->Multicell(30,5,"Total Bonus",0,C,false);

  	  
	  $aux7=$pdf->GetY();
	  $pdf->line(10,$pdf->GetY()-5,200,$pdf->GetY()-5);
  	  $pdf->line(10,$aux+12,200,$aux+12);
	  $pdf->SetY($aux7+5);

	
	
	
	// fin encabezado 	
	$pdf->Multicell(20,5,"",0,R,false);
	$pdf->SetX(75);	
	//$pdf->Multicell(75,5,"Total Employees w/Bonus: ".$conta." from:".$contat,0,R,false);	
					
		
//	$consulta = "SELECT * FROM bonus_summary ";
	//$consulta = $consulta . " ORDER BY Type_Per ASC,Tot_Bon ASC, Nic_Nam ASC";	
	//echo $consulta ;
	$sql3= "DELETE FROM bonus_summary_person WHERE Cod_Bonus='".$Codigo_Bono."'";
	//echo $sql3."<br>";
	$result3=$bd->ejecutar($sql3);
	

	$consulta = "SELECT b.*,p.Numero,p.Nick_Name,p.Fecha_Nacimiento,p.Fecha_Contratacion,p.Apellido_Materno, p.Aux5, p.Indice_Produccion as Indice, p.Empleado_ID,Nro_Bono,Spec_Bon1,Not_Bon ";
	$consulta = $consulta . " FROM personal p LEFT JOIN bonus_summary b on p.Empleado_ID=b.Empleado_ID WHERE (p.Aux5 ='f' || p.Aux5 ='F' ||  p.Aux5='FX') ";
	$consulta = $consulta . " ORDER BY b.Type_Per ASC,b.Tot_Bon ASC, b.Nic_Nam ASC";	
	$result=$bd->ejecutar($consulta);
	//echo $consulta."<br>";
	$aux=$pdf->GetY()+1;
	$pdf->SetY($aux);
	$gtotal=0;
	$conta=0;
	$contabon=0;
	$tot_spe_bon=0;
	$typ_per="xx";
	while($row=mysqli_fetch_array($result))
	{
			$Amount_Teamx=0;
			$Amount_Specialx=0;
			$Total_Bonusx=0;
			
			$Empleado_IDx=$row['Empleado_ID'];
			$Nick_Namex=$row["Nick_Name"];
			$Fec_Hirex=$row["Fecha_Contratacion"];
			$Indexx=$row["Indice"];
			$Numero=" #".$row["Numero"]." ";
			$Emp_Numx=$row["Numero"];
			$Nick_Name=$Numero.$row["Nick_Name"];
		
			if ($row["Tot_Bon"]>0)
				$contabon++;
			$conta++;					
			if ($typ_per<>($row['Type_Per']))
			{
				$pdf->line(10,$aux+1,35,$aux+1);
				$aux=$pdf->GetY();
				$aux=$aux+2;
				$pdf->SetY($aux);
			}
			$typ_per=($row['Type_Per']);
				$aux=$pdf->GetY();
				$pdf->SetY($aux);
					$pdf->SetX(10);					
					$pdf->Multicell(0,5,$conta,0,20,0,L,false);
					$Contax=$conta;
					$pdf->SetY($aux);
					$pdf->SetX(18);
					//echo $row['Fecha_Nacimiento']." //".$To_Date."<br>" ;
					if ($row['Fecha_Contratacion']< $To_Date)
						$FecStax="";
					  else
						$FecStax=date("m-d-Y",strtotime($row['Fecha_Contratacion']));
					$pdf->Multicell(50,5,(substr(($Nick_Name),0,25)),0,L,false);
					$pdf->SetY($aux);
					$pdf->SetX(65);
					$pdf->Multicell(23,5,$FecStax,0,L,false);
					$pdf->SetY($aux);
					$pdf->SetX(80);
					$pdf->Multicell(20,5," ".number_format($row["Indice"],2),0,R,false);
					$r1=$row['Tot_Bon']-$row["Spe_Bon1"];
					$Amount_Teamx=$rl;
					if ($Amount_Teamx=='')
						$Amount_Teamx=0;
					
					$pdf->SetY($aux);
					$pdf->SetX(120);
					$pdf->Multicell(20,5,("$".number_format($r1,2)),0,R,false);
					$pdf->SetY($aux);
					$pdf->SetX(145);
					$pdf->Multicell(20,5,"$".number_format($row["Spe_Bon1"],2),0,R,false);
					$Amount_Specialx=$row["Spe_Bon1"];
					if ($Amount_Specialx=='')
						$Amount_Specialx=0;
					$pdf->SetY($aux);
					$pdf->SetX(170);
					$pdf->Multicell(30,5,"$".number_format($row["Tot_Bon"],2),0,R,false);					
					$Total_Bonusx=$row["Tot_Bon"];
					$aux=($pdf->GetY()+0.5);
					$pdf->SetY($aux);
					if ($Total_Bonusx=='')
						$Total_Bonusx=0;

					$sql3= "INSERT INTO bonus_summary_person (Cod_Bonus,Num_Corr,Emp_Num,Cod_Per,Nick_Name,Fec_Hire,Indice,Amount_Team,Amount_Special,Total_Bonus) VALUES ('".$Codigo_Bono."',".$Contax.",".$Emp_Numx.",".$Empleado_IDx.",'".$Nick_Namex."','".$Fec_Hirex."',".$Indexx.",".$Amount_Teamx.",".$Amount_Specialx.",".$Total_Bonusx.")";
					$result3=$bd->ejecutar($sql3);
					
					//echo $sql3."<br>";
					$gtotal=$gtotal+($row["Tot_Bon"]);
					$tot_spe_bon=$tot_spe_bon+$row["Spe_Bon1"];
					
					if ($aux>260)
					{
						$aux=5;
						$pdf->AddPage();
						
							/// Encabezado ///

						  $aux=$pdf->GetY();
						  $pdf->SetX(20);
						  $pdf->Multicell(0,5,"Nick Name",0,L,false);
					
						  $pdf->SetY($aux);
						  $pdf->SetX(70);
						  $pdf->Multicell(20,5,"Index",0,C,false);
					
						  $pdf->SetY($aux);
						  $pdf->SetX(120);
						  $pdf->Multicell(25,5,"Bonus from Projects",0,L,false);
						  
						  $pdf->SetY($aux);
						  $pdf->SetX(145);
						  $pdf->Multicell(25,5,"Special Bonus ",0,L,false);
					
						  $pdf->SetY($aux);
						  $pdf->SetX(170);
						  $pdf->Multicell(30,5,"Total Bonus",0,C,false);
					
						  
						  $aux7=$pdf->GetY();
						  $pdf->line(10,$pdf->GetY()-5,200,$pdf->GetY()-5);
						  $pdf->line(10,$aux+12,200,$aux+12);
						  $pdf->SetY($aux7+10);

	
	
	// fin encabezado 	
						
						}
					
	}
	
	
				$aux=$pdf->GetY()+3;
				$pdf->SetY($aux);
				$pdf->line(100,$pdf->GetY(),200,$pdf->GetY());
				$aux=$pdf->GetY()+2;
				$pdf->SetY($aux);
				$pdf->SetX(10);
				$pdf->Multicell(0,5,"Totals ",0,L,false);	 
				
				$pdf->SetY($aux);
				$pdf->SetX(120);	
				$pdf->Multicell(20,5,"$".number_format($gtotal-$tot_spe_bon,2),0,R,false);
				
				$pdf->SetY($aux);
				$pdf->SetX(145);	
				$pdf->Multicell(20,5,"$".number_format($tot_spe_bon,2),0,R,false);
				
				$pdf->SetY($aux);
				$pdf->SetX(170);	
				$pdf->Multicell(30,5,"$".number_format($gtotal,2),0,R,false);

				$aux=$pdf->GetY()+3;
				$pdf->SetY($aux);
				$pdf->line(100,$pdf->GetY(),200,$pdf->GetY());
				
	
				$pdf->Multicell(20,5,"",0,R,false);
				$pdf->SetX(25);
				$pdf->Multicell(75,5,"Total Employees w/Bonus: ".$contabon." from:".$conta,0,R,false);	
				$pdf->SetX(125);
				$pdf->Multicell(40,5,"Date:". date('m-d-Y'),0,R,false);	
	
	
	///fin mmmm
	
	
	$pdf->Output("dato.pdf");
?>

	<embed src="dato.pdf#toolbar=1&navpanes=0&scrollbar=0" width="1190" height="570"></embed>

<?
	require('Library/Close_Conexion.php');	
?>







