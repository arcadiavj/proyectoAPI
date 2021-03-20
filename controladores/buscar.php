<?php
require_once 'ControladorGeneral.php';
require_once 'ControladorBonificaciones.php';
require_once 'ControladorContable_resumen.php';

$consulta = new ControladorContable_resumen();

$consulta->buscar();


