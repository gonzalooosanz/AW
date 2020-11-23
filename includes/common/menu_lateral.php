
<?php 
    $seccion = SessionControl::getSeccion(); 
?>
<div class = "lateral_menu_wrapper">
<span class="icon-menu" onclick = "gestionarMenuLateral()"></span>
<div class = "lateral_wrapper" id = "menu_lateral">
	<?php if($seccion == SECCION_PERFIL){?>
	<div class = "option">
		<span class="icon-user"></span>
		<a href = 'miCuentaView.php?section="cuenta"'> Datos de Tu Cuenta </a>
	</div>
	<div class = "option">
		<span class="icon-file-text"></span>
		<a href = 'miCuentaView.php?section="estadisticas"'> Mis Estadisticas </a>
	</div>
	<div class = "option">
		<span class="icon-rocket"></span>
		<a href = 'miCuentaView.php?section="eventos"'> Eventos en los que estoy apuntado </a>
	</div>
	<div class = "option">
		<span class="icon-users"></span>
		<a href = 'miCuentaView.php?section="parejas"'> Mis parejas de juego </a>
	</div>
	<div class = "option">
		<span class="icon-bell"></span>
		<a href = 'miCuentaView.php?section="notificaciones"'> Notificaciones </a>
	</div>
	<?php }
	else if($seccion == SECCION_JUGADOR){
	?>
	<div class = "option">
		<span class="icon-user"></span>
		<a href = 'jugadorView.php?section="datos"'> Datos personales </a>
	</div>
	<div class = "option">
		<span class="icon-file-text"></span>
		<a href = 'jugadorView.php?section="estadisticas"'> Estadisticas personales</a>
	</div>
	<?php }
	else if($seccion == SECCION_PARTIDO){
	?>
	
	<div class = "option">
		<span class="icon-file-text"></span>
		<a href = 'partidoView.php?section="datos"'>Informacion general</a>
	</div>
	<div class = "option">
		<span class="icon-users"></span>
		<a href = 'partidoView.php?section="inscritos"'> Inscritos </a>
	</div>
	
	<div class = "option">
		<span class="icon-stats-dots"></span>
		<a href = 'partidoView.php?section="resultados"'> Resultados </a>
	</div>
	
	<div class = "option">
		<span class="icon-pencil"></span>
		<a href = 'partidoView.php?section="subir_puntuaciones"'> Sube aqui tus puntuaciones </a>
	</div>
	
	<div class = "option">
		<span class="icon-image"></span>
		<a href = 'partidoView.php?section="imagenes"'> Imagenes </a>
	</div>
	<?php }
	else if($seccion == SECCION_TORNEO){
	?>
	<div class = "option">
		<span class="icon-user"></span>
		<a href = 'torneoView.php?section="datos"'> Datos generales </a>
	</div>
	<div class = "option">
		<span class="icon-users"></span>
		<a href = 'torneoView.php?section="inscritos"'> Inscritos </a>
	</div>
	<div class = "option">
		<span class="icon-stats-dots"></span>
		<a href = 'torneoView.php?section="resultados"'>Resultados</a>
	</div>
	<div class = "option">
		<span class="icon-image"></span>
		<a href = 'torneoView.php?section="imagenes"'> Imagenes </a>
	</div>
	<?php }?>
</div>
</div>