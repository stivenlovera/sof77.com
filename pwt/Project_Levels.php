<?php	 		

	session_name("Administrador");

	session_start();		

	if ($_SESSION["EntityID"] == "")

	{

		header("Location:sessionexpired.php"); 	

	}	 			

	require('Library/Control_Cache.php');

	require('Library/Open_Conexion.php');		

	$Pro_ID=$_GET['Pro_ID'];
	
	echo $Pro_ID."  Llego al hello <br>";
	
		

?>     
<table>
    	<tr>
			<td width="706" valign="top">    
			  <fieldset>
					<h1>
					  <legend>Generation of the levels and areas to  track hours </legend>
			        </h1>
				<form id="Form_Edificio_Nuevo" name="Form_Edificio_Nuevo">
			    </form>
				</fieldset>	
        	</td> 

        	<td width="185" valign="top">             

				<fieldset id="fs_Area">

					<legend></legend>
				</fieldset>				

        	</td>

		</tr>

	</table>



<?php
$Exist=0;
//echo "Datos:Pro.Id : ".$Pro_ID;
$sql = "SELECT COUNT(Pro_ID) AS Exist FROM edificios WHERE Pro_ID=".$Pro_ID;														
$result89=$bd->ejecutar($sql); 
echo $sql."<br>";
if (($row89 = mysqli_fetch_array($result89) ))	
{									
	$Exist=$row89["Exist"];

}
mysqli_free_result($result89);
echo "Exist: ".$Exist."  ".'<br>';
$RDinsert=0;
if ($Exist!=0)
{					
	echo "There is some structure for the project unable to generate <br>";
	echo " Delete the structure 1st. and make sure the data for that is empty  <br>";/*						$strSQL = "INSERT INTO registro_diario (Empleado_ID,  Fecha, Pro_ID, Hora_Ingreso, Hora_Salida,Actividad_ID) ";	
						$strSQL = $strSQL . " values (".$Empleado_ID_s[$i].", '".$Date_Work."',".$_SESSION["Pro_ID"].", '".$Hora_Ingreso_s[$i]."','".$Hora_Salida_s[$i]."',".$Actividad_ID.")";		
					
					$result2=$bd->ejecutar($strSQL);
					$RDinsert=1;
					mysqli_free_result($result2);
					//echo $strSQL."llego 5 inserto en registro diario <br>"; */
}
else
	{
		echo "Generating structure <br>";
		$Nombre="==";
		$Descripcion="-";
		$Horas_Estimadas=0;
		$Mat_Estimado=0;
		$Aux1='';
		$Aux2='';
		$Aux3='';
		$Aux4='';
		$Aux5='';
		$Aux6='';
		$Porcentaje=0;
		$Precio_Unitario=0;
		
		//EDIFICIO 
		$strSQL = "INSERT INTO edificios (Pro_ID, Nombre, Descripcion, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Porcentaje ) ";	
		$strSQL = $strSQL . " values (".$Pro_ID.",'" . $Nombre . "','" . $Descripcion . "','" . $Horas_Estimadas. "','" . $Mat_Estimado . "','" . $Aux1. "','" . $Aux2. "', '" . $Porcentaje. "')";		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);
		mysqli_free_result($res1); 		
		if ($res1)
		{
			$consulta = "SELECT MAX(Edificio_ID) as Edificio_ID FROM edificios WHERE Pro_ID=".$Pro_ID;	
			//echo $consulta;			
			$result2=$bd->ejecutar($consulta); 	
			while (($row2 = mysqli_fetch_array($result2) ))							
			{		
				$Edificio_ID = $row2["Edificio_ID"];
			}
			mysqli_free_result($result2);	
		}
		//FLOOR
		$strSQL = "INSERT INTO floor (Pro_ID, Edificio_ID, Nombre, Aux4, Porcentaje ) ";	
		$strSQL = $strSQL . " values (".$Pro_ID.",".$Edificio_ID.",'" . $Nombre . "','" . $Aux4  .  "','" .$Porcentaje. "')";		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);  		
		mysqli_free_result($res1); 	
		if ($res1)
		{
			$consulta = "SELECT MAX(Floor_ID) as Floor_ID FROM floor WHERE Pro_ID=".$Pro_ID;	
			//echo $consulta;			
			$result2=$bd->ejecutar($consulta); 	
			while (($row2 = mysqli_fetch_array($result2) ))							
			{		
				$Floor_ID = $row2["Floor_ID"];
			}
			mysqli_free_result($result2);
		}
		// AREAs
		$Nombre_A="Common Area,Touch up hours,Ticket Work";
		$Note="";
		$strSQL = "INSERT INTO area_control (Pro_ID, Floor_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje ) ";	
		$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",'" . $Nombre_A . "','" . $Horas_Estimadas. "','" . $Mat_Estimado . "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje. "')";		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);  		
	
		$Nombre_A="No Show Up ";
		$strSQL = "INSERT INTO area_control (Pro_ID, Floor_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje ) ";	
		$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",'" . $Nombre_A . "','" . $Horas_Estimadas. "','" . $Mat_Estimado . "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje. "')";		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);
	
		$Nombre_A=":Change Orders ";
		$strSQL = "INSERT INTO area_control (Pro_ID, Floor_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje ) ";	
		$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",'" . $Nombre_A . "','" . $Horas_Estimadas. "','" . $Mat_Estimado . "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje. "')";		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);
	

		$Nombre_A="Exterior";
		$strSQL = "INSERT INTO area_control (Pro_ID, Floor_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje ) ";	
		$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",'" . $Nombre_A . "','" . $Horas_Estimadas. "','" . $Mat_Estimado . "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje. "')";		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);

		$Nombre_A=".Floors ";
		$strSQL = "INSERT INTO area_control (Pro_ID, Floor_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje ) ";	
		$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",'" . $Nombre_A . "','" . $Horas_Estimadas. "','" . $Mat_Estimado . "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje. "')";		
		//echo $strSQL."<br>";				
		$res1=$bd->ejecutar($strSQL);

		//TASK
	
			$consulta = "SELECT Area_ID AS Area_ID FROM area_control WHERE Pro_ID=".$Pro_ID. " AND Floor_ID=".$Floor_ID. " AND Nombre like '%Common Area,Touch up%'";				
			$result2=$bd->ejecutar($consulta); 	
			while (($row2 = mysqli_fetch_array($result2) ))							
			{		
				$Area_ID = $row2["Area_ID"];
			}
			mysqli_free_result($result2);
			
			$Nombre_T='Punch List';	
			$Num_Act='.    20.400';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);
			
			$Nombre_T='Ticket Work';	
			$Num_Act='.    20.300';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);		
			
			$Nombre_T='Touch up Hours Allowance  on ticket';	
			$Num_Act='.    20.450';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);		
		
			$Nombre_T='Composite Clean Up';	
			$Num_Act='.    20.460';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);		
		
			$Nombre_T='Stairs';	
			$Num_Act='ST00 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);		
		
			$Nombre_T='Garage';	
			$Num_Act='GA00 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);
					
			///////
			$consulta = "SELECT Area_ID AS Area_ID FROM area_control WHERE Pro_ID=".$Pro_ID. " AND Floor_ID=".$Floor_ID. " AND Nombre like '%No Show%'";				
			$result2=$bd->ejecutar($consulta); 	
			while (($row2 = mysqli_fetch_array($result2) ))							
			{		
				$Area_ID = $row2["Area_ID"];
			}
			mysqli_free_result($result2);
	
			$Nombre_T='z.No show up/No worked';	
			$Num_Act='00.000';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);

			///////
			$consulta = "SELECT Area_ID AS Area_ID FROM area_control WHERE Pro_ID=".$Pro_ID. " AND Floor_ID=".$Floor_ID. " AND Nombre like '%Change Order%'";				
			$result2=$bd->ejecutar($consulta); 	
			while (($row2 = mysqli_fetch_array($result2) ))							
			{		
				$Area_ID = $row2["Area_ID"];
			}
			mysqli_free_result($result2);
	
			$Nombre_T='CO#??';	
			$Num_Act='PC00 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);

			$Nombre_T='CO#01';	
			$Num_Act='PC01 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);

			
			$Nombre_T='CO#02';	
			$Num_Act='PC02 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);
			
			$Nombre_T='CO#03';	
			$Num_Act='PC03 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);
			
		
			$Nombre_T='CO#04';	
			$Num_Act='PC04 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);

			$Nombre_T='CO#05';	
			$Num_Act='PC05 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);
			
			
			$Nombre_T='CO#06';	
			$Num_Act='PC06 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);
			
			
			$Nombre_T='CO#07';	
			$Num_Act='PC07 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);

			
			
			
			

			///////
			$consulta = "SELECT Area_ID AS Area_ID FROM area_control WHERE Pro_ID=".$Pro_ID. " AND Floor_ID=".$Floor_ID. " AND Nombre like '%Exterior%'";				
			$result2=$bd->ejecutar($consulta); 	
			while (($row2 = mysqli_fetch_array($result2) ))							
			{		
				$Area_ID = $row2["Area_ID"];
			}
			mysqli_free_result($result2);
	echo "/- ";
			$Nombre_T='Exterior ';	
			$Num_Act='EX00 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);

	
			$Nombre_T='Exterior walls';	
			$Num_Act='EX01 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);


			///////
			$consulta = "SELECT Area_ID AS Area_ID FROM area_control WHERE Pro_ID=".$Pro_ID. " AND Floor_ID=".$Floor_ID. " AND Nombre like '%Floor%'";				
			$result2=$bd->ejecutar($consulta); 	
			while (($row2 = mysqli_fetch_array($result2) ))							
			{		
				$Area_ID = $row2["Area_ID"];
			}
			mysqli_free_result($result2);
	
			$Nombre_T='Floor 1 or Level 1';	
			$Num_Act='FL01 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);
			echo "/- ";

			$Nombre_T='Floor 2 or Level 2';	
			$Num_Act='FL02 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);
	 		echo "/- ";

			$Nombre_T='Floor 3 or Level 3';	
			$Num_Act='FL03 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);
	
			$Nombre_T='Floor 4 or Level 4';	
			$Num_Act='FL04 20.200';	
			$strSQL = "INSERT INTO task (Pro_ID, Floor_ID, Area_ID, Nombre, Horas_Estimadas, Material_Estimado, Aux1, Aux2, Aux3, Aux4, Aux5, Aux6, Porcentaje, NumAct, Precio_Unitario ) ";	
			$strSQL = $strSQL . " values (".$Pro_ID.",".$Floor_ID.",".$Area_ID.",'" . $Nombre_T . "','" . $Horas_Estimadas. "','" . $Mat_Estimado. "','" . $Aux1. "','" . $Aux2. "','" . $Aux3 . "','" . $Aux4. "','" . $Aux5. "','" . $Aux6. "', '" . $Porcentaje."','". $Num_Act. "','". $Precio_Unitario. "')";		
		
			//echo $strSQL."<br>";				
			$res1=$bd->ejecutar($strSQL);  		
			mysqli_free_result($res1);
	
	
	  //end else generating stgructure 
	  echo "The structure is generated <br>";
	}
	require('Library/Close_Conexion.php');

?>

