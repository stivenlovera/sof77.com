<?php
	session_name("Administrador");
	session_start();		
	if ($_SESSION['EntityID'] == "")
	{
		header("Location:sessionexpired.php"); 	
	}	 	
		
	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	
	require('Library/funciones.php');		
	
	if ($_SESSION['Emp_ID_Aux']!= ""  ) 
		$Emp_ID=$_SESSION['Emp_ID_Aux'];		
	else
		$Emp_ID=$_GET['Emp_ID'];
	
	$PUEDE_VER_DATOS_CONTACTO=validaRol(18,$bd);	

?>
<style type="text/css">
<!--
.misdatos
{
	border-bottom-style:dotted;
	border-bottom-width:thin;
	border-bottom-color:#CCCCCC;
	color:#FF6633;
}
-->
</style>

<?php 
	$consulta_1 = "SELECT * FROM Empresas WHERE Emp_ID =".$Emp_ID;
	$con=1; 
	//echo $consulta_1 ;
	$result=$bd->ejecutar($consulta_1); 				
	if ($clients_1 = mysqli_fetch_array($result) )							
	{	   			
?></span></p>
<fieldset id="IModCliente" class="" >
		<legend>Company Info <?php echo $clients_1["Nombre"];?></legend>
	    <form id="IModCliente" name="IModCliente">			
<table width="100%" >  
  <tr>
      <td width="90">Codigo:</td>
      <td><font size="+2"><b><?php echo $clients_1["Codigo"];?></b></font></td>	  
      <td width="150">General Manager:</td>
    <td ><p class="edit"><span><?php echo $clients_1["Gerente_General"];?></span></p></td>			
  </tr>
  <tr>    
    <td width="70">Address:</td>
	<td ><p class="edit"><span> <?php echo $clients_1["Numero"]." ". $clients_1["Calle"] . ", ". $clients_1["Ciudad"].", ".$clients_1["Estado"]. " ". $clients_1["Zip_Code"];?></span></p></td>
    <td width="70">Phone:</td>
	<td ><p class="edit"><span> <?php echo $clients_1["Telefono"];?></span></p></td>	
  </tr>    
  	<tr>
		<td width="90">Fax:</td>
	    <td width="350" ><p class="edit"><span> <?php printHex($clients_1["Fax"]);?></span></p></td>
		<td width="70">Web Site  :</td>
		<td ><p class="edit"><span> <?php printHex($clients_1["Web"]);?></span></p></td>		
  	</tr>
  	<tr>
	    <td width="70">Details</td>
	    <td ><p class="edit"><span> 
        		<?php printHex($clients_1["Detalles"]);?>
        	</span></p>
        </td>    		
  	</tr>
</table>
</form>
</fieldset>
<?php	
}
else
{
	echo "No existen Registros";
}
?></span></p>
<?php
	require('Library/Close_Conexion.php');	
?>
