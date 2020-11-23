<?php
$ruta = $_SERVER['PHP_SELF'];
if(strpos($ruta, "includes") != false){
    require_once("../model/DAOs/DAONotificaciones.php"); 
    require_once("../model/DAOs/Notificacion.php"); 
    require_once("../configuration/Definitions.php");
    require_once("../model/DAOs/DAOUsuario.php");
    require_once("../model/DAOs/Usuario.php");
    require_once("../model/DAOs/DAOTorneo.php"); 
    require_once("../model/DAOs/Torneo.php");
    require_once("../control/SessionControl.php");
}
else{
    require_once("includes/model/DAOs/DAONotificaciones.php");
    require_once("includes/model/DAOs/Notificacion.php");
    require_once("includes/configuration/Definitions.php");
    require_once("includes/model/DAOs/DAOUsuario.php");
    require_once("includes/model/DAOs/Usuario.php");
    require_once("includes/model/DAOs/DAOTorneo.php");
    require_once("includes/model/DAOs/Torneo.php");
    require_once("includes/control/SessionControl.php");
}



class NotificacionesControl{
    
    /** 
     * Permite imprimir las notificacion de un usuario generando el HTML a partir de las notificaciones que tiene ese usuario en la BD. 
     * idUsuario: id del usuario del que se van a imprimir las notificaciones. 
     *
     * Devuelve el html de las notificaciones que se mostrarán por pantalla. 
     */
    
    public static function imprimirNotificacionesUsuario($idUsuario){
        $notificaciones = array(); 
        $html = ""; 
        $notificaciones = DAONotificaciones::notifyByUser($idUsuario); 
        if(count($notificaciones) > 0){
            $html .= '<div class = "notificaciones_wrapper">'; 
            foreach($notificaciones as $clave){
                $torneo = DAOTorneo::selectById($clave->getIdTorneoEnlazado()); 
                if($torneo != NULL){
                    $asunto = self::generarAsuntoNotificacion($clave, $torneo->getNombre()); 
                    $cuerpo = self::generarCuerpo($clave); 
                    if($asunto != ERROR_APLICACION && $cuerpo != ERROR_APLICACION){
                $html .= '<div class = "notificacion_wrapper" id = "notificacion'.$clave->getId().'">'; 
                $html .= '<div class = "cabecera_wrapper">'; 
                $html .= '<div class = "asunto_wrapper first" id = "asunto_wrapper'.$clave->getId().'" onclick = "mostrarNotificacionCompleta('.$clave->getId().')">'; 
                $html .= '<h3> Asunto: '.$asunto.' </h3>'; 
                $html .= '</div>';  // asunto_wrapper
                $html .= '<div class = "button_wrapper">'; 
                $html .= '<a onclick = "borrarNotificacion('.$clave->getId().')" class = "icon-bin2"></a>';
                $html .= '</div>'; // button wrapper
                $html .= '</div>'; // cabecera
                $html .= '<div class = "cuerpo disabled" id = "cuerpo'.$clave->getId().'">'; 
                $html .= $cuerpo;
                $html .= '<div class = "button_wrapper">'; 
                $html .= '<a class = "boton rojo pequeño" onclick = "mostrarNotificacionCompleta('.$clave->getId().')"> Cerrar notificacion </a>'; 
                $html .= '</div>'; // button_wrapper
                $html .= '</div>'; // cuerpo
                $html .= '</div>'; // notificacion_wrapper
                }
                
                else{
                    $html = ERROR_APLICACION; 
                }
                }
                else{
                    $html = ERROR_APLICACION; 
                }
                
            }
        }
        else{
            $html .= '<h3> No tiene notificaciones nuevas. </h3>'; 
        }
        return $html; 
    }
    
    /** 
     * Genera el HTML del cuerpo de una notificacion(el mensaje de la notificacion) a partir de una notificacion que se le pasa. 
     *  Notificacion $notificacion: Objeto de la notificacion para imprimir por HTML
     * Devuelve el html del cuerpo de la notificacion generada. 
     */
    public static function generarCuerpo(Notificacion $notificacion){
        $html = ""; 
        switch($notificacion->getTipo()){
            case NOTIFICACION_SOLICITUD_PAREJA: 
                $html = self::imprimirSolicitudPareja($notificacion); 
                break; 
            case NOTIFICACION_ACEPTO_PAREJA: 
                $html = self::imprimirAceptarPareja($notificacion); 
                break; 
            case NOTIFICACION_DESAPUNTADO_TORNEO: 
                $html = self::imprimirNotificacionDesapuntadoTorneo($notificacion); 
                break; 
            case NOTIFICACION_RECHAZO_PAREJA: 
                $html = self::imprimirNotificacionRechazoPareja($notificacion); 
                break; 
            case NOTIFICACION_PARTIDO_PROXIMO: 
                $html = self::imprimirNotificacionPartidoProximo($notificacion); 
                break; 
        }
        return $html; 
    }
    
    /** 
     * Genera el HTML de una notificacion de partido proximo. 
     * @param Notificacion $notificacion
     * Devuelve el html de la notificacion o ERROR_APLICACION si algo no ha salido bien. 
     */
    public static function imprimirNotificacionPartidoProximo(Notificacion $notificacion){
        $html = ""; 
        $usuarioPareja = DAOUsuario::selectById($notificacion->getIdUsuarioEnlazado()); 
        $torneo = DAOTorneo::selectById($notificacion->getIdTorneoEnlazado()); 
        $partido = DAOPartidosTorneos::selectById($notificacion->getIdPartidoTorneoEnlazado()); 
        if($torneo != NULL && $usuarioPareja != NULL && $partido != NULL){
            $html .= '<div class = "texto_wrapper">';
            $html .= '<p> El <a onclick = "popUpPartido('.$notificacion->getIdPartidoTorneoEnlazado().','.$notificacion->getIdTorneoEnlazado().')"> partido </a> del torneo <a href = "torneoView.php?id='.
                $notificacion->getIdTorneoEnlazado().'"> '.$torneo->getNombre().' </a> que jugarás junto a <a href = "jugadorView.php?id='.
                $notificacion->getIdUsuarioEnlazado().'"> '.$usuarioPareja->getNombre().' '.$usuarioPareja->getApellido1().' '.$usuarioPareja->getApellido2().
                ' </a> está a punto de comenzar ('.$partido->getFechaInicio().' ). '; 
            $html .= '</div>'; // texto_wrapper
        }
        else{
            $html = ERROR_APLICACION; 
        }
        return $html; 
    }
    
    // ANALOGO a imprimirNotificacionPartidoProximo. 
    public static function imprimirNotificacionRechazoPareja(Notificacion $notificacion){
        $html = ""; 
        $usuarioEmisor = DAOUsuario::selectById($notificacion->getIdUsuarioEnlazado()); 
        $torneo = DAOTorneo::selectById($notificacion->getIdTorneoEnlazado()); 
        if($usuarioEmisor != NULL && $torneo != NULL){
            $html .= '<div class = "texto_wrapper">'; 
            $html .= '<p> <a href = "jugadorView.php?id='.$notificacion->getIdUsuarioEnlazado().'"> '.$usuarioEmisor->getNombre().' '.$usuarioEmisor->getApellido1().' '.
            $usuarioEmisor->getApellido2().'</a> ha rechazado tu solicitud de pareja para el torneo <a href = "torneoView.php?id='.
            $notificacion->getIdTorneoEnlazado().'"> '.$torneo->getNombre().'</a> .'; 
            $html .= '</div>'; // texto_wrapper
        }
        else{
            $html = ERROR_APLICACION; 
        }
        return $html; 
    }
    
    // ANALOGO a imprimirNotificacionPartidoProximo. 
    public static function imprimirNotificacionDesapuntadoTorneo(Notificacion $notificacion){
        $html = ""; 
        $usuarioEmisor = DAOUsuario::selectById($notificacion->getIdUsuarioEnlazado()); 
        $torneo = DAOTorneo::selectById($notificacion->getIdTorneoEnlazado()); 
        if($usuarioEmisor != NULL && $torneo != NULL){
            $html .= '<div class = "texto_wrapper">'; 
            $html .= '<p> <a href = "jugadorView.php?id='.$notificacion->getIdUsuarioEnlazado().'"> '.$usuarioEmisor->getNombre().' '.
            $usuarioEmisor->getApellido1().' '.$usuarioEmisor->getApellido2().' 
            se ha desapuntado del torneo <a href = "torneoView.php?id='.$notificacion->getIdTorneoEnlazado().' ">'.$torneo->getNombre().
            '</a> por lo consiguiente vuestra pareja se ha roto y ambos quedais descalificados del torneo. ';
            $html .= '</div>'; // texto_wrapper
        }
        else{
            $html = ERROR_APLICACION; 
        }
        return $html; 
    }
    
    
    // ANALOGO a imprimirNotificacionPartidoProximo. 
    public static function imprimirAceptarPareja(Notificacion $notificacion){
        $html = ""; 
        $usuarioEmisor = DAOUsuario::selectById($notificacion->getIdUsuarioEnlazado()); 
        $torneo = DAOTorneo::selectById($notificacion->getIdTorneoEnlazado()); 
        if($usuarioEmisor != NULL && $torneo != NULL){
            $html .= '<div class = "texto_wrapper">'; 
            $html .= '<p><a href = "jugadorView.php?id='.$notificacion->getIdUsuarioEnlazado().'">'.$usuarioEmisor->getNombre().' '.$usuarioEmisor->getApellido1().' '.$usuarioEmisor->getApellido2().'
                    </a> ha aceptado tu solicitud para formar pareja en el torneo <a href = "torneoView.php?id='.$notificacion->getIdTorneoEnlazado().' "> 
                     '.$torneo->getNombre().'. </a> Enhorabuena ya formais ambos parte del torneo. '; 
            $html .= '</div>'; // texto_wrapper
        }
        else{
            $html = ERROR_APLICACION; 
        }
        return $html; 
    }
    
    
    // ANALOGO a imprimirNotificacionPartidoProximo. 
    public static function imprimirSolicitudPareja(Notificacion $notificacion){
        $html = ""; 
        $usuarioEmisor = DAOUsuario::selectById($notificacion->getIdUsuarioEnlazado());
        $torneo = DAOTorneo::selectById($notificacion->getIdTorneoEnlazado());
        if($usuarioEmisor != NULL && $torneo != NULL){
            $html .= '<div class = "texto_wrapper">';
            $html .= '<p> <a href = "jugadorView.php?id='.$notificacion->getIdTorneoEnlazado().'">'.$usuarioEmisor->getNombre().' '.$usuarioEmisor->getApellido1().' '.$usuarioEmisor->getApellido2().'
                            </a> ha solicitado formar pareja contigo para jugar juntos el torneo <a href = "torneoView.php?id='.$notificacion->getIdTorneoEnlazado().'">
                            '.$torneo->getNombre(). '</a> ¿Aceptas la solicitud?  </p>';
            $html .= '</div>'; // texto_wrapper
            $html .= '<div class = "buttons_wrapper">';
            $html .= '<a class = "boton rojo medio" href = "includes/peticionesAjaxYRedirecciones/AnularSolicitudPareja.php?id='.$notificacion->getIdTorneoEnlazado().'
                              "> Rechazar Solicitud de Pareja </a>';
            $html .= '<a class = "boton verde medio" href = "includes/peticionesAjaxYRedirecciones/AceptarSolicitudPareja.php?id='.$notificacion->getIdTorneoEnlazado().'
                              "> Aceptar Solicitud de Pareja </a>';
            $html .= '</div>'; // buttons_wrapper
            
            
        }
        else{
            $html = ERROR_APLICACION;
        }
        return $html; 
    }
    
   
    
    
    // Genera la cabecera de la notificacion. 
    public static function generarAsuntoNotificacion(Notificacion $notificacion, $nombreTorneo){
        $asunto = ""; 
        switch($notificacion->getTipo()){
            case NOTIFICACION_ACEPTO_PAREJA: 
                $asunto = "Solicitud de pareja para ".$nombreTorneo.' aceptada. '; 
                break; 
            case NOTIFICACION_RECHAZO_PAREJA:
                $asunto = "Solicitud de pareja para ".$nombreTorneo. ' rechazada. '; 
                break; 
            case NOTIFICACION_DESAPUNTADO_TORNEO: 
                $asunto = "Has sido expulsado de ".$nombreTorneo. '. '; 
                
                break; 
            case NOTIFICACION_PARTIDO_PROXIMO: 
                $asunto = "Juegas dentro de poco un partido de ".$nombreTorneo. '.'; 
                break; 
            case NOTIFICACION_SOLICITUD_PAREJA: 
                $asunto = "Solicitud de pareja para jugar en ".$nombreTorneo. '.'; 
                break; 
        }
        
        return $asunto; 
    }
    
    
    /** 
     * Inserta una notificacion de solicitud de pareja en la BD. 
     *  $receptor: Usuario receptor de la notificacion. 
     *  $usuarioEnlazado: Usuario emisor de la notificacion. 
     *  $idTorneo: Torneo al que se ha apuntado el usuario y ha solicitado una pareja. 
     * 
     */
    public static function notificacionSolicitudPareja($receptor, $usuarioEnlazado, $idTorneo){
        $notificacion = new Notificacion(); 
        $notificacion->setTipo(NOTIFICACION_SOLICITUD_PAREJA);
        $notificacion->setUsuarioReceptor($receptor); 
        $notificacion->setIdUsuarioEnlazado($usuarioEnlazado); 
        $notificacion->setIdTorneoEnlazado($idTorneo); 
        if(($filasInsertadas = DAONotificaciones::insertNotificacion($notificacion)) == 1){
            SessionControl::marcarExito("Solicitud de pareja registrada correctamente. 
                            Recibirás una notificación cuando tu pareja responda a tu solicitud"); 
            return OPERACION_CORRECTA;
        }
        else{
            SessionControl::marcarError("En este momento estamos teniendo problemas, vuelve a intentarlo mas tarde."); 
            return ERROR_APLICACION; 
        }
    }
    
    // ANALOGO a notificacionSolicitudPareja
    public static function notificacionRechazoPareja($receptor, $usuarioEnlazado, $idTorneo){
        $notificacion = new Notificacion(); 
        $notificacion->setTipo(NOTIFICACION_RECHAZO_PAREJA);
        $notificacion->setUsuarioReceptor($receptor); 
        $notificacion->setIdUsuarioEnlazado($usuarioEnlazado); 
        $notificacion->setIdTorneoEnlazado($idTorneo); 
        if(($filasInsertadas = DAONotificaciones::insertNotificacion($notificacion)) == 1){
                return OPERACION_CORRECTA;
            }
        else{
            SessionControl::marcarError("En este momento estamos teniendo problemas, vuelve a intentarlo mas tarde. "); 
            return ERROR_APLICACION;
        }
    }
    
    // ANALOGO a notificacionSolicitudPareja
    public static function notificacionPartidoProximo($idUsuarioReceptor, $idPareja, $idTorneo, $idPartido){
        
            $notificacion = new Notificacion(); 
            $notificacion->setIdTorneoEnlazado($idTorneo); 
            $notificacion->setIdPartidoTorneoEnlazado($idPartido); 
            $notificacion->setIdUsuarioEnlazado($idPareja); 
            $notificacion->setTipo(NOTIFICACION_PARTIDO_PROXIMO); 
            $notificacion->setUsuarioReceptor($idUsuarioReceptor); 
            $texto = NULL; 
            if(($filasInsertadas = DAONotificaciones::insertNotificacion($notificacion)) == 1){
                return OPERACION_CORRECTA;
            }
            else{
                SessionControl::marcarError(TEXTO_ERROR_ESTANDAR); 
                return ERROR_APLICACION;
            }
            
            
        }
        
        
        
    
    
        // ANALOGO a notificacionSolicitudPareja
    public static function notificacionAceptoPareja($receptor, $usuarioEnlazado, $idTorneo){
        $notificacion = new Notificacion(); 
        $notificacion->setTipo(NOTIFICACION_ACEPTO_PAREJA); 
        $notificacion->setUsuarioReceptor($receptor); 
        $notificacion->setIdUsuarioEnlazado($usuarioEnlazado); 
        $notificacion->setIdTorneoEnlazado($idTorneo); 
            if(($filasInsertadas = DAONotificaciones::insertNotificacion($notificacion)) == 1){
                $notificacionEliminar = DAONotificaciones::selectByTorneoAndUsuarioReceptorAndTipo($idTorneo, $usuarioEnlazado, NOTIFICACION_SOLICITUD_PAREJA); 
                if($notificacionEliminar != NULL){
                    if(($filasEliminadas = DAONotificaciones::deleteNotificacion($notificacionEliminar->getId())) == 1){
                        return OPERACION_CORRECTA; 
                    }
                }
                else{
                    SessionControl::marcarError(TEXTO_ERROR_ESTANDAR); 
                }
            }
            else{
                SessionControl::marcarError(TEXTO_ERROR_ESTANDAR); 
                return ERROR_APLICACION; 
            }
            
            
        }
        
    
        // ANALOGO a notificacionSolicitudPareja
    public static function notificacionDesapuntadoTorneo($receptor, $usuarioEnlazado, $idTorneo){
        $notificacion = new Notificacion();
        $notificacion->setTipo(NOTIFICACION_DESAPUNTADO_TORNEO);
        $notificacion->setUsuarioReceptor($receptor);
        $notificacion->setIdUsuarioEnlazado($usuarioEnlazado);
        $notificacion->setIdTorneoEnlazado($idTorneo);
            if(($filasInsertadas = DAONotificaciones::insertNotificacion($notificacion)) == 1){
                return OPERACION_CORRECTA;
            }
            else{
                SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
                return ERROR_APLICACION;
            }
            
            
        }
    
        // ANALOGO a notificacionSolicitudPareja
    public static function obtenerSolicitudParejaPorReceptor($receptor, $idTorneo){
        return DAONotificaciones::selectByTorneoAndUsuarioReceptorAndTipo($idTorneo, $receptor, NOTIFICACION_SOLICITUD_PAREJA); 
    }
    
    // ANALOGO a notificacionSolicitudPareja
    public static function rechazarSolicitudPareja($idTorneo){
        /* Una solicitud de pareja se puede rechazar si: 
         * 1. El torneo no está en juego. 
         * 2. El usuario que la intenta eliminar es el usuario que la ha emitido O el es el receptor de ella. 
         * 3. La notificacion existe. 
         */
        $torneo = new Torneo(); 
        $idSesion = SessionControl::getIdSesion(); 
        $torneo = DAOTorneo::selectById($idTorneo); 
        if($torneo != NULL){
            $notificacionEmisor = new Notificacion(); 
            $notificacionReceptor = new Notificacion(); 
            $notificacion = new Notificacion(); 
            $notificacionEmisor = DAONotificaciones::selectByTorneoAndUsuarioEnlazadoAndTipo($idTorneo, $idSesion, NOTIFICACION_SOLICITUD_PAREJA); 
            $notificacionReceptor = DAONotificaciones::selectByTorneoAndUsuarioReceptorAndTipo($idTorneo, $idSesion, NOTIFICACION_SOLICITUD_PAREJA); 
            if($notificacionEmisor != NULL || $notificacionReceptor != NULL){ /* El usuario puede eliminar la notificacion */ 
                if($notificacionReceptor != NULL){ // la solicitud de pareja es rechazada y por lo tanto se notifica al usuario emisor. 
                    self::notificacionRechazoPareja($notificacionReceptor->getIdUsuarioEnlazado(), $idSesion, $notificacionReceptor->getIdTorneoEnlazado());
                    $notificacion = $notificacionReceptor; 
                }
                else{
                    $notificacion = $notificacionEmisor; 
                }
                // la solicitud de pareja es anulada y no hace falta notificar al otro extremo. 
                    if(($filas = DAONotificaciones::deleteNotificacion($notificacion->getId())) == 1){
                        SessionControl::marcarExito("Solicitud rechazada/anulada"); 
                        return OPERACION_CORRECTA; 
                    }
                    else{
                        SessionControl::marcarError("Error al eliminar tu solicitud: La aplicacion no funciona correctamente en este momento."); 
                    }
                
            }
            else{
                SessionControl::marcarError("Error al eliminar tu solicitud: No tienes permiso para acceder a este torneo, puesto que no eres un participante. ");
            }
        }
        else{
            SessionControl::marcarError("Error al eliminar tu solicitud: El torneo al que haces referencia no existe. "); 
        }
        
        return ERROR_APLICACION;
    }
    
    // Borra la notificacion que corresponda con idNotificacion en la BD. 
    public static function borrarNotificacionUsuario($idNotificacion){
        /** 
         * 1. Comprobar que el usuario puede borrar la notificacion: 
         * a) El usuario esta logeado. 
         * b) El usuario es receptor de la notificacion recibida. 
         * c) La notificacion existe.
         */
        
        $idSesion = SessionControl::getIdSesion(); 
        if($idSesion != NULL){
            $notificacion = DAONotificaciones::selectById($idNotificacion);
            if($notificacion != NULL){
                $usuarioReceptor = $notificacion->getUsuarioReceptor(); 
                if($usuarioReceptor == $idSesion){
                    // Procedemos al borrado de la notificacion: 
                    if(($filasBorradas = DAONotificaciones::deleteNotificacion($idNotificacion)) == 1){
                        return OPERACION_CORRECTA; 
                    }
                    else{
                        SessionControl::marcarError(TEXTO_ERROR_ESTANDAR); 
                    }
                }
                else{
                    SessionControl::marcarError("No puedes borrar una notificacion que no es tuya. "); 
                }
            }
            else{
                SessionControl::marcarError("Error en el borrado de la notificacion: La notificacion no existe. "); 
            }
            
        }
        else{
            SessionControl::marcarError("No puedes borrar una notificacion sin haber iniciado sesion. "); 
        }
        
        
        return ERROR_APLICACION; 
    }
    
    // Resuelve inconsistencias en la BD de integridad.
    public static function borrarUltimaFilaInsertada(){
        $idBorrar = DAONotificaciones::obtenerUltimoIdNotificacion();
        if(($filas = DAONotificaciones::deleteNotificacion($idBorrar)) == 1){
            return OPERACION_CORRECTA;
        }
        else{
            return ERROR_APLICACION;
        }
    }
    
    
    
}