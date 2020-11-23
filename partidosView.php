<?php
require_once("includes/control/SessionControl.php");
require_once("includes/configuration/Definitions.php");
require_once("includes/model/DAOs/DAOImagenes.php");
require_once("includes/model/DAOs/Imagen.php");
require_once("includes/forms/UserEntrySecurity.php"); 


?>

<!DOCTYPE html>
<html lang = "es">
<head>
	<meta charset = "UTF-8">
	<title> Padel2u: Partidos Amistosos </title>
	<link rel = "stylesheet" type = "text/css" href = "estilos/general.css">
	<link rel = "stylesheet" type = "text/css" href = "fonts/style.css">
	<link rel = "stylesheet" type = "text/css" href = "estilos/layout_plural.css">
	<script src = "includes/resources/jquery.js"></script>
	<script src = "includes/js/vista.js"></script>
	
</head>

<body>
	<?php 
	/* Fija la seccion de la pagina en la que nos encontramos */
	SessionControl::setSeccion(SECCION_PARTIDO); 
	   require("includes/common/cabecera.php");
	?>
	
	<?php 
	   /* Captacion de datos necesarios */ 
	
	   $tipoSesion = SessionControl::tipoUsuarioLogeado(); 
	   $idSesion = SessionControl::getIdSesion(); 
	   $efectividadSesion = SessionControl::getEfectividadSesion(); 
	   $partidos = array(); 
	   echo SessionControl::getFeedbackEntrante(); 
	
	?>
	<div class = "main">
	   
	
	</div>


<?php 
	   require("includes/common/pie.php");
	?>



</body>





</html>