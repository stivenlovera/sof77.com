


<script type="text/javascript" >
	function wwRecord_Percentage_DoneA(Pro_ID, Date_Work, Opt_Rep)  
	{		
		//window.alert("lLEGO A RECORD_PERCENTAGE_DONEA ");	
		var Date_Per = Date_Work;
		var Opt_Rep = Opt_Rep;
		var Pro_ID_Per = Pro_ID;	
	//	window.alert(Date_Per);
	//	window.alert(Opt_Rep);
	//	window.alert(Pro_ID);	
	
//	url = 'wwJob_Percentage_Information.php';
		
	url = 'wwJob_Percentage_Information.php?Date_Per='+Date_Per+'&Opt_Rep='+Opt_Rep+'&Pro_ID_Per='+Pro_ID_Per;	
		//window.alert(url);
			//getAx(url,'basic-modal-content-espera',250);		
			//$('#basic-modal-content-espera').modal();
				getAx(url,'Div_Reporte',150);
			

	}	
</script>







<?php	 		

	session_name("Administrador");
	session_start();
	//echo "LLEGO REGISTRAR <br>";
	//echo "in on activity record <br>";
		
	require('Library/Control_Cache.php');
	require('Library/Open_Conexion.php');
	//require('Header.php');
	require('Library/funciones.php');	
	require('funciones_php/Actividades.php');

?>
<LINK href="include/Stat.css" type="text/css" rel="stylesheet">
<link rel="STYLESHEET" type="text/css" href="include/estilo_reporte.css">
<script type="text/javascript" src="include/jquery-1.3.2.js"></script>
<script type="text/javascript" src="include/getAjax.js"></script> 
<script type="text/javascript" src="include/funciones.js"></script>
<script type="text/javascript" src="include/jquery.columnhover.js" ></script>	
<!-- Contact Form CSS files -->
<link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />
<script type='text/javascript' src='include/jquery.simplemodal.js'></script>


<link href="css/flexigrid.pack.css" type="text/css" rel="stylesheet">	
<script type="text/javascript" src="include/flexigrid.pack.js"></script>	
<script type="text/javascript" src="include/jquery.jeditable.js"></script>


<!--************************ INICIO SELECTOR DE COLOR ************-->
<script type="text/javascript" src="color/jscolor.js"></script>
<!--************************ FIN SELECTOR DE COLOR ************-->
    
<style type="text/css">
p.MsoNormal {
margin:0cm;
margin-bottom:.0001pt;
font-size:12.0pt;
font-family:"Times New Roman";
}
</style>

<style type="text/css">
<!--
.style10 {
	color: #d7dbde;
	font-size: medium;
}
-->

td.betterhover, #tabletwo tbody tr:hover
{
	background: LightCyan;
}
</style>

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
	//echo "Act ID:".$Actividad_ID."<br>";
	//echo $Task_ID_var." Task_ID_var <br>";
	
	$Hora_Ingreso_s = explode("|", $Hora_Ingreso);
	$Hora_Salida_s = explode("|", $Hora_Salida);
	$NoTaskId=0;
	//echo $Task_ID_s[0]; 
	//echo "llego 0"."<br>";
	$i=0;
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
				if ($RDA_ID_s[$i]!=-1)
				{	
//					
									
					//$strSQL = "UPDATE registro_diario_actividad  SET Task_ID=".$Task_ID.", Horas_Contract='".$Horas_Contract_s[$i]."', Horas_TM='".$Horas_TM_s[$i]."', Detalles='".$Detalle_s[$i]."', Verificado_Foreman=".$Verificado_Foreman_s[$i];	
					
					$TasIDT="";
					$strSQL1 = "SELECT t.Tas_IDT FROM  task t where  Task_ID=".$Task_ID;	
					$result87=$bd->ejecutar($strSQL1); 
					//echo $strSQL."<br>";
					if (($row87 = mysqli_fetch_array($result87) ))	
					{									
						$TasIDT=$row87["Tas_IDT"];
					}
					//echo $TasIDT."<br>";
					mysqli_free_result($result87);
					$TasIDT=ltrim($TasIDT);
					$TasIDT=rtrim($TasIDT);
					
		 
					if ($TasIDT!="VACNOSHOW")
					{				
					$strSQL = "UPDATE registro_diario_actividad  SET Task_ID=".$Task_ID.", Horas_Contract='".$Horas_Contract_s[$i]."', Horas_TM='0', Detalles='".$Detalle_s[$i]."', Verificado_Foreman=".$Verificado_Foreman_s[$i];	
					$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_s[$i];	
					$result2=$bd->ejecutar($strSQL);
					}
					else 
					{
					$strSQL = "UPDATE registro_diario_actividad  SET Task_ID=".$Task_ID.", Horas_Contract=0, Horas_TM='0', Detalles='".$Detalle_s[$i]."', Verificado_Foreman=".$Verificado_Foreman_s[$i];	
					$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_s[$i];	
					$result2=$bd->ejecutar($strSQL);
					}
					
					//echo 'llllll '.$strSQL."<br>";
				}
			}			
		}
		else
		{				
			$NoTaskId=1;		
			if ($RDA_ID_s[$i]!=-1)
			{					
				//echo "DELETE FROM registro_diario_actividad "."<br>";	
				//$strSQL = "DELETE FROM registro_diario_actividad  ";	
				//$strSQL = $strSQL . " WHERE RDA_ID=".$RDA_ID_s[$i];	
				//$result2=$bd->ejecutar($strSQL);
			}
		}
	
			
		$sql = "SELECT SUM(Horas_Contract) AS Horas_Contract, SUM(Horas_TM) AS Horas_TM FROM registro_diario_actividad WHERE Reg_ID IN (SELECT Reg_ID FROM registro_diario WHERE Empleado_ID=".$Empleado_ID_s[$i]." AND Fecha='".$Date_Work."')";														
		$result89=$bd->ejecutar($sql); 
		//echo $sql."<br>";
		$Horas_Contract=0;
		$Horas_TM=0;
		$Nota=" STP-TimeCard ";		
		if (($row89 = mysqli_fetch_array($result89) ))	
		{									
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
			$Nota=" STP-TimeCard/No show up to the field/";
			$Horas_Contract=0;
			$Horas_TM=0;
			}
		$strSQL = "UPDATE actividad_personal SET HContract=".$Horas_Contract.", HTM=".$Horas_TM.", Note=CONCAT(Note,'".$Nota."') WHERE Empleado_ID=".$Empleado_ID_s[$i]." AND Actividad_ID IN (SELECT Actividad_ID FROM actividades WHERE Pro_ID=".$_SESSION["Pro_ID"]." AND Fecha='".$Date_Work."') ";	
		$result89=$bd->ejecutar($strSQL);
		//echo $strSQL."<br>";
			
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

				$opt_rep="day";
				$Pro_ID=$_SESSION["Pro_ID"];
				$Pro_ID_Per=$Pro_ID;
				$Date_Per=$Date_Work;
				$_SESSION["day"]="day";
				$opt_rep="day";
				$_SESSION["Date_Work"]=$Date_Work;
				
				
				/// record hours of tickets on estimate hours 
				$sql33 = "update task t1 INNER JOIN (SELECT *,sum(r.Horas_Contract) as suma FROM registro_diario_actividad r group by r.Task_ID) i on t1.Task_ID=i.Task_ID set t1.Horas_Estimadas=i.suma where t1.Pro_ID=".$Pro_ID." and t1.Tas_IDT='95.110'";
				$result33=$bd->ejecutar($sql33);
				mysqli_free_result($result33);
				//echo $sql33."<br>";
				//exit ();
		
		
				
				/////
				
				
				
				
				
						//$directorio=getcwd() . "\n"." ::";
				//$path="pwt"; 
				//chdir($path); 
				//$directorio=$directorio.getcwd() . "\n";
				//echo "directorios:".$directorio."<br>"; 
				//include 'wwJob_Percentage_Information.php';
				
				
				//////////////////////
				$consulta = "SELECT Pro_ID,Report_P_Done FROM proyectos WHERE Pro_ID=".$Pro_ID;	
				$result2=$bd->ejecutar($consulta); 	
				while (($row2 = mysqli_fetch_array($result2) ))							
				{		
					$Report_P_Done = $row2["Report_P_Done"];
				}
				mysqli_free_result($result2);	
						
				/////////////////
				
				
				
				if 	($Report_P_Done=="Y")
				{	

					?>

					<img src="images/spacer.gif" onload="wwRecord_Percentage_DoneA( <?php echo $Pro_ID; ?>,'<?php echo $Date_Work; ?>','<?php echo $opt_rep; ?>');" width="1" height="1" /> 

					<?php
					
						require('Library/Close_Conexion.php');	
					
				}
				else 
				{
					//////	fin actualizar percentage completed 
			
					//echo "Succesfull-- Recorded OK!!";
					

					echo "<script type='text/javascript'>alert('Succesfull Recorded -!=');</script>";
					echo "<script> window.location.href = 'https://www.sof77.com';</script>";
				}
        	}
        
		
	  }
	else
		echo " Error Recording! Some information is not correct please review an try again.";
		require('Library/Close_Conexion.php');	
	
	
?>


