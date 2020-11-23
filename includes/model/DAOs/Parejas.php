<?php
class Parejas{
    private $idPareja;
    private $idIntegrante1;
    private $idIntegrante2;
    private $torneoAsociado; 
    private $efectividad;
    private $enVigor; 
    
    public function setIdPareja($id){
        $this->idPareja = $id; 
    }
    public function getIdPareja(){
        return $this->idPareja;
    }

    public function setIdIntegrante1($id){
        $this->idIntegrante1 = $id; 
    }
    public function getIdIntegrante1(){
        return $this->idIntegrante1;
    }

    public function setIdIntegrante2($id){
        $this->idIntegrante2 = $id; 
    }
    public function getIdIntegrante2(){
        return $this->idIntegrante2;
    }
    
    public function setTorneoAsociado($id){
        $this->torneoAsociado = $id; 
    }
    public function getTorneoAsociado(){
        return $this->torneoAsociado; 
    }

    public function setEfectividad($efect){
        $this->efectividad = $efect;
    }
    public function getEfectividad(){
        return $this->efectividad;
    }
    
    public function setEnVigor($v){
        $this->enVigor = $v; 
    }
    public function getEnVigor(){
        return $this->enVigor; 
    }
}
?>