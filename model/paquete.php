<?php

class Paquete{
protected $id;
protected $paquete;
protected $proveedor;
protected $nombre;
protected $precio;
protected $unitario;
protected $base;
protected $observaciones;
protected $estado;
protected $comision;
protected $idtiki;
protected $fecha_anterior;
protected $precio_anterior;
protected $unitario_anterior;

    public function __construct( $id, $paquete, $proveedor, $nombre, $precio, $unitario, $base, $observaciones,
    $estado, $comision, $idtiki, $fecha_anterior, $precio_anterior, $unitario_anterior){
    $this->$id=$id;
    $this->$paquete=$paquete;
    $this->$proveedor=$proveedor;
    $this->$nombre=$nombre;
    $this->$precio=$precio;
    $this->$unitario=$unitario;
    $this->$base=$base;
    $this->$observaciones= $observaciones;
    $this->$estado=$estado;
    $this->$comision= $comision;
    $this->$idtiki=$idtiki;
    $this->$fecha_anterior= $fecha_anterior;
    $this->$precio_anterior= $precio_anterior;
    $this->$unitario_anterior=$unitario_anterior;
    }




}