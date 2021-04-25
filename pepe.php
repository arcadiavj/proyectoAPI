<?php
include_once "services/services.php";
include_once "services/tiki.php";
$usuario=[
    "alta"=>"2018-11-13 10:44:10",
    "rol"=>5,
    "usuario"=>"hola40",
    "contrasena"=>"hola1234",
    "correo"=>"hola40@hotmail.com",
    "idproveedor"=>999,
    // "proveedor"=>"hola",
    "cuit"=>9999,
    "dni"=>9999,
    "nombre"=>"hola",
    "apellido"=>"hola",
    "avatar"=>"hola",
    "domicilio"=>"hola",
    "pais"=>1,
    "provincia"=>1,
    "ciudad"=>948,
    "localidad"=>16571,
    "observaciones"=>"hola",
    "telefono1"=>9999,
    "telefono2"=>9999,
    "estado"=>1,
    "datas"=>"hola",
    "plataforma"=>"hola",
    "subid"=>1,
    "ingreso"=>"2018-11-13 10:44:10"];

$pepe = new Services();
$respuesta = $pepe->getUsuarios(/*$usuario*/);