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
	//$Foto=$_POST["Foto"];
	
	$nombre_img = $_FILES['archivo1']['name'];
	$tipo = $_FILES['archivo1']['type'];
	$tamano = $_FILES['archivo1']['size'];
	 
	 //echo "llego";
	//Si existe imagen y tiene un tamaño correcto
	if (($nombre_img == !NULL) && ($_FILES['imagen']['size'] <= 200000)) 
	{
	   //indicamos los formatos que permitimos subir a nuestro servidor
	   if (($_FILES["archivo1"]["type"] == "image/gif")
	   || ($_FILES["archivo1"]["type"] == "image/jpeg")
	   || ($_FILES["archivo1"]["type"] == "image/jpg")
	   || ($_FILES["archivo1"]["type"] == "image/png"))
	   {
			// Ruta donde se guardarán las imágenes que subamos
			$directorio = $_SERVER['DOCUMENT_ROOT'].'/pwt/fotos/';
			$hoy = getdate();
			$nombre_img=$Empleado_ID.$hoy["year"].$hoy["mon"].$hoy["mday"].$hoy["hours"].$hoy["minutes"].$hoy["seconds"].".".str_replace("image/", "", $_FILES["archivo1"]["type"]);
			// Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
			//echo $directorio.$nombre_img."<br>";
			move_uploaded_file($_FILES['archivo1']['tmp_name'],$directorio.$nombre_img);					  
			
			//echo "Archivos subidos exitosamente";
		  
		  	if ($Tipo=="In")
			{
				$strSQL = "UPDATE registro_diario SET Foto_Ingreso='".$nombre_img."' WHERE Reg_ID=".$Reg_ID;	
				//echo $strSQL."<br>";
				$result2=$bd->ejecutar($strSQL); 
				if ($result2)
				{
					echo "Registro Foto Ingreso Satisfactorio.";				
					echo "<img src='images/spacer.gif' onload='$(\"#Img_Foto_IN_".$Empleado_ID."\").attr(\"src\",\"pwt/fotos/".$nombre_img."\");' />";
					echo "<img src='images/spacer.gif' onload=\"$('#basic-modal-content-espera').dialog('close')\" />";	
				}
				else
					echo "Error en Registro";
			}
			else
			{
				if ($Tipo=="Out")
				{
					$strSQL = "UPDATE registro_diario SET Foto_Salida='".$nombre_img."' WHERE Reg_ID=".$Reg_ID;
					//echo $strSQL."<br>";	
					$res1=$bd->ejecutar($strSQL);  		
				
					if ($res1)
					{
						echo "Registro Foto Salida Satisfactorio <br>";
						echo "Picture Recorded ! <br>";
						echo "<img src='images/spacer.gif' onload='$(\"#Img_Foto_OUT_".$Empleado_ID."\").attr(\"src\",\"pwt/fotos/".$nombre_img."\");' />";
						echo "<img src='images/spacer.gif' onload='$(\"#Editar_".$Empleado_ID."\").html(\"\");' />";
						$_SESSION["Empleado_ID"]=$Empleado_ID;
						$Pro_ID=$_SESSION["Pro_ID"];
						 
						echo "<img src='images/spacer.gif' onload='empleado_registro_actividad_detalle_x(".$Reg_ID.", ".$Pro_ID.");' />";
						
						
					}			
				}
			}
		} 
		else 
		{
		   //si no cumple con el formato
		   echo "It is not posible upload a picture w/that format / No se puede subir una imagen con ese formato <br>";		   	   
		}
	} 
	else 
	{
	   //si existe la variable pero se pasa del tamaño permitido
	   if($nombre_img == !NULL) echo "The picture resolution is to big /La imagen es demasiado grande <br>"; 
	}	

				

	require('Library/Close_Conexion.php');	
?>