<table 	style="background-image: url(images/fondo.jpg); width:100%; border:0" cellpadding="0" cellspacing="0">	
<?php
if ($_SESSION["EntityID"]!= "") 
{
?>
	<tr height="25">
		<td align="left" valign="bottom" bgcolor="#FAE6C5" class="callfree_new">
	<?php  	     
		echo "Company: <b>".$_SESSION["NameEntity"]."</b> Usuario: <b>".$_SESSION["OperatorName"]."</b>";  	 
	?>		</td>
		<td colspan="3" align="right" bgcolor="#FAE6C5">
	<?php 	if ($_SESSION["BnPHeader"]=="true") 
			{
	?>
				<a href="index.php?msg=Ingrese su User Name y Password" class="enlaceboton">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;<br>
	<?php 	} 
			else 
			{ ?>
				<a href="menu_sistema.php" class="enlaceboton">Home</a>&nbsp;&nbsp;
				<a href="index.php?msg=Ingrese su User Name y Password" class="enlaceboton">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;<br>
	<?php 	} ?>	  </td>
	</tr>
<?php 
} 
?>
<tr>
	<td colspan="4" height="7" ><img src="images/spacer.gif" border="0" height="5" /></td>
</tr>
</table>
