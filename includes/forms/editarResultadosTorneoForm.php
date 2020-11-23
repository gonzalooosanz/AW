<?php
require_once ("Form.php");
require_once ("includes/model/DAOs/DAOUsuario.php");
require_once ("includes/forms/UserEntrySecurity.php");
require_once ("includes/configuration/Definitions.php");
require_once ("includes/control/SessionControl.php");
require_once ("includes/model/DAOs/DAOPartidosTorneos.php");
require_once ("includes/model/DAOs/PartidosTorneos.php");
require_once ("includes/model/DAOs/DAOParejas.php");
require_once ("includes/model/DAOs/Parejas.php");
require_once("includes/control/TorneosControl.php");

class EditarResultadoTorneoForm extends Form
{

    protected function generaCamposFormulario($datosFormulario)
    {
        $idPartido = SessionControl::getIdRecurso();
        $partido = DAOPartidosTorneos::selectById($idPartido);
        $idPareja1 = $partido->getPareja1();
        $idPareja2 = $partido->getPareja2();
        $pareja1 = DAOParejas::selectById($idPareja1);
        $pareja2 = DAOParejas::selectById($idPareja2);
        $usuario1 = DAOUsuario::selectById($pareja1->getIdIntegrante1());
        $usuario2 = DAOUsuario::selectById($pareja1->getIdIntegrante2());
        $usuario3 = DAOUsuario::selectById($pareja2->getIdIntegrante1());
        $usuario4 = DAOUsuario::selectById($pareja2->getIdIntegrante2());
        
        return '
               <div class = "segmento">
                <div class = "input-group">
                    <h3> Pareja 1:' . $usuario1->getNombre() . ' ' . $usuario1->getApellido1() . ' y ' . $usuario2->getNombre() . ' ' . $usuario2->getApellido1() . '</h3>
                    <label> Puntuacion de la pareja : </label>
                    <input type = "text" name = "puntuacion1">
                </div>
            
                 <label class = "label_error" id = "error_puntuacion1"> La puntuacion de la primera pareja no puede estar vacia, ser negativa  o contener letras.  </label>
                <div class = "input-group">
                    <h3> Pareja 2:' . $usuario3->getNombre() . ' ' . $usuario3->getApellido1() . ' y ' . $usuario4->getNombre() . ' ' . $usuario4->getApellido1() . '</h3>
                    <label> Puntuacion de la pareja: </label>
                    <input type = "text" name = "puntuacion2">
                </div>
                <label class = "label_error" id = "error_puntuacion2"> La puntuacion de la segunda pareja no puede estar vacia, ser negativa o contener letras. </label>
            </div>
               <div class = "boton_cargando grande azul">
                    <div class = "spinner disabled" id = "spinner_login"></div>
                    <input type = "submit" value = "Actualizar Puntuacion">
                </div>
        
        ';
    }

    protected function procesaFormulario($datos)
    {
        $erroresFormulario = array();
        $idPartido = SessionControl::getIdRecurso();
        $partido = DAOPartidosTorneos::selectById($idPartido);
        $idTorneo = $partido->getTorneoAsociado();
        $puntuacion = "";
        if (isset($_POST['puntuacion1']) && $_POST['puntuacion1'] != NULL && isset($_POST['puntuacion2']) && $_POST['puntuacion2'] != NULL) {
            $puntuacion = ''.UserEntrySecurity::asegurarEntradaUsuario($_POST['puntuacion1']).'';
            $puntuacion .= ' ';
            $puntuacion .= ''.UserEntrySecurity::asegurarEntradaUsuario($_POST['puntuacion2']).'';
            TorneosControl::actualizarResultadosPartido($idPartido, $puntuacion);
            return 'torneoView.php?id=' . $idTorneo;
        } else {
            $erroresFormulario[] = "No puede haber campos vacios en este formulario. ";
        }
        
        return $erroresFormulario;
    }
}