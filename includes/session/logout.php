<?php
require_once("../control/SessionControl.php"); 
SessionControl::cerrarSesion(); 
SessionControl::marcarExito("Sesion cerrada."); 
header('location: ../../index.php');