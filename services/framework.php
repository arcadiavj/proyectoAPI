<?php 

//▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐

class Base{
	// global $baseTipo, $host, $base, $user, $pass;
	private $conexion;
	private $servidor = 'localhost';//HOST;
	private $base = 'proyecto';//BASE;
	private $usuario = 'root';//USER;
	private $contrasena = '';//PASS;
	private $baseTipo = 'mysql';
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	
	function __construct(){
		if ($this->baseTipo == 'sql'){
			$config = array( "Database"=>$this->base, "UID"=>$this->usuario, "PWD"=>$this->contrasena, "CharacterSet"=>"UTF-8", "ConnectionPooling" => "1", "MultipleActiveResultSets"=>'0' );
			$this->conexion = sqlsrv_connect( $this->servidor, $config);			
			if( !$this->conexion ) {
				echo "Conexión no se pudo establecer.<br />";
				die( print_r( sqlsrv_errors(), true));
			}
		}elseif($this->baseTipo == 'mysql'){
			$this->conexion = new mysqli($this->servidor, $this->usuario, $this->contrasena, $this->base);
			// var_dump($this->usuario);
			$this->conexion->set_charset("utf8");
			if( $this->conexion->connect_error ) {
				echo "Conexión no se pudo establecer.<br />";
				die( print_r( $this->conexion->connect_error) );
			} 
		}
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function consultar( $sql ) {
		if ($this->baseTipo == 'sql'){
			$resultado = sqlsrv_query( $this->conexion, $sql ); 
			if(!$resultado){
				die( print_r( sqlsrv_errors(), true));
			}else{
				$array = array();
				while ( $filas = sqlsrv_fetch_array( $resultado, SQLSRV_FETCH_ASSOC ) ) {
					$array[] = $filas;
				};
				return $array;
			}
		} elseif ($this->baseTipo == 'mysql') {
			$resultado = $this->conexion->query($sql);
			if(!$resultado){
				die($this->conexion->error);
			}else{
				$array = $resultado->fetch_all(MYSQLI_ASSOC);
				// var_dump($array);
				return $array;
			}
		}
		$this->cerrar();

	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////

	public function ejecutar( $sql ) {
		// var_dump($sql);
		if ($this->baseTipo == 'sql'){
			$resultado = sqlsrv_query( $this->conexion, $sql ); 
			if(!$resultado){
				die( print_r( sqlsrv_errors(), true));
			}else{
				return true;
			}
		} elseif ($this->baseTipo == 'mysql') {
			// var_dump($sql);
			// if( stripos($sql, ";") ){
				// $resultado = $this->conexion->multi_query($sql);
			// }else{
				$resultado = $this->conexion->query($sql);
			// }
				// var_dump($this->conexion->use_result());
			$id = $this->conexion->insert_id;
			if(!$resultado){
				die($this->conexion->error);
			}else{
				// var_dump($id);
				return $id;
				// return ($id > 0) ? $id : true;
			}
			// var_dump($resultado);
		}
		$this->cerrar();
		// if( isset($resultado) )
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////

	public function cerrar(){
		if ($this->baseTipo == 'sql'){
			// sqlsrv_free_stmt( $result );
			sqlsrv_close( $this->conexion );
		}elseif ($this->baseTipo == 'mysql') {
			mysqli_close( $this->conexion );
		}
	}

	// Devolver columnas de una tabla
	public function tablaCampos($tabla){
		$sql = "SELECT COLUMN_NAME 
				FROM information_schema.columns
				WHERE TABLE_NAME = '$tabla'";
		$resultado = $this->consulta($sql);
		$campos = array();
		for ($i=0; $i < count($resultado) ; $i++) { 
			$campos[] = $resultado[$i]['COLUMN_NAME'];
		}
		return $campos;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////

}
$oBase = new Base;

//▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐

class Archivo{

	//////////////////////////////////////////////////////////////////////////////////////////////////////

	// Existe archivo remoto
	public function existe($url){
		/*
		$curl=curl_init($url);
		curl_setopt($curl,CURLOPT_NOBODY,true);
		$respuesta=curl_exec($curl);
		$resultado=false;
		if($respuesta!==false){
			$estado=curl_getinfo($curl,CURLINFO_HTTP_CODE);  
			if($estado==200){
				$resultado=true;   
			}
		}
		curl_close($curl);
		return $resultado;
		*/
		return (@fopen($path,"r")==true);
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////

	// Chequear existencia de archivo (alternativa)
	public function archivoExiste($url){
		return (@fopen($url,"r")==true);
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////

	public function generarThumb($w,$h){
		// generar diferentes versiones para las imagenes de los articulos
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////
	public function generarPoster($url){
		// Necesita tener instalado FFMPEG
		file_get_contents("http://www.batallercontenidos.com/apps/videothumb.php?video=$url");
	}

	public function subirAvatar($archivo){
		if( stripos( $archivo['type'] , 'image' ) !== false ){
			$archivoDestino = $this->nombrarFechaHora($archivo);
			return ( move_uploaded_file( $archivo['tmp_name'], AVATARS.$archivoDestino) ) ? $archivoDestino : NULL;
		}
	}

	public function subirarchivo($archivo,$destino=NULL){
		return move_uploaded_file($archivo, $destino);

		// $ruta = explode('/', $destino);

		// if( !file_exists(date('Y')) ){
			// mkdir(date('Y'));
			// var_dump(date('m'));
			// if(!file_exists(date('Y')))
		// }
		// var_dump();

/*
		for ($i=0; $i < count($ruta) ; $i++) { 
			file_exists('')
		}
		var_dump($ruta);
		*/
		// var_dump($destino);
		// var_dump(file_exists(''));

		// 	elseif(){
		// 	// for ($i=0; $i < count($archivo) ; $i++) { 
		// 		var_dump($archivo);
		// 		// var_dump('sube via comun');
		// 	// }
		// }else{
		// 	return false;
		// }
	}

	public function subirDocumento($archivo,$destino){
		// move_uploaded_file( $archivo[''] , destination)
	}
	public function nombrarFechaHora($archivo){
		// var_dump($archivo);
		if( is_array($archivo) ){
			$archivoNombre = pathinfo($archivo['tmp_name'])['filename'];
			// var_dump($archivo);
			$archivoExtension = pathinfo($archivo['name'])['extension'];
		}elseif( is_string($archivo) ){
			$archivoExtension = substr($archivo, strripos($archivo, ".")+1 );
		}else{
			return NULL;
		}
		$archivo = date('YmdHms').'.'.strtolower($archivoExtension);
		return $archivo;
	}
	public function archivoInfo($archivo){
		$tipo = '';
		$nombre = '';
		$extension = '';
		$peso = '';
	}
	public function comprobarFormato($archivo,$formato){
		$extension = mime_content_type($archivo);
		$extension = substr($extension,strripos($extension, '/')+1 );
		// var_dump($extension);
		if(is_array($formato)){ 
			$formato = array_map('strtolower', $formato);
			return in_array($extension, $formato);
		}elseif( strtolower($extension)==strtolower($formato) ){
			return true;
		}else{
			return false;
		}
	}

	public function maximoPermitido() {
		static $maximo = -1;
		if ($maximo < 0) {
			// Start with post_max_size.
			$post_max_size = $this->parsearTamano(ini_get('post_max_size'));
			if ($post_max_size > 0) {
				$maximo = $post_max_size;
			}
			// If upload_max_size is less, then reduce. Except if upload_max_size is
			// zero, which indicates no limit.
			$upload_max = $this->parsearTamano(ini_get('upload_max_filesize'));
			if ($upload_max > 0 && $upload_max < $maximo) {
				$maximo = $upload_max;
			}
		}
		return $maximo/1048576;
	}

	function parsearTamano($tamano) {
		$unidad = preg_replace('/[^bkmgtpezy]/i', '', $tamano); // Remove the non-unit characters from the size.
		$tamano = preg_replace('/[^0-9\.]/', '', $tamano); // Remove the non-numeric characters from the size.
		if ($unidad) {
			// Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
			return round($tamano * pow(1024, stripos('bkmgtpezy', $unidad[0])));
		}else{
			return round($tamano);
		}
	}
}
$oArchivo = new Archivo;

//▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐

class Txt{
	public $archivo;

	public function leer($archivo=null){
		if( !$archivo ) $archivo = $this->archivo;
		$archivo = fopen($archivo, "r");
		if( $archivo == false ) return;
		$contenido = '';
		while(!feof($archivo)) {
			$contenido .=  fgets($archivo);
		}
		fclose($archivo);
		return utf8_encode(nl2br($contenido));
	}
	public function editar($contenido,$archivo=null,$reemplazar=true){
		// $reemplazar
		// "true" : reemplaza todo el contenido
		// "false" : agrega/suma contenido
		if( !$archivo ) $archivo = $this->archivo;
		$modo = ($reemplazar) ? "w" : "a";
		$archivo = fopen($archivo, $modo);
		fwrite($archivo, $contenido);
		fclose($archivo);
	}

	public function borrar($archivo=null){
		if( !$archivo ) $archivo = $this->archivo;
		if (file_exists($archivo)) unlink($archivo);
	}
}
$oTxt = new Txt;

//▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐

class Sesion extends Base{

	public $puerta='sesion',$retorno='',$maestra='753951';

	public function __construct(){
		$this->habilitar();
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////

	public function iniciar($usuario,$contrasena){
		// $usuario = filter_var( trim($usuario), FILTER_SANITIZE_STRING);
		// $contrasena = md5(filter_var( trim($contrasena), FILTER_SANITIZE_STRING));
		

	}

//////////////////////////////////////////////////////////////////////////////////////////////////////

	function habilitar(){
		if(!isset($_SESSION)){
			@session_start();
		}
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////////

	function leer($variable){
		$this->habilitar();
		if(isset($_SESSION[$variable])){
			return $_SESSION[$variable];			
		}else{
			return '';
		}
	}	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////

	function escribir($variable,$valor){
		$_SESSION[$variable]=$valor;			
	}	
	
//////////////////////////////////////////////////////////////////////////////////////////////////////

	function estado(){
		if($this->leer('id')!=''){
			return 1;
		}else{
			return 0;
		}
	}
}
$oSesion = new Sesion;

//▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐

class Controlar{

	/////////////// String

	// Simplifica una cadena de texto para usarla como URL amigable
	public function textoUrl($cadena) {
		$limitePalabras = 50;
		// Elimina espacios al princio y al final
		$cadena = trim($cadena);
		// Elimina tags
		$cadena = strip_tags($cadena);
		// Pasar a minusculas
		$cadena = mb_strtolower($cadena);
		// Elimina caracteres extraños
		$eliminar = array('!','¡','?','¿','‘','’','“','”','"','$','(',')','.',':',',',';','_','-','\'','/','\\','$','%','@','#','*','«', '»','[',']','{','}','<','>','+','|','~','&','`','^','=');
		$cadena = str_replace($eliminar,'',$cadena);
		// Reemplazar acentos y ñ
		$acentos = array('á','é','í','ó','ú','Á','É','Í','Ó','Ú','ñ','Ñ','ü','à','è','ì','ò','ù','À','È','Ì','Ò','Ù');
		$reemplazo = array('a','e','i','o','u','a','e','i','o','u','n','n','u','a','e','i','o','u','A','E','I','O','U');
		$cadena = str_replace($acentos, $reemplazo, $cadena);
		// Reemplazar articulos, preposiciones y conjunciones
		$palabras = array(
						// Preposiciones
						' a ',' ante ',' bajo ',' con ',' de ',' desde ',' durante ',' en ',' entre ',' excepto ',' hacia ',' hasta ',' mediante ',' para ',' por ',' salvo ',' según ',' sin ',' sobre ',' tras ',
						// Articulos
						' un ',' unos ',' una ',' unas ',' el ',' la ',' las ',' lo ',' los ',
						// Conjunciones
						' y ',' e ',' ni ',' o ',' u ',' ya ',' pero ',' mas ',' sino ',' bien ',' ya ',' pero ',' mas ',' sino ',' luego ',' conque ',' asi ',' porque ',' pues ',' si ',' que ',' como ',' aunque ',' aun ',' que ',' no '
						);
		$cadena = str_replace($palabras, ' ', $cadena);
		// Reemplazar espacios dobles por simples
		$cadena = $this->espacios($cadena);
		// Crear un extracto si excede
		if( $this->contarPalabras($cadena) > $limitePalabras ) $cadena = $this->extracto($cadena,$limitePalabras);
		// Reemplazar espacios por guiones
		$cadena = str_replace(' ','-',$cadena);
		return $cadena;
	}
	// Elimina espacios dobles de una cadena
	public function espacios($cadena) {
		$cadena = str_replace("&nbsp;"," ",$cadena);
		$cadena = preg_replace('/(\s^\n){2,}/', ' ', $cadena);
		$cadena = trim( $cadena );
		return $cadena; 
	}
	// Generar un extracto
	public function extracto($cadena, $limite=100){
		$cadena = $this->espacios($cadena);
		$cadena = explode(' ', $cadena);
		$cadena = array_slice($cadena, 0,$limite);
		$cadena = implode(' ', $cadena);
		// var_dump($cadena);
		return $cadena;
	}
	// Contar palabras
	public function contarPalabras($cadena){
		$palabras = explode(' ', $cadena);
		return $palabras;	
	}
	// Hash contraseña
	public function contrasenaCrear($cadena){
		$cadena = mb_strtoupper($cadena);
		return ( strlen($cadena)>0 ) ? md5($cadena) : NULL;
	}
	// Hash contraseña
	public function contrasenaVerificar($cadena,$cadena2){
		return ( md5($cadena) == $cadena2 ) ? true : false;
	}
	// String seguro
	public function cadena($cadena){
		$cadena = trim($cadena);
		$cadena = filter_var($cadena,FILTER_SANITIZE_STRING);
		$cadena = mb_strtoupper($cadena);
		$cadena = str_replace('\N', '\n', $cadena);
		$cadena = $this->espacios($cadena);
		return (strlen($cadena)>0) ? $cadena : NULL;
	}
	// Empieza con
	public function empiezaCon($cadena, $buscar) {
		$cadena = trim($cadena);
		return $buscar === "" || strrpos($cadena, $buscar, -strlen($cadena)) !== false;
	}
	// Termina con
	public function terminaCon($cadena, $buscar) {
		$cadena = trim($cadena);
		return $buscar === "" || (($temp = strlen($cadena) - strlen($buscar)) >= 0 && strpos($cadena, $buscar, $temp) !== false);
	}

	/////////////// NUMEROS

	// Convertir a decimal
	public function decimal($valor,$cifras=2){
		// $valor = str_replace('.', '', $valor);
		$valor = str_replace('.', '', $valor);
		$valor = str_replace(',', '.', $valor);
		return ($valor) ? $valor : NULL;
		// var_dump($valor;
		// return ( strlen($valor)>0 ) ? number_format( $valor,$cifras,"",".") : NULL;
		// $valor = (empty($valor)) ?  : $valor;
	}
	public function entero($valor){
		$valor = filter_var($valor,FILTER_SANITIZE_NUMBER_INT);
		$valor = preg_replace('~\D~', '', $valor);
		$valor = (strlen($valor)>0 && is_numeric($valor) ) ? $valor : NULL;
		//var_dump($valor);
		return $valor;
	}
	public function moneda($valor){
		return number_format( $valor,2,',','.');
	}
	public function archivo($archivo){
		// var_dump($archivo);
		if( is_string($archivo['name']) && !empty($archivo['name']) ){
			$nuevo[] = array( 
							'nombre' => $archivo['name'], 
							'temporal' => $archivo['tmp_name'], 
							'tamano' => $archivo['size'], 
							'tipo' => $archivo['type'], 
							);
		}elseif( is_array($archivo['name']) && !empty($archivo['name'][0]) ){ 
			for ($i=0; $i < count($archivo['name']) ; $i++) { 
				$nuevo[] = array(
							'nombre' => $archivo['name'][$i], 
							'temporal' => $archivo['tmp_name'][$i], 
							'tamano' => $archivo['size'][$i], 
							'tipo' => $archivo['type'][$i], 
						);		
			}
		}else{
			$nuevo = NULL;
		}
		return $nuevo;
	}

}
$oControlar = new Controlar;

//▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐

class Url{
	/*
	public  function completa(){
		$resultado='http';
		if(@$_SERVER['HTTPS']=="on")$resultado.="s";
		$resultado.="://";
		if ($_SERVER["SERVER_PORT"]!="80"){
			$resultado.=$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$resultado.=$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $resultado;
	}
	*/

	public function completa(){
		return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}
	
	public function actualArchivo(){
		$urlArchivo = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[SCRIPT_NAME]";
		$urlArchivo = str_replace('.php', '', $urlArchivo);
		return htmlentities($urlArchivo);
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////

	public function servidor(){
		$resultado=$_SERVER["SERVER_NAME"];
		if($_SERVER["SERVER_PORT"]!="80")$resultado.=":".$_SERVER["SERVER_PORT"];
		return $resultado;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////

	// Chequear si una URL responde
	public function responde($url){
		$curl=curl_init($url);
		curl_setopt($curl,CURLOPT_NOBODY,true);
		$respuesta=curl_exec($curl);
		$resultado=false;
		if($respuesta!==false){
			$estado=curl_getinfo($curl,CURLINFO_HTTP_CODE);  
			if($estado==200){
				$resultado=true;   
			}
		}
		curl_close($curl);
		return $resultado;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////

	// Extraer partes de una URL
	public function extraer($parte,$url=''){
		if($url=''){$url=$this->actual();}
		$resultado='';
		switch ($parte) {
			case 'archivo':
				$subresultado=explode('?',basename($this->actual()));
				$resultado=$subresultado[0];
				break;
			case 'servidor':
				$resultado=parse_url($url,PHP_URL_HOST);
				break;
		}
		return $resultado;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////

	// Ir a una URL usando diferentes metodos
	public function ir($url,$modo='j'){
		global $oCadena;
		switch($modo){
			case 'j': //javascript
				echo '<script>window.location.href="'.$url.'"</script>';
				break;
			case 'p': //php
				header('Location: '.$url);
				//header('refresh:0;url='.$url);
				exit;
				break;
		}		
	}
}
$oUrl = new Url;

//▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐

class Fecha{
	public function formatear($fecha,$formato=NULL,$hora=NULL){
		if ( stripos($fecha, " ") ){
			$fecha = explode(" ", $fecha);
			$calendario = $fecha[0];
			$reloj = substr($fecha[1], 0, -3);
		}else{
			$calendario = $fecha;
		}
		$fechaArray = explode('-', $calendario);
		$dia = $fechaArray[2];
		$diaNombre = $this->diaNombre(date('w', strtotime($calendario)));
		$mes = $fechaArray[1];
		$mesNombre = $this->mesNombre($fechaArray[1]);
		$anio = $fechaArray[0];
		switch ($formato) {
			case 0: 
				# 23/12/2017
				$fechaFormteada = $dia."/".$mes."/".$anio;
				break;
			case 1: 
				# Sábado, 23 de Diciembre de 2017
				$fechaFormteada = $diaNombre.', '.$dia.' de '.$mesNombre.' de '.$anio;
				break;
			case 2: 
				# Sáb. 23 de Diciembre, 2017
				$fechaFormteada = substr($diaNombre, 0, 4).'. '.$dia.' de '.$mesNombre.', '.$anio;
				break;
			case 3:
				# 23 de Diciembre de 2017
				$fechaFormteada = $dia.' de '.$mesNombre.' de '.$anio;
				break;
			case 4:
				# 23, Dic. 2017
				$fechaFormteada =  $dia.', '.substr($mesNombre, 0, 3).'. '.$anio;
				break;
			case 5:
				# Diciembre 23, 2017
				$fechaFormteada = $mesNombre.' '.$dia.', '.$anio;
				break;
			case 6:
				# Dic. 23, 2017
				$fechaFormteada = substr($mesNombre, 0, 3).'. '.$dia.', '.$anio;
				break;

		}
		if($hora) $fechaFormteada.= ' - '.$reloj;
		return $fechaFormteada;
	}
	public function invertir($fecha){
		$fecha = explode('-', $fecha);
		$fecha = array_reverse($fecha);
		$fecha = implode('-', $fecha);
		return $fecha;
	}

	public function mesNombre($mes){
		switch($mes){ 
			case '1':$mes = "Enero"; break;
			case '2':$mes = "Febrero"; break;
			case '3':$mes = "Marzo"; break;
			case '4':$mes = "Abril"; break;
			case '5':$mes = "Mayo"; break;
			case '6':$mes = "Junio"; break;
			case '7':$mes = "Julio"; break;
			case '8':$mes = "Agosto"; break;
			case '9':$mes = "Septiembre"; break;
			case '10':$mes = "Octubre"; break;
			case '11':$mes = "Noviembre"; break;
			case '12':$mes = "Diciembre"; break;
		} 
		// y por ultimo regresamos el valor obtenido 
		return $mes; 
	} 

	public function diaNombre($dia){
		switch($dia){ 
			case '0':$dia = "Domingo"; break; 
			case '1':$dia = "Lunes"; break; 
			case '2':$dia = "Martes"; break; 
			case '3':$dia = "Miércoles"; break; 
			case '4':$dia = "Jueves"; break; 
			case '5':$dia = "Viernes"; break; 
			case '6':$dia = "Sábado"; break; 
		}
		return $dia;
	}

	public function hoy(){
		return date('Y-m-d');
	}
	public function ya(){
		return date('Y-m-d H:i:s');
	}

	public function hace($fecha){
		$fecha = strtotime($fecha);
		$diferencia = time() - $fecha ;
		$segundos = $diferencia;
		$minutos = round($diferencia / 60 );
		$horas = round($diferencia / 3600 );
		$dias = round($diferencia / 86400 );
		$semanas = round($diferencia / 604800 );
		$mes = round($diferencia / 2419200 );
		$anio = round($diferencia / 29030400 );

		if($segundos <= 60){
			$hace = "Hace segundos";
		}elseif($minutos <=60){
			$hace = ($minutos==1) ? "un minuto" : "$minutos minutos";
		}elseif($horas <=24){
			$hace = ($horas==1) ? "una hora" : "$horas horas";
		}elseif($dias <= 7){
			$hace = ($dias==1) ? "un día" : "$dias días";
		}elseif($semanas <= 4){
			$hace = ($semanas==1) ? "una semana" : "$semanas semanas";
		}elseif($mes <=12){
			$hace = ($mes==1) ? "un mes" : "$mes meses";
		}else{
			$hace = ($anio==1) ? "un año" : "$anio años";
		}
		return "Hace ".$hace;
	}
	public function sumarDias($fecha,$dias){
		$fecha = date($fecha);
		$nuevafecha = strtotime ( "$dias day" , strtotime($fecha) ) ;
		$nuevafecha = date ( "Y-m-d" , $nuevafecha );
		// $nuevafecha = date ( "Y-m-d h:i:s" , $nuevafecha );
		return $nuevafecha;
	}
	public function sumarMeses($cantidad,$fecha=NULL){
		if (!$fecha) $fecha = date('Y-m');
		$fecha = strtotime(date("Y-m-d", strtotime($fecha)) . " $cantidad month");
		$fecha = date("Y-m",$fecha);
		return $fecha;
	}
	public function diasEntreFechas($fecha1,$fecha2,$inclusive=false){
		$fecha1 = strtotime($fecha1);
		if( $inclusive ) $fecha2 = $this->sumarDias($fecha2,+1);
		$fecha2 = strtotime($fecha2);
		$calculo = $fecha2 - $fecha1;
		return (int) round($calculo / (60 * 60 * 24));
		// return
	}
	public function mesAnterior($fecha){
		$fecha = "$fecha first day of last month";
		$fecha = date_create($fecha);
		return $fecha->format('Y-m');
	}

}
$oFecha = new Fecha;

//▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐

class Cookies{

	public function crear($nombre,$valor,$tiempo=1){ // tiempo en dias
		setcookie( mb_strtolower(APP_NOMBRE)."[$nombre]", $valor, time() +84600*$tiempo );
		$tmp = strtolower(APP_NOMBRE)."[$nombre]";
		// var_dump($tmp);
		$_COOKIE["$tmp"] = $valor;
	}
	public function leer($nombre){
		$nombre = mb_strtolower($nombre);
		return $_COOKIE[$nombre];
	}
	public function eliminar($nombre){
		unset($_COOKIE[$nombre]);
	}
	public function existe($nombre){
		$nombre = mb_strtolower($nombre);
		/*
		if( stripos($nombre, "[") ){
			$nombre = str_replace("]", "", $nombre);
			$nombre = str_replace("[", "][", $nombre);
		}

		var_dump($_COOKIE[$nombre]);
		*/
		return ( isset($_COOKIE[$nombre]) ) ? true : false;
	}
}
$oCookies = new Cookies;

//▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐

class Correo{
	public $destinatario;
	public $asunto;
	public $cuerpo;
	// public $sesion;
	function __construct(){
		// $this->recuperarContrasena('raulalva3@gmail.com');
	}

	public function enviar(){
		if ( !empty($this->destinatario) && !empty($this->asunto) && !empty($this->cuerpo) ) {
			// var_dump($this->destinatario);
			if (is_string($this->destinatario)) {
				$this->destinatario = explode(';', $this->destinatario);
			}
			require_once 'phpmailer.php';
			require_once 'phpmailer.smtp.php';

			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->IsHTML(true); 
			$mail->CharSet = "utf-8";
			$mail->Port = CORREO_PUERTO;
			$mail->Host = CORREO_SMTP; 
			$mail->Username = CORREO_USUARIO; 
			$mail->Password = CORREO_CONTRASENA;
			$mail->From = CORREO_USUARIO;
			$mail->FromName = APP_NOMBRE;
			for ($i=0; $i < count($this->destinatario) ; $i++) { 
				$mail->addBCC(trim($this->destinatario[$i]));
			}
			$mail->Subject = $this->asunto;
			$mail->Body = $this->cuerpo;
			$mail->AltBody = strip_tags( preg_replace('/\<br(\s*)?\/?\>/i', "\n", $this->cuerpo) );
			$estadoEnvio = $mail->Send(); 
			// var_dump($estadoEnvio);
			if($estadoEnvio){
				return true;
			} else {
				return false;
			}
		}else{
			return false;
		}
	}

	public function recuperarContrasena($correo){
		$correo = mb_strtolower($correo);
		$this->destinatario = $correo;
		$this->asunto = "Recuperación de contraseña";
		$this->cuerpo = "<html>
							<body class='hold-transition login-page' style='padding: 0px 30px;'>
								<h2>Recuperación de contraseña</h2>
								<p><strong>Recientemente se solicitó un cambio de contraseña para el inicio de sesión en ".APP_NOMBRE.".</strong></p>
								<p>Para finalizar el proceso presionar ir al siguiente enlace:</p>
								<br>
								<p><a href='".APP_URL."recuperar?cuenta=".$correo."&token=".session_id()."' style='border: 1px solid gray; padding:10px' >CAMBIAR CONTRASEÑA</a></p>
								<br>
								<p>De no estar seguro de continuar el proceso, omitir este correo.</p>
								<br>
								<br>
								<small>".APP_NOMBRE."</small>
								<br>
								<br>
							</body>
						</html>";
		// var_dump($this);
		// echo $this->cuerpo;
		// var_dump(session_id());
		$this->enviar();
	}
}
$oCorreo = new Correo;



//▐▐▐▐▐▐▐▐ FUNCIONES▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐▐
function agregarPool($metodo,$parametros){
	global $oBase;
	$clase = NULL;
	if(stripos($metodo, "::")){
		$metodo = explode("::", $metodo);
		$clase = $metodo[0];
		$metodo = $metodo[1];
	}
	$sql = "INSERT IGNORE INTO sistema_pool (clase,metodo,parametros,fecha) VALUES ('$clase','$metodo','$parametros',NOW())";
	$oBase->ejecutar($sql);
}

function modoMantenimiento(){
	if ( $_SESSION['rol'] > 1 ) {
		session_start();
		session_unset();
		session_destroy();
		// if( $oCookies->existe(APP_NOMBRE) ) $oCookies->eliminar(APP_NOMBRE);
		header('location: '.HOME.'?mantenimiento');
	}
}

function buscarArrayM($array, $key, $value,$devolver=NULL) { 
	if (is_array($array)) { 
		for ($i=0; $i < count($array) ; $i++) { 
			if( $array[$i][$key]==$value ) 
				return ($devolver) ? $array[$i][$devolver] : $i;
		}
	}
	return false; 
} 

function eliminarElementoValor($array,$valor){
	if (($key = array_search($valor, $array)) !== false) {
		unset($array[$key]);
	}
	return;
}

/*

function buscarArrayM($products, $field, $value){
	// var_dump($field);
	// var_dump($value);
	foreach($products as $key => $product) {
		if ( $product[$field] == $value )
			return $key;
	}
	return false;
}
/*
function buscarArrayM($array, $clave, $valor){
	$resultado = array();
	if (is_array($array)) {
		if (isset($array[$clave]) && $array[$clave] == $valor) {
			$resultado[] = $array;
		}
		foreach ($array as $subarray) {
			$resultado = array_merge($resultado, buscarArrayM($subarray, $clave, $valor));
		}
	}
	return $resultado;
}
*/

include 'subframework.php';