<?php

class PartidosTorneos{
    private $id; 
    private $nombre; 
    private $pareja1; 
    private $pareja2; 
    private $torneoAsociado; 
    private $parejaGanadora; 
    private $resultados; 
    private $fechaInicio; 
    private $hora;
    private $ronda; 
    /**
     * @return mixed
     */
    public function getRonda()
    {
        return $this->ronda;
    }

    /**
     * @param mixed $ronda
     */
    public function setRonda($ronda)
    {
        $this->ronda = $ronda;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return mixed
     */
    public function getPareja1()
    {
        return $this->pareja1;
    }

    /**
     * @return mixed
     */
    public function getPareja2()
    {
        return $this->pareja2;
    }

    /**
     * @return mixed
     */
    public function getTorneoAsociado()
    {
        return $this->torneoAsociado;
    }

    /**
     * @return mixed
     */
    public function getParejaGanadora()
    {
        return $this->parejaGanadora;
    }

    /**
     * @return mixed
     */
    public function getResultados()
    {
        return $this->resultados;
    }

    /**
     * @return mixed
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @param mixed $pareja1
     */
    public function setPareja1($pareja1)
    {
        $this->pareja1 = $pareja1;
    }

    /**
     * @param mixed $pareja2
     */
    public function setPareja2($pareja2)
    {
        $this->pareja2 = $pareja2;
    }

    /**
     * @param mixed $torneoAsociado
     */
    public function setTorneoAsociado($torneoAsociado)
    {
        $this->torneoAsociado = $torneoAsociado;
    }

    /**
     * @param mixed $parejaGanadora
     */
    public function setParejaGanadora($parejaGanadora)
    {
        $this->parejaGanadora = $parejaGanadora;
    }

    /**
     * @param mixed $resultados
     */
    public function setResultados($resultados)
    {
        $this->resultados = $resultados;
    }

    /**
     * @param mixed $fechaInicio
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }

 
}