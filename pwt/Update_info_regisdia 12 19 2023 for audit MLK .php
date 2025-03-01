<?php	 		
	session_name("Administrador");
	session_start();		
			
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	
	require('Library/funciones.php');	
	
	
	
		$consulta = "SELECT * from info2442  ";
		echo $consulta."<br>";	
		//exit ();
		$result2=$bd->ejecutar($consulta); 	
		while (($row2 = mysqli_fetch_array($result2) ))							
		{	
		
			$fecha=$row2["fecha"];
			$num_emp=$row2["employee_num"];
		
			// to include $consulta7 = "SELECT p.Empleado_ID as Emp_ID,ap.*,a.* FROM actividad_personal ap join actividades a on a.Actividad_ID=ap.Actividad_ID join personal p on ap.Empleado_ID=p.Empleado_ID where a.Fecha='".$fecha."' and p.Numero=".$num_emp; 
			$consulta7 = "SELECT p.Empleado_ID as Emp_ID,ap.*,a.* FROM actividad_personal ap join actividades a on a.Actividad_ID=ap.Actividad_ID join personal p on ap.Empleado_ID=p.Empleado_ID where a.Fecha='".$fecha."' and p.Numero=".$num_emp." and a.Pro_ID=1617"; // to delete 
			
			
			echo $consulta7."<br>";	
			//exit ();
			$result7=$bd->ejecutar($consulta7); 	
			while (($row7 = mysqli_fetch_array($result7) ))							
			{	
			
				$actID_to_rep=$row7["Actividad_ID"];
				$emp_ID=$row7["Emp_ID"];
				$consulta8 = "SELECT * FROM actividades where fecha='".$fecha."' and Pro_ID=1617"; 
				echo $consulta8."<br>";	
				//exit ();
				$result8=$bd->ejecutar($consulta8); 	
				while (($row8 = mysqli_fetch_array($result8) ))							
				{	
					$actID_to_put=$row8["Actividad_ID"];
					// to add $consulta9="Update actividad_personal set actividad_id=".$actID_to_put." where actividad_id=".$actID_to_rep." and empleado_ID=".$emp_ID;
					$consulta9="Update actividad_personal set actividad_id=0 where actividad_id=".$actID_to_rep." and empleado_ID=".$emp_ID; //to delete
					echo $consulta9."<br>";	
						$result9=$bd->ejecutar($consulta9); 	
//to add					$consulta9="Update registro_diario set Actividad_ID=".$actID_to_put.",Pro_ID=1617 where Actividad_ID=".$actID_to_rep." and empleado_ID=".$emp_ID;
					$consulta9="Update registro_diario set Actividad_ID=0 where Actividad_ID=".$actID_to_rep." and empleado_ID=".$emp_ID; // to delete 

					echo $consulta9."<br>";	
						$result9=$bd->ejecutar($consulta9); 	
					//to add $consulta9="Update registro_diario_actividad set actividad_id=".$actID_to_put." where actividad_id=".$actID_to_rep." and empleado_ID=".$emp_ID;
					$consulta9="Update registro_diario_actividad set actividad_id=0 where actividad_id=".$actID_to_rep." and empleado_ID=".$emp_ID; //to delete 
					echo $consulta9."<br>";
						$result9=$bd->ejecutar($consulta9); 	
	
	
				}
			
			
			}
		
		
		}
		mysqli_free_result($result7);
		mysqli_free_result($result8);
		mysqli_free_result($result9);
	
	require('Library/Close_Conexion.php');	
?>