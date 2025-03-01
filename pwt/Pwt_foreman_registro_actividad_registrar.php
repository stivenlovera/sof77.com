<script type="text/javascript" >
	function Record_Percentage_DoneA(Pro_ID, Date_Work, Opt_Rep)  
	{		
		//window.alert("lLEGO A RECORD_PERCENTAGE_DONEA ");	
		var Date_Per = Date_Work;
		var Opt_Rep = Opt_Rep;
		//window.alert(Opt_Rep);
		var Pro_ID_Per = Pro_ID;	
		//window.alert(Date_Per);
		//window.alert(Opt_Rep);
		//window.alert(Pro_ID);		
//		url = 'Enter_Percentage_Done.php()';
		
		url = 'Job_Percentage_Information.php';	
		
		
		//url = 'Job_Percentage_Information.php?Date_Per='+Date_Per+'&Opt_Rep='+Opt_Rep+'&Pro_ID_Per='+Pro_ID_Per;	
		
			getAx(url,'basic-modal-content-espera',250);		
			$('#basic-modal-content-espera').modal(); 
			

	}	
</script>
<?php	 		

	session_name("Administrador");
	session_start();
	//echo "LLEGO REGISTRAR <br>";
	//echo "in on activity record <br>";
	if ($_SESSION["EntityID"] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	
		
	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');
	require('Library/funciones.php');				         					  		
?>

<script type="text/javascript" src="include/jquery.jeditable.js"></script>

<?php
	
	$Task_ID_var=$_GET["Task_ID"];
	$Horas_Contract=$_GET["Horas_Contract"];
	$Horas_TM=$_GET["Horas_TM"];
	$Detalle=$_GET["Detalle"];
	$RDA_ID=$_GET["RDA_ID"];	
	$Empleado_ID=$_GET["Empleado_ID"];	
	$Reg_ID=$_GET["Reg_ID"];
	$Verificado_Foreman=$_GET["Verificado_Foreman"];
	$Hora_Ingreso=$_GET["Hora_Ingreso"];
	$Hora_Salida=$_GET["Hora_Salida"];

	$Task_ID_s = explode("|", $Task_ID_var);
	$Horas_Contract_s = explode("|", $Horas_Contract);
	$Horas_TM_s = explode("|", $Horas_TM);
	$Detalle_s = explode("|", $Detalle);
	$RDA_ID_s = explode("|", $RDA_ID);
	$Empleado_ID_s = explode("|", $Empleado_ID);
	$Verificado_Foreman_s = explode("|", $Verificado_Foreman);
	$Reg_ID_s = explode("|", $Reg_ID);
	$Date_Work=$_SESSION["Date_Work"];
	$Actividad_ID=$_SESSION["Actividad_ID"];
	
	$Pro_ID=$_SESSION["Pro_ID"];
	//echo "Act ID:".$Actividad_ID."<br>";
	//echo $Task_ID_var." Task_ID_var <br>";
	
	$Hora_Ingreso_s = explode("|", $Hora_Ingreso);
	$Hora_Salida_s = explode("|", $Hora_Salida);
	$NoTaskId=0;
	//echo $Task_ID_s[0]; 
	//echo "llego 0"."<br>";
	$i=0;
	$NoTaskId=0;
	foreach ($Task_ID_s as &$Task_ID) // Poner Registro Maestro Vacio
	{
		
		//echo "llego 1:".$Reg_ID_s[$i]." //".$Reg_ID."===rda:".$RDA_ID."<br>";
		//echo $Verificado_Foreman_s[$i]."<br>";
		//if ($Task_ID_s[$i]!="-1")
		if ($Task_ID!="-1")
		{
			//echo "llego 2:".$RDA_ID_s[$i]."<br>";
			if ($RDA_ID_s[$i]=="-1")
			{	
				//echo "llego 3"."<br>";
				//echo $Reg_ID.":Reg ID not devided <br>";
				$Reg_ID=$Reg_ID_s[$i];
				//echo $Reg_ID.":Reg_ID from i".$Reg_ID_s[$i]." <br>";
				//echo 'llego 3:'.$Reg_ID_s[$i].":Reg_ID_s <br>";
				if ($Reg_ID_s[$i]==-1)
				{
					//echo "llego 4"."<br>";
					if ($Hora_Ingreso_s[$i]=="00:00:00" || ($Hora_Ingreso_s[$i]=="No Check In"))
						$Hora_Ingreso_s[$i]="00:00:01";
					if ($Hora_Salida_s[$i]=="00:00:00"  || ($Hora_Salida_s[$i]=="No Check Out"))
						$Hora_Salida_s[$i]="00:00:01";
					/////////////    888
					$Exist=0;
					$Proidx=$_SESSION["Pro_ID"];
					//echo "Datos:Emp.ID: ".$Empleado_ID_s[$i];
					
					$sql = "SELECT COUNT(Empleado_ID) AS Exist FROM registro_diario WHERE Empleado_ID=".$Empleado_ID_s[$i]." AND Fecha='".$Date_Work."' AND Pro_ID=".$Proidx." AND Actividad_ID=".$Actividad_ID."" ;														
					$result89=$bd->ejecutar($sql); 
					//echo $sql."<br>";
					if (($row89 = mysqli_fetch_array($result89) ))	
					{									
						$Exist=$row89["Exist"];
						
					}
					mysqli_free_result($result89);
					echo "Exist: ".$Exist."  regID:".$Reg_ID.'<br>';
					$RDinsert=0;
					if ($Exist==0)
					{					
						//$Hora_Ingreso_s[$i]=$Hora_Ingreso_s[$i]+20;
						//$Hora_Salida_s[$i]=$Hora_Salida_s[$i]+120;
						$strSQL = "INSERT INTO registro_diario (Empleado_ID,  Fecha, Pro_ID, Hora_Ingreso, Hora_Salida,Actividad_ID) ";	
						$strSQL = $strSQL . " values (".$Empleado_ID_s[$i].", '".$Date_Work."',".$_SESSION["Pro_ID"].", '".$Hora_Ingreso_s[$i]."','".$Hora_Salida_s[$i]."',".$Actividad_ID.")";		
					
					$result2=$bd->ejecutar($strSQL);
					$RDinsert=1;
					mysqli_free_result($result2); 
					//echo $strSQL."llego 5 inserto en registro diario <br>";
					
										
					}
					if ($RDinsert==1)
					{
						$sql = "SELECT Reg_ID FROM registro_diario ORDER BY Reg_ID DESC";														
						$result=$bd->ejecutar($sql); 		
						if (($row = mysqli_fetch_array($result) ))	
						{									
							$Reg_ID=$row["Reg_ID"];
							$Reg_ID_s[$i]=$Reg_ID;
						}
													
					}
					else
					  {
						$Reg_IDxx=-1;
						//echo "Llego 333 <br>";
					  }
				}
				$RDA_ID=$RDA_ID_s[$i];
				$Reg_ID=$Reg_ID_s[$i];
				//echo $RDA_ID_s[$i]."<-rdaId ".$Reg_ID."llego 99 <br>";
				
				if ($RDA_ID==-1)
				{
					//echo "llego 6 prev:".$Reg_ID;
					//$strSQL = "UPDATE registro_diario  SET Hora_Ingreso=ADDTIME('".$Hora_Ingreso_s[$i]."', '04:00:00.000'), Hora_Salida=ADDTIME('".$Hora_Salida_s[$i]."', '04:00:00.000')";	
					//$strSQL = $strSQL . " WHERE Reg_ID=".$Reg_ID;	
					//$result2=$bd->ejecutar($strSQL);
					//echo $strSQL."<br>";
					
					//echo "INSERT INTO registro_diario_actividad "."<br>";	
					

					
					$strSQL = "INSERT INTO registro_diario_actividad (Reg_ID, Task_ID, Horas_Contract, Horas_TM, Detalles, Verificado_Foreman) ";	
					$strSQL = $strSQL . " values (".$Reg_ID.",".$Task_ID.",'".$Horas_Contract_s[$i]."','".$Horas_TM_s[$i]."','".$Detalle_s[$i]."',".$Verificado_Foreman_s[$i].")";	
					$result2=$bd->ejecutar($strSQL);
					//echo "llego 6: ".$strSQL."<br>";
					
				}
			}
			else
			{
				//echo "UPDATE registro_diario_actividad  "."<br>";	
				$NoTaskId=0;
				if ($RDA_ID_s[$i]!=-1)
				{	
//					
				$strSQL = "SELECT p.Codigo,p.Pro_ID,t.Pro_ID,t.Tas_IDT FROM  task t inner join proyectos p on t.Pro_ID=p.Pro_ID where  Task_ID=".$Task_ID;	
				
				$result89=$bd->ejecutar($strSQL); 
				//echo $strSQL."<br>";
				if (($row89 = mysqli_fetch_array($result89) ))	
				{									
					$TasIDT=$row89["Tas_IDT"];
					$Codigo=$row89["Codigo"];
				}
				//echo $TasIDT."<br>";
				mysqli_free_result($result89);
				$TasIDT=ltrim($TasIDT);
				$TasIDT=rtrim($TasIDT);
				
				
				$numjob=substr($Codigo,0,4);
				
				if ($TasIDT!="VACNOSHOW" && $Horas_Contract_s[$i]==0 && $numjob<800)
				  {
						$NoTaskId=1;
						//echo $numjob."<br>";
						echo "<script type='text/javascript'>alert(' There is a CostCode with zero hours need REVIEW! ');</script>";
						
				  }
				if ($TasIDT=="VACNOSHOW" && $Horas_Contract_s[$i]!=0)
				  {
						$NoTaskId=1;
						echo "<script type='text/javascript'>alert(' There is No Show w/hours  need REVIEW! ');</script>";
				  }
				
				
				  //echo $NoTaskId." //".$Detalle_s[$i]."/////".$RDA_ID_s[$i]."<br>";
				if ($Detalle_s[$i]=="Erase")
					{
						$sql98 = "DELETE FROM registro_diario_actividad WHERE RDA_ID=".$RDA_ID_s[$i];														
						//echo $sql98."<br>";
						$result=$bd->ejecutar($sql98);
						mysqli_free_result($result);
						
					}
					
				if ($NoTaskId==0 && ($Detalle_s[$i]!="Erase"))
					{
						$strSQL = "UPDATE registro_diario_actividad  SET Task_ID=".$Task_ID.", Horas_Contract='".$Horas_Contract_s[$i]."', Horas_TM='".$Horas_TM_s[$i]."', Detalles='".$Detalle_s[$i]."', Verificado_Foreman=".$Verificado_Foreman_s[$i];	
						$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_s[$i];	
						$result2=$bd->ejecutar($strSQL);
						//echo 'llllll '.$strSQL."<br>";
					}
				
				
				}
			}			
		}
		else
		{				
			$NoTaskId=1;		
			if ($RDA_ID_s[$i]!=-1)
			{					
				echo "DELETE FROM registro_diario_actividad 11"."<br>";	
				//$strSQL = "DELETE FROM registro_diario_actividad  ";	
				//$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_s[$i];	
				//$result2=$bd->ejecutar($strSQL);
			}
		}
			
		$sql = "SELECT rd.Empleado_ID as EmpID,rd.Actividad_ID, SUM(rda.Horas_Contract) AS Horas_Contract, SUM(rda.Horas_TM) AS Horas_TM FROM registro_diario_actividad rda JOIN registro_diario rd on rd.Reg_ID=rda.Reg_ID WHERE rda.Reg_ID=".$Reg_ID_s[$i]." group by concat(rd.Actividad_ID,rd.Empleado_ID) ";														
		$result89=$bd->ejecutar($sql); 
		$Horas_Contract=0;
		$Horas_TM=0;
		$Nota=" STP-TimeCard:";	
		//echo "empID:".$Empleado_IDr." ".$sql."<br>";
		
		if (($row89 = mysqli_fetch_array($result89) ))	//due this is in the if other whise it go to the next record 
		{									
			$Actividad_IDr=$row89["Actividad_ID"];	
			$Empleado_IDr=$row89["EmpID"];
			$Horas_Contract=$row89["Horas_Contract"];
			$Horas_TM=$row89["Horas_TM"];
		}
		else
			{
			$Horas_Contract=0;
			$Horas_TM=0;	
			}
		mysqli_free_result($result89);
		//echo "hgh ".$Horas_Contract.'<br>';
		if ($Horas_Contract==0)
			{
			$Nota=$Nota."No show up to the field/";
			$Horas_Contract=0;
			$Horas_TM=0;
			}
			
		//echo "empID:".$Empleado_IDr." ".$sql."<br>";
		$Nota=$Nota."/".$Detalle_s[$i];
//		$strSQL = "UPDATE actividad_personal SET HContract=".$Horas_Contract.", HTM=".$Horas_TM.", Note=CONCAT(Note,'".$Nota."') WHERE Empleado_ID=".$Empleado_IDr." AND Actividad_ID=".$Actividad_IDr;	
		$strSQL = "UPDATE actividad_personal SET HContract=".$Horas_Contract.", HTM=".$Horas_TM.", Note='".$Nota."' WHERE Empleado_ID=".$Empleado_IDr." AND Actividad_ID=".$Actividad_IDr;
		//echo " Actualiza acti perso:".$strSQL."<br>";
		$result91=$bd->ejecutar($strSQL);
		mysqli_free_result($result91);
		$i++;	
	}	
	
	//echo $strSQL;
	if ($result2)
	  {
		if 	($NoTaskId==1)
			{
			echo "Go to Report again and review the areas where the crew worked ";
			echo "<script type='text/javascript'>alert('Incomplete !! Need Review the areas where the crew worked!');</script>";
			}
		 else
		 	{
				
				////// envio a actualizar percentage completed 

				$_SESSION["day"]="day";
				$opt_rep="day";
				$Pro_ID=$_SESSION["Pro_ID"];
				$directorio=getcwd() . "\n"." ::";
				$_SESSION["Date_Work"]=$Date_Work;
				//$path="pwt"; 
				//chdir($path); 
				$directorio=$directorio.getcwd() . "\n";
				//echo "directorios:".$directorio."<br>"; 
				
				/// record hours of tickets on estimate hours 
				$sql33 = "update task t1 INNER JOIN (SELECT *,sum(r.Horas_Contract) as suma FROM registro_diario_actividad r group by r.Task_ID) i on t1.Task_ID=i.Task_ID set t1.Horas_Estimadas=i.suma where t1.Pro_ID=".$Pro_ID." and t1.Tas_IDT='95.110'";
				$result33=$bd->ejecutar($sql33);
				mysqli_free_result($result33);
				//echo $sql33."<br>";
				//exit ();
				
				
				

?>
	<img src="images/spacer.gif" onload="Record_Percentage_DoneA( <?php echo $Pro_ID; ?>,'<?php echo $Date_Work; ?>','<?php echo $opt_rep; ?>');" width="1" height="1" />  
    
<?php
			
			//////	fin actualizar percentage completed 
				
				
				
				
				
			echo "Succesfull-- Recorded !";
			echo "<script type='text/javascript'>alert('Succesfull Recorded -!=');</script>";
		//	echo "<script> window.location.href = 'https://www.sof77.com'
		

        	}
        
		
	  }
	else
		echo " Error Recording! Same information is not correct please review an try again.";

	require('Library/Close_Conexion.php');	
	
	
?>