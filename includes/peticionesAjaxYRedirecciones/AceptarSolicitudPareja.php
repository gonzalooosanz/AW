<?php
require_once("../forms/UserEntrySecurity.php"); 
require_once("../control/SessionControl.php");
require_once("../model/DAOs/Notificacion.php");
require_once("../control/NotificacionesControl.php"); 
require_once("../control/TorneosControl.php");
require_once("../configuration/Definitions.php");
require_once("../control/TorneosControl.php");

/** PASOS DE DESARROLLO: 
 * 1. Comprobar que la notificacion(solicitud de pareja) existe (idTorneo = idURL y UsuarioReceptor = idSesion, tipo = NOTIFICACION_SOLICITUD_PAREJA). 
 * 2. Comprobar que el usuario que acepta la solicitud puede apuntarse al torneo. 
 * 3. Comprobar que el usuario que envió la solicitud puede apuntarse al torneo. 
 * 4. Aumentar 1 pareja mas apuntada en el campo numParejas de la tabla Torneos para indicar que se ha unido una pareja mas. 
 * 5. Insertar la pareja nueva formada por los dos usuarios en la tabla Parejas. 
 * 6. Notificar al usuario que envió la solicitud de pareja que ha sido aceptado en el torneo.
 */

// PASO 1: 

if(isset($_GET['id']) && $_GET['id'] != NULL){
    $idTorneo = UserEntrySecurity::asegurarEntradaUsuario($_GET['id']); 
    $notificacion = NULL; 
    $idSesion = SessionControl::getIdSesion(); 
    if($idSesion != NULL){
        $notificacion = NotificacionesControl::obtenerSolicitudParejaPorReceptor($idSesion, $idTorneo); 
        if($notificacion != NULL){ // La notificacion para el usuario que la esta aceptando y para el torneo al que hace referencia existe.
            // PASO 2: 
            $comprobacionesSesion = TorneosControl::comprobarApuntarseTorneo($idTorneo, $idSesion); 
            $comprobacionesPareja = TorneosControl::comprobarApuntarseTorneo($idTorneo, $notificacion->getIdUsuarioEnlazado()); 
            $error = 'Vaya parece que tu o tu pareja no podeis apuntaros a este torneo. Recuerda que eso puede deberse a muchas causas: \n: 
                        1. El torneo no exista actualmente en Padel2u. </br>
                        2. Para apuntarte a un torneo debes haber iniciado sesion. </br>
                        3. Tu o tu pareja necesitais tener por lo menos la efectividad requerida por el torneo. </br>
                        4. El torneo puede estar lleno. </br>
                        5. La fecha limite de inscripcion puede haber ya pasado.';
            
            if(($comprobacionesSesion == COMPROBACION_CORRECTA || $comprobacionesSesion == ERROR_USUARIO_PENDIENTE_ACEPTACION_TORNEO || $comprobacionesSesion == ERROR_USUARIO_PENDIENTE_ACEPTAR_SOLICITUD_PAREJA) 
                && ($comprobacionesPareja == COMPROBACION_CORRECTA || $comprobacionesPareja == ERROR_USUARIO_PENDIENTE_ACEPTACION_TORNEO || $comprobacionesPareja == ERROR_USUARIO_PENDIENTE_ACEPTAR_SOLICITUD_PAREJA)){ // Ambos usuarios pueden apuntarse al torneo. 
               $comprobacion = TorneosControl::apuntarseTorneo($idSesion, $notificacion->getIdUsuarioEnlazado(), $idTorneo);  
            }
            else{
                SessionControl::marcarError($error); 
            }
            
            
        }
        else{
            SessionControl::marcarError(" ERROR: La solicitud de pareja que estás aceptando parece no existir en la BD de Padel2u. "); 
        }
    
        
        
        
        
    }
    else{
        SessionControl::marcarError("ERROR: No puedes apuntarte a un torneo sin haber iniciado sesion en Padel2u"); 
    }






}
else{
    SessionControl::marcarError("No puedes cambiar el torneo al que quieres apuntarte por la URL!!");
}





header('location: ../../torneosView.php'); 
