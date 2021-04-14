<?php
include_once "services/services.php";

$pepe = new Services();

$respuesta = $pepe->getUsuarios();
