<?php

require_once("SingletonDataSource.php");
require_once("DataSource.php");
require_once("Parejas.php");

class DAOParejas{
    
    public static function selectParejas(){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM parejas");
        $pareja = NULL;
        $parejas = array();
        foreach ($data_table as $clave => $valor)
        {
            $pareja = new Parejas();
            
            $pareja = self::setEverything($data_table, $pareja, $clave);
            array_push($parejas,$pareja);
        }
        return $parejas;
    }
    
    
    public static function selectById($id){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM parejas WHERE id = :id",array(':id' => $id));
        $pareja = NULL;
        if($data_table != NULL){
            foreach($data_table as $clave => $valor){
                $pareja = new Parejas();
                $pareja = self::setEverything($data_table, $pareja, $clave);
            }
        }
        return $pareja;
    }
    
    public static function obtenerUltimoIdPareja(){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT MAX(id) AS maximo FROM parejas");
        return $data_table[0]["maximo"];
    }

    public static function selectByIntegrante1($nombre){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM parejas WHERE integrante1 = :integrante1",array(':integrante1' => $nombre));
        $pareja = NULL;
        $parejas = array(); 
        if($data_table != NULL){
            foreach($data_table as $clave => $valor){
                $pareja = new Parejas();
                $pareja = self::setEverything($data_table, $pareja, $clave);
                array_push($parejas, $pareja);
            }
        }
        return $parejas;
    }

    public static function selectByIntegrante2($nombre){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM parejas WHERE integrante2 = :integrante2",array(':integrante2' => $nombre));
        $pareja = NULL;
        $parejas = array(); 
        if($data_table != NULL){
            foreach($data_table as $clave => $valor){
                $pareja = new Parejas();
                $pareja = self::setEverything($data_table, $pareja, $clave);
                array_push($parejas, $pareja); 
            }
        }
        return $parejas;
    }
    
    public static function selectByIntegrante1AndTorneoAndEnVigor($nombre, $torneo, $enVigor){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM parejas WHERE integrante1 = :integrante1 AND torneoAsociado = :torneo AND enVigor = :enVigor"
            ,array(':integrante1' => $nombre, ':torneo' => $torneo, ':enVigor' => $enVigor));
        $pareja = NULL;
        if($data_table != NULL){
            foreach($data_table as $clave => $valor){
                $pareja = new Parejas();
                $pareja = self::setEverything($data_table, $pareja, $clave);
            }
        }
        return $pareja;
    }
    
    public static function selectByIntegrante2AndTorneoAndEnVigor($nombre, $torneo, $enVigor){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM parejas WHERE integrante2 = :integrante2 AND torneoAsociado = :torneo AND enVigor = :enVigor"
            ,array(':integrante2' => $nombre, ':torneo' => $torneo, ':enVigor' => $enVigor));
        $pareja = NULL;
        if($data_table != NULL){
            foreach($data_table as $clave => $valor){
                $pareja = new Parejas();
                $pareja = self::setEverything($data_table, $pareja, $clave);
            }
        }
        return $pareja;
    }
    
    public static function selectByTorneo($torneo){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM parejas WHERE torneoAsociado = :torneoAsociado"
            ,array(':torneoAsociado' => $torneo));
        $pareja = NULL;
        $parejas = array();
        if($data_table != NULL){
            foreach($data_table as $clave => $valor){
                $pareja = new Parejas();
                $pareja = self::setEverything($data_table, $pareja, $clave);
                array_push($parejas, $pareja);
            }
        }
        return $parejas;
    }
    
    public static function selectByIntegrante1AndEnVigor($id, $enVigor){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM parejas WHERE integrante1 = :integrante1 AND enVigor = :enVigor"
            ,array(':integrante1' => $id, ':enVigor' => $enVigor));
        $pareja = NULL;
        if($data_table != NULL){
            foreach($data_table as $clave => $valor){
                $pareja = new Parejas();
                $pareja = self::setEverything($data_table, $pareja, $clave);
            }
        }
        return $pareja;
    }
    
    public static function selectByIntegrante2AndEnVigor($id, $enVigor){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM parejas WHERE integrante2 = :integrante2 AND enVigor = :enVigor"
            ,array(':integrante2' => $id, ':enVigor' => $enVigor));
        $pareja = NULL;
        if($data_table != NULL){
            foreach($data_table as $clave => $valor){
                $pareja = new Parejas();
                $pareja = self::setEverything($data_table, $pareja, $clave);
            }
        }
        return $pareja;
    }

    public static function selectByIntegrantes($nombre1, $nombre2){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM parejas WHERE integrante1 = :integrante1
        AND integrante2 = :integrante2",array(':integrante1' => $nombre1,':integrante2' => $nombre2));
        $pareja = NULL;
        if($data_table != NULL){
            foreach($data_table as $clave => $valor){
                $pareja = new Parejas();
                $pareja = self::setEverything($data_table, $pareja, $clave);
            }
        }
        return $pareja;
    }

    public static function selectByEfectividad($efect){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM parejas WHERE efectividad => :efectividad", array(':efectividad' => $efect));
        $pareja = NULL; 
        $parejas = array(); 
            foreach($data_table as $clave => $valor){
                $pareja = new Parejas();
                $pareja = self::setEverything($data_table,$pareja, $clave);
                array_push($parejas, $pareja);
            }
        
        return $parejas; 
      }
    
    
    public static function insertPareja(Parejas $pareja){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $sql = "INSERT INTO parejas (`integrante1`, `integrante2`, `torneoAsociado`, `efectividad`, `enVigor`) 
        VALUES (:integrante1,:integrante2,:torneoAsociado,:efectividad, :enVigor)";
        $resultado = $data_source ->ejecutarActualizacion($sql,array(
            ':integrante1' => $pareja->getIdIntegrante1(),
            ':integrante2' => $pareja->getIdIntegrante2(),
            ':torneoAsociado' => $pareja->getTorneoAsociado(), 
            ':efectividad' => $pareja->getEfectividad(), 
            ':enVigor' => $pareja->getEnVigor()));
        return $resultado;
    }
    
    public static function updatePareja(Parejas $pareja){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $sql = "UPDATE parejas SET
        id = :id, 
        integrante1 = :integrante1, 
        integrante2 = :integrante2, 
        torneoAsociado = :torneoAsociado, 
        efectividad = :efectividad, 
        enVigor = :enVigor
        WHERE id = :id";
        $resultado = $data_source ->ejecutarActualizacion($sql,array(
            ':id' => $pareja->getIdPareja(),
            ':integrante1' => $pareja->getIdIntegrante1(),
            ':integrante2' => $pareja->getIdIntegrante2(),
            ':torneoAsociado' => $pareja->getTorneoAsociado(), 
            ':efectividad' => $pareja->getEfectividad(), 
            ':enVigor' => $pareja->getEnVigor())); 
        return $resultado; 
    }
    
    public static function deletePareja($id){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $resultado = $data_source->ejecutarActualizacion("DELETE FROM parejas WHERE
        id = :id", array(':id' => $id));
        return $resultado;  
    }
    
    public static function setEverything($data_table = array(), Parejas $pareja, $clave){
        $pareja->setIdPareja($data_table[$clave]["id"]);
        $pareja->setIdIntegrante1($data_table[$clave]["integrante1"]);
        $pareja->setIdIntegrante2($data_table[$clave]["integrante2"]);
        $pareja->setTorneoAsociado($data_table[$clave]["torneoAsociado"]); 
        $pareja->setEfectividad($data_table[$clave]["efectividad"]);
        $pareja->setEnVigor($data_table[$clave]["enVigor"]);
        return $pareja;
    }
}
?>