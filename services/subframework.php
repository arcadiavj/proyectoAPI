<?php 

if( isset($_GET['ejecutar']) ){
	if( $_SERVER['SERVER_NAME'] == 'localhost' ){
		$raiz = $_SERVER['DOCUMENT_ROOT'].'/woplay/';
	}
	ini_set('include_path', $raiz.'inc/php/' );
// var_dump(getcwd());
	// var_dump(get_include_path());
	require_once 'webconfig.php';
	// require_once 'framework.php';
	$objeto = new Usuario;
	$ejecutar = $_GET['ejecutar'];

	if(stripos($ejecutar, '.')) {
		$objeto = substr($ejecutar, 0, stripos($ejecutar, '.'));
		// $objeto = new $objeto;
		var_dump($objeto);
		
		$ejecutar = str_replace($objeto.'.', '', $ejecutar);
	}
	if(stripos($ejecutar, '(')){
		$metodo = substr($ejecutar, 0, stripos($ejecutar, '('));
		$parametros = substr($ejecutar,  stripos($ejecutar, '(')+1,  stripos($ejecutar, ')')-7);
		if( stripos($parametros, ',') ) {
			$parametros = explode(',', $parametros);
		}else{
			$parametros = (array)$parametros;
		}
	}
	if( isset($objeto) && !stripos($ejecutar, '(')){
		$propiedad = $ejecutar;
	}


	// $objeto = substr($ejecutar, 0, stripos($ejecutar, '.'));
	// $objeto_metodo = substr($ejecutar, strlen($objeto)+1, stripos($ejecutar, '('));

	// $objeto = substr($ejecutar, 0, stripos($ejecutar, '.'));


	// preg_match_all('/.+?(?=\.)/s', $ejecutar, $objeto);
	// $objeto = $objeto[0][0];
	// var_dump($objeto);
	// var_dump($metodo);

	// $ejecutar = $ejecutar();
	// echo ( $ejecutar ) ? $ejecutar : "Error";
}



require_once 'class.datatable.php';
require_once 'class.eventos.php';
require_once 'class.sistema.php';
require_once 'class.paquete.php';
require_once 'class.usuario.php';
// require_once 'class.proveedores.php';
require_once 'class.solicitudes.php';
require_once 'class.notificaciones.php';
require_once 'class.contable.php';
require_once 'class.bonificaciones.php';
require_once 'class.tickets.php';
require_once 'class.promociones.php';
require_once 'class.tikilive.php';
/*
function leerParametro($string,$parametro){
	preg_match_all("/(?<=<$parametro>).*(?=<\/$parametro>)/ims", $string, $match);
	return trim($match[0][0]);
}

function lala(){
	echo "**************************";
}
*/

