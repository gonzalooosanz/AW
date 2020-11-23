<?php
require_once("../control/SessionControl.php"); 
require_once("../control/TorneosControl.php"); 
require_once("../forms/UserEntrySecurity.php"); 


/** Pasos para desapuntarse de un torneo. 
 * 1. Comprobar que el usuario esta logeado. 
 * 2. 
 */

if(isset($_GET['id']) && $_GET['id'] != NULL){
    $idTorneo = UserEntrySecurity::asegurarEntradaUsuario($_GET['id']); 
    $idSesion = SessionControl::getIdSesion(); 
    if($idSesion != NULL){ // usuario logeado. 
        $comprobacion = TorneosControl::comprobarDesapuntarseTorneo($idTorneo, $idSesion); 
        if($comprobacion == COMPROBACION_CORRECTA){ // el usuario y su pareja pueden desapuntarse del torneo. 
            TorneosControl::desapuntarseTorneo($idSesion, $idTorneo); 
        }
    }
    else{
        SessionControl::marcarError("ERROR: Tienes que haber iniciado sesion para desapuntarte de un torneo. "); 
    }
    
    
    
}
else{
    SessionControl::marcarError("ERROR: No existe el torneo del cual te quieres desapuntar. "); 
}

header('location: ../../torneosView.php');


