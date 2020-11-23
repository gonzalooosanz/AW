<?php
require_once("../forms/UserEntrySecurity.php");
require_once("../resources/DateOperations.php");
require_once("../model/DAOs/DAOUsuario.php");
require_once("../configuration/Definitions.php");
require_once("../control/SessionControl.php");
require_once("../control/TorneosControl.php");

$valorBuscado = UserEntrySecurity::asegurarEntradaUsuario($_POST['parejaTorneo']); 
$idTorneo = SessionControl::getIdRecurso(); 
$valor = array(); 
$valor = preg_split('/\s/', $valorBuscado, null, PREG_SPLIT_OFFSET_CAPTURE); 
// 1. Obtenemos los usuarios que correspondan al nombre y apellidos introducidos 
$usuarios = array(); 
if(count($valor) == 1){
    $usuarios = DAOUsuario::selectByNombre($valor[0][0]);  
}
else if(count($valor) == 2){
    $usuarios = DAOUsuario::selectByNombreAndPrimerApellido($valor[0][0], $valor[1][0]);
}
else if(count($valor) == 3){
$usuario = DAOUsuario::selectByNombreAndApellidos($valor[0][0], $valor[1][0], $valor[2][0]); 
array_push($usuarios, $usuario);

}

$seleccionados = array(); 
$html = "";
$resultadosEncontrados = false;
    if(count($usuarios) > 0 && $usuarios[0] != NULL){
    $seleccionados = TorneosControl::parejasLibres($usuarios, $idTorneo);
    foreach($seleccionados as $clave){
        $puedeApuntarse = TorneosControl::comprobarApuntarseTorneo($idTorneo, $clave->getIdUsuario());
        if($puedeApuntarse == COMPROBACION_CORRECTA){
        $resultadosEncontrados = true; 
        $html .= '<div class = "usuario">
              <div class = "photo_wrapper">
               '; 
        if(($img = $clave->getPerfil()) != NULL){
            $html .= '<img src = "'.$clave->getPerfil().'" alt = "Imagen de perfil del usuario">';
        }
        else{
            $html .= '<img src = "img/user_icon.png" alt = "Imagen de perfil del usuario">'; 
        }
            $html .= '  </div>
              <h3> Nombre: '.$clave->getNombre().'. </h3>
              <h3> Efectividad conseguida: '.$clave->getEfectividad().'. </h3>
                <div class = "buttons_wrapper">
                    <a class = "boton gris medio" onclick = "popupUsuario('.$clave->getIdUsuario().');"> + Info </a>
                    <div class = "input-group radio">
                    <input type = "radio" name = "pareja_seleccionada" id = "'.$clave->getIdUsuario().'" value = "'.$clave->getIdUsuario().'">
                        <label for = "'.$clave->getIdUsuario().'"> Jugar junto a: '.$clave->getNombre().' '.$clave->getApellido1().' '.$clave->getApellido2().' </label>
                    </div>
                 </div>
                </div>
              </div>';
    }
    }
    if($resultadosEncontrados == true){
    echo $html; 
    }
    else{
        $html = "<p> No se han encontrado jugadores </p>"; 
        $html .= '<p> Recuerda que el formato de busqueda es [nombre] [primer_apellido] [segundo_apellido] </p>'; 
        $html .= '<p> Tambien es posible que el jugador que hayas buscado no aparezca al no tener la efectividad suficiente para apuntarse a este torneo. </p>'; 
        echo $html; 
    }

}
else{
   $html = '<p> No se han encontrado resultados </p>';
   echo $html;
}
