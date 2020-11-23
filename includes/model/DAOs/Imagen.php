<?php
class Imagen{
    
    
    private $id; 
    private $idTorneo; 
    private $idPartidoAmistoso; 
    private $localizacionCargador; 
    
    public function setId($id){
        $this->id = $id; 
    }
    public function getId(){
        return $this->id; 
    }
    
    public function setIdTorneo($id){
        $this->idTorneo = $id; 
    }
    public function getIdTorneo(){
        return $this->idTorneo; 
    }
    
    public function setIdPartidoAmistoso($id){
        $this->idPartidoAmistoso = $id; 
    }
    public function getIdPartidoAmistoso(){
        return $this->idPartidoAmistoso; 
    }
    
    public function setLocalizacionCargador($loc){
        $this->localizacionCargador = $loc; 
    }
    public function getLocalizacionCargador(){
        return $this->localizacionCargador; 
    }
    
}