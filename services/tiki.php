<?php

//////////// nueva rescatada
class TikiLive{
	// API
	public $token;
	public $username;
	public $password;
	public $apiId;
	public $apiKey;
	public $response;
	public $method;
	public $url;

	// TikiLive DB
	private $db_servidor;
	private $db_base;
	private $db_usuario;
	private $db_contrasena;
	private $db_conexion;

	// Usuario
	public $id;
	public $usuario;
	public $nombre;
	public $apellido;
	public $contrasena;
	public $correo;
	public $estado;
	public $paquetes;

	public function __construct() {
		if(/*PRODUCCIONP*/false){
			// API
			$this->apiId = 1999549; // replace XXX with your Application ID
			$this->baseUrl = 'https://ver.woplay.tv/api/'. $this->apiId . '/'; //replace xxxxx.com with your domain.com
			// $this->baseUrl = 'ver.woplay.tv/api/'. $this->apiId . '/'; //replace xxxxx.com with your domain.com
			$this->apiKey = 'BgbKdGdJY0w1593M'; // replace XXXXXXXXXX with your Api Key
			$this->authKey = '<guest>';
			$this->username = "raulalva3";
			$this->password = "Askapa72";

			// Mysql
			// $this->db_servidor = "144.217.243.129"; // Proxy para conexion local
			$this->db_servidor = "64.71.169.31";
			$this->db_base = "woplay_live";
			$this->db_usuario = "woplay_ro";
			$this->db_contrasena = "hPmhWHIB3P";
		}else{
			// API
			$this->apiId = 15; // replace XXX with your Application ID
			$this->baseUrl = 'http://testarea.ver.woplay.tv/api/'. $this->apiId . '/'; //replace xxxxx.com with your domain.com
			$this->apiKey = 'jdKMz5w8QpAeZEO0'; // replace XXXXXXXXXX with your Api Key
			$this->authKey = '<guest>';
			$this->username = "rauletealva";
			$this->password = "Askapa72";

			// Mysql
			$this->db_servidor = "64.71.169.31"; // Proxy para conexion local
			// $this->db_servidor = "184.105.77.52";
			$this->db_base = "woplay_testarea";
			$this->db_usuario = "woplay_test_ro";
			$this->db_contrasena = "a34xNB16TJ";
		}

	}

	public function authKeyUsingUserPass() {
		$response = $this->call("POST", 'authenticate', array("username"=>$this->username, "password" =>md5($this->password)));
		 //var_dump($response);exit;
		if (!empty($response->api_auth_key)) {
			$this->authKey =  $response->api_auth_key;
		}
	}

	//generate token
	public function getToken($uri) {
		if (empty($uri)) {
			return 'Invalid uri for token';
		}
		$signString = trim($this->method) . ':' . '/api/'. $this->apiId . '/'. $uri . ':' . $this->authKey;
		$token = hash_hmac('sha256', $signString, $this->apiKey, false);
		//var_dump($this->apiKey);
		return $token;
	}

	//make api calls
	public function call($method, $uri, $data='', $device=array()) {
		$ch = curl_init();
		var_dump($data);
		if (!empty($data)) {
			if ($method == "GET") {
				$this->url =  $this->baseUrl . $uri . "?" . http_build_query($data);
				$this->method = $method;
				$this->token = $this->getToken($uri . "?" . http_build_query($data));
			} else {
				$this->method = $method;
				$this->url = $this->baseUrl . $uri;
				$this->token = $this->getToken($uri);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			}
		} else {
			$this->url = $this->baseUrl . $uri;
			$this->method = $method;
			$this->token = $this->getToken($uri);
		}
		//var_dump($uri);
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $this->authKey .":". $this->token);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$this->response = curl_exec($ch);
		// $curl_error = curl_error($ch); // Guardar errores si los hay
		// var_dump($curl_error);
		curl_close($ch);
		//var_dump($this->response);
		return json_decode($this->response);
	}

	/*************** USUARIOS **************/
	public function usuarioBloquear($idUsuario,$motivo="Sin motivo"){
		$this->authKeyUsingUserPass();
		$resultado = $this->call(
								"POST",
								'users/'.$idUsuario.'/lock',
								array(
									'reason'=>$motivo
								)
							);
		if( $resultado && $resultado->status==200){
			return true;
		}elseif(  $resultado && stripos($resultado->reason, 'not found') ){
			return true;
		}else{
			agregarPool(__METHOD__,"$idUsuario");
			return false;
		}
	}

	public function usuarioDesbloquear($idUsuario){
		$this->authKeyUsingUserPass();
		$resultado = $this->call(
								"POST",
								'users/'.$idUsuario.'/unlock'
							);
		if( $resultado && $resultado->status==200){
			return true;
		}elseif( $resultado && stripos($resultado->reason, 'not found') ){
			return true;
		}else{
			agregarPool(__METHOD__,"$idUsuario");
			return false;
		}
	}

	public function usuarioCuentaCerrar($idUsuario){
		$this->authKeyUsingUserPass();
		$resultado = $this->call(
								"DELETE",
								'users/'.$idUsuario
							);
		if( $resultado && $resultado->status==200){
			return true;
		}elseif( $resultado && stripos($resultado->reason, 'not found') ){
			return true;
		}else{
			agregarPool(__METHOD__,"$idUsuario");
			return false;
		}
	}

	public function usuarioNuevo($usuario,$contrasena,$correo,$nombre,$apellido,$estado=1){
		
		global $oControlar;/*
		$usuario = $oControlar->cadena($usuario);
		$contrasena = $oControlar->cadena($contrasena);
		$correo = $oControlar->cadena($correo);
		$nombre = $oControlar->cadena($nombre);
		$apellido = $oControlar->cadena($apellido);
*/
//var_dump($oControlar);
//  var_dump($usuario); 
//  var_dump($contrasena); 
//  var_dump($correo); 
//  var_dump($nombre); 
//  var_dump($apellido); 
//  var_dump($estado);
// exit;
		$this->authKeyUsingUserPass();
		$resultado = $this->call(
								"POST",
								'users',
								array(
									'username'=>$usuario,
									'password'=>$contrasena,
									'email'=>$correo,
									'firstname'=>$nombre,
									'lastname'=>$apellido,
									'confirmed'=>1
								) 
							);
		 var_dump($resultado);
		// exit;
		if( $resultado && $resultado->status==200 && isset($resultado->id) ){
			var_dump($resultado->id);
			return $resultado->id;
		}elseif( $resultado && $resultado->errors) {
			return false;
		}else{
			return false;
		}

	}

	public function usuarioInfo($usuario,$username=false){ #por id o por nombre de usuario
		/*
		// Users - Retrieve data of an user
		$resultado = $this->call(
								"GET",
								'users/'.$idUsuario
							);
		var_dump($resultado);
		if( $resultado->status==200 ){
			return true;
		}else{
			return false;
		}
		*/
		$this->conectarTikiLiveDB();
		if($username){
			$where = "u.user_username = '$usuario'";
		}else{
			$where = "u.user_id = '$usuario'";
		}
		$sql = "SELECT
					u.user_id,
					u.user_username,
					u.user_password,
					u.user_email,
					(SELECT p.user_firstname FROM user_profile p WHERE p.user_id = u.user_id ) user_firstname,
					(SELECT p.user_lastname FROM user_profile p WHERE p.user_id = u.user_id ) user_lastname,
					u.user_locked,
					u.user_deleted,
				CASE
					WHEN u.user_locked = 0 AND u.user_deleted = '0' THEN 1		
					WHEN u.user_locked = 1 AND u.user_deleted = '1' THEN 2
					WHEN u.user_locked = 1 AND u.user_deleted = '0' THEN 3
					WHEN u.user_locked = 0 AND u.user_deleted = '1' THEN 4
				END estado
				FROM
					user u
				WHERE
					$where
				LIMIT 1
				";
		$resultado = $this->consultarTikiLive($sql);
		if ($resultado) {
			$paquetes = $this->comprobarPaquetes(75);
			$usuario = array(
				'id' => $resultado[0]['user_id'], 
				'usuario' => $resultado[0]['user_username'], 
				'nombre' => $resultado[0]['user_firstname'], 
				'apellido' => $resultado[0]['user_lastname'], 
				'contrasena' => $resultado[0]['user_password'], 
				'correo' => $resultado[0]['user_email'], 
				'estado' => $resultado[0]['estado'], 
				'paquetes' => $paquetes
			);
			/*
			$this->id = $resultado[0]['user_id'];
			$this->usuario = $resultado[0]['user_username'];
			$this->nombre = $resultado[0]['user_firstname'];
			$this->apellido = $resultado[0]['user_lastname'];
			$this->contrasena = $resultado[0]['user_password'];
			$this->correo = $resultado[0]['user_email'];
			$this->estado = $resultado[0]['estado'];
			*/
			return $usuario;
		}else{
			return false;
		}
		// $this->paquetes = $resultado[0]['aa'];

		// var_dump($resultado);		
		
	}


	public function usuarioActualizar($idUsuario,$parametro,$valor){
		// Parametros modificables [ password | email | firstname | lastname | confirmed ]
		$this->authKeyUsingUserPass();
		$resultado = $this->call(
								"PUT",
								'users/'.$idUsuario,
								array(
									$parametro=>$valor
								) 
							);
		// return $resultado;
		if( $resultado && $resultado->status==200 ){
			return true;
		}else{
			return false;
		}
	}

	/************ ACCIONES MYSQL **********/
	public function conectarTikiLiveDB(){

		@ $this->db_conexion = new mysqli($this->db_servidor, $this->db_usuario, $this->db_contrasena, $this->db_base);
		// var_dump($this->db_servidor);
		if( $this->db_conexion->connect_error ) {
			// echo "Conexión no se pudo establecer.<br />";
			// die( print_r( $this->db_conexion->connect_error) );
		} else{
			$this->db_conexion->set_charset("utf8");
		}

	}
	public function consultarTikiLive( $sql ) {
		if ($this->db_conexion) {
			$resultado = $this->db_conexion->query($sql);
			if(!$resultado){
				die($this->db_conexion->error);
			}else{
				$array = $resultado->fetch_all(MYSQLI_ASSOC);
				// var_dump($array);
				return $array;
			}
			$this->cerrar();
		}
	}

	public function cerrar(){
		mysqli_close( $this->db_conexion );
	}

	public function comprobarCorreo($correo){
		$this->conectarTikiLiveDB();
		$sql = "SELECT user_id FROM user WHERE user_email = '$correo'";
		$resultado = $this->consultarTikiLive($sql);
		if ($resultado) {
			return $resultado;
		}else{
			return false;
		}
	}

	public function comprobarUsuario($usuario){
		$this->conectarTikiLiveDB();
		$sql = "SELECT user_username FROM user WHERE user_username = '$usuario'";
		// var_dump($sql);
		$resultado = $this->consultarTikiLive($sql);
		if ($resultado) {
			return $resultado[0]['user_username'];
		}else{
			return false;
		}
	}

	public function comprobarId($usuario){
		$this->conectarTikiLiveDB();
		$sql = "SELECT user_id FROM user WHERE user_username = '$usuario'";
		// var_dump($sql);
		$resultado = $this->consultarTikiLive($sql);
		if ($resultado) {
			return $resultado[0]['user_id'];
		}else{
			return false;
		}
	}

	/*************** PAQUETES **************/
	public function comprobarPaquetes($idUsuario){
		$this->conectarTikiLiveDB();
		$paquetes = array();
		$sql = "SELECT 
					item_id
				FROM 
					channel_subscription
				WHERE 
					user_id = '$idUsuario'
					AND subscription_status = 'active'
					AND subscription_period_length >= 2"; 
		$resultado = $this->consultarTikiLive($sql);
// var_dump($sql);
		for ($i=0; $i < count($resultado); $i++) { 
			array_push($paquetes, $resultado[$i]['item_id']);
		}
		return $paquetes;
	}


	public function paquete($idUsuario,$paquete,$accion){
		$this->conectarTikiLiveDB();

		// Si es basico
		$sql = "SELECT channel_group_id FROM channel_group WHERE channel_group_id = '$paquete' LIMIT 1";
		if( $resultado = $this->consultarTikiLive($sql) ){
			// var_dump("basico");
			if( $accion=='agregar' ){
				return $this->asociarBasico($idUsuario,$paquete);
			}elseif( $accion=='quitar' ){
				return $this->quitarBasico($idUsuario,$paquete);
			}
		}

		// Si es premium
		$sql = "SELECT show_id FROM `show` WHERE show_id = '$paquete' LIMIT 1"; 
		if( $resultado = $this->consultarTikiLive($sql) ){
			// var_dump("premium maestrooo premium!!!");
			if( $accion=='agregar' ){
				return $this->asociarPremium($idUsuario,$paquete);
			}elseif( $accion=='quitar' ){
				return $this->quitarPremium($idUsuario,$paquete);
			}
		}


		/* POR API 
		// Plans - Retrieve details for one subscription plan
		// var_dump('asdasdad');
		// var_dump($idUsuario);
		// var_dump($paquete);
		// var_dump($accion);
		$resultado = $this->call(
								"GET",
								'plans/'.$paquete.'/standard'
							);
		// var_dump($resultado);
		if( $resultado && $resultado->status==200 ){
			if( $accion=='agregar' ){
				$this->asociarBasico($idUsuario,$paquete);
			}elseif( $accion=='quitar' ){
				$this->quitarBasico($idUsuario,$paquete);
			}
		}

		// Premium_Content - Retrieve data of a premium channel
		$resultado = $this->call(
								"GET",
								'premium-channels/'.$paquete
							);
		// var_dump($resultado);
		if( $resultado && $resultado->status==200 ){
			if( $accion=='agregar' ){
				$this->asociarPremium($idUsuario,$paquete);
			}elseif( $accion=='quitar' ){
				$this->quitarPremium($idUsuario,$paquete);
			}
		}


		// return $resultado;	
		return $resultado;
		*/
	}
	public function asociarBasico($idUsuario,$paquete){
		if( !in_array($paquete, $this->comprobarPaquetes($idUsuario)) ){
			// Users - Set user channel group
			$this->authKeyUsingUserPass();
			$resultado = $this->call(
									"PUT",
									'users/'.$idUsuario.'/channel-group',
									array(
										'channel_group_id'=>$paquete,
										'until'=>'2587593600'
										
									)
								);
			// var_dump($resultado); 'until'=>'2556143999'
			if( $resultado && $resultado->status==200 ) {
				return true;
			}else{
				agregarPool(__METHOD__,"$idUsuario,$paquete");
				return false;
			}
		}else{
			return true;
		}
	}
	public function quitarBasico($idUsuario,$paquete){
		if( in_array($paquete, $this->comprobarPaquetes($idUsuario)) ){
			$this->authKeyUsingUserPass();
			$resultado = $this->call(
									"PUT",
									'users/'.$idUsuario.'/channel-group',
									array(
										'channel_group_id'=>$paquete,
										'until'=>strtotime("+26 hours")
									)
								);
			// var_dump($resultado);
			if( $resultado && $resultado->status==200 ) {
				return true;
			}else{
				agregarPool(__METHOD__,"$idUsuario,$paquete");
				return false;
			}
		}else{
			return true;
		}		
	}
	public function asociarPremium($idUsuario,$paquete){
		if( !in_array($paquete, $this->comprobarPaquetes($idUsuario)) ){
			$this->authKeyUsingUserPass();
			$resultado = $this->call(
									"POST",
									'users/'.$idUsuario.'/grant-premium-channel',
									array(
										'channel_id'=>$paquete,
										'expiration_date'=>'12/31/2051'
									)
								);

			if( $resultado && $resultado->status==200 ) {
				return true;
			}else{
				agregarPool(__METHOD__,"$idUsuario,$paquete");
				return false;
			}
		}else{
			return true;
		}
	}
	public function quitarPremium($idUsuario,$paquete){
		if( in_array($paquete, $this->comprobarPaquetes($idUsuario)) ){
			$this->authKeyUsingUserPass();
			$resultado = $this->call(
									"POST",
									'users/'.$idUsuario.'/revoke-premium-channel',
									array(
										'channel_id'=>$paquete
									)
								);
			if( $resultado && $resultado->status==200 ) {
				return true;
			}else{
				agregarPool(__METHOD__,"$idUsuario,$paquete");
				return false;
			}
		}else{
			return true;
		}
	}


	public function usuarioListar(){
		// Users - User revoke access to a premium channel
		$this->authKeyUsingUserPass();
		$resultado = $this->call(
								"GET",
								'broadcasters',
								array(
									'order_by'=>'username',
									'direction'=>'ASC'
								)
							);
		return $resultado;
		
		if($resultado->status==200){
			return $resultado->broadcasters;
		}else{
			return false;
		}
		
	}

	public function usuariosPremium($idPaquete){
		// Users - User revoke access to a premium channel
		$this->authKeyUsingUserPass();
		$resultado = $this->call(
								"GET",
								'premium-channels/'.$idPaquete.'/subscriptions'
								/*,
								array(
									'order_by'=>'username',
									'direction'=>'ASC'
								)
								*/
							);
		return $resultado;
	}

	public function usuariosCanales($idPaquete){
		// Users - User revoke access to a premium channel
		$this->authKeyUsingUserPass();
		$resultado = $this->call(
								"GET",
								'users/'.$idPaquete.'/channel-group'
								/*,
								array(
									'order_by'=>'username',
									'direction'=>'ASC'
								)
								*/
							);
		return $resultado;
	}



}
$oTikiLive = new TikiLive;