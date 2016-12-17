<?php
include 'functions.php';
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["app_id"])){
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $app_id = $_POST["app_id"];
    if(getenv('HOST_NAME')){
        $host = getenv('HOST_NAME');
    }
    else {
        $host = 'http://localhost';
    }
    if($app_id == 350685531728)
    {
        $useragent = array_rand($user_agent['android']);
        $app = 'android';
        $token = json_decode(file_get_contents($host.'/android.php?u='.$email.'&p='.$pass.'&user_agent='.$useragent.''),true);
    }else if($app_id == 165907476854626)
    {
        $useragent = array_rand($user_agent['iphone']);
        $app = 'iphone';
        $token = json_decode(file_get_contents($host.'/ios.php?u='.$email.'&p='.$pass.'&user_agent='.$useragent.''),true);

    }else if($app_id == 6628568379)
    {
        $useragent = array_rand($user_agent['iphone']);
        $app = 'iphone';
        $token = json_decode(file_get_contents($host.'/iphone.php?u='.$email.'&p='.$pass.'&user_agent='.$useragent.''),true);
    }
    if(isset($token['access_token'])) {
        $token_validating = validate_token($app,$token['access_token'],$useragent);
        //Debug $token_validating
//        exit(json_encode($token_validating));

        if($token_validating['status'] == 'ok'){
            $token_info['status'] = 'ok';
            $token_info['access_token'] = $token['access_token'];
        }
        else{
            $token_info['status'] = 'error';
            $token_info['error_msg'] = $token_validating['message'];
        }
    }
    else {
        $token_info['error_msg'] = $token['error_msg'];
        $token_info['status'] = 'error';
    }
    exit(json_encode($token_info));
}
?>