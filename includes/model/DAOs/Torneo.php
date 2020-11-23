<?php
class Torneo{
    private $idTorneo;
    private $nombre;
    private $numParejas; 
    private $efectividadRequerida; 
    private $premio; 
    private $direccion;
    private $provincia; 
    private $ciudad; 
    private $fechaInicio;
    private $fechaFin;
    private $fechaInscripcion;
    private $maxParejas;
    private $cerrado; 
    private $maxRondas; 
    private $rondaActual; 
    
    
    /**
     * @return mixed
     */
    public function getRondaActual()
    {
        return $this->rondaActual;
    }

    /**
     * @param mixed $rondaActual
     */
    public function setRondaActual($rondaActual)
    {
        $this->rondaActual = $rondaActual;
    }

    public function setIdTorneo($idTorneo){
        $this->idTorneo = $idTorneo; 
    }
    public function getIdTorneo(){
        return $this->idTorneo;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre; 
    }
    public function getNombre(){
        return $this->nombre;
    }

    public function setnumParejas($num){
        $this->numParejas = $num; 
    }
    /**
     * @return mixed
     */
    public function getMaxRondas()
    {
        return $this->maxRondas;
    }

    /**
     * @param mixed $maxRondas
     */
    public function setMaxRondas($maxRondas)
    {
        $this->maxRondas = $maxRondas;
    }

    public function getnumParejas(){
        return $this->numParejas;
    }

    public function setEfectividadRequerida($efect){
        $this->efectividadRequerida = $efect;
    }
    public function getEfectividadRequerida(){
        return $this->efectividadRequerida;
    }
    
    public function setPremio($prize){
        $this->premio = $prize;
    }
    public function getPremio(){
        return $this->premio;
    }

    public function setdireccion($direccion){
        $this->direccion = $direccion;
    }
    public function getdireccion(){
        return $this->direccion;
    }
    
    public function setProvincia($provincia){
        $this->provincia = $provincia; 
    }
    public function getProvincia(){
        return $this->provincia;
    }
    
    public function setCiudad($ciudad){
        $this->ciudad = $ciudad; 
    }
    public function getCiudad(){
        return $this->ciudad; 
    }

    public function setFechaInicio($ini){
        $this->fechaInicio = $ini;
    }
    public function getFechaInicio(){
        return $this->fechaInicio;
    }

    public function setFechaFin($fin){
        $this->fechaFin = $fin;
    }
    public function getFechaFin(){
        return $this->fechaFin;
    }
    
    public function setFechaInscripcion($ins){
        $this->fechaInscripcion = $ins;
    }
    public function getFechaInscripcion(){
        return $this->fechaInscripcion;
    }
    
    public function setmaxParejas($maxParejas){
        $this->maxParejas = $maxParejas;
    }
    public function getmaxParejas(){
        return $this->maxParejas;
    }
    
    public function setCerrado($cerrado){
        $this->cerrado = $cerrado; 
    }
    public function getCerrado(){
        return $this->cerrado; 
    }
}
?>