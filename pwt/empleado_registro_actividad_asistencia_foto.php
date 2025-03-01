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

	$Empleado_ID=$_POST["Empleado_ID"];
	$Tipo=$_POST["Tipo"];
	$Reg_ID=$_POST["Reg_ID"];
	$Foto=$_POST["Foto"];	

		if ($Tipo=="In")
		{
			$strSQL = "UPDATE registro_diario SET Foto_Ingreso='".$Foto."' WHERE Reg_ID=".$Reg_ID;	
			//echo $strSQL."<br>";
			$result2=$bd->ejecutar($strSQL); 
			if ($result2)
			{
				echo "Registro Foto Ingreso Satisfactorio.";				
				echo "<img src='images/spacer.gif' onload='$(\"#Img_Foto_IN_".$Empleado_ID."\").attr(\"src\",\"images/con_foto.jpg\");' />";
			}
			else
				echo "Error en Registro";
		}
		else
		{
			if ($Tipo=="Out")
			{
				$strSQL = "UPDATE registro_diario SET Foto_Salida='".$Foto."' WHERE Reg_ID=".$Reg_ID;
				//echo $strSQL."<br>";	
				$res1=$bd->ejecutar($strSQL);  		
			
				if ($res1)
				{
					echo "Registro  Foto Salida Satisfactorio";					
					echo "<img src='images/spacer.gif' onload='$(\"#Img_Foto_OUT_".$Empleado_ID."\").attr(\"src\",\"images/con_foto.jpg\");' />";
					echo "<img src='images/spacer.gif' onload='$(\"#Editar_".$Empleado_ID."\").html(\"\");' />";
					$_SESSION["Empleado_ID"]=$Empleado_ID;
					$Pro_ID=$_SESSION["Pro_ID"];
					 
					echo "<img src='images/spacer.gif' onload='empleado_registro_actividad_detalle_x(".$Reg_ID.", ".$Pro_ID.");' />";
					
				}			
			}
		}		

	require('Library/Close_Conexion.php');	
?>