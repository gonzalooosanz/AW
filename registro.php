<?php
    require_once("includes/forms/registroForm.php"); 
    require_once("includes/configuration/Definitions.php"); 
    require_once("includes/forms/UserEntrySecurity.php"); 
    

?>

<!DOCTYPE html>
<html lang = "es">
<head>
	<title> Padel2u: Registro de Usuario</title>
	<meta charset = "UTF-8">
	<link rel = "stylesheet" type = "text/css" href = "estilos/general.css">
	<link rel = "stylesheet" type = "text/css" href = "estilos/form.css">
	<script src = "includes/resources/jquery.js"></script>
	<script src = "includes/js/vista.js"></script>
	<script src = "includes/js/forms.js"></script>
	<!--  PROVINCIAS Y POBLACIONES SCRIPT DE INCLUSION -->
	<script src = "includes/js/provinciasypoblaciones.js"></script>
	
	<!--  FIN PROVINCIAS Y POBLACIONES  -->
</head>

<body>
	<?php 
	/* Fija la seccion de la pagina en la que nos encontramos */
	SessionControl::setSeccion(SECCION_REGISTRO); 
	   require("includes/common/cabecera.php");
	?>
	
	<div class = "main">
		<div class="separator">
		<h1> Formulario de registro en Padel2u </h1>
		</div>
		<div class = "form_wrapper"> 
		
		<?php 
		  $opciones = array(); 
		  $opciones[] = "validarFormularioRegistro(this);";
		  $opciones[] = ""; 
		  $opciones[] = "multipart/form-data"; 
		  $registro = new registroForm("registroForm", $opciones); 
		  $registro->gestiona(); 
		?>
		
		<!--  USADO PARA LAS PROVINCIAS Y POBLACIONES  -->
		<script>
		var prov = document.getElementById('ps-prov');
		var mun = document.getElementById('ps-mun');
		// Create PS
		Pselect().create(prov, mun);


		</script>
		
		</div>
	</div>
	<?php 
	   require("includes/common/pie.php");
	?>
</body>
</html>