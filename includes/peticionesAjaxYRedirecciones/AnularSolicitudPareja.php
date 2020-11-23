<?php

require_once("../control/NotificacionesControl.php");
require_once("../forms/UserEntrySecurity.php");

NotificacionesControl::rechazarSolicitudPareja(UserEntrySecurity::asegurarEntradaUsuario($_GET['id'])); 
header('location: ../../torneosView.php'); 


