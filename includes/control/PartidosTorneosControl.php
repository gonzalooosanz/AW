<?php
$ruta = $_SERVER['PHP_SELF'];
if (strpos($ruta, "includes") != false) {
    require_once ("../model/DAOs/DAOPartidosTorneos.php");
    require_once ("../model/DAOs/PartidosTorneos.php");
    require_once ("../configuration/Definitions.php");
    require_once ("../model/DAOs/DAOTorneo.php");
    require_once ("../model/DAOs/Torneo.php");
    require_once ("../model/DAOs/DAOParejas.php");
    require_once ("../model/DAOs/Parejas.php");
    require_once ("../model/DAOs/DAOUsuario.php");
    require_once ("../model/DAOs/Usuario.php");
    require_once ("../resources/DateOperations.php");
} else {
    require_once ("includes/model/DAOs/DAOPartidosTorneos.php");
    require_once ("includes/model/DAOs/PartidosTorneos.php");
    require_once ("includes/configuration/Definitions.php");
    require_once ("includes/model/DAOs/DAOTorneo.php");
    require_once ("includes/model/DAOs/Torneo.php");
    require_once ("includes/model/DAOs/DAOParejas.php");
    require_once ("includes/model/DAOs/Parejas.php");
    require_once ("includes/model/DAOs/DAOUsuario.php");
    require_once ("includes/model/DAOs/Usuario.php");
    require_once ("includes/resources/DateOperations.php");
}

class PartidosTorneosControl
{
    /** Devuelve el html necesario para imprimir un partido.
     *
     *  $idPartido: Partido para imprimir.
     * Devuelve el HTML del partido.
     */
    public static function imprimirPartidoTorneo($idPartido)
    {
        $partido = NULL;
        $html = "";
        $partido = DAOPartidosTorneos::selectById($idPartido);
        if ($partido != NULL) {
            $torneo = NULL;
            $torneo = DAOTorneo::selectById($partido->getTorneoAsociado());
            $pareja1 = DAOParejas::selectById($partido->getPareja1());
            $pareja2 = DAOParejas::selectById($partido->getPareja2());
            if ($torneo != NULL && $pareja1 != NULL) {
                if ($pareja2 != NULL) {
                    $usuario1 = DAOUsuario::selectById($pareja1->getIdIntegrante1());
                    $usuario2 = DAOUsuario::selectById($pareja1->getIdIntegrante2());
                    $usuario3 = DAOUsuario::selectById($pareja2->getIdIntegrante1());
                    $usuario4 = DAOUsuario::selectById($pareja2->getIdIntegrante2());
                    if ($usuario1 != NULL && $usuario2 != NULL && $usuario3 != NULL && $usuario4 != NULL) {
                        $html .= '<div class = "partido_wrapper">';
                        $html .= '<h1> '.$partido->getNombre().' de <a href = "torneoView.php?id='.$partido->getTorneoAsociado().'"> '.$torneo->getNombre().' </a></h1>'; 
                        $html .= '<div class = "ubicacion_wrapper">';
                        $html .= '<h2> Ubicacion: </h2>';
                        $html .= '<p> Ubicacion: ' . $torneo->getdireccion() . ', <span class = "localidad_partido">' . $torneo->getCiudad() . ' </span><span class = "provincia_partido">' . $torneo->getProvincia() . ' </span> </p>';
                        $html .= '</div>'; // ubicacion_wrapper
                        $html .= '<div class = "participantes_wrapper">';
                        $html .= '<h2> Participantes: </h2>';
                        $html .= '<div class = "pareja_wrapper">';
                        $html .= '<p><a href = "jugadorView.php?id=' . $usuario1->getIdUsuario() . '"> ' . $usuario1->getNombre() . ' ' . $usuario1->getApellido1() . ' </a></p>';
                        $html .= '<p><a href = "jugadorView.php?id=' . $usuario2->getIdUsuario() . '"> ' . $usuario2->getNombre() . ' ' . $usuario2->getApellido1() . '</a></p>';
                        $html .= '</div>'; // pareja_wrapper
                        $html .= '<div class = "vs_wrapper">';
                        $html .= '<p>           VS             </p>';
                        $html .= '</div>'; // vs_wrapper
                        $html .= '<div class = "pareja_wrapper">';
                        $html .= '<p><a href = "jugadorView.php?id=' . $usuario3->getIdUsuario() . '"> ' . $usuario3->getNombre() . ' ' . $usuario3->getApellido1() . '</a></p>';
                        $html .= '<p><a href = "jugadorView.php?id=' . $usuario4->getIdUsuario() . '"> ' . $usuario4->getNombre() . ' ' . $usuario4->getApellido1() . '</a></p>';
                        $html .= '</div>'; // pareja_wrapper
                        
                        $html .= '<div class = "estado_wrapper">';
                        $html .= '<h2> Estado del partido:  </h2>';
                        $hoy = DateOperations::getTodayDate();
                        if ($hoy < $partido->getFechaInicio()) {
                            $html .= '<p> El partido comenzó el ' . $partido->getFechaInicio() . ' </p>';
                        } else {
                            $html .= '<p> Fecha de comienzo: ' . $partido->getFechaInicio() . ' </p>';
                        }
                        if ($partido->getResultados() != NULL) {
                            $html .= '<p> Resultados: ' . $partido->getResultados() . ' </p>';
                            $parejaGanadora = DAOParejas::selectById($partido->getParejaGanadora());
                            if ($parejaGanadora != NULL) {
                                $usuarioG1 = DAOUsuario::selectById($parejaGanadora->getIdIntegrante1());
                                $usuarioG2 = DAOUsuario::selectById($parejaGanadora->getIdIntegrante2());
                                if ($usuarioG1 != NULL && $usuarioG2 != NULL) {
                                    $html .= '<h3> Pareja Ganadora:  <a href = "jugadorView.php?id=' . $usuarioG1->getIdUsuario() . '"> ' . $usuarioG1->getNombre() . ' ' . $usuarioG1->getApellido1() . '</a> y
                                            <a href = "jugadorView.php?id=' . $usuarioG2->getIdUsuario() . '"> ' . $usuarioG2->getNombre() . ' ' . $usuarioG2->getApellido1() . '</a></h3>';
                                } else {
                                    $html = ERROR_APLICACION;
                                    return $html;
                                }
                            } else {
                                $html = ERROR_APLICACION;
                                return $html;
                            }
                        } else {
                            $html .= '<p> Las puntuaciones de este partido todavía no se han actualizado </p>';
                        }
                        
                        $ronda = $partido->getRonda();
                        $maxRonda = $torneo->getMaxRondas();
                        if ($ronda < $maxRonda - 2) {
                            $html .= '<p> Ronda actual: Cuartos de Final </p>';
                        } else if ($ronda < $maxRonda - 1) {
                            $html .= '<p> Ronda actual: Semifinal </p>';
                        } else if ($ronda == $maxRonda) {
                            $html .= '<p> Ronda actual: Final </p>';
                        } else {
                            $html .= '<p> Ronda actual: ' . $partido->getRonda() . ' </p>';
                        }
                        $html .= '</div>'; // estado_wrapper
                        $html .= '</div>'; // partido_wrapper
                    } else {
                        $html = ERROR_APLICACION;
                    }
                } else {
                    $html = ERROR_APLICACION;
                }
            } else {
                $html = ERROR_APLICACION;
            }
        } else {
            $html = ERROR_APLICACION;
        }
        return $html;
    }
}