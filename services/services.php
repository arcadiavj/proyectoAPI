<?php

/*$header = array();
$header['token']='abc123' ;

curl_setopt($ch, CURLOPT_URL, "http://localhost/proyecto17-3/app/apiRest/v1/usuarios");
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'x-token: abc123' ));
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$res = curl_exec($ch);
$res = json_encode($res);
print($res);
curl_close($ch);

//$data = json_encode(file_get_contents('http://localhost/proyecto17-3/app/apiRest/v1/bonificaciones'),true);
//var_dump($data);
*/
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL => "http://localhost/proyecto17-3/app/apiRest/v1/usuarios",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "token: abc123"
      ),
     ));
$res = curl_exec($ch);
//$res = json_encode($res);
print($res);
curl_close($ch);