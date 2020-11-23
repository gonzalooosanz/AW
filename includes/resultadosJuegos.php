<?php
require_once("model/DAOs/DAOUsuario.php");
require_once("model/DAOs/Usuario.php");
require_once("model/DAOs/DAOPartidosTorneos.php");
require_once("model/DAOs/PartidosTorneos.php");
require_once("model/DAOs/DAOParejas.php");
require_once("model/DAOs/Parejas.php");

class ResultadosJuegos{
    
    public static function generarEstadisticasIndividuales($idUsuario){
        $usuario = new Usuario(); 
        $usuario = DAOUsuario::selectById($idUsuario); 
        // 2. Obtenemos las parejas del usuario y con
        //eso todos los torneos en los que ha participado: 
        
        $parejasIzquierdo = array(); 
        $parejasDerecho = array(); 
        $parejasIzquierdo = DAOParejas::selectByIntegrante1($idUsuario);
        $parejasDerecho = DAOParejas::selectByIntegrante2($idUsuario); 
        /* 3. Generamos un array con los ids de los torneos en los que ha 
         * participado el usuario 
         * Por otro lado tambien generamos un array con los ids de cada pareja con la 
         * que ha participado ese usuario. 
         * Las posiciones de ambos arrays serán equivalentes. */ 
        $torneosParticipados = array(); 
        $parejaDeParticipacion = array(); 
        foreach($parejasIzquierdo as $clave){
            $torneo = new Torneo(); 
            $torneo = DAOTorneo::selectById($clave->getTorneoAsociado()); 
            array_push($torneosParticipados, $torneo); 
            array_push($parejaDeParticipacion, $clave->getIdPareja()); 
        }
        foreach($parejasDerecho as $clave){
            array_push($torneosParticipados, $clave->getTorneoAsociado());
            array_push($parejaDeParticipacion, $clave->getIdPareja()); 
        }
        
        /* 4. Para cada torneo generamos un array con los partidos que lo componen y que el usuario ha participado */ 
            $partidosPorTorneo = array(); /* array de arrays */ 
            $partidos = array(); 
            $indexPareja = 0; 
            foreach($torneosParticipados as $clave){
                $partidos = DAOPartidosTorneos::selectByTorneoAndPareja1OrPareja2($clave, $parejaDeParticipacion[$indexPareja]);
                array_push($partidosPorTorneo, $partidos);
                $indexPareja = $indexPareja + 1; 
            }
       /* 5. Generacion de HTML */ 
            
            $html = '<div class = "estadisticas_wrapper">
                        <h3> Estadisticas de '.$usuario->getNombre().'</h3>
                        <div class = "accordion-container">'; 
            foreach($torneosParticipados as $clave){
                $html .= '<a class = "acordion-titulo">'.$clave->getNombre().'</a>'; 
            }
                         
         
    }
}