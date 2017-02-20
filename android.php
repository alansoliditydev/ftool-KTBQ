<?php
include 'functions.php';
$useragent = $_GET['user_agent'];

error_reporting(E_ALL & ~ E_NOTICE);

header('Origin: https://facebook.com');
define('API_SECRET', '62f8ce9f74b12f84c123cc23437a4a32');

define('BASE_URL', 'https://api.facebook.com/restserver.php');

function sign_creator(&$data){
    $sig = "";
    foreach($data as $key => $value){
        $sig .= "$key=$value";
    }
    $sig .= API_SECRET;
    $sig = md5($sig);
    return $data['sig'] = $sig;
}

if(isset($_POST['u'], $_POST['p'])){
    $_GET = $_POST;
}

$data = array(
    "api_key" => "882a8490361da98702bf97a021ddc14d",
    //"credentials_type" => "password",
    "email" => @$_GET['u'],
    "format" => "JSON",
//	"generate_machine_id" => "1",
//	"generate_session_cookies" => "1",
    "locale" => "vi_vn",
    "method" => "auth.login",
    "password" => @$_GET['p'],
    "return_ssl_resources" => "0",
    "v" => "1.0"
);
sign_creator($data);
$response = cURL_android('GET', false, $data, $useragent);
//$responseJSON = json_decode($api);
exit($response);
?>
