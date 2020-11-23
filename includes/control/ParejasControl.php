<?php
$ruta = $_SERVER['PHP_SELF'];
if (strpos($ruta, "includes") != false) {
    require_once ("../model/DAOs/DAOParejas.php");
    require_once ("../model/DAOs/Parejas.php");
    require_once ("../model/DAOs/DAOUsuario.php");
    require_once ("../model/DAOs/Usuario.php");
} else {
    require_once ("includes/model/DAOs/DAOParejas.php");
    require_once ("includes/model/DAOs/Parejas.php");
    require_once ("includes/model/DAOs/DAOUsuario.php");
    require_once ("includes/model/DAOs/Usuario.php");
}

class ParejasControl
{

    // Resuelve inconsistencias en la BD de integridad.
    public static function borrarUltimaFilaInsertada()
    {
        $idBorrar = DAOParejas::obtenerUltimoIdPareja();
        if (($filas = DAOParejas::deletePareja($idBorrar)) == 1) {
            return OPERACION_CORRECTA;
        } else {
            return ERROR_APLICACION;
        }
    }

    /** Devuelve el html necesario para imprimir las parejas que se le pasan por el array por parametro. 
     * 
     *  $parejas: Parejas para imprimir por HTML. 
     * Devuelve el HTML de las parejas. 
     */
    public static function imprimirParejas($parejas = array())
    {
        $integrantes = array();
        $html = "";
        $i = 1; 
        $linea = false;
        foreach ($parejas as $clave) {
            $integrante1 = DAOUsuario::selectById($clave->getIdIntegrante1());
            $integrante2 = DAOUsuario::selectById($clave->getIdIntegrante2());
            array_push($integrantes, $integrante1);
            array_push($integrantes, $integrante2);
            $html .= '<div class = "pareja_wrapper">';
            $html .= '<h3> Pareja '.$i. ':  </h3> '; 
            if (count($integrantes) == 2) {
                foreach ($integrantes as $claveIntegrante) {
                    // INTEGRANTE 1:
                    $html .= '<div class = "integrante_wrapper">';
                    $html .= '<div class = "photo_wrapper">';
                    if (($img = $claveIntegrante->getPerfil()) != NULL) {
                        $html .= '<img src = "' . $claveIntegrante->getPerfil() . '" alt = "Imagen de perfil del usuario">';
                    } else {
                        $html .= '<img src = "img/user_icon.png" alt = "Imagen de perfil del usuario">';
                    }
                    $html .= '</div>'; // photo_wrapper
                    $html .= '<div class = "info_wrapper">';
                    $html .= '<div class = "link_wrapper">'; 
                    $html .= '<p> <a href = "jugadorView.php?id=' . $claveIntegrante->getIdUsuario() . ' "> ' . $claveIntegrante->getNombre() . ' ' 
                        . $claveIntegrante->getApellido1() . ' ' . $claveIntegrante->getApellido2() . '  </a> </p>';
                    $html .= '</div>'; // link_wrapper 
                    $html .= '<p> Efectividad de ' . $claveIntegrante->getNombre() . ': ' . $claveIntegrante->getEfectividad() . ' </p>';
                    $html .= '<p> Localidad y provincia de nacimiento: <span class = "localidad_usuario">' . $claveIntegrante->getlocalidad() . ' </span> <span class = "provincia_usuario"> ' . $claveIntegrante->getprovincia() . ' </span> </p>';
                    $html .= '</div>'; // info_wrapper
                    $html .= '</div>'; // integrante_wrapper
                                       
                    // Linea de unión entre cada integrante de la pareja.
                    
                }
            } 
            else {
                $html .= '<p class = "error"> Hemos tenido un error interno en la aplicación, es posible que algunas parejas no se muestren. </p>';
            }
            
            $html .= '</div>'; // pareja_wrapper
                               // vaciamos los integrantes de la pareja para la siguiente.
            unset($integrantes);
            $integrantes = array();
            $i = $i + 1; 
        }
        
        return $html; 
    }
}