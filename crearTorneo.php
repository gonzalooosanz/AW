<?php
require_once("includes/control/SessionControl.php");
require_once("includes/configuration/Definitions.php");
require_once("includes/forms/crearTorneoForm.php"); 
require_once("includes/forms/UserEntrySecurity.php"); 


?>

<!DOCTYPE html>
<html lang = "es">
<head>
	<meta charset = "UTF-8">
	<title> Padel2u: Torneos </title>
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
	SessionControl::setSeccion(SECCION_TORNEO); 
	require("includes/common/cabecera.php");
	?>
	<div class="main">
		<?php 

		/* Captacion de datos necesarios */ 

		$tipoSesion = SessionControl::tipoUsuarioLogeado();

		?>

		<!--  1. Boton de crear torneo  -->

		<div class = "separator">
			<h1>Formulario de creación de torneo en PADEL2U</h1>
			</div>
			<div class = "form_wrapper"> 

				<?php 
				if($tipoSesion == USUARIO_ARBITRO){
					$opciones = array();
					$opciones[] = "validarFormularioCrearTorneo(this);";
					$crearTorneo = new CrearTorneoForm("crearTorneoForm", $opciones); 
					$crearTorneo->gestiona(); 
				}

				else{
					?>
					<div class = "mensaje_wrapper">
						<h3> Solo los arbitros pueden crear un torneo </h3>
					</div>

				<?php }   // Fin de creacion de torneo ?>

			</div>
		

		<script>
			var prov = document.getElementById('ps-prov');
			var mun = document.getElementById('ps-mun');
		// Create PS
		Pselect().create(prov, mun);


	</script>
</div>
<?php 
require("includes/common/pie.php");
?>
</body>
</html>