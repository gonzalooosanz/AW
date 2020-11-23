<?php 
    require_once("includes/control/SessionControl.php"); 
    require_once("includes/configuration/Definitions.php"); 
    require_once("includes/forms/UserEntrySecurity.php"); 

?>

<!DOCTYPE html>
<html lang = "es">
<head>
	<title> Padel2u: Pagina Principal</title>
	<meta charset = "UTF-8">
	<link rel = "stylesheet" type = "text/css" href = "estilos/general.css"> 
	<link rel = "stylesheet" type = "text/css" href = "fonts/style.css">
	<link rel = "stylesheet" type = "text/css" href = "estilos/index.css">
	<script src = "includes/resources/jquery.js"></script>
	<script src = "includes/js/vista.js"></script>
	<!--  PROVINCIAS Y POBLACIONES SCRIPT DE INCLUSION -->
	<script src = "https://iagolast.github.io/pselect/dist/pselect.js"></script>
	
	<!--  FIN PROVINCIAS Y POBLACIONES  -->
	
</head>

<body>
	<?php 
	/* Fija la seccion de la pagina en la que nos encontramos */
	SessionControl::setSeccion(SECCION_INDEX); 
	   require("includes/common/cabecera.php");
	
	 echo SessionControl::getFeedbackEntrante(); 
	
	?>
	<div class="main">
	<h3> Para poder usar la página web como administrador: </h3>
	<p> Usuario: a@gmail.com </p>
	<p> Contraseña: a </p>
	<div class = "button_wrapper">
		<a href = "torneosView.php" class = "boton azul medio"> Ir a la parte implementada de torneos en esta practica. </a>
	</div>
	

</div>


</body>
<?php 
	   require("includes/common/pie.php");
	?>

<!--  PROVINCIAS Y POBLACIONES SCRIPT DE INCLUSION -->
<script src = "includes/js/provinciasypoblaciones.js"></script>
</html>