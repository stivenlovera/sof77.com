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

	

?> 

<fieldset id="Fs_Lista_Cliente" class="" >

	<legend>List of Projects:- </legend>

<div>

<table border="1" cellpadding="0" cellspacing="0" >

	  <tr>     

			<td width="10"></td>

			<td width="60"><b>Code</b></td>				

			<td width="115"><b>Job Name</b></td>			

	  </tr>	

<?php   				       

	  					  

	$Company=$_GET['Company'];	

	$Name=$_GET['Nombre'];	

	$Emp_ID=$_GET['Emp_ID'];	

	$Foreman_ID=$_GET['Foreman_ID'];	

	$Manager_ID=$_GET['Project_Manager_ID'];

	$Super_ID=$_GET['Super_ID'];

	$EstatusID=$_GET['EstatusID'];

		

	

	$vfrom_date=$_REQUEST["vfrom_date"];

	$vto_date=$_REQUEST["vto_date"];	

	

	$vdia=substr($vfrom_date,3,2);

	$vmes=substr($vfrom_date,0,2);

	$vano=substr($vfrom_date,8,2);	

	$af1="20".$vano."-".$vmes."-" .$vdia;

	

	$vdia=substr($vto_date,3,2);

	$vmes=substr($vto_date,0,2);

	$vano=substr($vto_date,8,2);	

	$af2="20".$vano."-".$vmes."-" .$vdia;		

	

	$consulta = "SELECT p.*, e.Nombre as Company FROM proyectos p INNER JOIN empresas e ON p.Emp_ID=e.Emp_ID ";	

	$consulta = $consulta . " WHERE p.Pro_ID IN ( SELECT DISTINCT(a.Pro_ID) FROM actividades a  WHERE a.fecha between '$af1' AND '$af2' )  AND ";	

			

	if ( ($Emp_ID!="") && ($Emp_ID!="-33")  )

		$consulta = $consulta." e.Emp_ID=".$_GET['Emp_ID']."  AND";   

	else	

		if ( $_GET['Company'] != ""  )

			$consulta = $consulta." e.Nombre like '%".$_GET['Company']."%'  AND";   

		

	

	if ( $_GET['Nombre'] != ""  )

		$consulta = $consulta." p.Nombre like '%".$_GET['Nombre']."%'  AND";   

	

	if ( $Foreman_ID != ""  )

		$consulta = $consulta." p.Foreman_ID ='".$Foreman_ID."'  AND";   

	

	if ( $Manager_ID	 != ""  )

		$consulta = $consulta." p.Manager_ID=".$Manager_ID."  AND";

		

	if ( $Super_ID	 != ""  )

		$consulta = $consulta." p.Coordinador_ID=".$Super_ID."  AND";  

	 

	

	if ( $EstatusID != "-1"  )

		$consulta = $consulta." p.Estatus_ID =".$EstatusID."  AND";   

		

	$consulta = $consulta." 1=1 ORDER BY p.Estatus_ID,p.Nombre";	

	

	//echo $consulta."<br>";

	$contador=1;	 	  	 	  	  



	$result2=$bd->ejecutar($consulta); 	

	while (($row2 = mysqli_fetch_array($result2) ))							

	{		

		$Codigo = $row2["Codigo"];

		$Emp_ID = $row2["Emp_ID"];

		$Company = $row2["Company"];

		$Pro_ID = $row2["Pro_ID"];

		$Nombre = $row2["Nombre"];

		$Fecha_Inicio=$row2["Fecha_Inicio"];	

		$Fecha_Fin=$row2["Fecha_Fin"];		

		$Horas=$row2["Horas"];			

		$Estado = $row2["Estado"];	

		$Ciudad = $row2["Ciudad"];

		$Zip_Code = $row2["Zip_Code"];			

		$Calle = $row2["Calle"];

		$Numero=$row2["Numero"];

		$Contratista_General=$row2["Contratista_General"];

		

		//if ( $_GET['Company'] != ""  )

			//$Estado='checked="checked"';

			$Estado='';

		/*else

			$Estado='';*/

		

	?>	

		<tr >

			<td> <input name="Pro_ID_Reporte" type="checkbox" id="Pro_ID_Reporte" value="<?php echo  $Pro_ID; ?>" checked="CHECKED" <?php echo  $Estado; ?> /> </td>

			<td align="right" style="font-size:x-small"><?php echo  $Codigo; ?></td>			

			<td align="left">				

				<?php echo $Nombre; ?> 

			</td>				

	  </tr>

		<?php    		

			$contador++;								 								

	}

	mysqli_free_result($result2);		

			?>

	</table>   	

</div>

<img src="images/spacer.gif" onload="$('.tabla_proyectos_listas').flexigrid({nowrap: false, showTableToggleBtn : true,width : 240,height :100, singleSelect: true	});" />	 

</fieldset>	

<?php

	require('Library/Close_Conexion.php');	

?>