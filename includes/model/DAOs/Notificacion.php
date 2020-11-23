<?php

class Notificacion{
    
    private $id; 
    private $tipo; 
    private $usuarioReceptor; 
    private $idUsuarioEnlazado; 
    private $idPartidoAmistosoEnlazado; 
    private $idTorneoEnlazado;
    private $idPartidoTorneoEnlazado; 
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
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @return mixed
     */
    public function getIdPartidoTorneoEnlazado()
    {
        return $this->idPartidoTorneoEnlazado;
    }

    /**
     * @param mixed $idPartidoTorneoEnlazado
     */
    public function setIdPartidoTorneoEnlazado($idPartidoTorneoEnlazado)
    {
        $this->idPartidoTorneoEnlazado = $idPartidoTorneoEnlazado;
    }

    /**
     * @return mixed
     */
    public function getUsuarioReceptor()
    {
        return $this->usuarioReceptor;
    }

    /**
     * @return mixed
     */
    public function getIdUsuarioEnlazado()
    {
        return $this->idUsuarioEnlazado;
    }

    /**
     * @return mixed
     */
    public function getIdPartidoAmistosoEnlazado()
    {
        return $this->idPartidoAmistosoEnlazado;
    }

    /**
     * @return mixed
     */
    public function getIdTorneoEnlazado()
    {
        return $this->idTorneoEnlazado;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @param mixed $usuarioReceptor
     */
    public function setUsuarioReceptor($usuarioReceptor)
    {
        $this->usuarioReceptor = $usuarioReceptor;
    }

    /**
     * @param mixed $idUsuarioEnlazado
     */
    public function setIdUsuarioEnlazado($idUsuarioEnlazado)
    {
        $this->idUsuarioEnlazado = $idUsuarioEnlazado;
    }

    /**
     * @param mixed $idPartidoAmistosoEnlazado
     */
    public function setIdPartidoAmistosoEnlazado($idPartidoAmistosoEnlazado)
    {
        $this->idPartidoAmistosoEnlazado = $idPartidoAmistosoEnlazado;
    }

    /**
     * @param mixed $idTorneoEnlazado
     */
    public function setIdTorneoEnlazado($idTorneoEnlazado)
    {
        $this->idTorneoEnlazado = $idTorneoEnlazado;
    }
 
    
    
    
    
}