<?php

class Usuario_model {
    private $id;    
    private $alta;
    private $usuario;
    private $contrasena;
    private $correo;
    private $idproveedor;
    private $proveedor;
    private $cuit;
    private $dni;
    private $nombre;
    private $apellido;
    private $domicilio;
    private $pais;
    private $provincia;
    private $ciudad;
    private $localidad;
    private $telefono1;
    private $telefono2;
    private $estado;
    private $plataforma;
    private $idtiki;
    private $paquete;
    
    public function __construct(/*$id, $alta, $usuario, $contrasena, $correo, $idproveedor, $proveedor, $cuit,
    $dni, $nombre, $apellido, $domicilio, $pais, $provincia, $ciudad, $localidad, $telefono1, $telefono2,
    $estado, $plataforma, $idtiki, $paquetes*/){
        /*$this->$id = $id;
        $this->$alta = $alta;
        $this->$usuario = $usuario;
        $this->$contrasena = $contrasena;
        $this->$correo = $correo;
        $this->$idproveedor = $idproveedor;
        $this->$proveedor = $proveedor;
        $this->$cuit = $cuit;
        $this->$dni = $dni;
        $this->$nombre = $nombre;
        $this->$apellido = $apellido;
        $this->$domicilio = $domicilio;
        $this->$pais = $pais;
        $this->$provincia = $provincia;
        $this->$ciudad = $ciudad;
        $this->$localidad = $localidad;
        $this->$telefono1 = $telefono1;
        $this->$telefono2 = $telefono2;
        $this->$estado = $estado;
        $this->$plataforma = $plataforma;
        $this->$idtiki = $idtiki;
        $this->$paquete = $paquete;*/
    }

    public function setUsuario($id, $alta, $usuario, $contrasena, $correo, $idproveedor, $proveedor, $cuit,
    $dni, $nombre, $apellido, $domicilio, $pais, $provincia, $ciudad, $localidad, $telefono1, $telefono2,
    $estado, $plataforma, $idtiki, $paquetes){
        $this->$id = $id;
        $this->$alta = $alta;
        $this->$usuario = $usuario;
        $this->$contrasena = $contrasena;
        $this->$correo = $correo;
        $this->$idproveedor = $idproveedor;
        $this->$proveedor = $proveedor;
        $this->$cuit = $cuit;
        $this->$dni = $dni;
        $this->$nombre = $nombre;
        $this->$apellido = $apellido;
        $this->$domicilio = $domicilio;
        $this->$pais = $pais;
        $this->$provincia = $provincia;
        $this->$ciudad = $ciudad;
        $this->$localidad = $localidad;
        $this->$telefono1 = $telefono1;
        $this->$telefono2 = $telefono2;
        $this->$estado = $estado;
        $this->$plataforma = $plataforma;
        $this->$idtiki = $idtiki;
        $this->$paquete = $paquete;
    }

    public function getUsuario(){
        return $this->$id;
    }
    
}