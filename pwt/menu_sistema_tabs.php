<?php
	session_name("Administrador");
	session_start();

	require('Library/Control_Cache.php');	
	require('Library/Open_Conexion.php');	
	
	if ($_SESSION["EntityID"] == "")
		header("Location: login_sistema.php?msg=Sesion expirada"); 			

	$_SESSION["PageTitle"] = "MENU";
	//echo  $_SESSION["EntityID"]."***".$_SESSION["username"]."***".$_SESSION["OperatorID"]."***".$_SESSION["OperatorName"];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>IP - <?php echo $_SESSION["NameEntity"]; ?> - Menu </title>
	<link rel="STYLESHEET" type="text/css" href="include/Stat.css">
	
	<link type="text/css" href="include/ui/css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" />	
	<script src="include/ui/jquery-1.5.1.js"></script>
	<script src="include/ui/js/jquery.ui.core.js"></script>
	<script src="include/ui/js/jquery.ui.widget.js"></script>
	<script src="include/ui/js/jquery.ui.tabs.js"></script>

<script type="text/javascript">	
	$(function() {
		$( "#tabs" ).tabs({
			ajaxOptions: {
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html(
						"Couldn't load this tab. We'll try to fix this as soon as possible. " +
						"If this wouldn't be a demo." );
				}
			}
		});
	});
	<style type="text/css">
		/*demo page css*/
		body{ font: 62.5% "Trebuchet MS", sans-serif; margin: 50px;}
		.demoHeaders { margin-top: 2em; }
		#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
		#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
		ul#icons {margin: 0; padding: 0;}
		ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
		ul#icons span.ui-icon {float: left; margin: 0 4px;}
	</style>
</script>
</head>
<body>
<?php  
	$_SESSION["BnPHeader"]="true"; 
	require('Header.php');

	$_SESSION["BnPHeader"] = "";

	if ($_SESSION["EntityID"] != "" )
	{
		$sql="SELECT m.*  FROM menuitems m LEFT JOIN rolesmenuitems rm ON m.mnu_id = rm.mnu_id WHERE rm.Rol_ID =".$_SESSION["Rol_ID"]." AND m.Mnu_parentID IS NULL AND Mnu_IsMenu ORDER BY m.Mnu_Position ";      
		//echo $sql."<br>";
		$result1=$bd->ejecutar($sql); 		  
		$i=1;
		?>
		<div id="tabs">
			<ul>
		<?php
		while ( $MenuPpal = mysqli_fetch_array($result1) )	
		{ 
			$sql = "SELECT m . *  FROM menuitems m LEFT JOIN rolesmenuitems rm ON m.mnu_id = rm.mnu_id WHERE rm.Rol_ID =".$_SESSION["Rol_ID"]." AND m.Mnu_parentID= ".$MenuPpal["Mnu_ID"]." AND Mnu_IsMenu ORDER BY m.Mnu_Position ";	
			//echo $sql;			   
			$result3=$bd->ejecutar($sql); 		         	
			while ( $SubMenuOptions = mysqli_fetch_array($result3) )	
			{  
			?>				
				<li><a href="<?php echo $SubMenuOptions["Mnu_URL"]; ?>"><?php echo $SubMenuOptions["Mnu_Description"] ?></a></li>					
			<?php  							 
			}//while
			mysqli_free_result($result3);
			$i++;    
		}//while
		mysqli_free_result($result1); 
		?>
			</ul>
		</div>
		<?php
}
else
{
?>
 <script>
  	alert("Su Sesion a Expirado Inicie sesion Nuevamente")
  	//window.open('login_sistema.php','_self');
 </script>
<?php
	header("Location: index.php"); 
}
require('Library/Close_Conexion.php');	
?>
</body>
</html>
