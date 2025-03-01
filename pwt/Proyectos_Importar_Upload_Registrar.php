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

				         					  

	$imp_id=$_GET['imp_id'];	

	

	$consulta = "SELECT * FROM import WHERE ID IN (".$imp_id.")"; 	 

	//echo $consulta."<br>";	

	

	$result33=$bd->ejecutar($consulta); 

	while (($row33 = mysqli_fetch_array($result33) ))							

	{	

		$Job = $row33["Job"];	

		$Code = $row33["Code"];	

		$Address = $row33["Address"];	

		$City = $row33["City"];	

		$Zip_Code = $row33["Zip_Code"];	

		$State = $row33["State"];	

		$Submital = $row33["Submital"];	

		$Estado_Submital = $row33["Estado_Submital"];	

		$Fecha = $row33["Fecha"];	

		$Pro_ID = $row33["Pro_ID"];	

		$Mat_ID = $row33["Mat_ID"];

		

		$consulta = "SELECT Emp_ID FROM empresas WHERE Codigo='PWT' "; 	 

		$result=$bd->ejecutar($consulta); 

		if (($row = mysqli_fetch_array($result) ))							

		{	

			$Emp_ID = $row["Emp_ID"];	

		}

		mysqli_free_result($result);

		

		$consulta = "SELECT Ven_ID FROM vendedor WHERE Codigo='WH' "; 	 

		$result=$bd->ejecutar($consulta); 

		if (($row = mysqli_fetch_array($result) ))							

		{	

			$Ven_ID = $row["Ven_ID"];	

		}

		mysqli_free_result($result);	

		

		$consulta = "SELECT Cat_ID FROM categoria_material WHERE Nombre like '%".$Estado_Submital."' "; 	 

		$result=$bd->ejecutar($consulta); 

		if (($row = mysqli_fetch_array($result) ))							

		{	

			$Cat_ID = $row["Cat_ID"];	

		}

		mysqli_free_result($result);	

		

		$consulta = "SELECT Pro_ID FROM proyectos WHERE Codigo='".$Code."'";	

		//echo $Code;									

		$Pro_ID=-1;

		$result2=$bd->ejecutar($consulta); 	

		while (($row2 = mysqli_fetch_array($result2) ))							

		{		

			$Pro_ID = $row2["Pro_ID"];

		}

		mysqli_free_result($result2);			

		//echo $Pro_ID;

		if ($Pro_ID==-1)

		{
			$StatusID=2;
			$fecha1= date('Y-m-d');
			$strSQL = "INSERT INTO proyectos (Emp_ID, Nombre, Estado, Ciudad, Zip_Code, Calle, Codigo,Estatus_ID,Fecha_Inicio ) ";	
			$strSQL = $strSQL . " values (".$Emp_ID.", '" . $Job . "','" . $State. "','" . $City . "','" . $Zip_Code. "','" . $Address. "', '" . $Code. "'," . $StatusID.", '" . $fecha1."')";	
			//echo $strSQL."<br>";
			$res1=$bd->ejecutar($strSQL);  		
			if ($res1)
			{
				$consulta = "SELECT MAX(Pro_ID) AS Pro_ID FROM proyectos "; 	 
				$result=$bd->ejecutar($consulta); 
				if (($row = mysqli_fetch_array($result) ))							
				{	
					$Pro_ID = $row["Pro_ID"];	
				}
				mysqli_free_result($result);	

	// rgistro area control
			$strSQL = "INSERT INTO area_control (Pro_ID, Nombre, Note, Aux1, Aux2, Aux3) ";	
				$strSQL = $strSQL . " values (".$Pro_ID.",'-.', '','','', '')";					
				$res1=$bd->ejecutar($strSQL); 

			// fin area control	

			//echo $strSQL."<br>";	

				if ($Submital!="")

				{

					$strSQL = "INSERT INTO materiales (Pro_ID, Ven_ID, Cat_ID, Denominacion, Unidad_Medida, Fecha_Registro) ";	

					$strSQL = $strSQL . " values (".$Pro_ID."," . $Ven_ID . "," . $Cat_ID. ",'" . $Submital. "','gl.', NOW() )";		

					//echo $strSQL."<br>";				

					$res1=$bd->ejecutar($strSQL); 

				}				

			}

		}

		else

		{

			if ($Submital!="")

			{

				$strSQL = "INSERT INTO materiales (Pro_ID, Ven_ID, Cat_ID, Denominacion, Unidad_Medida, Fecha_Registro) ";	

				$strSQL = $strSQL . " values (".$Pro_ID."," . $Ven_ID . "," . $Cat_ID. ",'" . $Submital. "','gl.', NOW() )";		

				//echo $strSQL."<br>";				

				$res1=$bd->ejecutar($strSQL); 

			}

		}	

	}

	mysqli_free_result($result33);		

	require('Library/Close_Conexion.php');	

?>