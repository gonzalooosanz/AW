<?php

require_once("SingletonDataSource.php");
require_once("DataSource.php");
require_once("Torneo.php");

class DAOTorneo{
    
    public static function selectTorneos(){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM torneos");
        $torneo = NULL;
        $torneos = array();
        foreach ($data_table as $clave => $valor)
        {
            $torneo = new Torneo();
            
            $torneo = self::setEverything($data_table, $torneo, $clave);
            array_push($torneos,$torneo);
        }
        return $torneos;
    }
    
    
    public static function selectById($id){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM torneos WHERE id = :id",array(':id' => $id));
        $torneo = NULL;
        if($data_table != NULL){
            foreach($data_table as $clave => $valor){
                $torneo = new Torneo();
                $torneo = self::setEverything($data_table, $torneo, $clave);
            }
        }
        return $torneo;
    }
    
    public static function obtenerUltimoIdTorneo(){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT MAX(id) AS maximo FROM torneos");
        return $data_table[0]["maximo"];
    }

    public static function selectByNombre($nombre){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM torneos WHERE nombre = :nombre",array(':nombre' => $nombre));
        $torneo = NULL;
        if($data_table != NULL){
            foreach($data_table as $clave => $valor){
                $torneo = new Torneo();
                $torneo = self::setEverything($data_table, $torneo, $clave);
            }
        }
        return $torneo;
    }

    public static function selectByNumParejas($num){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM torneos WHERE numParejas = :numParejas", array(':numParejas' => $num));
        $torneo = NULL; 
        $torneos = array(); 
        foreach($data_table as $clave => $valor){
            $torneo = new Torneo(); 
            $torneo = self::setEverything($data_table, $torneo, $clave); 
            array_push($torneos, $torneo);
        }                                              
        return $torneos; 
    }
   
    public static function selectByEfectividad($efect){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM torneos WHERE efectividadRequerida => :efectividadRequerida", array(':efectividadRequerida' => $efect));
        $torneo = NULL; 
        $torneos = array(); 
            foreach($data_table as $clave => $valor){
                $torneo = new Torneo(); 
                $torneo = self::setEverything($data_table, $torneo, $clave); 
                array_push($torneos, $torneo);
            }
        
        return $torneos;
    }
    
    public static function selectByCiudad($ciudad){
      $data_source = new SingletonDataSource();
      $data_source = $data_source->getInstance();
      $data_table = $data_source->ejecutarConsulta("SELECT * FROM torneos WHERE ciudad = :ciudad", array(':ciudad' => $ciudad));
      $torneo = NULL; 
        $torneos = array(); 
            foreach($data_table as $clave => $valor){
                $torneo = new Torneo(); 
                $torneo = self::setEverything($data_table, $torneo, $clave); 
                array_push($torneos, $torneo);
            }
        
        return $torneos;
    }
    
    public static function selectByFechaInscripcion($fecha){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM torneos WHERE fechaInscripcion = :fechaInscripcion",
            array(':fechaInscripcion' => $fecha));
        $torneo = NULL; 
        $torneos = array(); 
            foreach($data_table as $clave => $valor){
                $torneo = new Torneo(); 
                $torneo = self::setEverything($data_table, $torneo, $clave); 
                array_push($torneos, $torneo);
            }
        
        return $torneos;
    }

    
    
    public static function insertTorneo(Torneo $torneo){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $sql = "INSERT INTO torneos (`nombre`, `numParejas`, `efectividadRequerida`,
        `premio`, `provincia`, `direccion`, `ciudad`, `fechaInicio`, `fechaFin`, `fechaInscripcion`, `maxParejas`, `cerrado`, `maxRondas`, `rondaActual`) 
        VALUES (:nombre,:numParejas,:efectividadRequerida,
        :premio,:provincia, :direccion, :ciudad, :fechaInicio, :fechaFin,:fechaInscripcion, :maxParejas, :cerrado, :maxRondas, :rondaActual)";
        $resultado = $data_source ->ejecutarActualizacion($sql,array(
            ':nombre' => $torneo->getNombre(),
            ':numParejas' => $torneo->getnumParejas(),
            ':efectividadRequerida' => $torneo->getEfectividadRequerida(),
            ':premio' => $torneo->getPremio(),
            ':direccion' => $torneo->getdireccion(),
            ':provincia' => $torneo->getProvincia(), 
            ':ciudad' => $torneo->getCiudad(),
            ':fechaInicio' => $torneo->getFechaInicio(),
            ':fechaFin' => $torneo->getFechaFin(),
            ':fechaInscripcion' => $torneo->getFechaInscripcion(), 
            ':maxParejas' => $torneo->getmaxParejas(), 
            ':cerrado' => $torneo->getCerrado(), 
            ':maxRondas' => $torneo->getMaxRondas(), 
            ':rondaActual' => $torneo->getRondaActual())); 
        return $resultado;
    }
    
    public static function updateTorneo(Torneo $torneo){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $sql = "UPDATE torneos SET
        id = :id, 
        nombre = :nombre, 
        numParejas = :numParejas, 
        efectividadRequerida = :efectividadRequerida, 
        premio = :premio,
        provincia = :provincia, 
        direccion = :direccion,
        ciudad = :ciudad, 
        fechaInicio = :fechaInicio, 
        fechaFin = :fechaFin, 
        fechaInscripcion = :fechaInscripcion, 
        maxParejas = :maxParejas, 
        cerrado = :cerrado, 
        maxRondas = :maxRondas, 
        rondaActual = :rondaActual
        WHERE id = :id";
        $resultado = $data_source ->ejecutarActualizacion($sql,array(
            ':id' => $torneo->getIdTorneo(),
            ':nombre' => $torneo->getNombre(),
            ':numParejas' => $torneo->getnumParejas(),
            ':efectividadRequerida' => $torneo->getEfectividadRequerida(),
            ':premio' => $torneo->getPremio(),
            ':direccion' => $torneo->getdireccion(),
            ':provincia' => $torneo->getProvincia(),
            ':ciudad' => $torneo->getCiudad(),
            ':fechaInicio' => $torneo->getFechaInicio(),
            ':fechaFin' => $torneo->getFechaFin(),
            ':fechaInscripcion' => $torneo->getFechaInscripcion(), 
            ':maxParejas' => $torneo->getmaxParejas(), 
            ':cerrado' => $torneo->getCerrado(), 
            ':maxRondas' => $torneo->getMaxRondas(), 
            ':rondaActual' => $torneo->getRondaActual())); 
        return $resultado; 
    }
    
    public static function deleteTorneo($id){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $resultado = $data_source->ejecutarActualizacion("DELETE FROM torneos WHERE
        id = :id", array(':id' => $id));
        return $resultado;  
    }
    
    public static function setEverything($data_table = array(), Torneo $torneo, $clave){
        
        $torneo->setIdTorneo($data_table[$clave]["id"]);
        $torneo->setNombre($data_table[$clave]["nombre"]);
        $torneo->setnumParejas($data_table[$clave]["numParejas"]);
        $torneo->setEfectividadRequerida($data_table[$clave]["efectividadRequerida"]);   
        $torneo->setPremio($data_table[$clave]["premio"]);
        $torneo->setdireccion($data_table[$clave]["direccion"]);
        $torneo->setProvincia($data_table[$clave]["provincia"]); 
        $torneo->setCiudad($data_table[$clave]["ciudad"]); 
        $torneo->setFechaInicio($data_table[$clave]["fechaInicio"]); 
        $torneo->setFechaFin($data_table[$clave]["fechaFin"]);
        $torneo->setFechaInscripcion($data_table[$clave]["fechaInscripcion"]);
        $torneo->setmaxParejas($data_table[$clave]["maxParejas"]); 
        $torneo->setCerrado($data_table[$clave]["cerrado"]); 
        $torneo->setMaxRondas($data_table[$clave]["maxRondas"]); 
        $torneo->setRondaActual($data_table[$clave]["rondaActual"]); 
        
        return $torneo;
    }
}
?>