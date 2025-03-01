

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

//	$email='marioprueba@hot.com';

$vfrom_date=$_REQUEST["vfrom_date"];

$vto_date=$_REQUEST["vto_date"];

$Pro_ID_Reporte=$_REQUEST["Pro_ID_Reporte"];								



	$vdia=substr($vfrom_date,3,2);

	$vmes=substr($vfrom_date,0,2);

	$vano=substr($vfrom_date,8,2);

	$af1="20".$vano."-".$vmes."-".$vdia;

	$vdia=substr($vto_date,3,2);

	$vmes=substr($vto_date,0,2);

	$vano=substr($vto_date,8,2);

	$af2="20".$vano."-".$vmes."-" .$vdia;

	

	$sql = "select

	proyectos.Pro_ID,

	proyectos.codigo, 

	proyectos.nombre,

	proyectos.calle,

	proyectos.ciudad,

	proyectos.Estado,

	proyectos.zip_code,

	proyectos.coordinador_obra_id,

	proyectos.Estatus_ID,	

	proyectos.emails,

	actividades.Fecha,

	actividades.hora,

	actividades.descripcion,

	actividades.Actividad_ID,

	actividades.Descripcion,

	actividades.Aux2,

	actividades.Aux3,	

	actividades.Aux4,

	tipo_actividad.actividad_nombre,

	empresas.Codigo 

	FROM tipo_actividad inner join 

	(actividades inner join proyectos on actividades.pro_id=proyectos.pro_id) on tipo_actividad.tipo_actividad_id=actividades.tipo_actividad_id inner join empresas on proyectos.Emp_ID=empresas.Emp_ID

	WHERE actividades.fecha between '$af1' and '$af2' ";

	

	if ($Pro_ID_Reporte!=-33)	

		$sql = $sql . " AND actividades.Pro_ID=$Pro_ID_Reporte ";



	$sql = $sql . "	ORDER BY nombre,fecha,hora";	



	$result=$bd->ejecutar($sql);



//	echo $sql;



	// titulo del reporte

    if(mysql_num_rows($result)>0) 		 

	{		



		$bandera=1;	

		$bandera_2=1;	



		while ($row22=mysqli_fetch_array($result))

		{	

			$totalreg = mysql_num_rows($row22);

				mysql_data_seek ( $result, 0);

				

 

				$email=$row22["emails"];

				$pro_ID=$row22["Pro_ID"];

				$actividad_ID=$row22["Actividad_ID"];	

				echo $pro_ID."<br>";



				header("Location: reporte_daily_report_email_send.php?email=".urlencode($email)."&pro_ID=".$pro_ID."&actividad_ID=".$actividad_ID);

				

					header("Location: reporte_daily_report_email_send.php?email=".urlencode($email)."&pro_ID=".$pro_ID."&actividad_ID=".$actividad_ID);

				

//				 echo $pro_ID."<br>"."lllllllljjjj";







		}

	}



	

?>



<?php

	require('Library/Close_Conexion.php');

?>

	