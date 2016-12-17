<?php
include 'functions.php';
$useragent = $_GET['user_agent'];
$user = $_GET['u'];
$pass = $_GET['p'];
/**
 ***		Script Refresh token IOS
 ***			by: ShareFBScripts.BlogSpot.Com
 ***				Copyright (c) 2016. ShareFBScripts
 **/


$cnf = array(
    'email' => $user,
    'pass' =>  $pass
);


//Login
$cnf['login'] = 'Login';
$random = md5(rand(00000000,99999999)).'.txt';
$login = cURL_iOS('https://m.facebook.com/login.php', $random, $cnf,$useragent);
//print $login;
if(preg_match('/name="fb_dtsg" value="(.*?)"/', $login, $response)){
    $fb_dtsg = $response[1];
    $responseToken = cURL_iOS('https://www.facebook.com/v1.0/dialog/oauth/confirm?', $random, 'fb_dtsg='.$fb_dtsg.'&app_id=165907476854626&redirect_uri=fbconnect://success&display=popup&access_token=&sdk=&from_post=1&private=&tos=&login=&read=&write=&extended=&social_confirm=&confirm=&seen_scopes=&auth_type=&auth_token=&auth_nonce=&default_audience=&ref=Default&return_format=access_token&domain=&sso_device=ios&__CONFIRM__=1',$useragent);
    if(preg_match('/access_token=(.*?)&/', $responseToken, $token2))
    {
        $token['access_token'] = $token2[1];
        exit(json_encode($token));
    }
    else
    {
        $token['error_msg'] = 'Không xác định được lỗi.Không thể lấy token';
        exit(json_encode($token));
    }
}
else{
    $token['error_msg'] = 'Sai tài khoản,mật khẩu hoặc nick bị checkpoint';
    exit(json_encode($token));
}
unlink($random);
?>
