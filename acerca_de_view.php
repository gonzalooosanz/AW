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
	<title>Padel2u: ¿Quiénes somos?</title>
	<link rel = "stylesheet" type = "text/css" href = "estilos/general.css">
	<link rel = "stylesheet" type = "text/css" href = "estilos/torneo.css">
	<link rel = "stylesheet" type = "text/css" href = "fonts/style.css">
	<script src = "includes/resources/jquery.js"></script>
	<script src = "includes/js/vista.js"></script>
	
</head>

<body>
	<?php 
	/* Fija la seccion de la pagina en la que nos encontramos */
	SessionControl::setSeccion(SECCION_ACERCA_DE); 
	require("includes/common/cabecera.php");
	
	echo SessionControl::getFeedbackEntrante(); 
	
	?>
	<div class = "main">

		<div class="separator">
			<h1>Miembros del equipo de Padel2U</h1>
			<p><a href="#daniel">Perfil de Daniel</a></p>
			<p><a href="#alvaro">Perfil de Álvaro</a></p>
			<p><a href="#gonzalo">Perfil de Gonzalo</a></p>
			<p><a href="#arturo">Perfil de Arturo</a></p>
			<p><a href="#jorge">Perfil de Jorge</a></p>
		</div>

		<div class="separator">
			<h2  id="daniel">Daniel Villar Serrano</h2>
			<div class="photo_wrapper">
				<img src="img/d1.jpg" alt = "Imagen de Daniel Villar Serrano">
			</div>
			<div class="info_wrapper">
				<p>Davillar@ucm.es</p>
				<p>Le gusta cazar comadrejas en las noches de luna creciente.</p>
				<p>Para ello utiliza la Espada Sagrada de Ludwig, un arma con truco usada por la Iglesia de la Sanación.</p>
				<p>Se dice que la espada de plata fue empleada por Ludwig, primer cazador de la Iglesia.</p>
			</div>
		</div>

		<div class="separator">
			<h2 id="alvaro">Álvaro Acosta Rodríguez</h2>
			<div class="photo_wrapper">
				<img src="img/al1.jpg" alt = "Imagen de Alvaro Acosta Rodríguez">
			</div>
			<div class="info_wrapper">
				<p>Alvaraco@ucm.es</p>
				<p>Practica padel en sus tiempos libres.</p>
				<p>Habla tres idiomas, uno de ellos es el Esperanto, en el cual tiene un nivel C1.</p>
				<p>Fue galardonado con el premio Príncipe de Asturias al mejor piloto de F-22.</p>
			</div>
		</div>
		<div class="separator">
			<h2 id="gonzalo">Gonzalo Sanz Rodríguez</h2>
			<div class="photo_wrapper">
				<img src="img/g1.jpg" alt = "Imagen de Gonzalo Sanz Rodríguez">
			</div>
			<div class="info_wrapper">
				<p>Gonzsa02@ucm.es</p>
				<p>Le gusta jugar al fortnite aunque a veces se cabrea mucho.</p>
				<p>Practica mucho deporte, incluido el padel, alguna vez ha jugado con Álvaro.</p>
			</div>
		</div>

		<div  class="separator">
			<h2 id="arturo">Arturo Pinar Adán</h2>
			<div class="photo_wrapper">
				<img src="img/ar1.jpg" alt = "Imagen de Arturo Pinar Adán">
			</div>
			<div class="info_wrapper">
				<p>apinar@ucm.es</p>
				<p>Estudiante de cuarto curso de Ingeniería Informática en la UCM.</p>
				<p> Interesado en aprender a jugar bien al padel, una de las razones por 
				las que participa en el desarrollo de Padel2U.</p>
			</div>
		</div>

		<div class="separator" >
			<h2 id="jorge">Jorge Boticario Figueras</h2>
			<div class="photo_wrapper">
				<img src="img/j1.jpg" alt = "Imagen de Jorge Boticario Figueras">
			</div>
			<div class="info_wrapper">
				<p>Jorgebot@ucm.es</p>
				<p>No se sabe mucho de él, aunque los antiguos papiros arcanos dicen que tiene un poder inmenso.</p>
				<p>Por lo que parece, no le gusta mucho el padel, pero es una persona que dice hacer bien su trabajo.</p>
			</div>
		</div>
	</div>

</body>


<?php 
require("includes/common/pie.php");
?>


</html>