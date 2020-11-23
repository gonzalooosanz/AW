<?php
require_once("SingletonDataSource.php"); 
require_once("Notificacion.php");
require_once("DataSource.php");

class DAONotificaciones{
    
    
    
    
    public static function notifyByUser($id){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM notificaciones WHERE UsuarioReceptor = :id",array(':id' => $id));
        $notificacion = NULL;
        $notificaciones = array();
        foreach ($data_table as $clave => $valor)
        {
            $notificacion = new Notificacion();
            
            $notificacion = self::setEverything($data_table, $notificacion, $clave);
            array_push($notificaciones,$notificacion);
        }
        return $notificaciones;
    }
    
    public static function selectById($id){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM notificaciones WHERE Id = :id",array(':id' => $id));
        $notificacion = NULL;
        foreach ($data_table as $clave => $valor)
        {
            $notificacion = new Notificacion();
            $notificacion = self::setEverything($data_table, $notificacion, $clave);
        }
        return $notificacion;
    }
    
    /* Devuelve las solicitudes de pareja realizadas por un usuario, y por lo tanto si esta pendiente de aceptacion en un torneo */
    /* Devuelve una notificacion unica por que un usuario emisor no puede mandar varias solicitudes de pareja para un mismo torneo */
    
    public static function selectByTorneoAndUsuarioEnlazadoAndTipo($idTorneo, $idUsuario, $tipo){
        $data_source = new SingletonDataSource(); 
        $data_source = $data_source->getInstance(); 
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM notificaciones WHERE idTorneoEnlazado = :idTorneo AND idUsuarioEnlazado = :idUsuario AND Tipo = :tipo", 
            array(':idTorneo' => $idTorneo, ':idUsuario' => $idUsuario, ':tipo' => $tipo)); 
        
        $notificacion = NULL; 
        if(count($data_table) > 0){
            foreach($data_table as $clave => $valor){
                $notificacion = new Notificacion(); 
                $notificacion = self::setEverything($data_table,$notificacion, $clave); 
            }
        }
        return $notificacion; 
    }
    
    /* Devuelve las solicitudes de pareja recibidas por un usuario, y por lo tanto la posibilidad de aceptar o 
     * rechazar la solicitud de pareja para el torneo. 
     * Devuelve un id unico porque un usuario no puede recibir varias solicitudes de pareja para un mismo torneo. 
     */
    public static function selectByTorneoAndUsuarioReceptorAndTipo($idTorneo, $idUsuario, $tipo){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT * FROM notificaciones WHERE idTorneoEnlazado = :idTorneo AND UsuarioReceptor = :idUsuario AND Tipo = :tipo",
            array(':idTorneo' => $idTorneo, ':idUsuario' => $idUsuario, ':tipo' => $tipo));
        
        $notificacion = NULL; 
        if(count($data_table) > 0){
            foreach($data_table as $clave => $valor){
                $notificacion = new Notificacion();
                $notificacion = self::setEverything($data_table,$notificacion, $clave);
            }
        }
        return $notificacion; 
    }
    
    public static function obtenerUltimoIdNotificacion(){
        $data_source = new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $data_table = $data_source->ejecutarConsulta("SELECT MAX(id) AS maximo FROM notificaciones");
        return $data_table[0]["maximo"];
    }
    
    
    
    public static function insertNotificacion(Notificacion $notificacion){
        $data_source = new SingletonDataSource(); 
        $data_source = $data_source->getInstance(); 
        $sql = "INSERT INTO notificaciones (`Tipo`,`UsuarioReceptor`,`idUsuarioEnlazado`
            , `idPartidoAmistosoEnlazado`,`idTorneoEnlazado`, `idPartidoTorneoEnlazado`) VALUES (
               :tipo, :usuarioReceptor, :idUsuarioEnlazado, :idPartidoAmistosoEnlazado, 
                :idTorneoEnlazado, :idPartidoTorneoEnlazado)"; 
        $resultado = $data_source->ejecutarActualizacion($sql,array(
            ':tipo' => $notificacion->getTipo(), 
            ':usuarioReceptor' => $notificacion->getUsuarioReceptor(),
            ':idUsuarioEnlazado' => $notificacion->getIdUsuarioEnlazado(),
            ':idPartidoAmistosoEnlazado' => $notificacion->getIdPartidoAmistosoEnlazado(),
            ':idTorneoEnlazado' => $notificacion->getIdTorneoEnlazado(), 
            ':idPartidoTorneoEnlazado' => $notificacion->getIdPartidoTorneoEnlazado()
            ));
        return $resultado; 
    }
    
    public static function deleteNotificacion($id){
        $data_source= new SingletonDataSource();
        $data_source = $data_source->getInstance();
        $resultado = $data_source->ejecutarActualizacion("DELETE FROM notificaciones WHERE
        Id = :id", array(':id' => $id));
        return $resultado;
    }
    
    
    public static function setEverything($data_table = array(), Notificacion $notificacion, $clave){
        $notificacion->setId($data_table[$clave]["Id"]); 
        $notificacion->setTipo($data_table[$clave]["Tipo"]);
        $notificacion->setUsuarioReceptor($data_table[$clave]["UsuarioReceptor"]); 
        $notificacion->setIdUsuarioEnlazado($data_table[$clave]["idUsuarioEnlazado"]); 
        $notificacion->setIdPartidoAmistosoEnlazado($data_table[$clave]["idPartidoAmistosoEnlazado"]); 
        $notificacion->setIdTorneoEnlazado($data_table[$clave]["idTorneoEnlazado"]); 
        $notificacion->setIdPartidoTorneoEnlazado($data_table[$clave]["idPartidoTorneoEnlazado"]); 
        return $notificacion; 
    }
    
}