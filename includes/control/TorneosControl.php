<?php
$ruta = $_SERVER['PHP_SELF'];
if (strpos($ruta, "includes") != false) {
    require_once ("../model/DAOs/DAOTorneo.php");
    require_once ("../model/DAOs/Torneo.php");
    require_once ("../model/DAOs/DAOUsuario.php");
    require_once ("../model/DAOs/Usuario.php");
    require_once ("../configuration/Definitions.php");
    require_once ("../control/SessionControl.php");
    require_once ("../model/DAOs/DAOParejas.php");
    require_once ("../model/DAOs/Parejas.php");
    require_once ("../resources/DateOperations.php");
    require_once ("../model/DAOs/DAONotificaciones.php");
    require_once ("../model/DAOs/Notificacion.php");
    require_once ("../resources/MathematicOperations.php");
    require_once ("../control/NotificacionesControl.php");
    require_once ("../control/ParejasControl.php");
    require_once ("../model/DAOs/DAOPartidosTorneos.php");
    require_once ("../model/DAOs/PartidosTorneos.php");
} else {
    require_once ("includes/model/DAOs/DAOTorneo.php");
    require_once ("includes/model/DAOs/Torneo.php");
    require_once ("includes/model/DAOs/DAOUsuario.php");
    require_once ("includes/model/DAOs/Usuario.php");
    require_once ("includes/configuration/Definitions.php");
    require_once ("includes/control/SessionControl.php");
    require_once ("includes/model/DAOs/DAOParejas.php");
    require_once ("includes/model/DAOs/Parejas.php");
    require_once ("includes/resources/DateOperations.php");
    require_once ("includes/model/DAOs/DAONotificaciones.php");
    require_once ("includes/model/DAOs/Notificacion.php");
    require_once ("includes/resources/MathematicOperations.php");
    require_once ("includes/control/NotificacionesControl.php");
    require_once ("includes/control/ParejasControl.php");
    require_once ("includes/model/DAOs/DAOPartidosTorneos.php");
    require_once ("includes/model/DAOs/PartidosTorneos.php");
}

class TorneosControl
{

    public static function comprobarDesapuntarseTorneo($idTorneo, $idUsuario)
    {
        /**
         * Un usuario puede desapuntarse de un torneo si:
         * 1.
         * Usuario logeado.
         * 2. El torneo existe.
         * 3. El usuario esta apuntado al torneo y su pareja igual.
         * 4. El torneo no se ha cerrado (fechaActual < fechaInscripcion).
         */
        
        // PASO 1:
        $usuario = NULL;
        $usuario = DAOUsuario::selectById($idUsuario);
        $torneo = DAOTorneo::selectById($idTorneo);
        if ($usuario != NULL) { // el usuario esta logeado.
                                // PASO 2:
            if ($torneo != NULL) { // el torneo existe.
                                   // PASO 3:
                $parejaIzquierdo = NULL;
                $parejaDerecho = NULL;
                $pareja = NULL;
                $parejaIzquierdo = DAOParejas::selectByIntegrante1AndTorneoAndEnVigor($idUsuario, $idTorneo, 1);
                $parejaDerecho = DAOParejas::selectByIntegrante2AndTorneoAndEnVigor($idUsuario, $idTorneo, 1);
                if ($parejaIzquierdo != NULL || $parejaDerecho != NULL) { // el usuario esta apuntado al torneo y su pareja, por consiguiente, tambien.
                    if ($parejaIzquierdo != NULL) {
                        $pareja = $parejaIzquierdo;
                    } else {
                        $pareja = $parejaDerecho;
                    }
                    // PASO 4:
                    $cerrado = $torneo->getCerrado();
                    $hoy = DateOperations::getTodayDate();
                    $fechaInscripcion = $torneo->getFechaInscripcion();
                    if ($cerrado == false && $fechaInscripcion > $hoy) { // el torneo no esta cerrado.
                        return COMPROBACION_CORRECTA;
                    } else {
                        SessionControl::marcarError("Vaya!! Lo sentimos pero no puedes desapuntarte de un torneo que ya ha comenzado. ");
                    }
                } else {
                    SessionControl::marcarError("No puedes desapuntarte de un torneo del cual no formas parte. ");
                }
            } else {
                SessionControl::marcarError("No se ha encontrado el torneo del cual quieres desapuntarte. ");
            }
        } else {
            SessionControl::marcarError("No puedes desapuntarte de un torneo sin iniciar sesion. ");
        }
        
        return ERROR_APLICACION;
    }
    
    public static function actualizarResultadosPartido($idPartido, $puntuacionString){
        /** Pasos para actualizar la puntuacion de un partido de un torneo: 
         * 1. Actualizar la puntuacion en el partido. 
         * 2. Actualizar la efectividad de cada jugador. 
         * 3. Actualizar la efectividad de cada pareja. 
         * 
         */
        
        // PASO 1: 
        $partido = DAOPartidosTorneos::selectById($idPartido); 
        $puntuacion = array(); 
        $puntuacion = preg_split('/\s/', $puntuacionString, null, PREG_SPLIT_OFFSET_CAPTURE); 
        
        $pareja1 = DAOParejas::selectById($partido->getPareja1());
        $pareja2 = DAOParejas::selectById($partido->getPareja2());
        $usuario1 = DAOUsuario::selectById($pareja1->getIdIntegrante1());
        $usuario2 = DAOUsuario::selectById($pareja1->getIdIntegrante2());
        $usuario3 = DAOUsuario::selectById($pareja2->getIdIntegrante1());
        $usuario4 = DAOUsuario::selectById($pareja2->getIdIntegrante2());
        $efectividad1 = 0; 
        $efectividad2 = 0; 
        $efectividad3 = 0;
        $efectividad4 = 0; 
        $efectividadp1 = 0; 
        $efectividadp2 = 0; 
        if($partido != NULL && count($puntuacion) == 2){
            
            $partido->setResultados($puntuacionString); 
            if($puntuacion[0] > $puntuacion[1]){
                $partido->setParejaGanadora($partido->getPareja1());
                $efectividad1 = $usuario1->getEfectividad() + 3; 
                if($efectividad1 < 0){
                    $efectividad1 = 1;
                }
                $usuario1->setEfectividad($efectividad1); 
                $efectividad2 = $usuario2->getEfectividad() + 3; 
                if($efectividad2 < 0){
                    $efectividad2 = 1;
                }
                $usuario2->setEfectividad($efectividad2); 
                $efectividad3 = $usuario3->getEfectividad() - 1; 
                if($efectividad3 < 0){
                    $efectividad3 = 1;
                }
                $usuario3->setEfectividad($efectividad3); 
                $efectividad4 = $usuario4->getEfectividad() - 1;
                if($efectividad4 < 0){
                    $efectividad4 = 1;
                }
                $usuario4->setEfectividad($efectividad4); 
                $efectividadp1 = $pareja1->getEfectividad() + 3; 
                if($efectividadp1 < 0){
                    $efectividadp1 = 1;
                }
                $pareja1->setEfectividad($efectividadp1); 
                $efectividadp2 = $pareja2->getEfectividad() - 1; 
                if($efectividadp2 < 0){
                    $efectividadp2 = 1;
                }
                $pareja2->setEfectividad($efectividadp2); 
            }
            else if($puntuacion[0] < $puntuacion[1]){
                $partido->setParejaGanadora($partido->getPareja2()); 
                $efectividad1 = $usuario1->getEfectividad() - 1;
                if($efectividad1 < 0){
                    $efectividad1 = 1; 
                }
                $usuario1->setEfectividad($efectividad1); 
                $efectividad2 = $usuario2->getEfectividad() - 1;
                if($efectividad2 < 0){
                    $efectividad2 = 1;
                }
                $usuario2->setEfectividad($efectividad2); 
                $efectividad3 = $usuario3->getEfectividad() + 3;
                if($efectividad3 < 0){
                    $efectividad3 = 1;
                }
                $usuario3->setEfectividad($efectividad3); 
                $efectividad4 = $usuario4->getEfectividad() + 3;
                if($efectividad4 < 0){
                    $efectividad4 = 1;
                }
                $usuario4->setEfectividad($efectividad4); 
                $efectividadp1 = $pareja1->getEfectividad() - 1;
                if($efectividadp1 < 0){
                    $efectividadp1 = 1;
                }
                $pareja1->setEfectividad($efectividadp1); 
                $efectividadp2 = $pareja2->getEfectividad() + 3; 
                if($efectividadp2 < 0){
                    $efectividadp2 = 1;
                }
                $pareja2->setEfectividad($efectividadp2); 
            }
            else{
                $partido->setParejaGanadora(NULL); 
            }
            
            if(($updatePartido = DAOPartidosTorneos::updatePartido($partido)) == 1){
                if(($updateUsuario1 = DAOUsuario::updateUser($usuario1)) == 1){
                    if(($updateUsuario2 = DAOUsuario::updateUser($usuario2)) == 1){
                        if(($updateUsuario3 = DAOUsuario::updateUser($usuario3)) == 1){
                            if(($updateUsuario4 = DAOUsuario::updateUser($usuario4)) == 1){
                                if(($updatePareja1 = DAOParejas::updatePareja($pareja1)) == 1){
                                    if(($updatePareja2 = DAOParejas::updatePareja($pareja2)) == 1){
                                        SessionControl::marcarExito("Puntuacion cambiada"); 
                                        return OPERACION_CORRECTA; 
                                    }
                                }
                            }
                        }
                    }
                }
            }
            
        }
        else{
            SessionControl::marcarError(TEXTO_ERROR_ESTANDAR); 
        }
        SessionControl::marcarError(TEXTO_ERROR_ESTANDAR); 
        return ERROR_APLICACION; 
    }

    public static function datosTorneo(Torneo $torneo, $partidos = array(), $parejas = array(), $operation)
    {
        $html = "";
        // 1. Comprobaciones:
        $cPartidos = count($partidos);
        $cParejas = count($parejas);
        $tipoSesion = SessionControl::tipoUsuarioLogeado(); 
        if ($operation == OPERACION_DATOS_TORNEO && $torneo != NULL) {} 
        else if ($operation == OPERACION_PARTIDOS_TORNEO_SIN_FILTRO && ($cPartidos > 0) && $torneo != NULL && $parejas != NULL) {
            $rondaAnterior = 0;
            
            foreach ($partidos as $clave) {
                if($clave->getPareja1() != NULL && $clave->getPareja2()){
                $pareja1 = DAOParejas::selectById($clave->getPareja1());
                $pareja2 = DAOParejas::selectById($clave->getPareja2());
                $usuario1 = DAOUsuario::selectById($pareja1->getIdIntegrante1());
                $usuario2 = DAOUsuario::selectById($pareja1->getIdIntegrante2());
                $usuario3 = DAOUsuario::selectById($pareja2->getIdIntegrante1());
                $usuario4 = DAOUsuario::selectById($pareja2->getIdIntegrante2());
                $ronda = $clave->getRonda();
                $rondaStr = "";
                $resultadosStr = "";
                $maxRondas = $torneo->getMaxRondas();
                if ($ronda == $maxRondas) {
                    $rondaStr = " Finales";
                } else if ($ronda == $maxRondas - 1) {
                    $rondaStr = " Semifinales";
                } else if ($ronda == $maxRondas - 2) {
                    $rondaStr = " Cuartos de Final ";
                }
                else{
                    $rondaStr = "";
                }
                if (($res = $clave->getResultados()) == NULL) {
                    $resultadosStr = "No se han publicado todavia. ";
                } else {
                    $resultadosStr = $clave->getResultados();
                }
                
                if ($rondaAnterior != $clave->getRonda()) {
                    if ($clave->getRonda() != 1) {
                        $html .= '</table>';
                        $html .= '</div>';
                    }
                    $html .= '<div class = "ronda_wrapper">';
                    if($rondaStr != ""){
                        $html .= '<h3> '.$rondaStr.' </h3>'; 
                    }
                    else{
                        $html .= '<h3> Ronda ' . $clave->getRonda().' </h3>';
                    }
                        
                    $html .= '<table class = "ronda_table"';
                    $html .= '<tr>';
                    $html .= '<th> Nombre del partido </th>
                              <th> Lugar donde tendrá lugar </th>
                              <th> Pareja 1 </th>
                              <th> VS </th>
                              <th> Pareja 2 </th>
                              <th> Ronda del partido </th> 
                              <th> Resultados </th>
                              </tr>';
                    $rondaAnterior = $rondaAnterior + 1; 
                }
                $html .= '<tr>
                               <td>' . $clave->getNombre() . '</td>
                               <td>' . $torneo->getDireccion() . ' <span class = "ciudad">' . $torneo->getCiudad() . '</span><span class = "provincia"> ' . $torneo->getProvincia() . '</span>  </td>
                               <td>' . $usuario1->getNombre() . ' ' . $usuario1->getApellido1() . ' y ' . $usuario2->getNombre() . ' ' . $usuario2->getApellido1() . '</td>
                               <td> </td>
                               <td>' . $usuario3->getNombre() . ' ' . $usuario3->getApellido1() . ' y ' . $usuario4->getNombre() . ' ' . $usuario4->getApellido1() . ' </td>
                               <td>' . $clave->getRonda() . ' ( ' . $rondaStr . ' ) </td>
                               <td>' . $resultadosStr . '</td>';
                if ((($res = $clave->getResultados()) == NULL) && (($cerrado = $torneo->getCerrado()) == true) && $tipoSesion == USUARIO_ARBITRO) {
                    $html .= '<td> <a href = "editarResultadosTorneo.php?id='.$clave->getId().'" class = "boton azul pequeño"> Editar </a> </td>';
                }
                $html .= '</tr>';
                }
                else{
                    $pareja1 = DAOParejas::selectById($clave->getPareja1());
                    $usuario1 = DAOUsuario::selectById($pareja1->getIdIntegrante1());
                    $usuario2 = DAOUsuario::selectById($pareja1->getIdIntegrante2());
                    $html .= '<p> Los jugadores '.$usuario1->getNombre().' '.$usuario1->getApellido1().' y '.$usuario2->getNombre().' '.$usuario2->getApellido1().' pasan de ronda por falta de parejas rivales. </p>';
                }
            }
            
        }
        return $html;
    }
    

    public static function comprobarApuntarseTorneo($idTorneo, $idUsuario)
    {
        /*
         * Condiciones para que el usuario de la sesion pueda apuntarse:
         * 1. Usuario logeado y no arbitro.
         * 2. EfectividadUsuarioSesion >= efectividadRequeridaPorElTorneo.
         * 3. Torneo no lleno: numJugadores < maxJugadores.
         * 4. Torneo no cerrado: cerrado = false y fechaInscripcion >= fechaHoy.
         * 5. UsuarioSesion no está apuntado ya al torneo.
         */
        $errores = "";
        $torneo = new Torneo();
        $torneo = DAOTorneo::selectById($idTorneo);
        $usuario = new Usuario();
        $usuario = DAOUsuario::selectById($idUsuario);
        if ($torneo == NULL) {
            return ERROR_TORNEO_CERRADO;
        }
        if ($usuario == NULL) {
            return ERROR_APLICACION;
        }
        
        /* 1. Usuario logeado y no arbitro */
        if (($usuarioArbitro = $usuario->getArbitro()) == false) {
            /* 2. EfectividadUsuarioSesion >= efectividadRequeridaPorElTorneo. */
            $efectividadUsuario = $usuario->getEfectividad();
            $efectividadTorneo = $torneo->getEfectividadRequerida();
            if ($efectividadUsuario >= $efectividadTorneo) {
                /* 3. Torneo no lleno: numJugadores < maxJugadores */
                $numJugadores = $torneo->getnumParejas();
                $maxParejas = $torneo->getmaxParejas();
                if ($numJugadores < $maxParejas) {
                    /* 4. Torneo no cerrado: */
                    $cerrado = $torneo->getCerrado();
                    $fechaInscripcion = $torneo->getFechaInscripcion();
                    $hoy = DateOperations::getTodayDate();
                    if ($cerrado == false && $fechaInscripcion > $hoy) {
                        /* 5. UsuarioSesion no está apuntado ya al torneo */
                        $ladoIzquierdo = DAOParejas::selectByIntegrante1AndTorneoAndEnVigor($idUsuario, $idTorneo, 1);
                        $ladoDerecho = DAOParejas::selectByIntegrante2AndTorneoAndEnVigor($idUsuario, $idTorneo, 1);
                        /*
                         * El usuario de la sesion no puede pertenecer a ningun par con el idTorneo asociado a este torneo
                         * Para garantizar eso hace falta comprobar el integrante1 de todas las parejas y el integrante2.
                         */
                        if ($ladoIzquierdo == NULL && $ladoDerecho == NULL) {
                            /* 6. Comprobacion de que el usuario no esta pendiente de aceptacion de pareja para participar en el torneo */
                            $notificacion = DAONotificaciones::selectByTorneoAndUsuarioEnlazadoAndTipo($idTorneo, $idUsuario, NOTIFICACION_SOLICITUD_PAREJA);
                            if ($notificacion == NULL) {
                                /* 7. Comprobacion de que el usuario no esta pendiente de aceptar una solicitud de pareja */
                                $notif = DAONotificaciones::selectByTorneoAndUsuarioReceptorAndTipo($idTorneo, $idUsuario, NOTIFICACION_SOLICITUD_PAREJA);
                                if ($notif == NULL) {
                                    return COMPROBACION_CORRECTA;
                                } else {
                                    return ERROR_USUARIO_PENDIENTE_ACEPTAR_SOLICITUD_PAREJA;
                                }
                            } else {
                                return ERROR_USUARIO_PENDIENTE_ACEPTACION_TORNEO;
                            }
                        } else {
                            return ERROR_USUARIO_APUNTADO_TORNEO;
                        }
                    } else {
                        return ERROR_TORNEO_CERRADO;
                    }
                } else {
                    return ERROR_TORNEO_LLENO;
                }
            } else {
                return ERROR_EFECTIVIDAD_INSUFICIENTE;
            }
        } else {
            if(($usuarioArbitro = $usuario->getArbitro()) == true){
                $fechaInscripcion = $torneo->getFechaInscripcion();
                $hoy = DateOperations::getTodayDate();
                $cerrado = $torneo->getCerrado(); 
                if($cerrado == false && $fechaInscripcion > $hoy){
                    return ARBITRO_EDITAR_TORNEO;
                }
            }
            return ERROR_USUARIO_NO_LOGEADO;
        }
    }

    // Pre: Ambos usuarios ya son validados como que pueden apuntarse a torneo.
    public static function apuntarseTorneo($idUsuario1, $idUsuario2, $idTorneo)
    {
        /**
         * Se lleva a cabo a traves de los siguientes pasos:
         * 1.
         * Aumentar 1 pareja mas apuntada en el campo numParejas de la tabla Torneos para indicar que se ha unido una pareja mas.
         * 2. Insertar la pareja nueva formada por los dos usuarios en la tabla Parejas.
         * 3. Notificar al usuario que envió la solicitud de pareja que ha sido aceptado en el torneo.
         * En el caso de que no se cumpla cualquier paso anterior resolvemos las inconsistencias generadas en la BD.
         */
        // PASO 1:
        $torneo = NULL;
        $usuario1 = NULL;
        $usuario2 = NULL;
        $usuario1 = DAOUsuario::selectById($idUsuario1);
        $usuario2 = DAOUsuario::selectById($idUsuario2);
        $torneo = DAOTorneo::selectById($idTorneo);
        if ($torneo != NULL && $usuario1 != NULL && $usuario2 != NULL) {
            $numParejas = $torneo->getnumParejas();
            $numParejas = $numParejas + 1;
            $torneo->setnumParejas($numParejas);
            if (($filas = DAOTorneo::updateTorneo($torneo)) == 1) {
                // PASO 2:
                $pareja = new Parejas();
                $pareja->setEfectividad(MathematicOperations::calcularMedia($usuario1->getEfectividad() + $usuario2->getEfectividad(), 2));
                $pareja->setEnVigor(true);
                $pareja->setIdIntegrante1($idUsuario1);
                $pareja->setIdIntegrante2($idUsuario2);
                $pareja->setTorneoAsociado($idTorneo);
                if (($filas = DAOParejas::insertPareja($pareja)) == 1) {
                    // PASO 3:
                    $comprobaciones = NotificacionesControl::notificacionAceptoPareja($idUsuario2, $idUsuario1, $idTorneo);
                    if ($comprobaciones == OPERACION_CORRECTA) {
                        SessionControl::marcarExito('Enhorabuena, ya formas parte de este torneo junto con ' . $usuario2->getNombre() . '. Recordad que la fecha de inicio es: ' . $torneo->getFechaInicio() . '. ');
                        return OPERACION_CORRECTA;
                    } else { // resolucion de inconsistencias en la BD: Revierte el paso 1 y paso 2.
                        if (($comprobaciones = ParejasControl::borrarUltimaFilaInsertada()) == COMPROBACION_CORRECTA) {
                            $numParejas = $numParejas - 1;
                            $torneo->setnumParejas($numParejas);
                            if (($filasActualizadas = DAOTorneo::updateTorneo($torneo)) == 1) {
                                SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
                            } else { // inconsistencia generada por el paso 1 no resuelta.
                                SessionControl::marcarError(TEXTO_ERROR_GRAVE);
                            }
                        } else {
                            SessionControl::marcarError(TEXTO_ERROR_GRAVE);
                        }
                    }
                } else { // resolucion de inconsistencias en la BD: Revierte el paso 1.
                    $numParejas = $numParejas - 1;
                    $torneo->setnumParejas($numParejas);
                    if (($filasActualizadas = DAOTorneo::updateTorneo($torneo)) == 1) {
                        SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
                    } else { // inconsistencia generada por el paso 1 no resuelta.
                        SessionControl::marcarError(TEXTO_ERROR_GRAVE);
                    }
                }
            } else {
                SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
            }
        } else {
            SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
        }
        
        return ERROR_APLICACION;
    }

    // Pre: Validado que el usuario y su pareja pueden desapuntarse del torneo.
    public static function desapuntarseTorneo($idUsuario, $idTorneo)
    {
        /**
         * Pasos para desapuntarse de un torneo:
         * 1.
         * Reducir 1 unidad el numero de parejas apuntadas al torneo.
         * 2. Eliminar la pareja creada entre ese usuario que quiere desapuntarse y el otro jugador con el que habia formado pareja.
         * 3. Notificar al otro extremo de la pareja que el otro usuario se ha desapuntado del torneo.
         */
        $usuario = NULL;
        $torneo = NULL;
        $parejaIzquierdo = NULL;
        $pareja = NULL;
        $parejaDerecho = NULL;
        $usuario = DAOUsuario::selectById($idUsuario);
        $torneo = DAOTorneo::selectById($idTorneo);
        $parejaIzquierdo = DAOParejas::selectByIntegrante1AndTorneoAndEnVigor($idUsuario, $idTorneo, 1);
        $parejaDerecho = DAOParejas::selectByIntegrante2AndTorneoAndEnVigor($idUsuario, $idTorneo, 1);
        if (($usuario != NULL) && ($torneo != NULL) && ($parejaIzquierdo != NULL || $parejaDerecho != NULL)) {
            // PASO 1:
            $torneoAntiguo = $torneo;
            $numParejas = $torneo->getnumParejas();
            $numParejas = $numParejas - 1;
            if ($numParejas < 0) {
                SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
            } else {
                $torneo->setnumParejas($numParejas);
                if (($filas = DAOTorneo::updateTorneo($torneo)) == 1) {
                    // PASO 2:
                    if ($parejaIzquierdo != NULL) {
                        $pareja = $parejaIzquierdo;
                    } else {
                        $pareja = $parejaDerecho;
                    }
                    if (($filas = DAOParejas::deletePareja($pareja->getIdPareja())) == 1) {
                        // PASO 3:
                        $idUsuarioPareja = NULL;
                        if ($idUsuario == $pareja->getIdIntegrante1()) {
                            $idUsuarioPareja = $pareja->getIdIntegrante2();
                        } else {
                            $idUsuarioPareja = $pareja->getIdIntegrante1();
                        }
                        
                        if (($comprobaciones = NotificacionesControl::notificacionDesapuntadoTorneo($idUsuarioPareja, $idUsuario, $idTorneo)) == OPERACION_CORRECTA) {
                            $usuarioPareja = DAOUsuario::selectById($idUsuarioPareja);
                            SessionControl::marcarExito('Te has desapuntado correctamente del torneo' . $torneo->getNombre() . '
                                Recuerda que también se ha descalificado a tu pareja' . $usuarioPareja->getNombre() . ' ' . $usuarioPareja->getApellido1());
                            return OPERACION_CORRECTA;
                        } else { // Reversion del paso 1 y paso 2
                            if (($filas = DAOTorneo::updateTorneo($torneoAntiguo)) == 1) {
                                SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
                                if (($comprobacion = ParejasControl::borrarUltimaFilaInsertada()) == OPERACION_CORRECTA) {
                                    SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
                                } else {
                                    SessionControl::marcarError(TEXTO_ERROR_GRAVE);
                                }
                            } else {
                                SessionControl::marcarError(TEXTO_ERROR_GRAVE);
                            }
                        }
                    } else { // Reversion del paso 1
                        if (($filas = DAOTorneo::updateTorneo($torneoAntiguo)) == 1) {
                            SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
                        } else {
                            SessionControl::marcarError(TEXTO_ERROR_GRAVE);
                        }
                    }
                } else {
                    SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
                }
            }
        } else {
            SessionControl::marcarError(ERROR_APLICACION);
        }
        return ERROR_APLICACION;
    }

    // Resuelve inconsistencias en la BD de integridad.
    public static function borrarUltimaFilaInsertada()
    {
        $idBorrar = DAOTorneo::obtenerUltimoIdTorneo();
        if (($filas = DAOTorneo::deleteTorneo($idBorrar)) == 1) {
            return OPERACION_CORRECTA;
        } else {
            return ERROR_APLICACION;
        }
    }

    public static function parejasLibres($usuarios = array(), $idTorneo)
    {
        /* Comprueba para un array usuarios posibles para emparejar si estan libres */
        /*
         * Un usuario no puede estar emparejado si:
         * Esta emparejado con otro usuario Y la pareja pertenece al torneo idTorneo en vigor Y no es el mismo usuario que el de la sesion.
         */
        $seleccionados = array();
        $parejaIzquierdoOcupada = NULL; 
        $idSesion = SessionControl::getIdSesion();
        $parejaDerechoOcupada = NULL; 
        if ($idSesion != NULL) {
            foreach ($usuarios as $clave) {
                $parejaIzquierdoOcupada = DAOParejas::selectByIntegrante1AndTorneoAndEnVigor($clave->getIdUsuario(), $idTorneo, 1);
                $parejaDerechoOcupada = DAOParejas::selectByIntegrante2AndTorneoAndEnVigor($clave->getIdUsuario(), $idTorneo, 1);
                // Con esto obtenemos todas las parejas del usuario buscado.
                // 1. Nos quedamos con los que no estan emparejados:
              
                
                if (($parejaIzquierdoOcupada == NULL) && ($parejaDerechoOcupada == NULL) && $idSesion != $clave->getIdUsuario()) {
                    array_push($seleccionados, $clave);
                }
                // En el caso de haber cualquier pareja ocupada, el usuario ya no está libre.
            }
        } else {
            SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
        }
        return $seleccionados;
    }

    /**
     * Comprueba todos los eventos diarios referentes a torneos, por ejemplo que un torneo se cierre pasada la fecha de inscripcion
     * O por ejemplo que un torneo finalice pasada la fecha de finalizacion.
     */
    public static function eventosPeriodicosTorneos()
    {
        $torneos = array();
        $okPeriodicos = OPERACION_CORRECTA;
        $hoy = DateOperations::getTodayDate();
        $torneos = DAOTorneo::selectTorneos();
        if (count($torneos) > 0) { // solo si hay torneos comprobamos los eventos periodicos.
            foreach ($torneos as $clave) {
                // 1. ¿El torneo está cerrado y primera ronda?
                if ($hoy >= $clave->getFechaInscripcion() && (($cerrado = $clave->getCerrado()) == false)) { // el torneo se debe cerrar porque ha pasado la fecha de inscripcion. Previene que se cierre varias veces.
                    if (($comprobacion = self::primeraRonda($clave)) != OPERACION_CORRECTA) {
                        SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
                        $okPeriodicos = ERROR_APLICACION;
                    }
                }
               // Ni ultima ronda ni primera ronda: 
                if(($rondaNoAcabada = self::rondaNoAcabada($clave)) == false){
                    // La ronda i ha acabado ya que todos los partidos tienen una puntuacion establecida: 
                    if(($ok = self::rondaI($clave)) != OPERACION_CORRECTA){
                        $okPeriodicos = ERROR_APLICACION; 
                    }
                    
                }
            }
        }
    }
    
    public static function rondaI(Torneo $torneo){
        /* Pasos: 
         * 1. Obtener todos los partidos de la ronda actual del torneo. 
         * 2. Generar el array de parejasJugadoras a partir de cada pareja ganadora en cada partido. 
         * 3. Aumentar una ronda al torneo. 
         * 
         */
        // Paso 1: 
        $partidos = array(); 
        $okProccess = true; 
        $partidos = DAOPartidosTorneos::selectByTorneoAndRonda($torneo->getIdTorneo(), $torneo->getRondaActual()); 
        if(count($partidos) > 0){
            // Paso 2: 
            $parejasJugadoras = array(); 
            foreach($partidos as $clave){
                $idParejaGanadora = NULL; 
                // a) Parejas ganadoras de haber jugado un partido en la ronda anterior: 
                if(($pareja1 = $clave->getPareja1()) != NULL && ($pareja2 = $clave->getPareja2()) != NULL){
                    $idParejaGanadora = $clave->getParejaGanadora(); 
                }
                
                // b) Parejas ganadoras de haber pasado de ronda por falta de parejas: 
                else if(($pareja1 = $clave->getPareja1()) == NULL || ($pareja2 = $clave->getPareja2()) == NULL){
                   
                    if(($pareja1 = $clave->getPareja1()) != NULL){
                        $idParejaGanadora = $clave->getPareja1(); 
                    }
                    else{
                        $idParejaGanadora = $clave->getPareja2(); 
                    } 
                }
                
                $parejaGanadora = DAOParejas::selectById($idParejaGanadora);
                if($parejaGanadora != NULL){
                    array_push($parejasJugadoras, $parejaGanadora);
                }
                else{
                    SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
                    $okProccess = false; 
                }

            }
            
            if($okProccess == true){
            $rondaTorneo = $torneo->getRondaActual();
            $rondaTorneo = $rondaTorneo + 1;
            $torneo->setRondaActual($rondaTorneo);
            if(($updateFilas = DAOTorneo::updateTorneo($torneo)) == 1){
                if(($ok = self::generarRonda($parejasJugadoras, $torneo)) == OPERACION_CORRECTA){
                    return OPERACION_CORRECTA;
                }
            }
            else{
                SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
            }
            
        }
        else{
            SessionControl::marcarError(TEXTO_ERROR_ESTANDAR); 
        }
        }
        else{
            SessionControl::marcarError(TEXTO_ERROR_ESTANDAR); 
        }
        return ERROR_APLICACION; 
    }
    
    

    
    public static function rondaNoAcabada(Torneo $torneo){
        $rondaActual = $torneo->getRondaActual(); 
        $partidos = array(); 
        $partidos = DAOPartidosTorneos::selectByRonda($rondaActual); 
        $rondaNoAcabada = false; 
        $i = 0; 
        if(count($partidos) > 0){
        while($i < count($partidos) && $rondaNoAcabada == false){
            if(($res = $partidos[$i]->getResultados()) == NULL 
                && ($pareja1 = $partidos[$i]->getPareja1()) != NULL 
                && ($pareja2 = $partidos[$i]->getPareja2()) != NULL){
                $rondaNoAcabada = true; 
            }
            $i = $i + 1; 
        }
        }
        else{
            $rondaNoAcabada = true; 
        }
        return $rondaNoAcabada; 
        
    }
    
    
    public static function primeraRonda(Torneo $torneo){
        /* Pasos: 
         * 1. Cierra el torneo. 
         * 2. Obtiene las parejas jugadoras del torneo. 
         * 
         */
        if($torneo != NULL){
            $torneo->setCerrado(true); 
            $rondaActual = 1; 
            $torneo->setRondaActual($rondaActual); 
            $maxRondas = MathematicOperations::rondasMaximas($torneo->getnumParejas()); 
            $torneo->setMaxRondas($maxRondas); 
            if(($filasUpdate = DAOTorneo::updateTorneo($torneo)) == 1){
                // paso 2: 
                $parejasJugadoras = array(); 
                $parejasJugadoras = DAOParejas::selectByTorneo($torneo->getIdTorneo());
                if(count($parejasJugadoras) > MINIMO_PAREJAS_TORNEO){
                    if(($op = self::generarRonda($parejasJugadoras, $torneo)) == OPERACION_CORRECTA){
                        return OPERACION_CORRECTA; 
                    }
                    else{
                        SessionControl::marcarError(TEXTO_ERROR_ESTANDAR); 
                    }
                }
                else{
                    SessionControl::marcarExito("El torneo ha sido eliminado por falta de parejas inscritas. "); 
                    if(($filasEliminadas = DAOTorneo::deleteTorneo($torneo->getIdTorneo())) == 1){
                        return OPERACION_CORRECTA; 
                    }
                    else{
                        SessionControl::marcarError(TEXTO_ERROR_ESTANDAR); 
                    }
                }
            }
            else{
                SessionControl::marcarError(TEXTO_ERROR_ESTANDAR); 
            }
        }
        return ERROR_APLICACION; 
    }
    public static function generarRonda($parejasJugadoras = array(), Torneo $torneo){
        $lengthParejas = count($parejasJugadoras);
        $okInsercion = true;
        $restantes = $lengthParejas;
        $primeraPosicion = 0;
        $segundaPosicion = 0;
        $hoy = DateOperations::getTodayDate(); 
        $offsetDias = MathematicOperations::random_int(1, 6);
        $offsetHoras = MathematicOperations::random_int(1, 24); 
        $offsetMin = MathematicOperations::random_int(1, 60); 
        $vuelta = 1;
        $offsetHoras = 2;
        $offsetMin = 2; 
        
        
        while ($restantes > 0 && $okInsercion == true) { // En cada iteracion se genera un partido.
            
            while (($primeraPosicion) != $lengthParejas && ($parejasJugadoras[$primeraPosicion] == NULL || $primeraPosicion == $segundaPosicion)) {
                $primeraPosicion = MathematicOperations::obtenerRandom(1, $lengthParejas - 1); // LA PRIMERA PAREJA NO PUEDE SER FANTASMA.
            }
            while (($segundaPosicion != $lengthParejas) && ($parejasJugadoras[$segundaPosicion] == NULL || $primeraPosicion == $segundaPosicion)) {
                if($restantes > 1){
                    $segundaPosicion = MathematicOperations::obtenerRandom(1, $lengthParejas - 1);
                }
                else{ // si solo queda una pareja por casar pasa de ronda.
                    $segundaPosicion = $lengthParejas;
                }
                
                
            }
            $partido = new PartidosTorneos();
            
            // la primera posicion nunca puede ser fantasma.
            if ($segundaPosicion == $lengthParejas) {
                $partido->setPareja2(NULL);
                $partido->setPareja1($parejasJugadoras[$primeraPosicion]->getIdPareja());
            } else {
                $partido->setPareja1($parejasJugadoras[$primeraPosicion]->getIdPareja());
                $partido->setPareja2($parejasJugadoras[$segundaPosicion]->getIdPareja());
            }
            
            $fechaInicio = DateOperations::cambiarFecha(0, 0, $offsetDias, $offsetHoras, 45); 
            $partido->setFechaInicio($fechaInicio);
            $partido->setNombre("Partido: " . $vuelta . ". ");
            $partido->setRonda($torneo->getRondaActual());
            $partido->setTorneoAsociado($torneo->getIdTorneo());
            $offsetHoras = MathematicOperations::random_int(1, 24); 
            $offsetMin = MathematicOperations::random_int(1, 60); 
            $offsetDias = MathematicOperations::random_int(1, 6);
            $okInsercion = DAOPartidosTorneos::insertPartido($partido);
            if ($okInsercion == true) {
                // PASO 4:
                $idPareja1 = $partido->getPareja1();
                $pareja1 = DAOParejas::selectById($idPareja1);
                $usuario1 = NULL;
                $usuario2 = NULL;
                $usuario3 = NULL;
                $usuario4 = NULL;
                $idPareja2 = $partido->getPareja2();
                $idPartidoInsertado = DAOPartidosTorneos::obtenerUltimoIdPartidosTorneos();
                $pareja2 = DAOParejas::selectById($idPareja2);
                
                if ($idPareja1 != NULL && $idPareja2 != NULL) {
                    $usuario1 = $pareja1->getIdIntegrante1();
                    $usuario2 = $pareja1->getIdIntegrante2();
                    $usuario3 = $pareja2->getIdIntegrante1();
                    $usuario4 = $pareja2->getIdIntegrante2();
                    $okInsercion = NotificacionesControl::notificacionPartidoProximo($usuario1, $usuario2, $torneo->getIdTorneo(), $idPartidoInsertado);
                    if($okInsercion == true){
                    $okInsercion = NotificacionesControl::notificacionPartidoProximo($usuario2, $usuario1, $torneo->getIdTorneo(), $idPartidoInsertado);
                    }
                    if($okInsercion == true){
                    $okInsercion = NotificacionesControl::notificacionPartidoProximo($usuario3, $usuario4, $torneo->getIdTorneo(), $idPartidoInsertado);
                    }
                    if($okInsercion == true){
                    $okInsercion = NotificacionesControl::notificacionPartidoProximo($usuario4, $usuario3, $torneo->getIdTorneo(), $idPartidoInsertado);
                    }
                } else if ($idPareja1 != NULL && $idPareja2 == NULL) {
                    $usuario1 = $pareja1->getIdIntegrante1();
                    $usuario2 = $pareja1->getIdIntegrante2();
                    if($okInsercion == true){
                    $okInsercion = NotificacionesControl::notificacionPartidoProximo($usuario1, $usuario2, $torneo->getIdTorneo(), $idPartidoInsertado);
                    }
                    if($okInsercion == true){
                    $okInsercion = NotificacionesControl::notificacionPartidoProximo($usuario2, $usuario1, $torneo->getIdTorneo(), $idPartidoInsertado);
                    }
                }
                
                if($primeraPosicion < $lengthParejas){
                    $parejasJugadoras[$primeraPosicion] = NULL;
                    $restantes = $restantes - 1;
                }
                if($segundaPosicion < $lengthParejas){
                    $parejasJugadoras[$segundaPosicion] = NULL;
                    $restantes = $restantes - 1;
                }
                $vuelta = $vuelta + 1;   
            }
        }
        if($okInsercion == true){
            return OPERACION_CORRECTA; 
        }
        else{
            SessionControl::marcarError(TEXTO_ERROR_ESTANDAR); 
            return ERROR_APLICACION; 
        }
    }
}