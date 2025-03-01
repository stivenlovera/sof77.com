<?php	 		
	session_name("Administrador");
	session_start();		
			
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	
	require('Library/funciones.php');	



/*
// update 4444  start date on DOB 
	$sql = "SELECT Empleado_ID FROM personal WHERE Aux5='F'";
		$result89=$bd->ejecutar($sql);
		echo $sql."<br>" ;
		while ($row89 = mysqli_fetch_array($result89) )
		  {
			$Empleado_ID=$row89['Empleado_ID'];
			$sql1 = "SELECT a.Fecha as Fecha,a.Actividad_ID,ap.Empleado_ID,ap.Actividad_ID FROM actividad_personal ap inner join actividades a on ap.Actividad_ID=a.Actividad_ID  WHERE ap.Empleado_ID=".$Empleado_ID." ORDER BY a.Fecha";
			$result90=$bd->ejecutar($sql1); 
			echo $sql1."<br>" ;
			if ($row90 = mysqli_fetch_array($result90))
		  	{
				$row90=mysqli_fetch_array($result90);
				$fechastart=$row90['Fecha'];
				$strSQL = "UPDATE personal SET Fecha_Nacimiento='".$fechastart."' WHERE Empleado_ID=".$Empleado_ID;	
				$result91=$bd->ejecutar($strSQL);
				mysqli_free_result($result91);
				echo $strSQL."<br>";
							
			}
	
		}			
		mysqli_free_result($result89);
		exit();  */

//  4444  END UPDATE START DATE


/// update actividad_personal from actividad personal aux1 after update by mistake
	/*	$sql = "SELECT * FROM actividad_personal WHERE Actividad_ID>1";
		$result89=$bd->ejecutar($sql); 
		while ($row89 = mysqli_fetch_array($result89) )
		  {
			$Horas_Contract=$row89["Horas_Contract"];
			$Horas_TM=$row89["Horas_TM"];
			$Actividad_ID=$row89["Actividad_ID"];
			$Empleado_ID=$row89["Empleado_ID"];
			$Note=$row89["Note"];

		$strSQL = "UPDATE actividad_personal SET HContract=".$Horas_Contract.", HTM=".$Horas_TM.", Note='".$Note."') WHERE Empleado_ID=".$Empleado_ID." AND Actividad_ID=".$Actividad_ID;	
		$result90=$bd->ejecutar($strSQL);
		mysqli_free_result($result90);
		echo $strSQL."<br>";
		}			
		mysqli_free_result($result89);
		exit();*/
//// end update actividad_personal from actividad personal aux1 after update by mistake



////  update horas on actividad_personal

		$sql = "SELECT rd.Fecha,rd.Reg_ID,rd.Actividad_ID as Actividad_IDx,rda.Reg_ID,rda.Task_ID,rd.Empleado_ID as Empleado_IDx,SUM(rda.Horas_Contract) AS Horas_Contracts, SUM(rda.Horas_TM) AS Horas_TMs FROM registro_diario_actividad rda INNER JOIN registro_diario rd on rd.Reg_ID=rda.Reg_ID WHERE rd.fecha>'2020-07-01' AND rda.Task_ID<>0 group by concat(rd.Actividad_ID,rd.Empleado_ID)";
		
		//echo $sql."<br>";
		//exit();														
		$result89=$bd->ejecutar($sql); 
		$Horas_Contract=0;
		$Horas_TM=0;
		while ($row89 = mysqli_fetch_array($result89) )
		  {
			$Horas_Contract=$row89["Horas_Contracts"];
			$Horas_TM=$row89["Horas_TMs"];
			$Actividad_ID=$row89["Actividad_IDx"];
			$Empleado_ID=$row89["Empleado_IDx"];
			$Task_ID=$row89["Task_ID"];
			$Note="";
			$Fecha=$row89["Fecha"];
		  if ($Horas_Contract==0 && $Task_ID !=0)
			{
			$Nota=" STP-TimeCard/No show up to the field/";
			$Horas_Contract=0;
			$Horas_TMs=0;
			}
			else
				$Nota="STP-TimeCard updated";
 		  if ($Horas_Contract==0 && $Task_ID ==0)
		    {
				$Nota=" Estimate hours  ";
				$Horas_Contract=8;
				$Horas_TMs=0;
			} 
			
			if ($Task_ID !=0)
			{
						$strSQL = "UPDATE actividad_personal SET HContract=".$Horas_Contract.", HTM=".$Horas_TM.", Note='".$Nota."' WHERE Empleado_ID=".$Empleado_ID." AND Actividad_ID=".$Actividad_ID;
						//." AND Note<>G.H.S.UP";	
			$result90=$bd->ejecutar($strSQL);
			
			echo $strSQL."<br>";
			echo $Fecha;
			}
			//exit();
			//mysqli_free_result($result90);	
		  
		}			
		mysqli_free_result($result89);	
		echo '<script>alert("update completed from 08/01/2020 at today")</script>';
		
	//	exit();
/// fin update horas on actividad_Personal 









///// update actividad_personal 
/*
		$sql = "SELECT rd.*,rda.* FROM registro_diario_actividad rda join registro_diario rd on rd.Reg_ID=rda.Reg-ID WHERE rd.Actividad_ID >41713";														
		$result89=$bd->ejecutar($sql); 
		echo $sql."<br>";
		exit();
		while ($row89 = mysqli_fetch_array($result89) )
		  {
			$Actividad_ID=$row89["Actividad_ID"];
			$Empleado_ID=$row89["Empleado_ID"];
			$strSQL="INSERT INTO actividad_personal (Actividad_ID,Empleado_ID)  ";	
			$strSQL = $strSQL . " values (".$Actividad_ID.",".$Empleado_ID.")";		
			echo $strSQL."<br>";			
			$result89=$bd->ejecutar($strSQL);
		echo $strSQL."<br>";

	
		}			
		mysqli_free_result($result89);

exit(); */

////// end update actividad personal 


/*	
	
	
		$consulta = "SELECT ap.Empleado_ID,ap.Actividad_ID,a.Fecha,a.Actividad_ID,rd.Actividad_Id,rd.Reg_ID as rdRegID,rda.Reg_ID as rdaRegID,a.Pro_ID,ap.HContract,ap.Note FROM `actividad_personal` ap join actividades a on a.Actividad_ID=ap.Actividad_ID left join registro_diario rd on a.Actividad_ID=rd.Actividad_Id and rd.Empleado_ID=ap.Empleado_ID left join registro_diario_actividad rda on rd.Reg_ID=rda.Reg_ID where a.Fecha='2020-08-26' and (rd.Reg_ID IS NULL OR rda.Reg_ID IS NULL )";
		echo $consulta."<br>";	
		//exit ();
		$result2=$bd->ejecutar($consulta); 	
		while (($row2 = mysqli_fetch_array($result2) ))							
		{	
			$Empleado_ID = $row2["Empleado_ID"];
			$Actividad_ID =$row2["Actividad_ID"];
			$Pro_ID =$row2["Pro_ID"];
			$Fecha=$row2["Fecha"];
			$HContract=	$row2["HContract"];		
			$Note=	$row2["Note"];	
			$rdRegID=$row2["rdRegID"];
			$rdaRegID=$row2["rdaRegID"];
			echo $Empleado_ID,"emp ID"."<br>";
			//exit();
			////////////////////
			//record in registro_diario 
			if ($rdRegID==NULL)
	   {
		
			$strSQL = "INSERT INTO registro_diario (Empleado_ID, Actividad_ID,Pro_ID,Fecha) ";	
			$strSQL = $strSQL . " values (" . $Empleado_ID . ", " . $Actividad_ID . ",".$Pro_ID.",'".$Fecha. "')";		
	echo $strSQL."<br>";				
	$res1=$bd->ejecutar($strSQL);  	
	
	
		$consulta = "SELECT Reg_ID FROM registro_diario WHERE Actividad_ID=".$Actividad_ID." AND	Empleado_ID=".$Empleado_ID." AND Pro_ID=".$Pro_ID." AND	Fecha ='".$Fecha."'";			
		$result3=$bd->ejecutar($consulta); 	
		while (($row3 = mysqli_fetch_array($result3) ))							
		{	
			$Reg_ID = $row3["Reg_ID"];	
		}
		mysqli_free_result($result3);
	}
	    else
			$Reg_ID=$rdRegID;
			
		if ($rdaRegID==NULL)
		{
	
		$strSQL = "INSERT INTO registro_diario_actividad (Reg_ID,Horas_Contract) ";	
		$strSQL = $strSQL . " values (" . $Reg_ID.",".$HContract.")";		
		$res1=$bd->ejecutar($strSQL);  	
		echo $strSQL."<br>";
		}
				
		}
		mysqli_free_result($result2);
	
*/

	require('Library/Close_Conexion.php');	
?>