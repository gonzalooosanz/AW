<?php
    require_once("includes/forms/loginForm.php"); 
    require_once("includes/configuration/Definitions.php"); 
    require_once("includes/forms/UserEntrySecurity.php"); 
    

?>

<!DOCTYPE html>
<html lang = "es">
<head>
	<title> Padel2u: Iniciar Sesion</title>
	<meta charset = "UTF-8">
	<link rel = "stylesheet" type = "text/css" href = "estilos/general.css">
	<link rel = "stylesheet" type = "text/css" href = "estilos/form.css">
	<script src = "includes/resources/jquery.js"></script>
	<script src = "includes/js/forms.js"></script>
	<script src = "includes/js/vista.js"></script>
	<script src = "includes/js/usuario.js"></script>
	
</head>

<body>
	<?php 
	/* Fija la seccion de la pagina en la que nos encontramos */
	SessionControl::setSeccion(SECCION_LOGIN); 
	   require("includes/common/cabecera.php");
	?>
		<div class = "main">
 		<div class="separator">
		<h1> Formulario de inicio de sesion en Padel2u </h1>
		</div>
		<div class = "form_wrapper"> 
		
		<?php 
		  $opciones = array(); 
		  $opciones[] = "validarFormularioLogin(this);";
		  $login = new LoginForm("loginForm", $opciones); 
		  $login->gestiona(); 
		
		?>
		
		</div>
	
	</div>
	<?php 
	   require("includes/common/pie.php");
	?>
</body>
</html>