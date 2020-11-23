<?php
require_once("SingletonDataSource.php");
require_once("DataSource.php");
require_once("PartidosTorneos.php");

class DAOPartidosTorneos{
    
    /* Devuelve los partidos en los que ha participado $pareja del torneo $torneo */ 
    public static function selectByTorneoAndPareja1OrPareja2($torneo, $pareja){
        $data_source = new SingletonDataSource(); 
        $data_source = $data_source->getInstance(); 
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM partidos_torneos WHERE torneoAsociado = :torneoAsociado AND (pareja1 = :pareja1 OR pareja2 = :pareja2", 
            array(':torneoAsociado' => $torneo, ':pareja1' => $pareja, ':pareja2' => $pareja)); 
        $partidos = array(); 
        if(count($data_table) > 0){
            
            foreach($data_table as $clave => $valor){
                $partido = new PartidosTorneos(); 
                $partido = self::setEverything($data_table, $partido, $clave); 
                array_push($partidos, $partido);
            }
        }
        return $partidos; 
    }
    
    public static function selectById($id){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM partidos_torneos WHERE id = :id",
            array(':id' => $id));
            $partido = NULL; 
            foreach($data_table as $clave => $valor){
                $partido = new PartidosTorneos();
                $partido = self::setEverything($data_table, $partido, $clave);
            }
            
        return $partido; 
    }
    
    public static function selectByRonda($ronda){
        $data_source = new SingletonDataSource(); 
        $data_source = $data_source->getInstance(); 
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM partidos_torneos WHERE ronda = :ronda", array(':ronda' => $ronda)); 
        $partidos = array(); 
        foreach($data_table as $clave => $valor){
            $partido = new PartidosTorneos(); 
            $partido = self::setEverything($data_table, $partido, $clave); 
            array_push($partidos, $partido);  
       }
       return $partidos; 
    }
    
    public static function selectByTorneoAndRonda($idTorneo, $ronda){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM partidos_torneos WHERE torneoAsociado = :torneoAsociado AND ronda = :ronda", array(':torneoAsociado' => $idTorneo, ':ronda' => $ronda));
        $partidos = array();
        foreach($data_table as $clave => $valor){
            $partido = new PartidosTorneos();
            $partido = self::setEverything($data_table, $partido, $clave);
            array_push($partidos, $partido);
        }
        return $partidos; 
    }
    
    public static function selectByTorneo($idTorneo){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM partidos_torneos WHERE torneoAsociado = :torneoAsociado",
            array(':torneoAsociado' => $idTorneo));
        $partidos = array();
        if(count($data_table) > 0){
            
            foreach($data_table as $clave => $valor){
                $partido = new PartidosTorneos();
                $partido = self::setEverything($data_table, $partido, $clave);
                array_push($partidos, $partido);
            }
        }
        return $partidos; 
    }
    
    public static function obtenerUltimoIdPartidosTorneos(){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT MAX(id) AS maximo FROM partidos_torneos");
        return $data_table[0]["maximo"];
    }
    
    public static function insertPartido(PartidosTorneos $partido){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $sql = "INSERT INTO partidos_torneos (`nombre`, `pareja1`, `pareja2`,
        `torneoAsociado`, `parejaGanadora`, `resultados`, `fechaInicio`, `ronda`)
        VALUES (:nombre,:pareja1,:pareja2,
        :torneoAsociado,:parejaGanadora, :resultados, :fechaInicio, :ronda)";
        $resultado = $data_source ->ejecutarActualizacion($sql,array(
            ':nombre' => $partido->getNombre(), 
            ':pareja1' => $partido->getPareja1(), 
            ':pareja2' => $partido->getPareja2(), 
            ':torneoAsociado' => $partido->getTorneoAsociado(), 
            ':parejaGanadora' => $partido->getParejaGanadora(), 
            ':resultados' => $partido->getResultados(), 
            ':fechaInicio' => $partido->getFechaInicio(),
            ':ronda' => $partido->getRonda()
                            ));
        return $resultado;
    }
    
    public static function updatePartido(PartidosTorneos $partido){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $sql = "UPDATE partidos_torneos SET
        id = :id,
        nombre = :nombre,
        pareja1 = :pareja1,
        pareja2 = :pareja2,
        torneoAsociado = :torneoAsociado,
        parejaGanadora = :parejaGanadora,
        resultados = :resultados,
        fechaInicio = :fechaInicio,
        ronda = :ronda
        WHERE id = :id";
        $resultado = $data_source ->ejecutarActualizacion($sql,array(
            ':id' => $partido->getId(),
            ':nombre' => $partido->getNombre(),
            ':pareja1' => $partido->getPareja1(),
            ':pareja2' => $partido->getPareja2(),
            ':torneoAsociado' => $partido->getTorneoAsociado(),
            ':parejaGanadora' => $partido->getParejaGanadora(),
            ':resultados' => $partido->getResultados(),
            ':fechaInicio' => $partido->getFechaInicio(),
            ':ronda' => $partido->getRonda()));
        return $resultado;
    }
    
    
    
    
    public static function setEverything($data_table = array(), PartidosTorneos $partidos, $clave){
        $partidos->setId($data_table[$clave]["id"]); 
        $partidos->setNombre($data_table[$clave]["nombre"]); 
        $partidos->setPareja1($data_table[$clave]["pareja1"]); 
        $partidos->setPareja2($data_table[$clave]["pareja2"]); 
        $partidos->setTorneoAsociado($data_table[$clave]["torneoAsociado"]); 
        $partidos->setParejaGanadora($data_table[$clave]["parejaGanadora"]);
        $partidos->setResultados($data_table[$clave]["resultados"]); 
        $partidos->setFechaInicio($data_table[$clave]["fechaInicio"]); 
        $partidos->setRonda($data_table[$clave]["ronda"]);
        return $partidos; 
    }
    
    
  
}
