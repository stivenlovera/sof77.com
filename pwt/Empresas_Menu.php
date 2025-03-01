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
	
	$Emp_ID=trim($_GET['Emp_ID']);
	
	$PUEDE_VER_PROYECTOS=validaRol(4,$bd);	
	$PUEDE_VER_PERSONAL=validaRol(5,$bd);
	$PUEDE_VER_DATOS=validaRol(6,$bd);
	$PUEDE_VER_LOGS=validaRol(7,$bd);
	
	$consulta = "SELECT * FROM empresas WHERE Emp_ID=".$Emp_ID;    		
	$result2=$bd->ejecutar($consulta); 	
	while (($row2 = mysqli_fetch_array($result2) ))							
	{		
		$Codigo = $row2["Codigo"];	
		$Nombre = $row2["Nombre"];
	}
	mysqli_free_result($result2);	
?> 
<div id='div_menu_cliente_aux'>
	<fieldset id="Datos Cliente" class="" >
		<legend>Company: <?php echo $Nombre; ?></legend>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align="left">
					<div id=tabmenu>
						<ul > 	
							<?php 
							if ($PUEDE_VER_PROYECTOS) 
							{
							?>
								<li onclick="makeactive(1,<?php echo $Emp_ID; ?>)"><a class="" id="tab1"><span>Projects</span></a></li> 				
							<?php 
							}
							else
							{
							?>
								<span id="tab1"></span>
							<?php 
							} 
								
							if ($PUEDE_VER_PERSONAL) 
							{
							?>
								<li onclick="makeactive(2,<?php echo $Emp_ID; ?>)"><a class="" id="tab2"><span>Employees</span></a></li> 				
							<?php 
							} 
							else
							{
							?>
								<span id="tab2"></span>
							<?php 
							} 	
							
							if ($PUEDE_VER_DATOS) 
							{
							?>
								<li onclick="makeactive(3,<?php echo $Emp_ID; ?>)"><a class="" id="tab3"><span>.</span></a></li> 				
							<?php 
							} 
							else
							{
							?>
								<span id="tab3"></span>
							<?php 
							}
							
							if ($PUEDE_VER_LOGS) 
							{
							?>
								<li onclick="makeactive(4,<?php echo $Emp_ID; ?>)"><a class="" id="tab4"><span>.</span></a></li> 				
							<?php 
							} 
							else
							{
							?>
								<span id="tab4"></span>
							<?php 
							}	
							?>		
						</ul> 
					</div><br>
				</td>
			</tr>
			<tr>
				<td >	
					<div id="dropInfo1" class="dropcontent" style="display:none">
						<div id="Div_Empresas_Lista_Proyectos"></div>
					</div>
					<div id="dropInfo2" class="dropcontent" style="display:none">
					   <div id="Div_Empresas_Lista_Empleados"></div>
					</div>	
					<div id="dropInfo3" class="dropcontent" style="display:none">
						
					</div>	
					<div id="dropInfo4" class="dropcontent" style="display:none">		
						
					</div>	
				</td>
			</tr>
		</table>
	</fieldset>
</div>