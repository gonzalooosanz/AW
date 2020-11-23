<?php
require_once("SingletonDataSource.php");
require_once("DataSource.php"); 
require_once("Imagen.php"); 

class DAOImagenes{
    
    public static function selectImagenes(){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM imagenes");
        $imagen = NULL;
        $imagenes = array();
        foreach ($data_table as $clave => $valor)
        {
            $imagen = new Imagen();
            
            $imagen = self::setEverything($data_table, $imagen, $clave);
            array_push($imagenes,$imagen);
        }
        return $imagenes;
    }
    
    public static function selectPrimeraImagenByTorneo($idTorneo){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM imagenes WHERE idTorneo = :idTorneo",array(':idTorneo' => $idTorneo));
        $imagen = NULL;
        if($data_table != NULL){
            $imagen = new Imagen(); 
            $imagen = self::setEverything($data_table, $imagen, 0); 
        }
        return $imagen; 
    }
    
    public static function obtenerUltimoIdImagen(){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT MAX(id) AS maximo FROM imagenes");
        return $data_table[0]["maximo"];
    }
    
    public static function insertImagen(Imagen $imagen){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $sql = "INSERT INTO imagenes (`idTorneo`, `idPartidoAmistoso`, `localizacionCargador`)
        VALUES (:idTorneo,:idPartidoAmistoso,:localizacionCargador)";
        $resultado = $data_source ->ejecutarActualizacion($sql,array(
            ':idTorneo' => $imagen->getIdTorneo(),
            ':idPartidoAmistoso' => $imagen->getIdPartidoAmistoso(),
            ':localizacionCargador' => $imagen->getLocalizacionCargador()));
        return $resultado;
    }
    
    public static function updateImagen(Imagen $imagen){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $sql = "UPDATE imagenes SET
        id = :id,
        idTorneo = :idTorneo,
        idPartidoAmistoso = :idPartidoAmistoso,
        localizacionCargador = :localizacionCargador
        WHERE id = :id";
        $resultado = $data_source ->ejecutarActualizacion($sql,array(
            ':id' => $imagen->getId(),
            ':idTorneo' => $imagen->getIdTorneo(),
            ':idPartidoAmistoso' => $imagen->getIdPartidoAmistoso(),
            ':localizacionCargador' => $imagen->getLocalizacionCargador()));
        return $resultado; 
    }
    
    
    public static function setEverything($data_table = array(), Imagen $imagen, $clave){
        $imagen->setId($data_table[$clave]["id"]); 
        $imagen->setIdTorneo($data_table[$clave]["idTorneo"]); 
        $imagen->setIdPartidoAmistoso($data_table[$clave]["idPartidoAmistoso"]); 
        $imagen->setLocalizacionCargador($data_table[$clave]["localizacionCargador"]); 
        return $imagen; 
    }
    
    
}