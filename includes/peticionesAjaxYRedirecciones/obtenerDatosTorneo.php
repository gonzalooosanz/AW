<?php
require_once ("../control/TorneosControl.php");
require_once ("../control/ParejasControl.php");
require_once ("../forms/UserEntrySecurity.php");
require_once ("../control/SessionControl.php");
require_once ("../configuration/Definitions.php");
require_once ("../model/DAOs/DAOTorneo.php");
require_once ("../model/DAOs/Torneo.php");
require_once ("../model/DAOs/DAOPartidosTorneos.php");
require_once ("../model/DAOs/PartidosTorneos.php");
require_once ("../model/DAOs/DAOParejas.php");
require_once ("../model/DAOs/Parejas.php");
require_once ("../resources/DateOperations.php");
require_once ("../model/DAOs/DAOUsuario.php");
require_once ("../model/DAOs/Usuario.php");
require_once("../control/PartidosTorneosControl.php"); 

if (isset($_POST['operation']) && $_POST['operation'] != NULL) {
    $operacion = UserEntrySecurity::asegurarEntradaUsuario($_POST['operation']);
    $html = "";
    if (isset($_POST['idTorneo']) && $_POST['idTorneo'] != NULL) {
        $idTorneo = UserEntrySecurity::asegurarEntradaUsuario($_POST['idTorneo']);
        $torneo = DAOTorneo::selectById($idTorneo);
        switch ($operacion) {
            case OPERACION_PARTIDOS_TORNEO_SIN_FILTRO:
                $partidos = array();
                $partidos = DAOPartidosTorneos::selectByTorneo($idTorneo);
                $parejas = array();
                $parejas = DAOParejas::selectByTorneo($idTorneo);
                $html = "";
                $comprobacion = NULL;
                if (count($partidos) > 0) {
                    if (($comprobacion = TorneosControl::datosTorneo($torneo, $partidos, $parejas, OPERACION_PARTIDOS_TORNEO_SIN_FILTRO)) != ERROR_APLICACION) {
                        $html .= $comprobacion;
                        echo $html;
                    }
                } else {
                    echo '<h3> Este torneo aun no tiene partidos generados espere hasta ' . $torneo->getFechaInscripcion() . ' para que se indiquen los partidos del torneo. </h3>';
                }
                break;
            case OPERACION_UBICACION_TORNEO:
                if ($torneo->getdireccion() != NULL && $torneo->getCiudad() != NULL && $torneo->getProvincia() != NULL) {
                    $html = '<p> Este torneo tendrá lugar en ' . $torneo->getdireccion() . ' de <span class = "ciudad_torneo">' . $torneo->getCiudad() . '</span> <span class = "provincia_torneo"> ' . $torneo->getProvincia() . ' </span></p> ';
                    echo $html;
                } else {
                    echo '<p> Este torneo aún no tiene una ubicación definida. </p>';
                }
                break;
            case OPERACION_INSCRITOS_TORNEO:
                $parejasInscritas = array();
                $parejasInscritas = DAOParejas::selectByTorneo($idTorneo);
                if (count($parejasInscritas) > 0) {
                    $html .= ParejasControl::imprimirParejas($parejasInscritas);
                } 
                else {
                    $html .= '<p> Este torneo aún no tiene ninguna pareja inscrita. </p>';
                }
                echo $html;
                break;
            case OPERACION_PARTIDO_TORNEO: 
                if(isset($_POST['idPartido']) && $_POST['idPartido'] != NULL){
                    $idPartido = UserEntrySecurity::asegurarEntradaUsuario($_POST['idPartido']); 
                    $html = PartidosTorneosControl::imprimirPartidoTorneo($idPartido);
                    
                }
                else{
                    $html = ERROR_APLICACION; 
                }
                echo $html; 
                break; 
        }
    } else {
        SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
    }
} else {
    SessionControl::marcarError(TEXTO_ERROR_ESTANDAR);
}